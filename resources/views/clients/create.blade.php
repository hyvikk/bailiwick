@extends('layouts.admin')

@section('content')
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Client</h4>
                        </div>
                        <div class="card-content">
                            @if (count($errors) > 0)
                            <div class="alert alert-danger">
                            <ul>
                            @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                            </ul>
                            </div>
                            @endif
                           {!! Form::open(['route' => 'clients.store','method'=>'post']) !!}
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Name</label>
                                        <input type="text" name="name" placeholder="Enter name" class="form-control" value="{{ old('name') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email Id</label>
                                       <input type="email" name="email" placeholder="Enter email" class="form-control" value="{{ old('email') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Phone</label>
                                        <input type="text" name="phone" placeholder="Enter phone" class="form-control" value="{{ old('phone') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Country</label>
                                         <select class="form-control" name="country" id="country">
                                          <option value="">--select--</option>
                                            @foreach($data as $row)
                                                @if (Input::old('country') == $row->country_name)
                                                <option value="{{$row->country_name}}" selected>{{$row->country_name}}</option>
                                                @else
                                                <option value="{{$row->country_name}}">{{$row->country_name}}</option>
                                                @endif
                                          @endforeach
                                            </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Address</label>
                                        <textarea class="form-control" name="address" placeholder="Enter address" rows="3">{{ old('address') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                       <button type="submit" class="btn btn-fill btn-info">Submit</button>
                                    </div>
                                </div>
                            </div>
                       {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
@endsection
