<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>DSC Enrollment</title>
    <style>
        @font-face {
            font-family: preeti;
            src: url('PREETI.ttf');
        }
    </style>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">


    <!-- Styles -->
    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('home') }}">{{ __('Dashboard') }}</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="navbar-brand nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                Home<span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('funds_transfer') }}">Form Signing</a>
                                <a class="dropdown-item" href="{{ route('pdf_signing') }}">Pdf Signing</a>
                                <a class="dropdown-item" href="{{ route('enroll_dsc') }}">Enroll DSC</a>
                                <a class="dropdown-item" href="{{ route('reenroll_dsc') }}">Reenroll DSC</a>
                                <!-- <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form> -->
                            </div>
                        </li>
                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <main class="py-4">
            @yield('content')
        </main>
    </div>
    <script type="text/javascript">
        var email = "<?php echo Session::get('email');?>";
        var enrollSigUrl = "<?php echo URL::to("user/enroll_signature");?>";
        var gemRandomNoUrl = "<?php echo URL::to("user/generateRandomNo");?>";
        $(document).ready(function(){
             $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#lan_nep').on('click',function(){
                $('.font').css('font-family','preeti');
                $('#lan_eng').prop('checked',true);
            });
        });
        
    </script>
    <!-- <script src="{{ asset('js/mpin_data.js')}}"></script> -->
    <script src="{{ asset('js/enroll_ds.js')}}"></script>
    <script src="{{ asset('js/dsc_connection.js') }}"></script>
    

    <script type="text/javascript">
        startConnection();
        $(document).ready(function(){
            $('#enroll_ds').click(function(){
                generateRandomNo(email);
                //getSignature(email,successCallBackForEnroll);
            });
            $('#reenroll_ds').click(function(){
                generateRandomNo(email,true);
            });
            $('#MPINForm').on('submit',function(e){
                alert('ok');
                e.preventDefault();
                var name = $('#name').val();
                var email = $('#email').val();
                var account_no = $('#account_number').val();
                var data = name + '||' + email + '||' + account_no;
                console.log('Appended Data is ::' + data);
                getSignature(data,gotSignature);
            });

            function gotSignature(respData) {
                console.log(respData);
                var i_name = $("#name").val();
                var i_email = $("#email").val();
                var i_account_number = $("#account_number").val();
                var siglast = respData.indexOf("CommonName");
                var sig = respData.substring(10, siglast);
                var str = new String(sig);
                var seriallast = respData.indexOf("IssuerCommonName");
                var serial = respData.substring(44 + str.length, seriallast);
                serial = serial.replace(/\s/g,'');
                if (sig == '') {
                    alert('Invalid Sign Data');
                    return false;
                }

                $.ajax({
                    url : "{{ URL::to('form_signing') }}",
                    type : "POST",
                    data : {
                        name : i_name,
                        email : i_email,
                        account_number : i_account_number,
                        sign_data : sig,
                        serial_number : serial
                    },
                    success: function(data) {
                        //success
                        if(data == 'success') {
                        console.log("Success");
                        window.alert("Successfully transferred !!");
                        } else {
                            console.log("Error !!");
                        }

                    },
                    error: function(error) {
                        //error
                        console.log("Errosr");
                    }
                });
            }

            // pdf signing
            $("#fileSigning").on('submit', function(e){
                e.preventDefault();
                $.ajax({
                    url: "{{URL::to('file/upload')}}",
                    type:"POST",
                    contentType: false,
                    cache: false,
                    processData:false,
                    data:new FormData($("#fileSigning")[0]),

                    success: function(fileName) {
                        // Sign the pdf
                        var outputfileUrl = "files/"+fileName;
                        var inputFileUrl = "http://dscnew.test/public/files/"+fileName;
                        // var inputFileUrl = encodeURI("http://dms.inficare.net/uploads/UploadedFiles/Pending/branch 2/2019/8/4029/1/Account_Opening_Form.pdf");
                        signPdf(inputFileUrl, outputfileUrl, successCallback, failureCallback);
                        //if success
                        function successCallback(respData){
                            // console.log(respData);
                            gotSignedPDF(respData);
                        }
                        //if failed
                        function failureCallback(error){
                            console.log(error)
                        }

                        //sign and get file
                        function signPdf(inputFileUrl, outputfileUrl, successCallback, failureCallback) {
                            var signParams="emsigneraction=pdfsign\ntbs="+inputFileUrl+"\noutputpath="+outputfileUrl+"\nsignaction=3\ncerttype=ALL\nexpirycheck=true\nissuername=\nsigntype=detached\ncoordinate=400,100,500,150\npageno=all\nreason=test\nlocation=nepal";
                            callApplet(signParams,successCallback, failureCallback);
                        }

                        //got signed pdf
                        function gotSignedPDF(respData){
                            var siglast = respData.indexOf("CommonName");
                            var sig = respData.substring(10,siglast);
                            console.log('pdf Signed ');
                            var resultDiv = $('#sign_result');
                            resultDiv.append('<a href="'+outputfileUrl+'">Signed file is here !!</a>');
                            console.log("Appended");
                            doAjaxTheData(respData);
                        }
                        function doAjaxTheData(data){
                            var ajaxUrl = "{{URL::to('upload-base64')}}";
                            // console.log("Ajx URl is "+ajaxUrl+ " CSRF "+csrf);
                            var formData = new FormData();
                            formData.append("data", data);
                            formData.append("outputfile", outputfileUrl);
                            $.ajax({
                                url: ajaxUrl,
                                type: "POST",
                                data: formData,
                                cache: false,
                                processData: false,
                                contentType: false,
                                beforeSend: function() {
                                    console.log("about to send");
                                },
                                complete: function(data) {
                                    console.log("Ajax complete");
                                    console.log("data: "+data);
                                },
                                success: function(json) {
                                    console.log("Success ajax ");
                                    console.log(json);
                                },
                                error: function(xhr, ajaxOptions, thrownError) {
                                    alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
                                }
                            });
                        }
                    //sign and get file end
             },
             error: function(data) {
                  console.log(data);
             }
           });
 });
//pdf signing end
        });
    </script>
</body>
</html>
