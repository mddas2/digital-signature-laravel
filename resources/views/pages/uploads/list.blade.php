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
				<div class="card-body">
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
                </div>
	            <div class="card-body">
	            	<h5 class="card-title">List Of Uploaded Signed File</h5>
                    <table class="mb-0 table table-bordered table-hover">
                        <thead>
	                        <tr>
	                            <th>S.N.</th>
	                            <th>Signed File</th>
								<th>Non Signed File</th>
	                        </tr>
                        </thead>
                        <tbody>
                        	@foreach($uploads as $key=>$upload)
		                    <tr>
		                        <td>{{$key + 1}}</td>
		                        <td><a href="{{asset('storage/signedfile/'.$upload->file_name)}}" target="_blank">{{$upload->file_name}}</td>
								<td><a href="{{asset('/tempUpload/'.$upload->non_signed_file)}}" target="_blank">{{$upload->non_signed_file}}</td>
								<td>
									<form>
										<input type="checkbox" id="vehicle1" name="vehicle1" value="Bike">
										<button type = "submit" class="btn-sm primary">Signed this file </button>
									</form>
								</td>
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
