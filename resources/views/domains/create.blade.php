@extends('layouts.admin')

@section('content')

<div class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Add Domain</h4>
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
                {!! Form::open(['route' => 'domains.store','method'=>'post']) !!}
                <input type="hidden" name="domain_err" id="domain_err" value="{{ old('domain_err') }}" />
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Domain Name</label>
                            <input type="text" name="domain_name" id="domain_name" placeholder="Enter domain name" class="form-control" value="{{ old('domain_name') }}">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Registrar</label>
                            <input type="text" name="registrar" id="registrar" placeholder="Enter registrar" class="form-control" value="{{ old('registrar') }}">
                        </div>
                    </div>
                </div>
               <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Client Name</label>
                            <select class="form-control" name="client_name" id="client_name">
                                <option value="">--select--</option>
                                @foreach($data as $row)
                                     @if (Input::old('client_name') == $row->id)
                                          <option value="{{$row->id}}" selected>{{$row->name}}</option>
                                    @else
                                          <option value="{{$row->id}}">{{$row->name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Creation Date</label>
                            <input type="text" name="creation_date" placeholder="Enter creation date" id="crdate" class="form-control" value="{{ old('creation_date') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Note</label>
                             <textarea class="form-control" name="note" placeholder="Enter note" rows="3">{{ old('note') }}</textarea>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label>Expiry Date</label>
                            <input type="text" name="expiry_date" placeholder="Enter expiry date" id="expdate" class="form-control" value="{{ old('expiry_date') }}">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                       <div class="form-group">
                            <?php $currency = '($)';?>
                            @if(!empty($amt_currency->currency))
                                <?php $currency = "(" . $amt_currency->currency . ")";?>
                            @endif
                            <label>Base Amount {{ $currency }}</label>
                            <input type="text" name="amount"  placeholder="Enter amount" class="form-control" value="{{ old('amount') }}">
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

@section('script')
<script>
$(document).ready(function() 
{
    $("#expdate").on('change', function()
    {
        var cdate = $("#crdate").val();
        var cnew  = cdate.split("-").reverse().join("-");

        var expdate = $("#expdate").val();
        var enew  = expdate.split("-").reverse().join("-");        

        if(cnew>enew)
        {
             alert("Creation date is bigger than expiry date.");
            $("#crdate").val("");
            $("#expdate").val("");
        }        
    });
});
</script>
@endsection
