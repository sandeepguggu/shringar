<?php
log_message('error', print_r($output, true));
$status = isset($status) ? $status : 0;
$print_state = isset($output['print']) ? $output['print'] : 0;
$barcode = isset($output['barcode']) ? $output['barcode'] : '';
$credit_note_id = isset($output['credit_note_id']) ? $output['credit_note_id'] : '';
$credit_note_date = isset($output['date']) ? $output['date'] : '';
if (!isset($output['selected_products']) || !is_array($output['selected_products']) || count($output['selected_products']) <= 0) {
    log_message('error', '#4, po/printpo.php error');
    $selected_products = array();
} else {
    $selected_products = $output['selected_products'];
}
$bill_amount = isset($output['total_credit_note']) ? $output['total_credit_note'] : 0;
$vat_amount = isset($output['vat_amount']) ? $output['vat_amount'] : 0;

$print_class = '';
?>

<script language="javascript">
    $(document).ready(function () {
        $('#po_barcode').barcode("<?php echo $barcode; ?>", "code128", {barWidth:1, barHeight:40});
    <?php
    if ($print_state == 1) {
        echo 'window.print();';
        $print_class = '';
    }
    ?>
    });
</script>
<?php if (!$status) : ?>
<h3><?php echo $msg; ?></h3>
<?php else: ?>
    <div class="<?php echo $print_class; ?>">
        <div class="content-header">
            <h3>Credit Note</h3>
            <?php if ($print_state != 1) : ?>
            <!--<a href="<?php /*echo site_url('invoice/invoice'); */?>" class="btn btn-primary pull-right">
                <i class="icon-tags icon-white"></i>
                New Invoice
            </a>-->
            <?php endif;; ?>
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
                            <th>Credit Note #</th>
                            <td class="text-right"><?php echo $credit_note_id; ?></td>
                        </tr>
                        <tr>
                            <th>Created At</th>
                            <td class="text-right"><?php echo $credit_note_date; ?></td>
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
               href="<?php echo site_url('invoice/print_invoice/' . ($credit_note_id - 1));?>">
                <i class="icon-circle-arrow-left icon-white"></i>
                Prev
            </a>
        <span class="pull-left">&nbsp;</span>
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('invoice/print_invoice/' . ($credit_note_id + 1));?>">
            <i class="icon-circle-arrow-right icon-white"></i>
            Next
        </a>
        <a class="btn btn-success pull-right" target="_blank"
           href="<?php echo site_url('invoice/print_invoice/' . $credit_note_id . '/1');?>">
            <i class=" icon-print icon-white"></i>
            Print
        </a>
        <?php endif; ?>
    </div>
<?php endif; ?>