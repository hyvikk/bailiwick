<?php 
$currency='$';
if(!empty($amt_currency->currency)) { 
     $currency=$amt_currency->currency;
} ?>
<table class="table table-striped table-bordered">
    <thead>
        <tr>
            <th>Payment type</th>
            <th>Amount</th>  
            <th>Date</th>           
        </tr>
    </thead>
    <tbody>
       @foreach($receipt as $row)
        <tr>
          <td>{{$row->payment_type}}</td>
          <td><?=$currency.$row->amount?></td>
          <?php $date=date('d-m-Y',strtotime($row->created_at)); ?>
          <td>{{$date}}</td>
       </tr>
        @endforeach
   </tbody>
</table>