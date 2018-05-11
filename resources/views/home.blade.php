@extends('layouts.admin')
@section('content')
<div class="content">
    <div class="container-fluid">
			<div class="row">
	                    <div class="col-lg-4 col-sm-6 ">
	                        <div class="card" style="background-color: #00c0ef;">
	                            <div class="card-content">
	                                <div class="row">
	                                    <div class="col-xs-5">
	                                        <div class="icon-big icon-warning text-center">
	                                            <i class="ti-user"></i>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-7">
	                                        <div class="numbers" style="color: #fff;">
	                                            <p>Clients</p>
	                                           <span><?=$clients?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
								<div class="card-footer">
									<hr>
									<div class="stats" style="color: #fff;">
										<a href="{{ route('clients.index') }}" style="color: #fff;">More info <i class="ti-arrow-right"></i> </a>
									</div>
								</div>
	                        </div>
	                    </div>
	                    <div class="col-lg-4 col-sm-6">
	                        <div class="card" style="background-color: #00a65a;">
	                            <div class="card-content">
	                                <div class="row">
	                                    <div class="col-xs-5">
	                                        <div class="icon-big icon-success text-center">
	                                            <i class="ti-world"></i>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-7">
	                                        <div class="numbers" style="color: #fff;">
	                                            <p>Domains</p>
	                                            <span><?=$domains?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
								<div class="card-footer">
									<hr>
									<div class="stats" style="color: #fff;">
										<a href="{{ route('domains.index') }}" style="color: #fff;">More info <i class="ti-arrow-right"></i> </a>
									</div>
								</div>
	                        </div>
	                    </div>
	                    <div class="col-lg-4 col-sm-6">
	                        <div class="card"  style="background-color: #f39c12;">
	                            <div class="card-content">
	                                <div class="row">
	                                    <div class="col-xs-5">
	                                        <div class="icon-big icon-danger text-center">
	                                            <i class="ti-harddrives"></i>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-7">
	                                        <div class="numbers" style="color: #fff;">
	                                            <p>Hostings</p>
	                                            <span><?=$hostings?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
								<div class="card-footer">
									<hr>
									<div class="stats" style="color: #fff;">
										<a href="{{ route('hostings.index') }}" style="color: #fff;">More info <i class="ti-arrow-right"></i> </a>
									</div>
								</div>
	                        </div>
	                    </div>
	                </div>
	                <div class="row">
	                   	<div class="col-lg-3 col-sm-6 ">
	                        <div class="card" style="background-color: #dd4b39;">
	                            <div class="card-content">
	                                <div class="row">
	                                    <div class="col-xs-2">
	                                        <div class="icon-big icon-info text-center">
	                                         	<?php 
						                            $currency='$';
						                            if(!empty($amt_currency->currency)) { 
						                                $currency=$amt_currency->currency;
						                            } 
						                            echo $currency;
						                         ?>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-10">
	                                        <div class="numbers" style="color: #fff;">
	                                            <p>Domain payment</p>
	                                            <p>({{ date('M-Y')}})</p>
	                                            <span><?=$pay_dom_monthly?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
							<div class="card-footer">
									<hr>
									<div class="stats" style="color: #fff;">
										<i class="ti-arrow-right"></i> Current Month Payments
									</div>
								</div>
	                        </div>
	                    </div>
	                    <div class="col-lg-3 col-sm-6">
	                        <div class="card" style="background-color: #605ca8;">
	                            <div class="card-content">
	                                <div class="row">
	                                    <div class="col-xs-3">
	                                        <div class="icon-big icon-warning text-center">
	                                            <?php 
						                            $currency='$';
						                            if(!empty($amt_currency->currency)) { 
						                                $currency=$amt_currency->currency;
						                            } 
						                            echo $currency;
						                            ?>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-9">
	                                        <div class="numbers" style="color: #fff;">
	                                            <p>Hosting payment</p>
	                                            <p>({{ date('M-Y')}})</p>
	                                           <span><?=$pay_host_monthly?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
							<div class="card-footer">
									<hr>
									<div class="stats" style="color: #fff;">
										<i class="ti-arrow-right"></i> Current Month Payments
									</div>
								</div>
	                        </div>
	                    </div>  
	                        <div class="col-lg-3 col-sm-6">
	                        <div class="card" style="background-color: #009688;">
	                            <div class="card-content">
	                                <div class="row">
	                                    <div class="col-xs-2">
	                                        <div class="icon-big icon-info text-center">
	                                         	<?php 
						                            $currency='$';
						                            if(!empty($amt_currency->currency)) { 
						                                $currency=$amt_currency->currency;
						                            } 
						                            echo $currency;
						                         ?>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-10">
	                                        <div class="numbers" style="color: #fff;">
	                                            <p>Domain payment</p>
	                                            <p>({{ date("M-Y", strtotime("-1 months"))}})</p>
	                                            <span><?=$pay_dom_prev_mont?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
								<div class="card-footer">
									<hr>
									<div class="stats" style="color: #fff;">
										<i class="ti-arrow-right"></i> Previouse Month Payments
									</div>
								</div>
	                        </div>
	                    </div>
	                    <div class="col-lg-3 col-sm-6 ">
	                        <div class="card" style="background-color: #2196F3;">
	                            <div class="card-content">
	                                <div class="row">
	                                    <div class="col-xs-3">
	                                        <div class="icon-big icon-warning text-center">
	                                            <?php 
						                            $currency='$';
						                            if(!empty($amt_currency->currency)) { 
						                                $currency=$amt_currency->currency;
						                            } 
						                            echo $currency;
						                            ?>
	                                        </div>
	                                    </div>
	                                    <div class="col-xs-9">
	                                        <div class="numbers" style="color: #fff;">
	                                            <p>Hosting payment</p>
	                                            <p>({{ date("M-Y", strtotime("-1 months"))}})</p>
	                                           <span><?=$pay_host_prev_mont?></span>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
								<div class="card-footer">
									<hr>
									<div class="stats" style="color: #fff;">
										<i class="ti-arrow-right"></i> Previouse Month Payments
									</div>
								</div>
	                        </div>
	                    </div> 
	        	</div>
	      
		</div>
</div>
@endsection
