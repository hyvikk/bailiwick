<?php
namespace App\Http\Controllers;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;

class PasswordController extends Controller {
	public function __construct() {
		$this->middleware('auth');
	}

	public function index() {

		$index['page'] = "changepass";
		return view("changepass", $index);
	}
	public function changepassword(Request $request) {
		$validator = Validator::make($request->all(), [
			'passwd' => 'required',
		]);
		if ($validator->fails()) {
			return redirect('/changepass')
				->withErrors($validator)
				->withInput();
		}
		$id = Auth::user()->id;
		$user = User::whereId($id)->first();
		$user->password = bcrypt($request->passwd);
		$user->save();
		$data['page'] = "changepass";
		$data['msg'] = "Password is successfully changed.";
		return view("changepass", $data);

	}

}
