@extends('layouts.admin')

@section('content')
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Edit Hosting</h4>
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
                            {!! Form::open(['route' => ['hostings.update',$data->id],'method'=>'PATCH']) !!}
                            {!! Form::hidden('id',$data->id) !!}
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Client Name</label>
                                        <select class="form-control" name="client_name" id="client_name">
                                            <option value="">--select--</option>
                                            @foreach($clients as $row)
                                            @if ($data->client_id == $row->id)
                                                      <option value="{{$row->id}}" selected>{{$row->name}}</option>
                                                @else
                                                      <option value="{{$row->id}}">{{$row->name}}</option>
                                                @endif

                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Hosting Provider</label>
                                         <input type="text" name="hosting_provider" placeholder="Enter hosting provider" class="form-control" value="<?=$data->hosting_provider;?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Hosting Type</label>
                                         <input type="text" name="hosting_type" placeholder="Enter hosting type" class="form-control" value="<?=$data->hosting_type;?>">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                         <input type="text" id="start_date" name="start_date" placeholder="Enter start date" class="form-control" value="<?=date('d-m-Y', strtotime($data->start_date))?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                       <input type="text" id="end_date" name="end_date" placeholder="Enter end date" class="form-control" value="<?=date('d-m-Y', strtotime($data->end_date))?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes" placeholder="Enter notes" rows="3"><?=$data->notes;?></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <?php
$currency = '($)';
if (!empty($amt_currency->currency)) {
	$currency = "(" . $amt_currency->currency . ")";
}?>
                                        <label>Amount {{ $currency }}</label>
                                        <input type="text" name="amount" placeholder="Enter amount" class="form-control" value="<?=$trans->amount;?>">
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
