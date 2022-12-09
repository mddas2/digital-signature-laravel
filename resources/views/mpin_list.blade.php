@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                	<a href="{{ URL::to('home') }}"><i class="fa fa-arrow-left" style="cursor:pointer"></i></a> &nbsp;&nbsp;&nbsp;  MPIN List 
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Account Number</th>
                        <th>MPIN</th>
                        <th></th>
                      </tr>
                    </thead>
                    <tbody>
                    @for($i = 0 ;$i< count($data) ; $i++)
                      <tr>
                       <td>{{$data[$i]->id}}</td>
                       <td>{{$data[$i]->name}}</td>
                       <td>{{$data[$i]->email}}</td>
                       <td>{{$data[$i]->account_number}}</td>
                       <td>{{$data[$i]->mpin}}</td>
                       <td class="view" data-mpin="{{$data[$i]->id}}" ><center><i class="fa fa-eye fa-lg" style="cursor:pointer"></i></center></td>
                      </tr>
                    @endfor
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
