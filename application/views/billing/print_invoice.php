<style type="text/css">
    .table-no-border tr td {
        border: none;
    }
</style>
<?php
log_message('error', print_r($output, true));
$status = isset($status) ? $status : 0;
$print_state = isset($output['print']) ? $output['print'] : 0;
$barcode = isset($output['barcode']) ? $output['barcode'] : '';
$bill_id = isset($output['bill_id']) ? $output['bill_id'] : '';
$bill_date = isset($output['date']) ? $output['date'] : '';
if (!isset($output['products']) || !is_array($output['products']) || count($output['products']) <= 0) {
    log_message('error', '#4, po/printpo.php error');
    $selected_products = array();
} else {
    $selected_products = $output['products'];
}
$bill_amount = isset($output['bill_amount']) ? $output['bill_amount'] : 0;
$vat_amount = isset($output['vat_amount']) ? $output['vat_amount'] : 0;

$vat_group = array();
$print_class = 'content-menu-body' ;
?>
<script language="javascript">
    $(document).ready(function () {
        $('#po_barcode').barcode("<?php echo $barcode; ?>", "code128", {barWidth:1, barHeight:40});
    });
    
    invoice.addMoreShortCuts();    
</script>
<?php if (!$status) : ?>
<h3><?php echo $msg; ?></h3>
<?php else: ?>
<div class="block mini-receipt" id="print-area">
    <div class="company-header">
        <h4>New Shringar Fancy Centre</h4>
        <span>#19, 9th Main Road</span>
        <span>3rd Block Jayanagar</span>
        <span>Bangalore 560011</span>
        <span>Ph 26634568 / 26645570</span>
        <span>Web site: www.shringargroup.com</span>
        <span>E-Mail: shringargroup@gmail.com</span>
        <span>VAT TIN: 29720210785</span>
    </div>
    <br>

    <h4>TAX INVOICE</h4>
    <table class="table table-no-border">
        <tr>
            <td>Bill No.</td>
            <td><?php echo $bill_id; ?></td>
            <td>Time:</td>
            <td><?php  date_default_timezone_set('Asia/Calcutta'); 
                        echo date('h:i:s'); ?></td>
        </tr>
        <tr>
            <td>Date.</td>
            <td><?php echo $bill_date; ?></td>
            <td>User:</td>
            <td>Shringar</td>
        </tr>

    </table>
    <table class="table-mini-receipt">
        <tr>
            <th width="30%" style="text-align: left" class="hide-me">Name</th>
            <th width="70%" style="text-align: left">Product</th>
            <th>Qty.</th>
            <th>Price</th>
            <th>Disc.</th>
            <th>Amount</th>
        </tr>
        <?php
        $totalqty = 0;
        foreach ($selected_products as $product) {
           $totalqty = $totalqty + $product['quantity'];
            echo '<tr>';
            //if(isset($product['extratax']))
                //echo $product['extratax'];
            echo '<td class="hide-me">' . $product['name'] . '</td>';
            echo '<td>' . $product['class'] . '</td>';
            echo '<td class="text-right ">' . $product['quantity'] . '</td>';
            echo '<td class="text-right ">' . sprintf('%.2f', $product['price']) . '</td>';
            echo '<td class="text-right ">' . sprintf('%.2f', $product['discount_amount'] * $product['quantity']) . '</td>';
            echo '<td class="text-right ">' . sprintf('%.2f', $product['final_amount']) . '</td>';
            echo '</tr>';
            if (isset($vat_group[$product['vat_percentage']])) {
                $vat_group[$product['vat_percentage']] += $product['vat_amount'];
            } else {
                $vat_group[$product['vat_percentage']] = $product['vat_amount'];
            }
        }
        ?>
        <tr class="table-bottom">
            <th class="text-left">Totals</th>
             <td class="text-right"><?php echo $totalqty?></td>
             <td>&nbsp;</td>
              <td>&nbsp;</td>
            <td class="text-right"><?php echo sprintf('%.2f', $bill_amount); ?></td>
        </tr>
        <?php if (count($vat_group) > 0): ?>
        <!--<tr>
            <th colspan="5">Tax Details</th>
        </tr>-->
        <?php foreach ($vat_group as $k => $v) : ?>
            <tr>
                <td colspan="3">
                    VAT @ <?php echo $k; ?> %
                </td>
                <td class="hide-me"></td>
                <td class="text-right"><?php echo sprintf('%.2f', $v); ?></td>
                <td>&nbsp;</td>
            </tr>
            <?php endforeach; ?>
        <tr>
            <td class="hide-me"></td>
            <th colspan="3" class="text-right">Tax Amount</th>
            <td>&nbsp;</td>
            <td class="text-right"><?php echo sprintf('%.2f', $vat_amount); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td class="hide-me"></td>
            <th colspan="3" class="text-right">Gross Amount</th>
            <td>&nbsp;</td>
            <td class="text-right"><?php echo sprintf('%.2f', $output['bill_amount']); ?></td>
        </tr>
        <tr>
            <th colspan="5">Payment</th>
        </tr>
        <?php
        if (isset($output['new_payment'])) {
            foreach ($output['new_payment'] as $k => $v) {

                switch ($k) {
                    case 'cash' :
                        echo '<tr>';
                        echo '<td class="hide-me"></td>';
                        echo '<th class="text-right" colspan="3">Cash</th>';

                        echo '<td>&nbsp;</td    >';
                        echo '<td class="text-right">' . sprintf('%.2f', $v['amount']) . '</td>';

                    case 'cards' :
                        $temp = 0;

                        foreach ($v as $key => $value) {
                            if($temp == 0) {
                                $temp++;
                                continue;
                            }

                            echo '<tr>';

                            echo '<th class="text-right" colspan="3">Card - ' . $value['last_digits'] . '</th>';
                            echo '<td>&nbsp;</td>';
                            echo '<td class="text-right">' . sprintf('%.2f', $value['amount']) . '</td>';
                        }

                        break;
                    case 'cheques' :
                        $temp = 0;
                        foreach ($v as $key => $value) {
                            if($temp == 0) {
                                $temp++;
                                continue;
                            }
                            echo '<tr>';
                            echo '<th class="text-right" colspan="3">Cheque - ' . $value['number'] . '</th>';
                            echo '<td>&nbsp;</td>';
                            echo '<td class="text-right">' . sprintf('%.2f', $value['amount']) . '</td>';
                        }

                        break;
                }
                echo '</tr>';
            }
        }
        ?>
        <tr class="table-bottom">
            <td class="hide-me"></td>
            <td style="text-align: center" colspan="5">Goods once sold will not be exchanged or returned</td>
        </tr>
        <tr>
            <td class="hide-me"></td>
            <td style="text-align: center" colspan="5">Specialists in Drama - Dance Dresses, Marriage, Temple Jewellery for hire & sales<br>Thank You Visit Again</td>
        </tr>

    </table>
    <div class="content-footer">
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('invoice/print_invoice/' . ($bill_id - 1));?>">
            <i class="icon-circle-arrow-left icon-white"></i>
            Prev
        </a>
        <span class="pull-left">&nbsp;</span>
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('invoice/print_invoice/' . ($bill_id + 1));?>">
            <i class="icon-circle-arrow-right icon-white"></i>
            Next
        </a>
        <a accesskey="p" class="btn btn-success pull-right" id="print" onclick="window.print()"
           href="#">
            <i class=" icon-print icon-white"></i>
            <u>P</u>rint
        </a>
        <a accesskey="i" class="btn btn-primary pull-right" id="invoice"
           href="<?php echo site_url('invoice/new_invoice');?>">
            <i class=" icon-print icon-white"></i>
            <u>I</u>nvoice
        </a>
    </div>
