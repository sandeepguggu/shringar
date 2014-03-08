<?php //print_r($output); ?>
<?php if ($output['print'] == 1): ?>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-1.6.2.min.js'); ?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url('resources/js/jquery-barcode-2.0.2.js'); ?>"></script>
<script language="javascript">
    $(document).ready(function(){
        $('.old-purchase-print').find('.barcode-target').barcode("<?php echo $output['barcode']; ?>", "code128",{barWidth:1, barHeight:40});
<?php if ($output['print'] == 1): ?>
            window.print();
<?php endif; ?>
    });
</script>
<?php
$metal_table = 0;
$stone_table = 0;
$ornament_table = 0;
foreach ($output['items'] as $k => $v) {
    if ($v['item_entity_id'] == 1) {
        $metal_table = 1;
    } else if ($v['item_entity_id'] == 2) {
        $stone_table = 1;
    }
}
?>
<div class="old-purchase-print my-block">
    <h3>Old Metal Purchase</h3>
    <hr />
    <div class="my-block">
        <div class="pull-left span6">
            <b class="customer-style"><?php echo $output['customer']['fname'] . ' ' . $output['customer']['lname']; ?></b><br/>
            <span class="customer-style">Ph: <?php echo $output['customer']['phone']; ?></span><br />
            <span class="customer-style"><?php echo $output['customer']['building'] . ', ' . $output['customer']['street'] . ', ' . $output['customer']['area']; ?></span>
        </div>
        <div class="pull-right">
            <table class="my-table" style="width: 300px">
                <tr>
                    <td class="span2 meta-head">Purchase Bill #</td>
                    <td class="span2"><span class="pull-right"><?php echo $output['bill_id']; ?></span></td>
                </tr>
                <tr>
                    <td class="span2 meta-head">Date</td>
                    <td class="span2"><span class="pull-right"><?php echo $output['date']; ?></span></td>
                </tr>
            </table>
        </div>
        <div class="span1 pull-right">&nbsp;</div>
        <div class="pull-right barcode-target">
        </div>
    </div>
    <?php if ($metal_table > 0): ?>
        <h4>Metal</h4>
        <br />
        <table style="width:99%" class="my-table">
            <tr>
                <th class="my-span1 meta-head my-border-left">ID</th>
                <th class="meta-head">Metal Name</th>
                <th class="my-span1 meta-head">Fineness</th>
                <th class="my-span3 meta-head">Gr. Wt.</th>
                <th class="my-span3 meta-head">Nt. Wt.</th>
                <th class="my-span3 meta-head">Rate</th>
                <th class="meta-head my-span5">Price</th>
            </tr>
            <?php
            $sno = 1;
            ?>
            <?php foreach ($output['items'] as $k => $v): ?>
                <?php if ($v['item_entity_id'] == 1): //print_r($v); ?>                    
                    <tr>
                        <td class="my-span1 my-border-bottom my-border-left">
                            <span class="my-span1"><?php echo $sno++; ?></span>
                        </td>
                        <td class="my-border-bottom">
                            <span><?php echo $v['name']; ?></span>
                        </td>
                        <td class="my-span1 my-border-bottom  my-text-align-center">
                            <span class="my-span1"><?php echo $v['fineness']; ?></span>
                        </td>
                        <td class="my-span3 my-border-bottom">
                            <span class="my-span3 pull-right"><?php echo $v['gross_weight']; ?></span>
                        </td>
                        <td class="my-span3 my-border-bottom">
                            <span class="my-span3 pull-right"><?php echo $v['net_weight']; ?></span>
                        </td>
                        <td class="my-border-bottom">
                            <b class="pull-right"><?php echo $v['rate']; ?></b>
                        </td>
                        <td class="my-border-bottom">
                            <b class="pull-right"><?php echo $v['price']; ?></b>
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="4" class="my-border-right my-border-bottom-no my-border-left-no">&nbsp;</td>
                <td colspan="2" class="my-border-right my-border-bottom"><b class="pull-right">Total</b></td>
                <td colspan="1" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="metal-final-total pull-right"><?php echo $output['total']; ?></b></td>
            </tr>
        </table>
    <?php endif; ?>

    <?php if ($stone_table > 0): ?>
        <h4>Stone</h4>
        <br />
        <table style="width:99%" class="my-table" id="selected_Stones">
            <tr>
                <th class="my-span1 meta-head">S.No.</th>
                <th class="meta-head">Stone Name</th>
                <th class="my-span4 meta-head">Carat Wt</th>
                <th class="my-span3  meta-head">Quantity</th>
                <th class="my-span3  meta-head">Rate</th>
                <th class="my-span5 meta-head">Price</th>
                <?php if ($output['print'] == 0): ?><th class="my-span1 my-border-bottom my-border-right">&nbsp;</th><?php endif; ?>
            </tr>
            <?php
            $sno = 1;
            $price = 0;
            $vat_amount = 0;
            $total = 0;
            ?>
            <?php foreach ($output['items'] as $k => $v): ?>
                <?php if ($v['item_entity_id'] == 2): //print_r($v); ?>
                    <?php
                    $price += $v['price'];
                    $vat_amount += $v['price'] * $v['vat_rate'] / 100;
                    $total += $v['price'] + $v['price'] * $v['vat_rate'] / 100;
                    ?>
                    <tr>
                        <td class="my-span1 my-border-bottom my-border-left">
                            <span class="my-span1"><?php echo $sno++; ?>
                        </td>
                        <td class="my-border-bottom">
                            <span><?php echo $v['name']; ?></span>
                        </td>
                        <td class="my-span4 my-border-bottom">
                            <span class="my-span1"<?php echo $v['carat_weight']; ?></span>
                        </td>
                        <td class="my-span3 my-border-bottom">
                            <span class="my-span3"><?php echo $v['quantity']; ?></span>
                        </td>
                        <td class="my-span3 my-border-bottom">
                            <span class="my-span3"><?php echo $v['rate']; ?></span>
                        </td>
                        <td class="my-span5 my-border-bottom">
                            <b class="price-stone pull-right"><?php echo $v['price']; ?></b>
                        </td>
                        <?php if ($output['print'] == 0): ?>
                            <td class="my-border-bottom my-border-right my-span1">
                                <a href="" target="_blank" class="btn primary">Barcode</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="2" class="my-border-right my-border-bottom-no my-border-left-no">&nbsp;</td>
                <td colspan="3" class="my-border-right my-border-bottom"><b class="pull-right">Sub Total</b></td>
                <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="stone-sub-total pull-right"><?php echo $price; ?></b></td>
            </tr>
            <tr>
                <td colspan="2" class="my-border-right my-border-bottom-no my-border-left-no">&nbsp;</td>
                <td colspan="3" class="my-border-right my-border-bottom"><b class="pull-right">Vat</b></td>
                <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="stone-vat pull-right"><?php echo $vat_amount; ?></b></td>
            </tr>
            <tr>
                <td colspan="2" class="my-border-right my-border-bottom-no my-border-left-no">&nbsp;</td>
                <td colspan="3" class="my-border-right my-border-bottom"><b class="pull-right">Total</b></td>
                <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="stone-final-total pull-right"><?php echo $total; ?></b></td>
            </tr>
        </table>

    <?php endif; ?>

    <?php if ($ornament_table > 0): ?>
        <h4>Ornament</h4>
        <table style="width: 99%" class="my-table" id="selected_Ornaments">
            <tr>
                <th class="my-span1 meta-head">ID</th>
                <th class="meta-head" colspan="2">Name</th>
                <th class="my-span1 meta-head">Weight</th>
                <th class="my-span1 meta-head">Quantity</th>
                <th class="my-span1 meta-head">Rate</th>
                <th class="my-span1 meta-head">Price</th>
                <th class="my-span4 meta-head">Total</th>
                <?php if ($output['print'] == 0): ?><th class="my-span1 my-border-bottom my-border-right">&nbsp;</th><?php endif; ?>
            </tr>
            <?php
            $sno = 1;
            $price = 0;
            $vat_amount = 0;
            $total = 0;
            ?>
            <?php foreach ($output['selected_products'] as $k => $v): ?>
                <?php if (substr($k, 0, 1) == 3): //print_r($v); ?>
                    <?php
                    $price += $v['price'];
                    $vat_amount += $v['price'] * $v['vat_rate'] / 100;
                    $total += $v['price'] + $v['price'] * $v['vat_rate'] / 100;
                    ?>
                    <?php
                    $count = count($v['items']);
                    ?>
                    <tr>
                        <td class="my-span1 my-border-left">
                            <span class="my-span1"><?php echo $sno++; ?></span>
                        </td>
                        <td colspan="2">
                            <span><?php echo $v['name']; ?></span>
                        </td>
                        <td class="my-span1">
                            <span class="ornament-weight my-span1"><?php echo $v['weight']; ?></span>
                        </td>
                        <td class="my-span2">
                            <span class="my-span3"><?php echo $v['quantity']; ?></span>
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td>
                            &nbsp;
                        </td>
                        <td class="my-span4 my-bottom-align my-border-bottom" rowspan="<?php echo count($v['items']) + 1; ?>">
                            <b class="price-ornament pull-right">
                                <?php echo $v['price']; ?>
                            </b>
                        </td>
                        <?php if ($output['print'] == 0): ?>
                            <td class="my-span4 my-bottom-align my-border-bottom" rowspan="<?php echo count($v['items']) + 1; ?>">
                                <a href="" target="_blank" class="btn primary">Barcode</a>
                            </td>
                        <?php endif; ?>
                    </tr>
                    <?php foreach ($v['items'] as $key => $value): //print_r($value); ?>
                        <tr>
                            <td colspan="1" class="my-span1 my-border-left <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                                &nbsp;
                            </td>
                            <td class="my-span1 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                                <b class="my-span1"><?= $value['type']; ?></b>
                            </td>
                            <td class="<?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                                <span><?= $value['name']; ?></span>
                            </td>
                            <td class="my-span2 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                                <span><?php echo $value['weight']; ?></span>
                            </td>
                            <td class="my-span2 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                                <span class="my-span2 pull-right"><?php echo $value['quantity']; ?></span>
                            </td>
                            <td class="my-span2 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                                <span class="my-span3"><?php echo $value['rate']; ?></span>
                            </td>
                            <td class="my-span3 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                                <b class="price-ornament-item pull-right"><?php echo $value['price']; ?></b>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            <?php endforeach; ?>
            <tr>
                <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
                <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Sub Total</b></td>
                <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-sub-total pull-right"><?php echo $price; ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
                <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Vat</b></td>
                <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-vat pull-right"><?php echo $vat_amount; ?></b></td>
            </tr>
            <tr>
                <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
                <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Total</b></td>
                <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-final-total pull-right"><?php echo $total; ?></b></td>
            </tr>
        </table>
    <?php endif; ?>        
</div>
<br />
<div class="my-block">
    <span class="span2 my-font">Balance Amount : </span>
    <b class="my-font">Rs.&nbsp;<?php echo sprintf('%.2f',$output['amount_due']);?>&nbsp;/-</b>
</div>
<?php if ($output['print'] == 0): ?>
    <div class="my-block print-center">
        <a href="<?php echo site_url('billing/print_purchase_bill/' . $output['bill_id'] . '/1'); ?>" class="btn primary" target="_blank">Print</a>
    </div>
<?php endif; ?>