<?php 
if(!empty($report)) {?>
<div align="center" style="height:30px;" style="font-size:9px;"><b>Transactions for <?php echo $report[0]['name']?></b></div>
<!--<div align="center" style="height:30px;" style="font-size:9px;"><b>Opening Stock - <?php echo $stock['opening_stock']?></b></div>
<div align="center" style="height:30px;" style="font-size:9px;"><b>Closing Stock - <?php echo $stock['closing_stock']?></b></div> !-->

<table class="bordered-table zebra-striped" width="100%">
<tr>
<th>SNo.</th>
<th class="my-span1">Trans.Qty</th>
<th class="my-span1">Trans.Wgt</th>
<th class="my-span1">Pre-Trans Qty</th>
<th class="my-span1">Post-Trans Qty</th>
<th class="my-span1">Pre-Trans Wgt</th>
<th class="my-span1">Post-Trans Wgt</th>
<th class="my-span1">Date</th>
<th class="my-span1">Flow</th>
</tr>
<tr><td colspan="5">Opening Stock : &nbsp; <?php echo $opening_stock?></td><td colspan="4">Closing Stock: &nbsp; <?php echo $closing_stock?></td></tr>
<?php 
$cnt = 1;
foreach($report as $rep) { ?>
<tr>
<td><?php echo $cnt; ?></td>
<td><?php echo $rep['quantity'] ?></td>
<td><?php echo $rep['weight']." ".'gms' ?> </td>
<td><?php echo $rep['quantity_before'] ?></td>
<td><?php echo $rep['quantity_after'] ?></td>
<td><?php echo $rep['weight_before']." ".'gms' ?></td>
<td><?php echo $rep['weight_after']." ".'gms' ?></td>
<td><?php echo $rep['created_at'] ?></td>
<td><?php if($rep['weight']>0){echo "In";} else {echo "Out";} ?></td>
</tr>
<?php $cnt++; } ?>
</table>
<?php } else {echo "No Records Found";}