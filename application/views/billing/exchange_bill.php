<?php
log_message('error', 'Bill - Exchange Bill'.print_r($bill, true))
?>
<div class="content-menu-body exchange-bill"> 
    <form id="exchange_bill" class="form-horizontal" action="<?php echo site_url('invoice/confirm_refund'); ?>" method="post">
        <div class="content-header">
            <h3>Exchange</h3>
            <b class="pull-right">Date: <?php echo date('M jS,  Y'); ?></b>
        </div>
        <div class="content-subject">
            <div class="block">
                <div class="address-block pull-left">
                    <?php if (isset($customer)): ?>
                    <strong>Customer:</strong>
                    <address class="address-block-address">
                        <?php echo $customer['fname'].' '.$customer['lname']; ?>
                        <br>
                        <?php echo $customer['building'].', '. $customer['street']; ?>
                        <br>
                        <?php echo $customer['city']; ?>,&nbsp;<?php echo $customer['pin']; ?>
                        <br>
                        <abbr title="Mobile">P:</abbr>
                        <?php echo $customer['phone']; ?>
                    </address>
                    <?php endif; ?>
                </div>
                <div class="address-block pull-right" style="width: auto">
                    <table class="table table-bordered">
                        <tr>
                            <th>Invoice #</th>
                            <td class="text-right">
                                <?php echo $bill['id']; ?>
                                <input type="hidden" name="bill_id" value="<?php echo $bill['id']; ?>">
                            </td>
                        </tr>
                        <tr>
                            <th>Date</th>
                            <td><?php echo $bill['created_at']; ?></td>
                        </tr>
                    </table>
                </div>
            </div>
            <h3>Products</h3>
            <table class="table table-bordered" id="exchange-table">
                <tr>
                    <th></th>
                    <th>S.No.</th>
                    <th width="25%">Product Name</th>
                    <th width="75%">Attributes</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Dis(%)</th>
                    <th>Total</th>
                </tr>
                <?php
                if (!isset($bill_items) || !is_array($bill_items) || count($bill_items) <= 0) {
                    $bill_items = array();
                    log_message('error', '');
                }
                ?>
                <?php
                $sno = 1;
                foreach ($products as $i => $item) {
                    $c_id = $item['item_entity_id'] . '_' . $item['item_specific_id'] . '_' . $sno;
                    $name = $item['name'];
                    $quantity = $bill_items[$i]['quantity'];
                    $returned_qty = $bill_items[$i]['returned_qty'];
                    $max_qty = $quantity - $returned_qty;
                    if($max_qty > 0) {
                    $price = $item['price'];
                    $discount = $item['discount'];
                    $vat_percentage = $item['vat_percentage'];
                    $final_amount = $item['final_amount'];
                    echo '<tr>';
                    echo '<td><input type="checkbox" name="exchange_' . $c_id . '"></td>';
                    echo '<td>' . $sno . '</td>';
                    echo '<td>' . $name;
                    echo '<input type="hidden" name="name_' . $c_id . '" value="' . $name . '">';
                    echo '<input type="hidden" name="bill_item_id_' . $c_id . '" value="' . $bill_items[$i]['id'] . '">';
                    echo '<input type="hidden" name="item_id[]" value="' . $c_id . '">';
                    echo '<input type="hidden" name="vat_percentage_' . $c_id . '" value="' . $vat_percentage . '">';
                    echo '</td>';
                    echo '<td>';
                    log_message('error', print_r($item['attributes'],1));
                    foreach ($item['attributes'] as $k => $attr) {
                        $attr_name = isset($attr['display_name']) ? $attr['display_name'] : $attr['name'];
                        if ($k != 0) {
                            echo ', ';
                        }
                        echo $attr_name . ' : ' . $attr['value'];
                    }
                    echo '</td>';
                    echo '<td>';
                    $min_qty = $max_qty <= 0 ? 0 : $max_qty;
                    echo '<input type="text" readonly name="quantity_' . $c_id . '" class="input-mini text-right required" min="'. $min_qty .'" max="' . $max_qty . '" autocomplete="off" value="' . $max_qty . '" onkeyup="exchange.update(config.exchange)">';
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="text" readonly name="price_' . $c_id . '" class="input-mini text-right" value="' . $price . '">';
                    echo '</td>';
                    echo '<td>';
                    echo '<input type="text" readonly name="discount_' . $c_id . '" class="input-mini text-right" value="' . $discount . '">';
                    echo '</td>';
                    $total_amount = $max_qty * $price;
                    $total_amount -= $total_amount * $discount /100;
                    echo '<td class="text-right product-total">'.sprintf('%.2f', $total_amount).'</td>';
                    echo '</tr>';
                    $sno++;
                    }
                }
                ?>
                <tr class="table-footer">
                    <th colspan="7" class="text-right">Total</th>
                    <th class="text-right" id="exchange_sub_total">0.00</th>
                </tr>
                <tr>
                    <th colspan="7" class="text-right">VAT</th>
                    <th class="text-right" id="exchange_vat_amount">0.00</th>
                </tr>
                <tr>
                    <th colspan="7" class="text-right">Refund Amount</th>
                    <th class="text-right" id="exchange_refund_amount">0.00</th>
                </tr>
            </table>
        </div>
        <div class="content-footer">
            <a href="<?php echo site_url('invoice/exchange');?>" class="btn btn-danger pull-right input-small">
                Reset
            </a>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="submit" class="btn btn-primary pull-right input-small">
                Exchange
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
    element.click('input[name*=exchange]', exchange.checked);

    element.focus('.exchange-bill input', validation.focus);
    element.key_up('.exchange-bill input', validation.focus);
    validation.bind({
        formId:config.exchange.form_id,
        callback:exchange.validate
    });
</script>