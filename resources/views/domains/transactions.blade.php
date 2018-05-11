<?php
use App\Currency;

$currency = '$';
if (!empty($amt_currency->currency)) {
	$currency = $amt_currency->currency;
}?>
<table class="table table-striped table-bordered">
  <thead>
    <tr>
      <th>Client Name</th>
      <th>Domain Name</th>
      <th>Amount</th>
      <th>Remaining</th>
      <?php $i = 0;
$j = 0;
$count = $trans->count();

foreach ($trans as $row) {

	if (!is_null($payment_receipt) && $payment_receipt->count() > 0) {

		if ($sum == $row->amount) {
			$i += 1;
		}
		$j += 1;
	}

	if ($count != $i) {
		?>
  <th>Pay Receipt</th>
  <?php }
	if ($j > 0) {?>
  <th>View Receipt</th>
  <?php }?>
</tr>
<?php }?>
</thead>
<tbody>
 <?php
foreach ($trans as $row) {
	?>
  <tr>
    <td><?php echo $client_name->name ?> </td>
    <td><?php echo $dd->domain_name ?></td>
    <td><?php echo $currency . $row->amount ?></td>

    <?php

	if (is_null($payment_receipt) || $payment_receipt->count() < 1) {
		?>
     <td><?php echo $currency . $row->amount ?></td>
     <td>
      <a title="payment receipt" class="btn btn-primary" href="#domain_receipt_modal" data-toggle="modal" data-dismiss="modal" data-id="<?php echo $row->id; ?>" data-clientid="<?php echo $row->client_id; ?>"><i class="ti-receipt"></i></a>
    </td>
    <?php
}
	if (!is_null($payment_receipt) && $payment_receipt->count() > 0) {
		//$sum = Paymentreceipt::sum_amount($row->id);
		if ($sum < $row->amount) {
			$rem = $row->amount - $sum;
			$rem_amount = number_format($rem, 2, '.', ',')
			?>
    <td><?php echo $currency . $rem_amount ?></td>
    <td>
     <a title="payment receipt" class="btn btn-primary" href="#domain_receipt_modal" data-toggle="modal" id="aa" data-dismiss="modal"  data-id="<?php echo $row->id; ?>" data-clientid="<?php echo $row->client_id; ?>"><i class="ti-receipt"></i></a>
   </td>
   <td>
     <a onClick="view_domain_receipt(this.id)" title="view receipt" class="btn btn-success" data-toggle="modal" data-dismiss="modal" id="<?php echo $row->id; ?>"><i class="ti-clipboard"></i></a>
   </td>
   <?php
}
		if ($sum == $row->amount) {
			?>
  <td>0</td>
  <?php if ($count != $i) {?>
  <td></td>
  <?php }?>
  <td>
   <a onClick="view_domain_receipt(this.id)" title="view receipt" class="btn btn-success" data-toggle="modal" data-dismiss="modal" id="<?php echo $row->id; ?>"><i class="ti-clipboard"></i></a>
 </td>
 <?php
}
	}
	?>
</tr>
<?php
}?>
</tbody>
</table>
