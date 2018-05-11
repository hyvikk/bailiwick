<?php
namespace App\Http\Controllers;
use App\Currency;
use Illuminate\Http\Request;
use Input;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;
use Unirest;

class SettingController extends Controller
{
    public function index() {
        $index['amt_currency']=Currency::select('currency')->first();
        $index['page']='setting';
       return view("setting", $index);
    }

   public function store(Request $request)  {
        $validator = Validator::make($request->all(), [
            'currency' => 'required',
        ]);
        if ($validator->fails()) {
            return redirect('/setting')
                ->withErrors($validator)
                ->withInput();
        }
        $dd=Currency::select('id')->first();
        if(!empty($dd->id)){
            $data = Currency::whereid($dd->id)->first();
        } else{
            $data = new Currency;
        }
        $data->currency = $request->get("currency");
        $data->save();
        return Redirect::route("setting.index");
    }

    
}
