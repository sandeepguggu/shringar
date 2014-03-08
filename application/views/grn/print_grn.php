<?php
//log_message('error', print_r($output, 1));
$status = isset($status) ? $status : 0;
$print_state = isset($output['print']) ? $output['print'] : 0;
$barcode = isset($output['barcode']) ? $output['barcode'] : '';
$grn_id = isset($output['grn_id']) ? $output['grn_id'] : '';
$grn_date = isset($output['date']) ? $output['date'] : '';
if (!isset($output['selected_products']) || !is_array($output['selected_products']) || count($output['selected_products']) <= 0) {
    log_message('error', '#4, po/printpo.php error');
    $selected_products = array();
} else {
    $selected_products = $output['grn_items'];
}
$total_grn_price = isset($output['total_grn_price']) ? $output['total_grn_price'] : 0;
?>
<script language="javascript">
    $(document).ready(function () {
        $('#po_barcode').barcode("<?php echo $barcode; ?>", "code128", {barWidth:1, barHeight:40});
    <?php
    if ($print_state == 1) {
        echo 'window.print();';
    }
    ?>
    });
</script>
<?php if ($status != 1) : ?>
<h3><?php echo $error_msg;?></h3>
<?php else: ?>
<div class="content-header">
    <h3>Goods Received Note</h3>
    <?php if ($print_state != 1) : ?>
    <a href="<?php echo site_url('grn'); ?>" class="btn btn-primary pull-right">
        <i class="icon-tags icon-white"></i>
        New GRN
    </a>
    <?php endif; ?>
</div>
<div class="content-subject print-page" id="grn-print-page">
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
        &nbsp;&nbsp;
        <div class="pull-left address-block">
            <div id="po_barcode"></div>
        </div>
        <div class="pull-right address-block" style="width: auto;">
            <table class="table-print">
                <tr>
                    <th>GRN #</th>
                    <td class="text-right"><?php echo $grn_id; ?></td>
                </tr>
                <tr>
                    <th>Date</th>
                    <td class="text-right"><?php echo $grn_date; ?></td>
                </tr>
            </table>
        </div>
    </div>
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
    </div>
    <table class="table-print">
        <tr>
            <th>S.No.</th>
            <th style="width: 25%">Product Name</th>
            <th>Brand</th>
            <th style="width: 75%">Attributes</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Total</th>
            <?php if ($print_state != 1): ?>
            <th colspan="2"></th>
            <?php endif; ?>
        </tr>
        <?php
        $sno = 1;
        echo '<script type="text/javascript">BARCODES = ' . json_encode($selected_products) . ';</script>';
        foreach ($selected_products as $product) {
            echo '<tr>';
            echo '<td class="text-right">' . $sno . '</td>';
            echo '<td width="25%">' . $product['name'] . '</td>';
            echo '<td>' . $product['brand'] . '</td>';
            echo '<td width="75%">';
            $mrp = 0;
            foreach ($product['attributes'] as $k => $attr) {
                if ($k != 0) {
                    echo ', ';
                }
                if ($attr['name'] == 'price') {
                    $mrp = $attr['value'];
                }
                $attr_name = isset($attr['display_name']) ? $attr['display_name'] : $attr['name'];
                echo $attr_name . ' : ' . $attr['value'];
            }
            $total = $product['purchase_price'] * $product['quantity'];
            echo '</td>';
            echo '<td class="text-right">' . $product['quantity'] . '</td>';
            echo '<td class="text-right">' . sprintf('%.2f', $product['purchase_price']) . '</td>';
            echo '<td class="text-right">' . sprintf('%.2f', $total) . '</td>';
            if ($print_state != 1) {
                echo '<td style="width: 50px"><button type="button" class="btn action-button btn-primary print-single-barcode" b-name="' . $product['name'] . '" b-code="' . $product['barcode'] . '" b-type="1" b-mrp="' . $mrp . '">C</button></td>';
                echo '<td><button type="button" class="btn action-button btn-primary print-single-barcode" b-name="' . $product['name'] . '" b-code="' . $product['barcode'] . '" b-type="2" b-mrp="' . $mrp . '">J</button></td>';
            }
            echo '</tr>';
            $sno++;
        }
        ?>
        <tr class="table-footer">
            <th colspan="4"></th>
            <th colspan="2" class="text-right">Total</th>
            <th class="text-right" id="po_sub_total"><?php echo sprintf('%.2f', $total_grn_price); ?></th>
            <?php if ($print_state == 0): ?>
            <th colspan="2"></th>
            <?php endif; ?>
        </tr>
    </table>


