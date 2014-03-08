<?php
$print_state = isset($output['print']) ? $output['print'] : 0;
$barcode = isset($output['barcode']) ? $output['barcode'] : '';
$po_id = isset($output['po_id']) ? $output['po_id'] : '';
$po_date = isset($output['po_date']) ? $output['po_date'] : '';
if (!isset($output['selected_products']) || !is_array($output['selected_products']) || count($output['selected_products']) <= 0) {
    log_message('error', '#4, po/printpo.php error');
    $selected_products = array();
} else {
    $selected_products = $output['selected_products'];
}
log_message('error', print_r($selected_products, 1));
$total_po_price = isset($output['total_po_price']) ? $output['total_po_price'] : 0;
?>
<script language="javascript">
    $(document).ready(function () {
        $('#po_barcode').barcode("<?php echo $barcode; ?>", "code128", {barWidth:1, barHeight:50});
    <?php
    if ($print_state == 1) {
        echo 'window.print();';
    }
    ?>
    });
</script>
<?php if ($status != 1) : ?>
<h3>Failed to Create Purchase Order</h3>
<?php else: ?>
<div class="content-header">
    <h3>Purchase Order</h3>
    <?php if ($print_state != 1) : ?>
    <a href="<?php echo site_url('po'); ?>" class="btn btn-primary pull-right">
        <i class="icon-tags icon-white"></i>
        New PO
    </a>
    <?php endif; ?>
</div>
<div class="content-subject" id="po-print-page">
    <div class="block">
        <div class="address-block pull-left">
            <?php if (isset($output['vendor'])): $vendor = $output['vendor']; ?>
            <address>
                <strong>New Shringar Fancy Centre</strong>
                #19, 9th Main Road
                <br>
                3rd Block Jayanagar
                <br>
                Bangalore 560011
                <br>

                <abbr title="Mobile">P:</abbr>
                26634568 / 26645570
            </address>
            <?php endif; ?>
        </div>
        <div class="pull-left address-block">
            <div id="po_barcode"></div>
        </div>
        <div class="pull-right address-block" style="width:auto">
            <table class="table-print">
                <tr>
                    <th>PO #</th>
                    <td class="text-right"><?php echo $po_id; ?></td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td class="text-right"><?php echo $po_date; ?></td>
                </tr>
            </table>
        </div>

    </div>
    <br>

    <div class="block">
        <div class="address-block pull-left">
            <?php if (isset($vendor)): ?>
            <strong>Vendor:</strong>
            <address class="address-block-address">
                <?php echo $vendor['company_name']; ?>
                <br>
                <?php echo $vendor['address']; ?>
                <br>
                <?php echo $vendor['city']; ?>,&nbsp;<?php echo $vendor['pin']; ?>
                <br>
                <abbr title="Mobile">P:</abbr>
                <?php echo $vendor['mobile']; ?>
            </address>
            <?php endif; ?>
        </div>
        <div class="address-block pull-left hide">
            <?php if (isset($vendor)): ?>
            <strong>Ship To:</strong>
            <address class="address-block-address">
                <?php echo 'Shringar'; ?>
                <br>
                <?php echo $vendor['address']; ?>
                <br>
                <?php echo $vendor['city']; ?>,&nbsp;<?php echo $vendor['pin']; ?>
                <br>
                <abbr title="Mobile">P:</abbr>
                <?php echo $vendor['mobile']; ?>
            </address>
            <?php endif; ?>
        </div>
        <div class="address-block pull-right" style="width: auto;">
            <strong>Payment:</strong>
            <address class="address-block-address">
                D. Date: <?php echo $output['delivery_date']; ?>
                <br>
                Terms: <?php echo $output['payment_terms']; ?>
                <br>
                Date: <?php echo $output['pay_on_date']; ?>
                <br>
                Days: <?php echo $output['pay_days']; ?>
                <br>
                <b>Contact:</b>
                <br>
                <?php echo $output['vendor_contact_person_name']; ?>
                <br>
                <abbr title="Mobile">P:</abbr>
                <?php echo $output['vendor_contact_person_phone']; ?>
            </address>
        </div>
    </div>
    <table class="table-print">
        <tr>
            <th>S.No.</th>
            <th width="25%">Product Name</th>
            <th>Brand</th>
            <th width="75%">Attributes</th>
            <th>Qty</th>
            <!--<th>Price</th>
            <th>Total</th>-->
        </tr>
        <?php
        $sno = 1;
        foreach ($selected_products as $product) {
            echo '<tr>';
            echo '<td class="text-right">' . $sno . '</td>';
            echo '<td class="">' . $product['name'] . '</td>';
            echo '<td class="">' . $product['brand'] . '</td>';
            echo '<td>';
            foreach ($product['attributes'] as $k => $attr) {
                if ($k != 0) {
                    echo ', ';
                }
                $attr_name = isset($attr['display_name']) ? $attr['display_name'] : $attr['name'];
                echo $attr_name . ' : ' . $attr['value'];
            }
            echo '</td>';
            echo '<td class="text-right">' . $product['quantity'] . '</td>';
            /*echo '<td class="text-right">' . sprintf('%.2f', $product['price']) . '</td>';
            echo '<td class="text-right">' . sprintf('%.2f', $product['sub_total']) . '</td>';*/
            echo '</tr>';
            $sno++;
        }
        ?>
        <!--<tr>
            <th colspan="3"></th>
            <th colspan="2" class="text-right">Total</th>
            <th class="text-right" id="po_sub_total"><?php /*echo sprintf('%.2f', $total_po_price); */?></th>
        </tr>-->
    </table>
</div>
<?php if ($print_state == 0): ?>
    <div class="content-footer">
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('po/printpo/' . ($po_id - 1));?>">
            <i class="icon-circle-arrow-left icon-white"></i>
            Prev
        </a>
        <span class="pull-left">&nbsp;</span>
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('po/printpo/' . ($po_id + 1));?>">
            <i class="icon-circle-arrow-right icon-white"></i>
            Next
        </a>
        <button id="print-page-btn" class="btn btn-success pull-right">
            <i class=" icon-print icon-white"></i>
            Print
        </button>
    </div>
    <div id="print-area" class="hide"></div>
    <script type="text/javascript">
        BIZ.app.bind({
            event:'click',
            targetElement:'#print-page-btn',
            parentElement:'.content-footer',
            callback:BIZ.app.print,
            extra:{sourceElement:'#po-print-page'}
        });
    </script>
    <?php endif; ?>
<?php endif; ?>