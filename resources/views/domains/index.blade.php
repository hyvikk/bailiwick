@extends('layouts.admin')

@section('content')
<?php $currency = '$';?>
@if (!empty($amt_currency->currency))
  <?php $currency = $amt_currency->currency;?>
@endif
<div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <h4 class="title">Domains
              <a href="{{ route('domains.create')}}" class="btn btn-info btn-fill btn-wd">Add new</a></h4>
              <br>
              <div class="card">
                <div class="card-content">
                  <div class="fresh-datatables">
                    <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                      <thead>
                        <tr>
                          <th>Sr. no.</th>
                          <th>Client Name</th>
                          <th>Domain Name</th>
                          <th>Registrar</th>
                          <th>Registration Date</th>
                          <th>Expires On</th>
                          <th>Days Remaining</th>
                          <th>Renewed On</th>
                          <th class="disabled-sorting">Actions</th>
                      </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Sr no</th>
                      <th>Client Name</th>
                      <th>Domain Name</th>
                      <th>Registrar</th>
                      <th>Registration Date</th>
                      <th>Expires On</th>
                      <th>Days Remaining</th>
                      <th>Renewed On</th>
                      <th>Actions</th>
                  </tr>
              </tfoot>
              <tbody>
                <?php $count = 0;?>
                @foreach($data as $row)
                <?php ++$count;
$date1 = new DateTime();
$date2 = new DateTime($row->expiry_date);
$diff = $date2->diff($date1)->format("%a");
$days = intval($diff);
?>
                <tr>
                  <td>{{ $count }}</td>
                  <td class="client_name">{{$row->clients->name}}</td>
                  <td>{{$row->domain_name}}</td>
                  <td>{{$row->registrar}}</td>
                  <td class="creation_date">{{date('d-m-Y',strtotime($row->creation_date))}}</td>
                  <td class="expiry_date">{{date('d-m-Y',strtotime($row->expiry_date))}}</td>
                  <?php 
                              $current = date('Y-m-d');
                              $start_date = strtotime($current); 
                              $end_date = strtotime($row->expiry_date); 
                              $diff = ($end_date - $start_date)/60/60/24;
                              if($diff <= +45)
                              {
                                 
                        ?>
                        <td class="remaining_days" style="color:red;">{{ $diff }}</td>
                        <?php
                              }
                              else
                              {

                        ?>
                        <td class="remaining_days">{{ $diff }}</td>
                         <?php
                              }
                        ?>
                  <td class="amount">
                    {{date('d-m-Y',strtotime($row->updated_at))}}
                  </td>
                  <td>
                    {!! Form::open(['url' => 'domains/'.$row->id,'method'=>'DELETE','class'=>'form-horizontal']) !!}

                    <a href="{{ url("domains/".$row->id."/edit")}}" class="btn btn-warning"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                    <input type="hidden" id="client_id" name="client_id" value="{{ $row->client_id }}">

                    <input type="hidden" name="id" value="{{ $row->id }}">

                    <button title="delete" class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>

                    <a onClick="get_domain_trans(this.id)" title="transactions"  class="btn btn-primary"  data-toggle="modal"   id="<?php echo $row->id; ?>" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>
                    <!-- <br class="hidden-xs"> -->
                     <?php 
                              $current = date('Y-m-d');
                              $start_date = strtotime($current); 
                              $end_date = strtotime($row->expiry_date); 
                              $diff = ($end_date - $start_date)/60/60/24;
                              if($diff <= +45)
                              {
                                 
                        ?> 
                    <a href="#domain_renew_modal" title="renew domain"  class="btn btn-success domain_renew_modal" data-toggle="modal" class=""   data-id="<?php echo $row->id; ?>" data-clientid="<?php echo $row->client_id; ?>" data-expiry_date="<?php echo date('d-m-Y', strtotime($row->expiry_date)); ?>" ><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>
                    <?php
                      }
                    ?>  
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

@section('modal')
<div class="modal fade  " id="domains_modal" role="dialog">
   <div class="modal-dialog modal-lg" >
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Transaction List</h4>
      </div>
      <div class="modal-body domain_modal_body ">
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
  </div>
</div>
</div>



<div class="modal fade" id="receipt_domains_modal" role="dialog">
   <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">View Receipt</h4>
      </div>
      <div class="modal-body dom_receipt_body">
      </div>
      <div class="modal-footer">
        <a href="#domains_modal" data-toggle="modal" data-dismiss="modal" class="btn btn-info" role="button">Back</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
</div>
</div>
</div>

<div class="modal fade" id="domain_renew_modal" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['method'=>'get','id'=>'domain_renew']) !!}
      <div class="modal-header ">
         <button type="button" class="close" data-dismiss="modal">&times;</button>


         <h3 class="modal-title">Domain Renewal</h3>


         <p id="result_renew_modal" class="inline text-right"  style="font-size: 14px;margin: 0px;"></p>

     </div>
     <div class="modal-body">
        <div class="row">
            <div class="col-md-12">
           <div class="alert alert-danger domain_renew_error" role="alert" style="display: none">
              <ul></ul>
          </div>


          <input type="hidden" id="renew_domain_id" name="renew_domain_id" value="">
          <input type="hidden" id="renew_client_id" name="renew_client_id" value="">
          <input type="hidden" id="renew_expiry_date" name="renew_expiry_date" value="">
        </div>
          <div class="col-md-12">

            <p class="result_client_name" style="font-size: 14px;"></p>
        <hr/>
        </div>

        <div class="col-md-12">

          <h4 class="modal-title">Previous Renew Details:</h4>
          <p class="result_amount" style="font-size:14px;margin-top:5px;margin-bottom:0px;display: inline-block; padding-right: 10px;"></p>
          <p class="result_creation_date" style="font-size:14px;display: inline-block;"></p>

          <hr/>
      </div>




            <div class="col-md-6">
                <div class="form-group">
                    <label>Renew Domain for:</label>
                    <select class="form-control" name="domain_renew_year" id="domain_renew_year">
                        <option value="">--select--</option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                    </select>
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group">
                    <label>Renewal Amount:</label>
                    <input type="text" name="domain_renew_amount" id="domain_renew_amount" placeholder="Enter amount" class="form-control" value="{{ old('domain_renew_amount') }}">
                </div>
            </div>

            <hr/>


          <div class="col-md-6">
            <p id="total_year" style="font-size: 14px;">
              <b>Domain will be renewed for:</b>
          </p>

      </div>
      <div class="col-md-6">
        <p id="total_amount" style="font-size: 14px;">
            <b>Total Amount To Be Paid:</b>
        </p>
    </div>

</div>

<div class="modal-footer">
    <button type="submit" class="btn btn-primary pull-left" >Submit</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>

</div>
{!! Form::close() !!}
</div>
</div>
</div>
@endsection