@extends('layouts.admin')

@section('content')

  <div class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-md-12">
              <h4 class="title">Change Password</h4>
          </div>
        </div>
          <div class="card">
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
                  <?php if(isset($msg)) { ?>
                    <div class="alert alert-success">
                        <ul>
                         
                          <li>{{ $msg }}</li>
                        
                        </ul>
                    </div>
                  <?php } ?>
                  <div class="row">
                   {{ Form::open(array("url"=>"/changepassword"))}}
                      <div class="col-md-5">
                        <div class="form-group">
                            <input type="password" class="form-control"  name="passwd" placeholder="Enter New Password" />
                        </div>
                      </div>
                      <div class="col-md-5">
                        <div class="form-group">
                          <button type="submit" class="btn btn-fill btn-info">Submit</button>
                        </div>
                      </div>
                    {!! Form::close() !!}
                  </div>
              </div>
            </div>
          </div>
        </div>
@endsection
