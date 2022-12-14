@extends('master')

@section('content')
<div class="app-main__inner">
	<div class="row">
	    <div class="col-md-12">
	        <div class="main-card mb-3 card">
	            <div class="card-header">
	            	Signed File
	            	 <a href="{{route('file_upload')}}" class="btn btn-primary" style="right: 50px;position: fixed;">Upload New File</a>
	        	</div>
				<!-- <div class="card-body">
	            	<h5 class="card-title">List Of non signed File</h5>
                    <table class="mb-0 table table-bordered table-hover">
                        <thead>
	                        <tr>
	                            <th>S.N.</th>
	                            <th>Non Signed File</th>
	                        </tr>
                        </thead>
                        <tbody>
                        	@foreach($uploads as $key=>$upload)
		                    <tr>
		                        <td>{{$key + 1}}</td>
		                        <td><a href="{{asset('/tempUpload/'.$upload->non_signed_file)}}" target="_blank">{{$upload->non_signed_file}}</td>
		                    </tr>
		                    @endforeach
                        </tbody>
                    </table>
                </div> -->
	            <div class="card-body">
	            	<h5 class="card-title">List Of Uploaded Signed File</h5>
                    <table class="mb-0 table table-bordered table-hover">
                        <thead>
	                        <tr>
	                            <th>S.N.</th>
								<th>Non Signed File</th>
								<th>signed</th>
	                            <th>Signed File</th>
								
	                        </tr>
                        </thead>
                        <tbody>
                        	@foreach($uploads as $key=>$upload)
		                    <tr>
		                        <td>{{$key + 1}}</td>
								<td><a href="{{asset('/tempUpload/'.$upload->non_signed_file)}}" target="_blank">{{$upload->non_signed_file}}</td>
								<td>
									<button id="{{$upload->id}}" onclick="Emsigner(this)" value="{{asset('/tempUpload/'.$upload->non_signed_file)}}" class="btn btn-primary">sign file</button>
								</td>
		                        <td><a href="{{asset('storage/signedfile/'.$upload->file_name)}}" target="_blank">{{$upload->file_name}}</td>								
								
		                    </tr>
		                    @endforeach
                        </tbody>
                    </table>
                </div>
	        </div>
	    </div>
	</div>
</div>
@endsection
@section('js_scripts')
<script type="text/javascript">
	
	function Emsigner(element) {
		
		// Const url = document.getElementById('file_path');
		// alert(url)
		var url = element.value;
		var id = element.id;
	
        // e.preventDefault();
        // e.stopPropagation();
        //upload pdf to templocation
		signPdf(url, id , pdfSigned, failedToSignPdf);
    }

    function pdfSigned(data,id) {
		
        // alert("Hello i am pdfsigned");
        console.log(data);
		id = id
        console.log('about to upload signed pdf');		
		var CSRF_TOKEN = "{{csrf_token()}}";
		var form_data = new FormData();
		form_data.append('_token', CSRF_TOKEN);
		form_data.append("signature", data);
		form_data.append("id", id);
        // $('#signeddoc').val(data);
        // $('#docinfo').text('Signed Document attached!');
		$.ajax({
            url: '/file_upload',
            method: 'POST',
			data : form_data,
            contentType: false,
            cache: false,
            processData: false,
            beforSend: function () {
                alert("file uploading")
            },
            success: function (data) {
                alert("file signed successfully");
				location.reload();
            },
            error: function (error) {
              alert("error to upload")
            }
        })
    }
    function failedToSignPdf(error) {
        $('#docinfo').text('Failed to sign : ' + error);
        alert('Failed To sign: ' + error);
    }
</script>
@endsection
