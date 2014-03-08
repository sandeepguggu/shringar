<?php if(!empty($report)) {?>
<table class="bordered-table zebra-striped" width="100%">
<tr>
<th>SNo.</th>
<th>Name</th>
<th>By Cash</th>
<th>By Card</th>
<th>By Scheme</th>
<th>Amount</th>
<th>Discnt Type</th>
<th>Discnt Amt.</th>
<th>Total</th>
<th>Status</th>
</tr>
<?php
$cnt = 1;
foreach($report as $rep) { ?>
<tr>
<td><?php echo $cnt; ?></td>
<td><?php echo $rep['fname']." ".$rep['lname']?></td>
<td><?php echo $rep['paid_by_cash']?></td>
<td><?php echo $rep['paid_by_card'] ?></td>
<td><?php echo $rep['paid_by_scheme'] ?> </td>
<td><?php echo $rep['total_amount'] ?></td>
<td><?php echo $rep['discount_type'] ?></td>
<td><?php echo $rep['discount_value'] ?></td>
<td><?php echo $rep['final_amount'] ?></td>
<td><?php echo $rep['status'] ?></td>
</tr>
<?php $cnt++; } ?>
</table>
<?php } else {echo "No Records Found";}