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
        <h4 class="title">Hostings
          <a href="{{ route('hostings.create')}}" class="btn btn-info btn-fill btn-wd">Add new</a></h4>
          <br>
          <div class="card">
            <div class="card-content">
              <div class="fresh-datatables">
                <table id="datatables" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                  <thead>
                    <tr>
                      <th>Sr. no.</th>
                      <th>Client Name</th>
                      <th>Provider</th>
                      <th>Domain Name</th>
                      <th>Hosting Type</th>
                      <th>Reg. Date</th>
                      <th>Exp. On</th>
                      <th>Remaining Days</th>
                      <th>Renewed On</th>
                      <th class="disabled-sorting">Actions</th>
                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Sr. no.</th>
                      <th>Client Name</th>
                      <th>Provider</th>
                      <th>Domain Name</th>
                      <th>Hosting Type</th>
                      <th>Reg. Date</th>
                      <th>Exp. On</th>
                      <th>Remaining Days</th>
                       <th>Renewed On</th>
                      <th>Actions</th>
                    </tr>
                  </tfoot>
                  <tbody>
                    <?php
$count = 0;
foreach ($data as $row) {

	$count++;
	// for ($i = 1; $i <= $count; $i++) {

	$date1 = new DateTime();
	$date2 = new DateTime($row->end_date);
	$diff = $date2->diff($date1)->format("%a");
	$days = intval($diff);
	?>
                      <tr>
                        <td>{{$count}}</td>
                        <td class="client_name">{{$row->clients->name}}</td>
                        <td>{{$row->hosting_provider}}</td>
                        <td>{{$row->domain->domain_name??"None"}}</td> 
                        <td>{{$row->hosting_type}}</td>
                        <td class="creation_date">{{date('d-m-Y',strtotime($row->start_date))}}</td>
                        <td class="expiry_date">{{date('d-m-Y',strtotime($row->end_date))}}</td>

                        <?php   
                              $current = date('Y-m-d');
                              $start_date = strtotime($current); 
                              $end_date = strtotime($row->end_date); 
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
                        <td>{{date('d-m-Y',strtotime($row->updated_at))}}</td>
                        <td>
                          {!! Form::open(['url' => 'hostings/'.$row->id,'method'=>'DELETE','class'=>'form-horizontal']) !!}

                          <a title="edit" href="{{ url("hostings/".$row->id."/edit")}}" class="btn btn-warning"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>

                          <input type="hidden" id="client_id" name="client_id" value="{{ $row->client_id }}">

                          <input type="hidden" name="id" value="{{ $row->id }}">

                          <button title="delete" class="btn btn-danger" type="submit" onclick="return confirm('Are you sure?')"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>

                          <a onClick="get_hosting_trans(this.id)" title="transactions"  class="btn btn-primary"  data-toggle="modal"   id="<?php echo $row->id; ?>" ><span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span></a>

                          <?php 
                              $current = date('Y-m-d');
                              $start_date = strtotime($current); 
                              $end_date = strtotime($row->end_date); 
                              $diff = ($end_date - $start_date)/60/60/24;
                              if($diff <= +45)
                              {
                          ?>
                          
                          <a href="#hosting_renew_modal" title="renew hosting"  class="btn btn-success hosting_renew_modal"  data-toggle="modal" data-id="<?php echo $row->id; ?>" data-clientid="<?php echo $row->client_id; ?>" data-domainid="<?php echo $row->domain_id; ?>" data-end_date="<?php echo $row->end_date; ?>" ><span class="glyphicon glyphicon-refresh" aria-hidden="true"></span></a>

                          <?php
                              } 
                          ?>
                          
                          {!! Form::close() !!}
                        </td>
                      </tr>
                      <?php
}?>
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

<div class="modal fade" id="hosting_renew_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      {!! Form::open(['method'=>'get','id'=>'hosting_renew']) !!}
      <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Hosting Renewal</h3>

          <p id="result_renew_modal" class="inline text-right" style="font-size: 14px;margin: 0px;"></p>
      </div>
       <div class="modal-body">
          <div class="row">
            <div class="col-md-12">

         <div class="alert alert-danger hosting_renew_error" role="alert" style="display: none">
              <ul></ul>
          </div>
        </div>
        <div class="col-md-12">
            <p class="result_client_name"></p>
            <hr/>
        </div>


        <div class="col-md-12">
          <h4 class="modal-title">Previous Renew Details</h4>
          <p class="result_amount m-0" style="font-size: 14px;margin-top:5px;margin-bottom:0px;display: inline-block; padding-right: 10px;"></p>
          <p class="result_creation_date" style="font-size:14px; display: inline-block;"></p>





          <input type="hidden" id="renew_hosting_id" name="renew_hosting_id" value="">
          <input type="hidden" name="renew_domain_id" id="domain_id1" value=""> 
          <input type="hidden" id="renew_host_client_id" name="renew_host_client_id" value="">
           <input type="hidden" id="renew_end_date" name="renew_end_date" value="">
             <hr/>
          </div>



            <div class="col-md-6">

                <div class="form-group">
                    <label>Renew Domain for:</label>
                    <select class="form-control" name="hosting_renew_year" id="hosting_renew_year">
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
                    <input type="text" name="hosting_renew_amount" id="hosting_renew_amount" placeholder="Enter amount" class="form-control" value="{{ old('hosting_renew_amount') }}">
                </div>
            </div>


          <!-- <div class="col-md-12"> -->
          <hr/>
          <div class="col-md-6">
            <p id="total_year" style="font-size: 14px;">
              <b>Hosting will be renewed for: </b>
          </p>

          </div>
          <div class="col-md-6">
            <p id="total_amount" style="font-size: 14px;">
                <b>Total Amount To Be Paid:</b>
            </p>
        </div>
        <!-- </div> -->
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary pull-left" >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
       {!! Form::close() !!}
    </div>
  </div>
</div>
</div>

  <div class="modal fade" id="transactions_modal" role="dialog">
   <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Transaction List</h4>
      </div>
      <div class="modal-body transcation_modal_body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="receipt_hosting_modal" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">View Receipt</h4>
    </div>
    <div class="modal-body host_receipt_body">
    </div>
    <div class="modal-footer">
      <a href="#transactions_modal" data-toggle="modal" data-dismiss="modal" class="btn btn-info" role="button">Back</a>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
</div>
</div>

@endsection
