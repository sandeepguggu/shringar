<?php 
if(!empty($report)) {?>
<table class="bordered-table zebra-striped" width="100%">
<tr>
<th>SNo.</th>
<th>Name</th>
<th>Price</th>
<th>Trans Qty</th>
<th>Trans Wgt</th>
<th>Weight before</th>
<th>Weight after</th>
<th>Qty before</th>
<th>Qty after</th>
<th>Date</th>
<th>Flow</th>
</tr>
<?php 
$cnt = 1;
foreach($report as $rep) { ?>
<tr>
<td><?php echo $cnt; ?></td>
<td><?php echo $rep['ornament_name']?></td>
<td><?php echo $rep['price']?></td>
<td><?php echo $rep['quantity'] ?></td>
<td><?php echo $rep['weight'] ?> </td>
<td><?php echo $rep['weight_before'] ?></td>
<td><?php echo $rep['weight_after'] ?></td>
<td><?php echo $rep['quantity_before'] ?></td>
<td><?php echo $rep['quantity_after'] ?></td>
<td><?php echo $rep['created_at'] ?></td>
<td><?php if($rep['weight']>0){echo "In";} else {echo "Out";} ?></td>
</tr>
<?php $cnt++; } ?>
</table>
<?php } else {echo "No Records Found";}