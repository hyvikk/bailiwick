<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="csrf_token" content="{{ csrf_token() }}">
    <link href="{{ asset('css/paper-dashboard.css') }}" rel="stylesheet">
    <!-- Animation library for notifications   -->
    <link href="{{ asset('css/animate.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/demo.css') }}" rel="stylesheet">
    <!--  Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='https://fonts.googleapis.com/css?family=Muli:400,300' rel='stylesheet' type='text/css'>
    <link href="{{ asset('css/themify-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datepicker.css') }}" rel="stylesheet">

   <style>

   #chart_table{
    display:none;
   }
   .pagination>li>a, .pagination>li>span {
    padding: 2px 8px;
  }
  .pagination > li > a, .pagination > li > span {
    height: 24px;
    min-width: 20px;
  }
  .pagination > li.active > a{
    font-size: 12px;
  }
   </style>
   <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
    </script>

</head>
<div class="js">
<body>
<div id="preloader"></div>
<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">
       <div class="sidebar-wrapper">
            <div class="logo">
                <a href="#" class="simple-text">
                    <img src="{{ asset('img/Bailiwick-220px.png') }}" alt="logo" />
                </a>
            </div>
            <ul class="nav">
                <li class="{{ $page == 'home' ? 'active' : '' }}">
                    <a href="{{ url('/') }}"> <i class="ti-panel"></i>
                    <p>Dashboard</p></a>
                </li>
                <li class="{{ $page == 'clients' ? 'active' : '' }}">
                    <a href="{{ route('clients.index') }}"><i class="ti-user"></i>
                    <p>Clients</p></a>
                </li>
                <li class="{{ $page == 'domains' ? 'active' : '' }}">
                    <a href="{{ route('domains.index') }}"><i class="ti-world"></i>
                    <p>Domains</p></a>
                </li>
                <li class="{{ $page == 'hostings' ? 'active' : '' }}">
                    <a href="{{ route('hostings.index') }}"><i class="ti-harddrives"></i>
                    <p>Hostings</p></a>
                </li>
                <li class="{{ $page == 'report' ? 'active' : '' }}">
                    <a href="{{ route('report.index') }}"><i class="ti-notepad"></i>
                    <p>Reports</p></a>
                </li>
                <li class="{{ $page == 'transaction_report' ? 'active' : '' }}">
                    <a href="{{ route('transaction_report.index') }}"><i class="ti-layout-accordion-merged"></i>
                    <p>Transaction Reports</p></a>
                </li>
                <li class="{{ $page == 'payment_report' ? 'active' : '' }}">
                    <a href="{{ route('payment_report.index') }}"><i class="ti-money"></i>
                    <p>Payment Reports</p></a>
                </li>
                <li class="{{ $page == 'setting' ? 'active' : '' }}">
                    <a href="{{ route('setting.index') }}"><i class="ti-settings"></i>
                    <p>Setting</p></a>
                </li>
             </ul>
        </div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" href="#">Dashboard</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                         @if (!Auth::guest())
                        <li class="dropdown">
                              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <p>{{ Auth::user()->name }}</p>
                                <b class="caret"></b>
                              </a>
                              <ul class="dropdown-menu">
                                <li  class="{{ $page == 'changepass' ? 'active' : '' }}"><a href="{{ url('/changepass') }}">Change Password</a></li>
                                <li>
                                   <a href="{{ route('logout') }}"
                                      onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">
                                      Logout
                                  </a>
                                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                              {{ csrf_field() }}
                                  </form>
                                </li>
                              </ul>
                          </li>
                         @endif
                    </ul>

                </div>
            </div>
        </nav>
        @yield('content')

        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script> <a href="http://www.hyvikk.com">Hyvikk</a>
                </div>
            </div>
        </footer>
    </div>
