<?php //echo print_r($output); ?>
<?php if ($output['print'] == 1): ?>
    <script type="text/javascript" src="<?php echo base_url('resources/js/jquery-1.6.2.min.js'); ?>"></script>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url('resources/js/jquery-barcode-2.0.2.js'); ?>"></script>
<script language="javascript">
    $(document).ready(function(){
        $('.print-order').find('.barcode-target').barcode("<?php echo $output['barcode']; ?>", "code128",{barWidth:1, barHeight:40});
<?php if ($output['print'] == 1): ?>
            window.print();
<?php endif; ?>
    });
</script>
<div class="print-order">
    <h3>Customer Order</h3>
    <hr />
    <div class="my-block">
        <div class="pull-left span6">
            <b class="customer-style"><?php echo $output['customer']['fname'] . ' ' . $output['customer']['lname']; ?></b><br/>
            <span class="customer-style">Ph: <?php echo $output['customer']['phone']; ?></span><br />
            <span class="customer-style"><?php echo $output['customer']['building'] . ', ' . $output['customer']['street'] . ', ' . $output['customer']['city']; ?></span>
        </div>
        <div class="pull-right">
            <table class="my-table" style="width: 300px">
                <tr>
                    <td class="span2 meta-head">Order #</td>
                    <td class="span2"><span class="pull-right"><?php echo $output['order_id']; ?></span></td>
                </tr>
                <tr>
                    <td class="span2 meta-head">Date</td>
                    <td class="span2"><span class="pull-right"><?php echo $output['co_date']; ?></span></td>
                </tr>
            </table>
        </div>
        <div class="span1 pull-right">&nbsp;</div>
        <div class="pull-right barcode-target">
        </div>
    </div>
    <table style="width: 99%" class="my-table" id="selected_Ornaments">
        <tr>
            <th class="my-span1 meta-head">ID</th>
            <th class="meta-head" colspan="2">Name</th>
            <th class="my-span1 meta-head">Weight</th>
            <th class="my-span1 meta-head">Quantity</th>
            <th class="my-span1 meta-head">Rate</th>
            <th class="my-span1 meta-head">Price</th>
            <th class="my-span4 meta-head">Total</th>
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
                //$vat_amount += $v['price'] * $v['vat_rate'] / 100;
                //$total += $v['price'] + $v['price'] * $v['vat_rate'] / 100;
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
                </tr>
                <?php foreach ($v['items'] as $key => $value): //print_r($value); ?>
                    <?php
                    $item_price = $value['sub_rate'] * $value['sub_quantity'] * $value['sub_weight'];
                    ?>
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
                            <span><?php echo $value['sub_weight']; ?></span>
                        </td>
                        <td class="my-span2 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                            <span class="my-span2 pull-right"><?php echo $value['sub_quantity']; ?></span>
                        </td>
                        <td class="my-span2 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                            <span class="my-span3"><?php echo $value['sub_rate']; ?></span>
                        </td>
                        <td class="my-span3 <?php if ($key == $count - 1) echo 'my-border-bottom'; ?>">
                            <b class="price-ornament-item pull-right"><?php echo $item_price; ?></b>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php endforeach; ?>
        <tr>
            <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
            <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Sub Total</b></td>
            <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-sub-total pull-right"><?php echo $output['total_amount']; ?></b></td>
        </tr>
        <tr>
            <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
            <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Vat</b></td>
            <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-vat pull-right"><?php echo $output['vat_amount']; ?></b></td>
        </tr>
        <tr>
            <td colspan="3" class="my-border-left-no my-border-bottom-no my-border-right">&nbsp;</td>
            <td colspan="4" class="my-border-bottom my-border-right"><b class="pull-right">Total</b></td>
            <td colspan="2" class="my-border-bottom my-border-right"><b class="pull-left">Rs.</b><b class="ornament-final-total pull-right"><?php echo $output['final_amount']; ?></b></td>
        </tr>
    </table>
</div>
<br />
<div class="my-block">
    <label class="pull-left span2">Advance Paid:</label>
    <label class="span2 pull-left"><b>Rs.&nbsp;<?php echo $output['advance']; ?>&nbsp/-</b></label>
</div>
<div class="my-block">
    <label class="pull-left span2">Rate Type:</label>
    <label class="span2 pull-left">
        <b>
        <?php
        if ($output['rate_type'] == 0) {
            echo 'Delivery Date';
        } else {
            echo $output['co_date'];
        }
        ?>
        </b>
    </label>
</div>
<br />
<?php if ($output['print'] == 0): ?>
    <div class="my-block print-center">
        <a href="<?php echo site_url('billing/print_order/' . $output['order_id'] . '/1'); ?>" class="btn primary" target="_blank">Print</a>
    </div>
<?php endif; ?>