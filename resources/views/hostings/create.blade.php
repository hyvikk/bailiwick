@extends('layouts.admin')

@section('css')
<style>

.form-check {
  margin-top: .65rem;
  padding-left: 0;
}


.form-check .form-check-label {
  display: inline-block;
  position: relative;
  cursor: pointer;
  padding-left: 15px;
  line-height: 26px;
  font-size: 16px;
  font-weight: normal;
  margin-bottom: 0;
  -webkit-transition: color 0.3s linear;
  -moz-transition: color 0.3s linear;
  -o-transition: color 0.3s linear;
  -ms-transition: color 0.3s linear;
  transition: color 0.3s linear;
}

 .form-check-sign {
  padding-left: 28px;
}


.form-check .form-check-sign::before,
.form-check .form-check-sign::after {
  content: " ";
  display: inline-block;
  position: absolute;
  width: 26px;
  height: 26px;
  left: 0;
  cursor: pointer;
  border-radius: 3px;
  top: 0;
  background-color: transparent;
  border: 1px solid #E3E3E3;
  -webkit-transition: opacity 0.3s linear;
  -moz-transition: opacity 0.3s linear;
  -o-transition: opacity 0.3s linear;
  -ms-transition: opacity 0.3s linear;
  transition: opacity 0.3s linear;
}


.form-check .form-check-sign::after {
  font-family: 'Nucleo Outline';
  content: "\ea22";
  top: 0px;
  text-align: center;
  font-size: 14px;
  opacity: 0;
  color: #555555;
  border: 0;
  background-color: inherit;
}


.form-check.disabled .form-check-label,
.form-check.disabled .form-check-label {
  color: #9A9A9A;
  opacity: .5;
  cursor: not-allowed;
}


.form-check input[type="checkbox"],
.radio input[type="radio"] {
  opacity: 0;
  position: absolute;
  visibility: hidden;
}


.form-check input[type="checkbox"]:checked+.form-check-sign::after {
  opacity: 1;
}

.form-control input[type="checkbox"]:disabled+.form-check-sign::before,
.checkbox input[type="checkbox"]:disabled+.form-check-sign::after {
  cursor: not-allowed;
}

.form-check input[type="checkbox"]:disabled+.form-check-sign,
.form-check input[type="radio"]:disabled+.form-check-sign {
  pointer-events: none;
}


.form-check-radio .form-check-sign::before,
.form-check-radio .form-check-sign::after {
  content: " ";
  width: 20px;
  height: 20px;
  border-radius: 50%;
  border: 1px solid #E3E3E3;
  display: inline-block;
  position: absolute;
  left: 3px;
  top: 3px;
  padding: 1px;
  -webkit-transition: opacity 0.3s linear;
  -moz-transition: opacity 0.3s linear;
  -o-transition: opacity 0.3s linear;
  -ms-transition: opacity 0.3s linear;
  transition: opacity 0.3s linear;
}


.form-check-radio input[type="radio"]+.form-check-sign:after,
.form-check-radio input[type="radio"] {
  opacity: 0;
}


.form-check-radio input[type="radio"]:checked+.form-check-sign::after {
  width: 4px;
  height: 4px;
  background-color: #555555;
  border-color: #555555;
  top: 11px;
  left: 11px;
  opacity: 1;
}


</style>
@endsection
@section('content')
            <div class="content">
                <div class="container-fluid">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Add Hosting</h4>
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
                           {!! Form::open(['route' => 'hostings.store','method'=>'post']) !!}
                            <div class="row">
                                <div class="col-md-4">
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
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Hosting Provider</label>
                                       <input type="text" name="hosting_provider" placeholder="Enter hosting provider" class="form-control" value="{{ old('hosting_provider') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Hosting Type</label>
                                        <input type="text" name="hosting_type" placeholder="Enter hosting type" class="form-control" value="{{ old('hosting_type') }}">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Domains</label>
                                        <select class="form-control" name="domain_name" id="domain_name">
                                            <option value="">--select--</option>
                                            
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Start Date</label>
                                        <input type="text" id="start_date" name="start_date" placeholder="Enter start date" class="form-control" value="{{ old('start_date') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>End Date</label>
                                        <input type="text" id="end_date" name="end_date" placeholder="Enter end date" class="form-control" value="{{ old('end_date') }}">
                                    </div>
                                </div>
                                
                              </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Notes</label>
                                        <textarea class="form-control" name="notes" placeholder="Enter notes" rows="2">{{ old('notes') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                     <?php 
                                        $currency='($)';
                                        if(!empty($amt_currency->currency)) { 
                                            $currency="(".$amt_currency->currency.")";
                                        } ?>
                                       <label>Base Amount {{ $currency }}</label>
                                        <input type="text" name="amount" placeholder="Enter amount" class="form-control" value="{{ old('amount') }}">
                                    </div>
                                </div>
                                 
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label>Domain Purchased from</label>
                                      <div class="form-check form-check-radio">
                                       <label class="form-check-label">
                                          <input class="form-check-input" type="radio" 
                                          name="purchase"  value="1">
                                           This site
                                          <span class="form-check-sign"></span>
                                         
                                       </label>
                                       <label class="form-check-label">
                                          <input class="form-check-input" type="radio" 
                                          name="purchase"  value="0" >
                                          Another site
                                          <span class="form-check-sign"></span>
                                        </label>
                                       </div>
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
    $("#domain_name").attr("disabled",true);
    $("#client_name").on('change', function()
    {
        $("#domain_name").empty();
        $("#domain_name").attr("disabled",false);
        var value = $("#client_name").val();
                    $.ajax({
                  type:'get',
                  url:'{{URL::to("finddomain")}}',
                  data: {'client':value},
                  success:function(data)
                  {
                    var obj = JSON.parse(data);
                    var output = '<option value="">--select--</option>';
                    //console.log(obj);
                    $.each(obj,function(index,value){
                        output = output + '<option value="'+value.id+'">'+value.domain_name+'</option>';
                    });
                    $("#domain_name").append(output);
                  }
                });
    });

    $("#end_date").on('change', function()
    {
        var cdate = $("#start_date").val();
        var cnew  = cdate.split("-").reverse().join("-");

        var expdate = $("#end_date").val();
        var enew  = expdate.split("-").reverse().join("-");        

        if(cnew>enew)
        {
             alert("Creation date is bigger than expiry date.");
            $("#start_date").val("");
            $("#end_date").val("");
        }        
    });
});
</script>
@endsection