</div>
<div class="modal fade" id="hosting_receipt_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Payment Receipt</h4>
      </div>
       <div class="modal-body">
         {!! Form::open(['url' =>'hosting_payment_receipt','method'=>'post','id'=>'host_pay_receipt']) !!}
         <div class="alert alert-danger error_alert" role="alert" style="display: none">
              <ul></ul>
          </div>
          <div class="row">
              <input type="hidden" id="pay_host_transid" name="pay_host_transid" value="">
              <input type="hidden" id="pay_host_clientid" name="pay_host_clientid" value="">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Payment Type</label>
                    <select class="form-control" name="payment_type" id="payment_type">
                        <option value="">--select--</option>
                        <option value="bank" @if (Input::old('payment_type') == 'bank') selected @endif>bank</option>
                        <option value="cheque" @if (Input::old('payment_type') == 'cheque') selected @endif>cheque</option>
                        <option value="cash" @if (Input::old('payment_type') == 'cash') selected @endif>cash</option>
                        <option value="paypal" @if (Input::old('payment_type') == 'paypal') selected @endif>paypal</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" name="amount" id="amount" placeholder="Enter amount" class="form-control" value="{{ old('amount') }}">
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <a href="#transactions_modal" data-toggle="modal" data-dismiss="modal" class="btn btn-info pull-left" role="button">Back</a>
        <button type="submit" class="btn btn-primary pull-left">Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
       {!! Form::close() !!}
    </div>
  </div>
</div>
</div>
<div class="modal fade" id="domain_receipt_modal" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title">Payment Receipt</h4>
      </div>
       <div class="modal-body">
         {!! Form::open(['url' =>'domain_payment_receipt','method'=>'post','id'=>'domain_pay_receipt']) !!}
         <div class="alert alert-danger domain_error_alert" role="alert" style="display: none">
              <ul></ul>
          </div>
          <div class="row">
          <input type="hidden" id="pay_trans_id" name="pay_trans_id" value="">
          <input type="hidden" id="pay_client_id" name="pay_client_id" value="">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Payment Type</label>
                    <select class="form-control" name="domain_payment_type" id="domain_payment_type">
                        <option value="">--select--</option>
                        <option value="bank" @if (Input::old('domain_payment_type') == 'bank') selected @endif>bank</option>
                        <option value="cheque" @if (Input::old('domain_payment_type') == 'cheque') selected @endif>cheque</option>
                        <option value="cash" @if (Input::old('domain_payment_type') == 'cash') selected @endif>cash</option>
                        <option value="paypal" @if (Input::old('domain_payment_type') == 'paypal') selected @endif>paypal</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Amount</label>
                    <input type="text" name="domain_amount" id="domain_amount" placeholder="Enter amount" class="form-control" value="{{ old('domain_amount') }}">
                </div>
            </div>
        </div>
      <div class="modal-footer">
        <a href="#domains_modal" data-toggle="modal" data-dismiss="modal" class="btn btn-info pull-left" role="button">Back</a>
        <button type="submit" class="btn btn-primary pull-left" >Submit</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
       {!! Form::close() !!}
    </div>
  </div>
</div>
</div>


