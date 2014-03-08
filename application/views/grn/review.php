<?php
if (!isset($selected_products) || !is_array($selected_products) || count($selected_products) <= 0) {
    log_message('error', '#3, grn/review.php error');
    $selected_products = array();
}
log_message('error', print_r($selected_products, 1));
$total_grn_price = isset($total_grn_price) ? $total_grn_price : 0;
?>
<div class="grn-review">
    <div class="content-header">
        <h3>GRN Review</h3>

        <div class="pull-right">&nbsp; &nbsp;</div>
        <a href="<?php echo site_url('grn'); ?>" class="btn btn-danger pull-right">
            <i class="icon-remove-circle icon-white"></i>
            &nbsp;Cancel
        </a>

        <form action="<?php echo site_url('/grn'); ?>" method="post">
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
        <table class="table table-bordered">
            <tr>
                <th style="20px">S.No.</th>
                <th width="25%">Product Name</th>
                <th>Brand</th>
                <th width="75%">Attributes</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Total</th>
            </tr>
            <?php
            $sno = 1;
            foreach ($selected_products as $product) {
                echo '<tr>';
                echo '<td class="text-right">' . $sno . '</td>';
                echo '<td width="25%">' . $product['name'] . '</td>';
                echo '<td class="span2">' . $product['brand'] . '</td>';
                echo '<td width="75%">';
                foreach ($product['attributes'] as $k => $attr) {
                    if ($k != 0) {
                        echo ', ';
                    }
                    echo $attr['name'] . ' : ' . $attr['value'];
                }
                echo '</td>';
                echo '<td class="text-right span1">' . $product['quantity'] . '</td>';
                echo '<td class="text-right span1">' . sprintf('%.2f', $product['price']) . '</td>';
                echo '<td class="text-right span1">' . sprintf('%.2f', $product['sub_total']) . '</td>';
                echo '</tr>';
                $sno++;
            }
            ?>
            <tr class="table-footer">
                <th colspan="4"></th>
                <th colspan="2" class="text-right">Total</th>
                <th class="text-right" id="po_sub_total"><?php echo sprintf('%.2f', $total_grn_price); ?></th>
            </tr>
        </table>
    </div>
    <div class="content-footer">
        <form action="<?php echo site_url('grn/confirmed'); ?>" method="post">
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