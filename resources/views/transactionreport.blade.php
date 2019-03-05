@extends('layouts.admin')

@section('content')
<?php
use App\Currency;

$currency = '$';
if (!empty($amt_currency->currency)) {
	$currency = $amt_currency->currency;
}
?>
  <div class="content">
      <div class="container-fluid">
            <div class="card">
              <div class="card-content">
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="title">Transaction Details </h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-content">
                        <div class="fresh-datatables">
                          <table id="trans_report_datatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                              <tr>
                                  <th>Client Name</th>
                                  <th>Domain</th>
                                  <th>Type</th>
                                  <th>Name</th>
                                  <th>Amount</th>
                                  <th>Domain Purchased</th>
                                  <th>Year</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <th>Client Name</th>
                                  <th>Domain</th>
                                  <th>Type</th>
                                  <th>Name</th>
                                  <th>Amount</th>
                                  <th>Domain Purchased</th>
                                  <th>Year</th>
                                </tr>
                              </tfoot>
                              <tbody>
                                @foreach($data as $row)                                  
                                <tr>
                                  <td>{{ $row->clients->name }}</td>
                                  <td>{{ $row->domains->domain_name??"None"}}</td>
                                  <td>{{ $row->flag }}</td>
                                  <td>{{ $row->flag=='domain'?$row->domains->domain_name:$row->hostings->hosting_provider}}</td>
                                  <td><?=$currency . $row->amount?></td>
                                  <td>
                                  @if($row->hostings['domain_purchase_site'] == 0)
                                    From other site
                                  @else
                                    From this site
                                  @endif
                                  </td>
                                  <td>{{ $row->year }}</td>
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


    </div>
  </div>


@endsection