@yield('modal')
</body>
</div>
    <script src="{{ asset('js/jquery-1.10.2.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/nouislider.min.js') }}"></script>
    <script src="{{ asset('js/es6-promise-auto.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-checkbox-radio.js') }}"></script>
    <script src="{{ asset('js/paper-dashboard.js') }}"></script>
    <script src="{{ asset('js/jquery.datatables.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datepicker.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.js"></script>
    <script src="{{ asset('js/demo.js')}}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('#datatables').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });
            $('#domain_report_datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });
            $('#hosting_report_datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });

            $('#hosting_datatable').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                responsive: true,
                language: {
                search: "_INPUT_",
                    searchPlaceholder: "Search records",
                }
            });

            $('#trans_report_datatable').DataTable( {
               "pagingType": "full_numbers",
              initComplete: function () {
                  this.api().columns().every( function (i) {
                      var column = this;
                        if (i==0 || i==1 || i == 2 )
                    {
                      var select = $('<select><option value=""></option></select>')
                          .appendTo( $(column.footer()).empty() )
                          .on( 'change', function () {
                              var val = $.fn.dataTable.util.escapeRegex(
                                  $(this).val()
                              );

                              column
                                  .search( val ? '^'+val+'$' : '', true, false )
                                  .draw();
                          } );
                 column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );

                }
            } );
        }
    } );

  $('#pay_report_datatable').DataTable( {
     "pagingType": "full_numbers",
      initComplete: function () {
                  this.api().columns().every( function (i) {
                      var column = this;
                       if (i==0 || i==1 || i == 2 || i == 3)
                    {
                      var select = $('<select><option value=""></option></select>')
                          .appendTo( $(column.footer()).empty() )
                          .on( 'change', function () {
                              var val = $.fn.dataTable.util.escapeRegex(
                                  $(this).val()
                              );

                              column
                                  .search( val ? '^'+val+'$' : '', true, false )
                                  .draw();
                          } );
                 column.data().unique().sort().each( function ( d, j ) {
                    select.append( '<option value="'+d+'">'+d+'</option>' )
                } );
                }
            } );
        }
    } );
});

    $('#crdate').datepicker({
       format: 'dd-mm-yyyy',
       autoclose:true
     });
    $('#upddate').datepicker({
       format: 'dd-mm-yyyy',
       autoclose:true
     });
    $('#expdate').datepicker({
       format: 'dd-mm-yyyy',
       autoclose:true
     });
    $('#start_date').datepicker({
       format: 'dd-mm-yyyy',
       autoclose:true
     });
    $('#end_date').datepicker({
       format: 'dd-mm-yyyy',
       autoclose:true
     });

    function get_hosting_trans(id)  {
      //alert(id);
      $.ajax({
        url:'hosting_transaction',
        type:'GET',
        data:{
          'id':id,
        },
        success:function(data){
          $('#transactions_modal').appendTo("body").modal('show');
          $(".transcation_modal_body").html(data);
          //alert(data);
        },
         error:function(){
          alert("eoor");
             }
      });
  }
  function get_domain_trans(id)  {
      $.ajax({
        url:'domain_transaction',
        type:'GET',
        data:{
          'id':id,
        },
        success:function(data){
          $('#domains_modal').appendTo("body").modal('show');
          $(".domain_modal_body").html(data);
        },
         error:function(){
             }
      });
  }
    function view_domain_receipt(id)  {
      $.ajax({
        url:'domain_view_receipt',
        type:'GET',
        data:{
          'id':id,
        },
        success:function(data){
          $('#receipt_domains_modal').appendTo("body").modal('show');
          $(".dom_receipt_body").html(data);
        },
         error:function(){
             }
      });
  }
  function dom_report_receipt(id)  {
      $.ajax({
        url:'domain_report_receipt',
        type:'GET',
        data:{
          'id':id,
        },
        success:function(data){
          $('#receipt_domains_report').appendTo("body").modal('show');
          $(".dom_receipt_report").html(data);
        },
         error:function(){
             }
      });
  }
  function view_hosting_receipt(id)  {
      $.ajax({
        url:'hosting_view_receipt',
        type:'GET',
        data:{
          'id':id,
        },
        success:function(data){
          $('#receipt_hosting_modal').appendTo("body").modal('show');
          $(".host_receipt_body").html(data);
        },
         error:function(){
             }
      });
  }
  function host_report_receipt(id)  {
      $.ajax({
        url:'hosting_report_receipt',
        type:'GET',
        data:{
          'id':id,
        },
        success:function(data){
          $('#receipt_hostings_report').appendTo("body").modal('show');
          $(".hosting_receipt_report").html(data);
        },
         error:function(){
             }
      });
  }

$(document).ready(function(){
  var val=$('#client').val();
    if(val !=""){
    $('#chart_link').show();
  }

$(function(){
  $('#chart_link').click(function(){
        $(this).text(function(_, val){
            return val == "show chart" ? "hide chart" : "show chart"
        });
       $('.chart_toggle').slideToggle($(this).text() == "hide chart");
   });
});

});
 $('#hosting_receipt_modal').on('show.bs.modal', function (e) {
    var id = $(e.relatedTarget).data('id');
    var client_id = $(e.relatedTarget).data('clientid');
     $('#pay_host_transid').val(id);
    $('#pay_host_clientid').val(client_id);
  })
$(document).on('submit', '#host_pay_receipt', function(event){
 var info = $('.error_alert');
  event.preventDefault();
  var data = { amount: $("#amount").val(),  payment_type: $("#payment_type").val(), trans_id: $("#pay_host_transid").val(),  client_id: $("#pay_host_clientid").val()}
    $.ajax({
      url: "hosting_payment_receipt",
      type: "GET",
      data: data,
    }).done(function(response) {
        info.hide().find('ul').empty();
        if(response.errors)
        {
            $.each(response.errors, function(index, error){
                info.find('ul').append("<li>"+error+"</li>");
            });
            info.slideDown();
        }
        else if(response.success){
          window.location.href = "{{ route('hostings.index') }}";
        }
    });
});
$('#hosting_receipt_modal').on('hidden.bs.modal', function () {
    $('.error_alert').hide();
    $(this).find('#host_pay_receipt').trigger('reset');
})
 $('#domain_receipt_modal').on('show.bs.modal', function (e) {
    var id = $(e.relatedTarget).data('id');
    var client_id = $(e.relatedTarget).data('clientid');
     $('#pay_trans_id').val(id);
    $('#pay_client_id').val(client_id);
  })
