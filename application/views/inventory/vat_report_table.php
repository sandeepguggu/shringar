<?php $vat_percentages = $data['vat_percentages']; ?>
<div class="content-subject">
    <div class="data-grid">
        <div class="block grid-message">  
            <span class="pull-left grid-message-text total-record">Total Number of Records : <span id="count-total"></span><?php echo $count; ?></span>
        </div>
        <table class="table table-striped table-bordered" width="100%">
            <thead>
                <tr>
                    <th>BILL NO / REF NO</th>
                    <th>DATE</th>
                    <th>TOTAL SALES</th>
                    <?php foreach ($vat_percentages as $vat) { if($vat['vat_percentage'] > 0) {?> <th>GROSS SALES @ <?php echo $vat['vat_percentage']?> </th>  <th>VAT @<?php echo $vat['vat_percentage']?> </th><?php  } else { ?><th>EXEMPTED</th> <?php }} ?> 
                </tr>
            </thead>
            <tbody>
                <?php 
               // debugbreak();
                    $data_bill = $data['bill'];
                   // $qty_sold = 0; $qty_purchased = 0; $qty_left = 0; $landed_cost = 0; $value = 0; $opening_balance = 0;
                    // debugbreak();
                    //$i = $offset;
                    foreach($data_bill as $d)
                    { 
                       // $qty_sold = $qty_sold + round($d['qty_sold'],0);
                       // $qty_purchased = $qty_purchased + round($d['qty_purchased'],0);
                       // $qty_left = $qty_left + round($d['qty_left'],0);
                      //  $landed_cost = $landed_cost + $d['cost_per_unit'];
                      //  $value = $value + ($d['cost_per_unit'] * round($d['qty_left'],0));
                     //   $opening_balace = $opening_balance + round($d['opening_qty'],0);
                      //  $per_qty_left =  ( round($d['opening_qty'],0) + round($d['qty_purchased'],0) ) -  round($d['qty_sold'],0);
                    ?>
                    <tr>
                        <td><?php echo $d['bill_id'];?></td>
                        <td><?php echo $d['created_at']?></td>
                        <td><?php echo $d['vat_inclusive_amount']?></td>
                        <?php foreach($vat_percentages as $vat){ if($vat['vat_percentage'] > 0) { ?>
                         <td><?php echo $d['gross_sales @'.$vat['vat_percentage']]?></td>
                         <td><?php echo $d['vat @'.$vat['vat_percentage']]?></td>      
                       <?php }else{ ?>   
                         <td><?php echo $d['exempted'] ?></td>
                         
                        <?php } 
                        } ?>
                    </tr>   
                    <?php  } ?>
            </tbody> 
        </table>
        <div class="pagination"><?php echo $pagination ?></div>
    </div>
</div>