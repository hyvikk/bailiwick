@extends('layouts.admin')

@section('content')
      <div class="content">
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <h4 class="title">Clients
              <a href="{{ route('clients.create')}}" class="btn btn-info btn-fill btn-wd">Add new</a></h4>
              <br>
              <div class="card">
                <div class="card-content">
                  <div class="fresh-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email Id</th>
                          <th>Phone</th>
                          <th>Country</th>
                          <th>Address</th>
                          <th class="disabled-sorting">Actions</th>
                        </tr>
                      </thead>
                      <tfoot>
                        <tr>
                          <th>Name</th>
                          <th>Email Id</th>
                          <th>Phone</th>
                          <th>Country</th>
                          <th>Address</th>
                          <th>Actions</th>
                        </tr>
                      </tfoot>
                      <tbody>
                       @foreach($data as $row)
                        <tr>
                          <td>{{$row->name}}</td>
                          <td>{{$row->email_id}}</td>
                          <td>{{$row->phone}}</td>
                          <td>{{$row->country}}</td>
                          <td>{{$row->address}}</td>
                          <td>
                            {!! Form::open(['url' => 'clients/'.$row->id,'method'=>'DELETE','class'=>'form-horizontal']) !!}
                            <a href="{{ url("clients/".$row->id."/edit")}}" class="btn btn-warning"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
                            <input type="hidden" name="id" value="{{ $row->id }}">
                            <button class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>
                            {!! Form::close() !!}
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
 </div>
</div>
@endsection
