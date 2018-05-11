@extends('layouts.admin')

@section('content')

  <div class="content">
      <div class="container-fluid">
            <div class="card">
              <div class="card-content">
                <div class="row">
                  <div class="col-md-12">
                    <h4 class="title">Payment Details </h4>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card">
                      <div class="card-content">
                        <div class="fresh-datatables">
                          <table id="pay_report_datatable" class="table table-striped table-no-bordered table-hover" cellspacing="0" width="100%" style="width:100%">
                            <thead>
                              <tr>
                                  <th>Client Name</th>
                                  <th>Type</th>
                                  <th>Name</th>
                                  <th>Payment Type</th>
                                  <th>Amount</th>
                                </tr>
                              </thead>
                              <tfoot>
                                <tr>
                                  <th>Client Name</th>
                                  <th>Type</th>
                                  <th>Name</th>
                                  <th>Payment Type</th>
                                  <th>Amount</th>
                                </tr>
                              </tfoot>
                              <tbody>
                                @foreach ($data as $row)
                                    <tr>
                                      <td>{{ $row->client->name }}</td>
                                      <td>{{ $row->transaction_type }}</td>
                                      <td>{{ $row->transactions->flag=='domain'?$row->transactions->domains->domain_name:$row->transactions->hostings->hosting_provider}}</td>
                                      <td>{{ $row->payment_type }}</td>
                                      <td>{{$currency . $row->amount}}</td>
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
