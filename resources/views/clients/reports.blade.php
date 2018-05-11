@extends('layouts.admin')

@section('content')

<?php $currency = '$';?>
@if (!empty($amt_currency->currency))
	<?php $currency = $amt_currency->currency;?>
@endif
<?php $cid = '';?>
@if (!empty($client_id))
	<?php $cid = $client_id;?>
@endif


  <div class="content">
      <div class="container-fluid">
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
                  <div class="row">
                    {!! Form::open(['route' => 'report.store','method'=>'post']) !!}
                      <div class="col-md-2">
                          <div class="form-group pull-right">
                            <label>Client Name:</label>
                          </div>
                      </div>
                      <div class="col-md-4">
                        <div class="form-group">
                          <select class="form-control" name="client" id="client">
                            <option value="">--select client--</option>
                            @foreach($clients as $row)

                              @if ($cid == $row->id )
                              <option value="{{$row->id}}" selected>{{$row->name}}</option>
                              @else
                              <option value="{{$row->id}}">{{$row->name}}</option>
                              @endif
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="col-md-1">
                        <div class="form-group">
                          <button id="report_btn" type="submit" class="btn btn-fill btn-info">Submit</button>
                        </div>
                      </div>
                      <div class="col-md-3">
                        <div class="form-group">
                          <a  id="chart_link" class="btn btn-success payment_chart" role="button" style="display: none;" >show chart</a>
                        </div>
                      </div>
                    {!! Form::close() !!}
                  </div>
              </div>
            </div>

            <?php if (isset($chartjs)) {?>
            <div class="clear">
              <div class="chart_toggle" style="display:none">
                <div style="width:75%;">
                   <?php echo $chartjs->render(); ?>
                 </div>
              </div>
            </div>
            <?php }?>

            @if (!empty($domains))

            <div class="card">
              <div class="card-content">
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="title">Domain Details </h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-content">
                        <div class="fresh-datatables">
                          <table id="domain_report_datatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                              <thead>
                                <tr>
                                  <th>Domain Name</th>
                                  <th>Registrar</th>
                                  <th>Creation Date</th>
                                  <th>Expiry Date</th>
                                  <th>Total</th>
                                  <th>Remaining</th>
                                  <th>View Receipt</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <th>Domain Name</th>
                                  <th>Registrar</th>
                                  <th>Creation Date</th>
                                  <th>Expiry Date</th>
                                  <th>Total</th>
                                  <th>Remaining</th>
                                  <th>View Receipt</th>
                                </tr>
                              </tfoot>
                              <tbody>
                                @foreach($domains as $row)

                                <tr>
                                  <td>{{ $row->domain_name }}</td>
                                  <td>{{ $row->registrar }}</td>
                                  <td>{{date('d-m-Y',strtotime($row->creation_date))}}</td>
                                  <td>{{date('d-m-Y',strtotime($row->expiry_date))}}</td>
                                  <td><?=$currency . $sum_domain?></td>
                                  <?php
//$payment_receipt = Transactions::find($trans[0]->id)->payment_receipt ;
?>
                                @if (count($payment_receipt) > 0)

                                	<?php //$sum = Paymentreceipt::sum_amount($trans[0]->id); ?>

                                	@if ($sum < $sum_domain)
                                		<?php $rem_amount = $sum_domain - $sum;?>
                                          <td>{{$currency . number_format($rem_amount, 2, '.', ',')}}</td>
                                          <td>
                                            <a onClick="dom_report_receipt(this.id)" title="view receipt" class="btn btn-success" data-toggle="modal" data-dismiss="modal" id="<?php echo $row->client_id; ?>"><i class="ti-clipboard"></i></a>
                                          </td>

                                    @else
                                          <td>0</td>
                                          <td><a onClick="dom_report_receipt(this.id)" title="view receipt" class="btn btn-success" data-toggle="modal" data-dismiss="modal" id="<?php echo $row->client_id; ?>"><i class="ti-clipboard"></i></a></td>
                                    @endif
                                  @else
                                          <td>{{$sum_domain}}</td>
                                          <td></td>
                                  @endif
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
@endif

@if (!empty($hostings))

        <div class="card">
          <div class="card-content">
            <div class="row">
              <div class="col-md-12">
                <h4 class="title">Hosting Details </h4>
              </div>
            </div>
            <div class="row">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-content">
                    <div class="fresh-datatables">
                      <table id="hosting_report_datatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                          <thead>
                            <tr>
                              <th>Hosting Provider</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                              <th>Hosting Type</th>
                              <th>Total</th>
                              <th>Remaining</th>
                              <th>View Receipt</th>
                            </tr>
                          </thead>
                          <tfoot>
                            <tr>
                              <th>Hosting Provider</th>
                              <th>Start Date</th>
                              <th>End Date</th>
                              <th>Hosting Type</th>
                              <th>Total</th>
                              <th>Remaining</th>
                              <th>View Receipt</th>
                            </tr>
                          </tfoot>
                          <tbody>
                          @foreach($hostings as $row)

                          <tr>
                            <td>{{ $row->hosting_provider }}</td>
                            <td>{{date('d-m-Y',strtotime($row->start_date))}}</td>
                            <td>{{date('d-m-Y',strtotime($row->end_date))}}</td>
                            <td>{{$row->hosting_type}}</td>
                            <td><?=$currency . $sum_host?></td>
                            <?php
//$payment_receipt = Transactions::find($trans[0]->id)->payment_receipt ;
?>
                        @if (count($payment_receipt) > 0)

                        	@if ($sum < $sum_host)
                        		<?php $rem_amount = $sum_host - $sum;?>
                                  <td>{{$currency . number_format($rem_amount, 2, '.', ',')}}
                                  </td>
                                  <td><a onClick="host_report_receipt(this.id)" title="view receipt" class="btn btn-success" data-toggle="modal" data-dismiss="modal" id="<?php echo $row->client_id; ?>"><i class="ti-clipboard"></i></a></td>

                          @else
                                <td>0</td>
                                <td><a onClick="host_report_receipt(this.id)" title="view receipt" class="btn btn-success" data-toggle="modal" data-dismiss="modal" id="<?php echo $row->client_id; ?>"><i class="ti-clipboard"></i></a></td>
                          @endif
                        @else
                                <td>{{$sum_host}}</td>
                                <td></td>
                        @endif
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
      @endif
    </div>
  </div>
  <div class="modal fade" id="receipt_domains_report" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">View Receipt</h4>
    </div>
    <div class="modal-body dom_receipt_report">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
  </div>
</div>
<div class="modal fade" id="receipt_hostings_report" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">View Receipt</h4>
    </div>
    <div class="modal-body hosting_receipt_report">
    </div>
    <div class="modal-footer">
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
  </div>
</div>
<div class="modal fade" id="payment_chart" role="dialog">
 <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal">&times;</button>
      <h4 class="modal-title">Total Payment</h4>
    </div>
    <div class="modal-body payment_chart_body">
    </div>
    <div class="modal-footer">
    <script src="{{ asset('js/jquery-1.10.2.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
  </div>
  </div>
</div>

@endsection