$(document).on('submit', '#domain_pay_receipt', function(e){
  var info = $('.domain_error_alert');
  event.preventDefault();
  var data = { domain_amount: $("#domain_amount").val(),  domain_payment_type: $("#domain_payment_type").val(), trans_id: $("#pay_trans_id").val(),  client_id: $('#pay_client_id').val()}
    $.ajax({
      url: "domain_payment_receipt",
      type: "GET",
      data: data,
    }).done(function(response) {

        info.hide().find('ul').empty();
        if(response.errors)
        {
            $.each(response.errors, function(index, error){
                info.find('ul').append("<li>"+error+"</li>");

            });
            info.slideDown();
        }
        else if(response.success){
          window.location.href = "{{ route('domains.index') }}";
        }
    });
});
$('#domain_receipt_modal').on('hidden.bs.modal', function () {
    $('.domain_error_alert').hide();
    $(this).find('#domain_pay_receipt').trigger('reset');
})


$('#domain_renew_modal').on('show.bs.modal', function (e) {
  var id = $(e.relatedTarget).data('id');
  var client_id = $(e.relatedTarget).data('clientid');
  var expiry_date = $(e.relatedTarget).data('expiry_date');
  $('#renew_client_id').val(client_id);
  $('#renew_domain_id').val(id);
  $('#renew_expiry_date').val(expiry_date);
})
$('#domain_renew_modal').on('hidden.bs.modal', function () {
    $('.domain_renew_error').hide();
    $(this).find('#domain_renew').trigger('reset');
})
$(document).on('submit', '#domain_renew', function(event){
   var info = $('.domain_renew_error');
  event.preventDefault();
  var data = { domain_id: $("#renew_domain_id").val(),client_id: $("#renew_client_id").val(), domain_renew_year: $("#domain_renew_year").val(),  domain_renew_amount: $("#domain_renew_amount").val(),expiry_date: $("#renew_expiry_date").val(),}
    $.ajax({
      url: "domain_renew",
      type: "GET",
      data: data,
    }).done(function(response) {
      //alert(response);
        info.hide().find('ul').empty();
        if(response.errors)
        {
            $.each(response.errors, function(index, error){
                info.find('ul').append("<li>"+error+"</li>");
                //alert(error);
            });
            info.slideDown();
        }
        else if(response.success){
         //$('#domain_renew').modal('hide');
          window.location.href = "{{ route('domains.index') }}";
        }
    });
});

$('#hosting_renew_modal').on('show.bs.modal', function (e) {
  var id = $(e.relatedTarget).data('id');
  var client_id = $(e.relatedTarget).data('clientid');
  var end_date = $(e.relatedTarget).data('end_date');
  $('#renew_host_client_id').val(client_id);
  $('#renew_hosting_id').val(id);
  $('#renew_end_date').val(end_date);
})
$('#hosting_renew_modal').on('hidden.bs.modal', function () {
    $('.hosting_renew_error').hide();
    $(this).find('#hosting_renew').trigger('reset');
})
$(document).on('submit', '#hosting_renew', function(event){
   var info = $('.hosting_renew_error');
  event.preventDefault();
  var data = { hosting_id: $("#renew_hosting_id").val(),client_id: $("#renew_host_client_id").val(), hosting_renew_year: $("#hosting_renew_year").val(),  hosting_renew_amount: $("#hosting_renew_amount").val(),end_date: $("#renew_end_date").val(),}
    $.ajax({
      url: "hosting_renew",
      type: "GET",
      data: data,
    }).done(function(response) {
      //alert(response);
        info.hide().find('ul').empty();
        if(response.errors)
        {
            $.each(response.errors, function(index, error){
                info.find('ul').append("<li>"+error+"</li>");
                //alert(error);
            });
            info.slideDown();
        }
        else if(response.success){
         //$('#domain_renew').modal('hide');
          window.location.href = "{{ route('hostings.index') }}";
        }
    });
});
</script>

</html>