</div>
<?php if ($print_state == 0): ?>
    <div class="content-footer">
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('grn/print_grn/' . ($grn_id - 1));?>">
            <i class="icon-circle-arrow-left icon-white"></i>
            Prev
        </a>
        <span class="pull-left">&nbsp;</span>
        <a class="btn btn-primary pull-left"
           href="<?php echo site_url('grn/print_grn/' . ($grn_id + 1));?>">
            <i class="icon-circle-arrow-right icon-white"></i>
            Next
        </a>
        <a class="btn btn-primary pull-right" target="_blank"
           href="<?php echo site_url('grn/print_grn/' . $grn_id . '/1');?>">
            <i class=" icon-print icon-white"></i>
            Print
        </a>
        <span class="pull-right">&nbsp;</span>
        <button id="print-barcode-j-btn" class="btn btn-success pull-right">
            <i class=" icon-print icon-white"></i>
            Print J Barcodes
        </button>
        <span class="pull-right">&nbsp;</span>
        <button id="print-barcode-c-btn" class="btn btn-success pull-right">
            <i class=" icon-print icon-white"></i>
            Print C Barcodes
        </button>
    </div>
    <div id="multiple-j-barcodes" class="hide"></div>
    <div id="multiple-c-barcodes" class="hide"></div>
    <div id="print-area" class="hide"></div>
    <script type="text/javascript">
        var counter = parseInt(1);
        for (var i in BARCODES) {
            var barcode = BARCODES[i].barcode;
            var qty = BARCODES[i].quantity;
            var name = BARCODES[i].name;
            var mrp = 0;
            for(var a in BARCODES[i].attributes) {
                //console.log(BARCODES[i].attributes[a]);
                if(BARCODES[i].attributes[a].name == 'price') {
                    mrp = parseFloat(BARCODES[i].attributes[a].value);
                    mrp = isNaN(mrp) ? 0 : mrp;
                    break;
                }
            }
            for (var j = 0; j < qty; j++) {
                $('#barcode-id-' + counter).barcode(barcode, "code128", {barWidth:1, barHeight:20});

                html = '<div class="barcode-page-break" style="page-break-after: always;">';
                html += '<div class="jewellery-barcode-container"><div id="barcode-target-j' + counter + '"></div><div class="barcode-hri">' + barcode + '</div></div>';
                html += '<div class="jewellery-barcode-description"><span class="name">' + name + '</span><span class="price">M.R.P : ' + mrp.toFixed(2) + '</span></div></div>';
                html += '</div>';

                $('#multiple-j-barcodes').append(html);

                $('#barcode-target-j' + counter).barcode(barcode, "code128", {barWidth:1, barHeight:15, output:'bmp'});
                $('#barcode-target-j' + counter).attr('style', 'width: 24mm');
                $('#barcode-target-j' + counter + ' object').attr('style', 'width: 24mm; height: 5mm');

                html = '<div class="barcode-page-break" style="page-break-after: always;">';
                html += '<div class="cosmetic-barcode-container"><div id="barcode-target-c'+counter+'"></div><div class="barcode-hri">'+barcode+'</div></div>';
                html += '<div class="cosmetic-barcode-description"><span class="name">' + name + '</span><span class="price">M.R.P : ' + mrp.toFixed(2) + '</span></div></div>';
                html += '</div>';

                $('#multiple-c-barcodes').html(html);
                $('#barcode-target-c' + counter).barcode(barcode, "code128", {barWidth:1, barHeight:15, output:'bmp'});
                $('#barcode-target-c' + counter).attr('style', 'width: 38mm');
                $('#barcode-target-c' + counter + ' object').attr('style', 'width: 38mm; height: 5mm');

                counter++;
            }
        }
        BIZ.app.bind({
            event:'click',
            targetElement:'.print-single-barcode',
            parentElement:'#grn-print-page',
            callback:BIZ.app.printBarcode,
            extra:{sourceElement:'#grn-print-page'}
        });

        /* BIZ.app.bind({
            event:'click',
            targetElement:'#print-page-btn',
            parentElement:'.content-footer',
            callback:BIZ.app.print,
            extra:{sourceElement:'#grn-print-page'}
        });*/
        BIZ.app.bind({
            event:'click',
            targetElement:'#print-barcode-c-btn',
            parentElement:'.content-footer',
            callback:BIZ.app.print,
            extra:{sourceElement:'#multiple-c-barcodes'}
        });
        BIZ.app.bind({
            event:'click',
            targetElement:'#print-barcode-j-btn',
            parentElement:'.content-footer',
            callback:BIZ.app.print,
            extra:{sourceElement:'#multiple-j-barcodes'}
        });

    </script>
    <?php endif; ?>
<?php endif; ?>