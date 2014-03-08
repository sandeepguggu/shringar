<?php
log_message('error', print_r($output, true));
if (!isset($output['selected_products']) || !is_array($output['selected_products']) || count($output['selected_products']) <= 0) {
    log_message('error', '#3, po/review.php error');
    $selected_products = array();
} else {
    $selected_products = $output['selected_products'];
}
log_message('error', print_r($selected_products, 1));
$total_po_price = isset($output['total_po_price']) ? $output['total_po_price'] : 0;
?>
<div class="po-review content-menu-body">
    <div class="content-header">
        <h3>PO Review</h3>

        <div class="pull-right">&nbsp; &nbsp;</div>
        <a href="<?php echo site_url('po'); ?>" class="btn btn-danger pull-right">
            <i class="icon-remove-circle icon-white"></i>
            &nbsp;Cancel
        </a>

        <form action="<?php echo site_url('/po'); ?>" method="post">
            <input type="hidden" name="load_from" value="review"/>
            <?php
            foreach ($_REQUEST as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k1 => $v1) {
                        echo '<input type="hidden" name="' . $k . '[]" value="' . $v1 . '" />';
                    }
                } else {
                    echo '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
                }

            }
            ?>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="button" class="btn btn-primary pull-right" onclick="$(this).submit()">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Back
            </button>
        </form>
    </div>
    <div class="content-subject">
        <div class="block">
            <div class="address-block pull-left">
                <?php if (isset($output['vendor'])): $vendor = $output['vendor'];?>
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
        <table class="table table-bordered" id="purchase-order-table">
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
                echo '<td>' . $product['name'] . '</td>';
                echo '<td>' . $product['brand'] . '</td>';
                echo '<td>';
                foreach ($product['attributes'] as $k => $attr) {
                    if ($k != 0) {
                        echo ', ';
                    }
                    echo $attr['display_name'] . ' : ' . $attr['value'];
                }
                echo '</td>';
                echo '<td class="text-right">' . $product['quantity'] . '</td>';
                /*echo '<td class="text-right">' . sprintf('%.2f', $product['price']) . '</td>';
                echo '<td class="text-right">' . sprintf('%.2f', $product['sub_total']) . '</td>';*/
                echo '</tr>';
                $sno++;
            }
            ?>
            <!--<tr class="table-footer">
                <th colspan="3"></th>
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right" id="po_sub_total"><?php /*echo sprintf('%.2f', $total_po_price); */?></th>
            </tr>-->
        </table>
    </div>
    <div class="content-footer">
        <form action="<?php echo site_url('/po/confirmed'); ?>" method="post">
            <?php
            foreach ($_REQUEST as $k => $v) {
                if (is_array($v)) {
                    foreach ($v as $k1 => $v1) {
                        echo '<input type="hidden" name="' . $k . '[]" value="' . $v1 . '" />';
                    }
                } else {
                    echo '<input type="hidden" name="' . $k . '" value="' . $v . '" />';
                }
            }
            ?>
            <button type="submit" class="btn btn-primary pull-right" onclick="$(this).submit()">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Confirm
            </button>
        </form>
    </div>
</div>