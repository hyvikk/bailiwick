<?php
namespace App\Http\Controllers;
use App\Clients;
use App\Countries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Redirect;
use Validator;

class ClientsController extends Controller {

	public function index() {
		$index['data'] = Clients::get();
		$index['page'] = 'clients';

		return view("clients.index", $index);
	}

	public function create() {
		$index['data'] = Countries::get();
		$index['page'] = 'clients';
		return view("clients.create", $index);
	}

	public function store(Request $request) {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone' => 'required|numeric',
			'email' => 'required|email',
			'country' => 'required',
			'address' => 'required',

		]);
		if ($validator->fails()) {
			return redirect('clients/create')
				->withErrors($validator)
				->withInput();
		}
		$Client = new Clients;
		$Client->user_id = Auth::user()->id;
		$Client->name = $request->get("name");
		$Client->email_id = $request->get("email");
		$Client->phone = $request->get("phone");
		$Client->country = $request->get("country");
		$Client->address = $request->get("address");
		$Client->save();
		return Redirect::route("clients.index");
	}

	public function edit($id) {
		$index['data'] = Clients::whereId($id)->first();
		$index['country'] = Countries::select('country_name')->get();
		$index['page'] = 'clients';
		return view("clients.edit", $index);
	}

	public function update(Request $request, $id) {
		$validator = Validator::make($request->all(), [
			'name' => 'required',
			'phone' => 'required|numeric',
			'email' => 'required|email',
			'country' => 'required',
			'address' => 'required',

		]);
		if ($validator->fails()) {
			return redirect('clients/' . $request->get("id") . '/edit')
				->withErrors($validator)
				->withInput();
		}
		$Client = Clients::whereid($request->get('id'))->first();
		$Client->user_id = $request->get("user_id");
		$Client->name = $request->get("name");
		$Client->email_id = $request->get("email");
		$Client->phone = $request->get("phone");
		$Client->country = $request->get("country");
		$Client->address = $request->get("address");
		$Client->save();
		return Redirect::route("clients.index");
	}

	public function destroy(Request $request) {
		Clients::find($request->get('id'))->delete();
		return redirect()->route('clients.index');

	}

}
