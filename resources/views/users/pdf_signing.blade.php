@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                <!--     <button class="btn btn-outline-info" id="enroll_ds">Enroll DS</button> -->
                    <!-- <a href="{{ URL::to('mpin_list') }}"><button class="btn btn-outline-info" id="view_mpin_t_list">View MPIN Transer List</button></a>
                    <br><br> -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    File Signing
                                </div>
                                <div class="card-body">
                                    <form id="fileSigning">
                                        {{csrf_field()}}
                                        <label>For PDF Signing</label>
                                        <input type="file" name="fileUrl" id="fileUrl" class="form-control" accept=".pdf" required><br/>
                                        <button type="submit" class="btn btn-success" id="file" name="file">Upload</button>
                                        <button type="button" class="btn btn-danger">Cancel</button>
                                    </form>
                                </div>
                            </div>    
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