</div>
    <div class="<?php echo $print_class; ?> hide">
        <div class="content-header">
            <h3>Invoice</h3>
            <?php if ($print_state != 1) : ?>
            <a href="<?php echo site_url('invoice/new_invoice'); ?>" class="btn btn-primary pull-right">
                <i class="icon-tags icon-white"></i>
                New Invoice
            </a>
            <?php endif; ?>
        </div>
        <div class="content-subject">
            <div class="block">
                <div class="address-block pull-left">
                    <?php if (isset($output['customer'])): $customer = $output['customer']; ?>
                    <address>
                        <strong><?php echo $customer['fname'] . ' ' . $customer['lname']; ?></strong>
                        <?php echo $customer['building'] . ', ' . $customer['street']; ?>
                        <br>
                        <?php echo $customer['city']; ?>,&nbsp;<?php echo $customer['pin']; ?>
                        <br>
                        <abbr title="Mobile">P:</abbr>
                        <?php echo $customer['phone']; ?>
                    </address>
                    <?php endif; ?>
                </div>
                <div class="pull-left address-block">
                    <div id="po_barcode"></div>
                </div>
                <div class="pull-right address-block" style="width:auto">
                    <table class="table-print" style="width: 100%">
                        <tr>
                            <th>Invoice #</th>
                            <td class="text-right"><?php echo $bill_id; ?></td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td class="text-right"><?php echo $bill_date; ?></td>
                        </tr>
                    </table>
                </div>

            </div>
            <table class="table-print">
                <tr>
                    <th>S.No.</th>
                    <th style="width: 100%">Product Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Disc(%)</th>
                    <th>Total</th>
                </tr>
                <?php
                $sno = 1;
                foreach ($selected_products as $product) {
                    echo '<tr>';
                    echo '<td class="text-right">' . $sno . '</td>';
                    echo '<td style="width: 100%">' . $product['name'] . '</td>';
                    echo '<td class="text-right ">' . $product['quantity'] . '</td>';
                    echo '<td class="text-right ">' . sprintf('%.2f', $product['price']) . '</td>';
                    echo '<td class="text-right ">' . sprintf('%.2f', $product['discount']) . '</td>';
                    echo '<td class="text-right ">' . sprintf('%.2f', $product['final_amount']) . '</td>';
                    echo '</tr>';
                    $sno++;
                }
                ?>
                <tr>
                    <th colspan="5" class="text-right">Total</th>
                    <th class="text-right"><?php echo sprintf('%.2f', $bill_amount); ?></th>
                </tr>
                <!--<tr>
                    <th colspan="5" class="text-right">Vat</th>
                    <th class="text-right"><?php /*echo sprintf('%.2f', $vat_amount); */?></th>
                </tr>-->
            </table>
        </div>
        <?php if ($print_state == 0): ?>
        <div class="content-footer">
            <a class="btn btn-primary pull-left"
               href="<?php echo site_url('invoice/print_invoice/' . ($bill_id - 1));?>">
                <i class="icon-circle-arrow-left icon-white"></i>
                Prev
            </a>
        <span class="pull-left">&nbsp;</span>
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('invoice/print_invoice/' . ($bill_id + 1));?>">
            <i class="icon-circle-arrow-right icon-white"></i>
            Next
        </a>
        <a class="btn btn-success pull-right" target="_blank"
           href="<?php echo site_url('invoice/print_invoice/' . $bill_id . '/1');?>">
            <i class=" icon-print icon-white"></i>
            Print
        </a>
        <?php endif; ?>
    </div>
<?php endif; ?>