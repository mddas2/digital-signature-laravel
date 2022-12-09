@extends('master')

@section('content')
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
            @include('message.flash')
	        <div class="main-card mb-3 card">
	            <div class="card-header">
	            	Upload File
	           </div>
	            <div class="card-body">
	            	<form action="{{ route('file_upload')}}" method="POST" id="fundsTransfer" enctype="multipart/form-data">
                        {{csrf_field()}}
                        <input name="signature" type="hidden" class="signedData">
                        <div class="position-relative form-group">
                        	<label class="">Select File To Upload</label>
                        	<input type="file" id="document" class="btn btn-default btn-file"> 
                        	<input type="hidden" id="tempdoc" name="tempdoc">
                        	<input type="hidden" id="signeddoc" name="signature">
                        	<br>
                        	<button id="sign-doc" class="btn btn-info" type="button">Sign it</button>
                        	<span id="docinfo"></span>

                        </div>
                     	<button class="btn btn-primary" type="submit" id="formSigning">Upload File</button>
                        <a href="{{route('restart-emsigner')}}" class="btn btn-success" target="_blank">Restart EmSigner</a>
                	</form>
	            </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
@section('js_scripts')
<script type="text/javascript">
	var CSRF_TOKEN = "{{csrf_token()}}";
	var uploadUrl = "{!! route('temp.upload') !!}";
	var baseURL = "{{ url('/') }}";
	$('#sign-doc').click(function (e) {
        e.preventDefault();
        e.stopPropagation();

        if ($('#document').val() == null) {
            alert('Please select the document first!');
            return;
        }
        $('#onLoadingEffect').show();

        //upload pdf to templocation
        var doc = document.getElementById('document').files[0];
        var form_data = new FormData();
        form_data.append('_token', CSRF_TOKEN);
        form_data.append("file", doc);
        $.ajax({
            url: uploadUrl,
            method: 'POST',
            data: form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforSend: function () {
                $('#docinfo').text('Please Wait!! Starting Signing process...');
            },
            success: function (data) {
                $('#tempdoc').val(data.filepath);
                console.log(baseURL + data.filepath);
                signPdf(baseURL + data.filepath, pdfSigned, failedToSignPdf);
            },
            error: function (error) {
              
            }
        })
    });

    function pdfSigned(data) {
        // alert("Hello i am pdfsigned");
        console.log(data);
        console.log('about to upload signed pdf');
        $('#signeddoc').val(data);
        $('#docinfo').text('Signed Document attached!');
    }
    function failedToSignPdf(error) {
        $('#docinfo').text('Failed to sign : ' + error);
        alert('Failed To sign: ' + error);
    }
</script>
@endsection
