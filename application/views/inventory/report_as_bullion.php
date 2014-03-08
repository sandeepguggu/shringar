<?php 
if(!empty($report)) {?>
<table class="bordered-table zebra-striped" width="100%">
<tr>
<th class="my-span1">SNo.</th>
<th class="my-span1">Name</th>
<th class="my-span1">Price</th>
<th class="my-span1">Trans Qty</th>
<th class="my-span1">Trans Wgt</th>
<th class="my-span1">Pre-Trans Qty</th>
<th class="my-span1">Post-Trans Qt</th>
<th class="my-span1">Pre-Trans Wgt</th>
<th class="my-span1">Post-Trans Wgt</th>
<th class="my-span1">Date</th>
<th class="my-span1">Flow</th>
</tr>
<?php 
$cnt = 1;
foreach($report as $rep) { ?>
<tr>
<td><?php echo $cnt; ?></td>
<td><?php echo $rep['item_specific_name']?></td>
<td><?php echo $rep['price']?></td>
<td><?php echo $rep['transaction_qty'] ?> </td>
<td><?php echo $rep['transaction_weight'] ?></td>
<td><?php echo $rep['quantity_before'] ?></td>
<td><?php echo $rep['quantity_after'] ?></td>
<td><?php echo $rep['weight_before'] ?></td>
<td><?php echo $rep['weight_after'] ?></td>
<td><?php echo $rep['created_at'] ?></td>
<td><?php if($rep['transaction_qty']>0){echo "In";} else {echo "Out";} ?></td>
</tr>
<?php $cnt++; } ?>
</table>
<?php } else {echo "No Records Found";}