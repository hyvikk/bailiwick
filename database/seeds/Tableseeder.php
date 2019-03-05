<?php
use App\Clients;
use App\Currency;
use App\Domains;
use App\Hostings;
use App\Paymentreceipt;
use App\Transactions;
use App\User;
use Illuminate\Database\Seeder;

class Tableseeder extends Seeder {
	public function run() {
		/* users table insert */

		$users = (
			['name' => 'super admin', 'email' => 'admin@gmail.com', 'password' => bcrypt('admin'), 'remember_token' => str_random(60)]
		);
		$user = User::create($users);
		$user_id = $user->id;

		/* clients table insert */

		$clients = [
			['user_id' => $user_id, 'name' => 'client1', 'email_id' => 'client1@gmail.com', 'phone' => 8777777777, 'country' => 'United States', 'address' => 'address1'],

			['user_id' => $user_id, 'name' => 'client2', 'email_id' => 'client2@gmail.com', 'phone' => 8777777799, 'country' => 'United States', 'address' => 'address2'],
		];

		foreach ($clients as $row) {
			$client = Clients::create($row);
			$client_ids[] = $client->id;
		}

		/* domains table insert */

		$domains = [
			['user_id' => $user_id, 'client_id' => $client_ids[0], 'domain_name' => 'google.com', 'creation_date' => '1997-09-14', 'note' => 'note1', 'expiry_date' => '2020-09-14', 'registrar' => 'MarkMonitor ,Inc.'],

			['user_id' => $user_id, 'client_id' => $client_ids[1], 'domain_name' => 'facebook.com', 'creation_date' => '1997-03-29', 'note' => 'note2', 'expiry_date' => '2025-03-29', 'registrar' => 'MarkMonitor, Inc.'],
		];
		foreach ($domains as $row) {
			$domain = Domains::create($row);
			$domain_id[] = $domain->id;
		}

		/* domains transaction insert */

		$domain_trans = [
			['flag' => 'domain', 'attach_id' => $domain_id[0], 'client_id' => $client_ids[0], 'amount' => 500.00, 'year' => '23', 'domain_id' => $domain_id[0]],

			['flag' => 'domain', 'attach_id' => $domain_id[1], 'client_id' => $client_ids[1], 'amount' => 800.00, 'year' => '28', 'domain_id' => $domain_id[1]],
		];

		foreach ($domain_trans as $row) {
			$domain_trans = Transactions::create($row);
			$domain_trans_id[] = $domain_trans->id;
		}

		/* domains receipt insert */

		$domain_receipt = [
			['transaction_id' => $domain_trans_id[0], 'transaction_type' => 'domain', 'client_id' => $client_ids[0], 'payment_type' => 'bank', 'amount' => 500.00],

			['transaction_id' => $domain_trans_id[1], 'transaction_type' => 'domain', 'client_id' => $client_ids[1], 'payment_type' => 'cash', 'amount' => 600.00],
		];

		foreach ($domain_receipt as $row) {
			$domain_receipt = Paymentreceipt::create($row);

		}

		/* hosting table insert */

		$hosting = [
			['client_id' => $client_ids[0], 'hosting_provider' => 'godaddy', 'start_date' => '2017-07-01', 'end_date' => '2020-07-01', 'hosting_type' => 'cloud', 'notes' => 'notes'],

			['client_id' => $client_ids[1], 'hosting_provider' => 'abc provider', 'start_date' => '2017-07-17', 'end_date' => '2021-07-17', 'hosting_type' => 'dedicated', 'notes' => 'notes'],
		];
		foreach ($hosting as $row) {
			$hosting = Hostings::create($row);
			$hosting_id[] = $hosting->id;
		}

		/* hosting  transaction  insert */

		$hosting_trans = [
			['flag' => 'hosting', 'attach_id' => $hosting_id[0], 'client_id' => $client_ids[0], 'amount' => 600.00, 'year' => '3', 'hosting_id' => $hosting_id[0]],

			['flag' => 'hosting', 'attach_id' => $hosting_id[1], 'client_id' => $client_ids[1], 'amount' => 900.00, 'year' => '4', 'hosting_id' => $hosting_id[1]],
		];

		foreach ($hosting_trans as $row) {
			$hosting_trans = Transactions::create($row);
			$hosting_trans_id[] = $hosting_trans->id;
		}

		/* hosting  receipt  insert */

		$hosting_receipt = [

			['transaction_id' => $hosting_trans_id[1], 'transaction_type' => 'hosting', 'client_id' => $client_ids[1], 'payment_type' => 'cash', 'amount' => 900.00],
		];

		foreach ($hosting_receipt as $row) {
			$hosting_receipt = Paymentreceipt::create($row);

		}

		/* currency table insert */

		$currency = (
			['currency' => '$']
		);
		Currency::create($currency);

	}
}