<?php
namespace App\Http\Controllers;
use App\Domains;
use App\Clients;
use App\Hostings;
use App\Paymentreceipt;
use App\Currency;
use Illuminate\Http\Request;

class HomeController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $index['clients'] = Clients::all()->count();
        $index['domains'] = Domains::all()->count();
        $index['hostings'] = Hostings::all()->count();
        $index['amt_currency']=Currency::select('currency')->first();
        $index['pay_dom_monthly']=Paymentreceipt::sum_domain_payment_current();
        $index['pay_dom_prev_mont']=Paymentreceipt::sum_domain_payment_last();
        $index['pay_host_monthly']=Paymentreceipt::sum_hosting_payment_current();
        $index['pay_host_prev_mont']=Paymentreceipt::sum_hosting_payment_last();
        $index['page'] = "home";
        return view("home", $index);
    }
}
