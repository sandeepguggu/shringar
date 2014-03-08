<?php //print_r($output);             ?>
<?php
$count = count($output['items']);
$item_id = $output['item_entity_id'] . '_' . $output['id'];
$item_weight = 0;
$item_price = 0;
foreach ($output['items'] as $item)
{
    $item_weight += $item['weight'];
    if ($item['item_entity_id'] == 1) {
        $price_metal = $item['weight'] * $item['quantity'] * $item['rate'];
        $price_making = $price_metal * $output['making_cost_percent'] / 100;
        $price_wastgae = $price_metal * $output['wastage_percent'] / 100;
        $item_price += $price_metal + $price_making + $price_wastgae;
    } else {
        $item_price += $item['weight'] * $item['quantity'] * $item['rate'];
    }
}
?>
<tr class="ornament-row">
    <td class="my-span1 my-border-left">
        <span class="my-span1"><?php echo $output['id']; ?></span>
    </td>
    <td colspan="2">
        <span><?php echo $output['name']; ?></span>
        <input type="hidden" name="item_id[]"
               value="<?php echo $item_id; ?>"
               class="main-item"
               />
        <input type="hidden"
               value="<?php echo $item_id; ?>"
               class="main-item-id"
               />
    </td>
    <td class="my-span2">
        <span class="ornament-weight pull-right">
            <?php echo sprintf('%.2f', $item_weight); ?>
        </span>
    </td>
    <td class="my-span1">
        <span class="my-span1 pull-right">1</span>
        <input type="hidden" autocomplete="off"
               name="quantity_<?php echo $item_id; ?>"
               class="required my-span1 ornament-quantity main-item-quantity" min="0" 
               value="1" />
    </td>
    <td class="my-span2">&nbsp;</td>
    <td class="my-span1">&nbsp;</td>
    <td class="my-span1">&nbsp;</td>
    <td class="my-span1">&nbsp;</td>
    <td class="my-span1">
        <b class="ornament-price my-span1"><?php echo sprintf('%.2f', $item_price); ?></b>
        <input type="hidden" class="ornament-vat" value="<?php echo $output['vat']; ?>" />
    </td>
    <td class="my-span1 my-border-right">
        <input type="button" class="btn primary danger my-span1 remove_button" onclick="invoice_remove_row(this);" value="Remove" />
    </td>
</tr>

<?php foreach ($output['items'] as $k => $item): ?>
    <?php
    $sub_item_id = $item['item_entity_id'] . '_' . $item['item_specific_id'];
    $sub_item_weight = $item['weight'];
    $sub_item_quantity = $item['quantity'];
    $sub_item_rate = $item['rate'];
    if ($item['item_entity_id'] == 1) {
        $sub_item_price = $sub_item_weight * $sub_item_quantity * $sub_item_rate;
        $sub_making = $sub_item_price * $output['making_cost_percent'] / 100;
        $sub_wastage = $sub_item_price * $output['wastage_percent'] / 100;
        $sub_item_total = $sub_item_price + $sub_making + $sub_wastage;
    } else {
        $sub_item_total = $sub_item_price = $sub_item_weight * $sub_item_quantity * $sub_item_rate;
    }
    ?>
    <tr class="row-sub">    
        <td class="my-span1 my-border-left <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">&nbsp;</td>
        <td class="my-span1 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <span class="my-span1"><?= $item['type']; ?></span>
        </td>
        <td class="<?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <span><?= $item['name']; ?></span>
            <input type="hidden"
                   name="sub_item_id"
                   class="sub-item sub-item-id"
                   value="<?php echo $sub_item_id; ?>" 
                   />
        </td>
        <td class="my-span2 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <span class="item-weight pull-right">
                <?php echo sprintf('%.2f', $sub_item_weight); ?>
            </span>
        </td>
        <td class="my-span1 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <span class="my-span1 item-quantity pull-right">
                <?php echo $sub_item_quantity; ?>
            </span>
        </td>
        <td class="my-span2 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <span class="pull-right item-rate"><?php echo sprintf('%.2f', $sub_item_rate); ?></span>
            <input type="hidden" autocomplete="off" 
                   name="sub_rate_<?php echo $sub_item_id; ?>"
                   class="required my-span2 sub-item-rate item-rate" min="0"
                   value="<?php echo $sub_item_rate; ?>"
                   onkeyup="invoice_update_item_total(this)"
                   />
        </td>
        <td class="my-span1 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <span class="item-price pull-right">
                <?php echo sprintf('%.2f', $sub_item_price); ?>
            </span>
            <input type="hidden" class="item-total" value="<?php echo $sub_item_total; ?>" />
            <input type="hidden" class="item-discount" value="0" />
            <input type="hidden" class="item-vat" value="<?php echo $output['vat']; ?>" />
            <input type="hidden" class="item-vat-amount" value="<?php echo $sub_item_total * $output['vat'] / 100; ?>" />
            <input type="hidden" class="scheme-vat" value="0" />
            <input type="hidden" class="scheme-vat-amount" value="0" />
        </td>
        <?php if ($item['item_entity_id'] == 1): ?>
            <td>
                <span class="item-making my-span1 pull-right">
                    <?php echo $output['making_cost_percent']; ?>
                </span>
                <input type="hidden" value="0" class="scheme-making" />
                <input type="hidden" value="0" class="scheme-making-cost" />
            </td>
            <td>
                <span class="item-wastage my-span1 pull-right">
                    <?php echo $output['wastage_percent']; ?>
                </span>
                <input type="hidden" value="0" class="scheme-wastage" />
                <input type="hidden" value="0" class="scheme-wastage-cost" />
            </td>
        <?php endif; ?>
        <td class=" my-border-right <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>" colspan="<?php if ($item['item_entity_id'] == 1) echo 4; else echo 6; ?>"></td>
    </tr>
<?php endforeach; ?>