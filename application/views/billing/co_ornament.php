<?php
    $item_id = $item_entity_id.'_'.$id;
    $count = count($items);
?>
<tr>
    <td class="my-span1 my-border-left">
        <span class="my-span1"><?php echo $id; ?></span>
    </td>
    <td colspan="2">
        <span><?php echo $name; ?></span>
        <input type="hidden" name="item_id[]" 
               value="<?php echo $item_id; ?>"
               class="row-count-temp" />
    </td>
    <td class="my-span1">
        <span class="ornament-weight pull-right">0.00</span>
    </td>
    <td class="my-span2">
        <input type="text" autocomplete="off"
               name="quantity_<?php echo $item_id; ?>"
               class="required my-span3 ornament-quantity row-count-quantity" min="0" 
               onkeyup="update_by_quantity(this)"
               value="1" />
    </td>
    <td>
        &nbsp;
    </td>
    <td>
        &nbsp;
    </td>
    <td class="my-span4 my-bottom-align my-border-bottom" rowspan="<?php echo count($items) + 1; ?>">
        <b class="price-ornament pull-right">0.00</b>
        <input type="hidden" class="vat vat-temp" value="<?php echo $vat; ?>" name="vat_<?php echo $item_id; ?>" />
        <input type="hidden" class="total-vat" value="0" />
        <input type="hidden" class="total-ornament total-temp" value="0" name="final_price_<?php echo $item_id; ?>"/>
    </td>
    <td class="my-span1 my-bottom-align my-border-bottom my-border-right" rowspan="<?php echo count($items) + 1; ?>">
        <input type="button" class="btn primary danger my-span1" onclick="remove_row(this, 'ornament-item');" value="Remove" />
    </td>
</tr>
<?php foreach ($items as $k => $item): ?>
    <?php
    $price = 0;
    if (isset($item['quantity']) && isset($item['weight']) && isset($item['rate'])) {
        if ($item['item_entity_id'] == 1) {
            $price += $item['weight'] * $item['quantity'] * $item['rate'];
        } else {
            $price += $item['quantity'] * $item['rate'];
        }
    }
    ?>
    <tr class="row-sub<?php if (isset($row_count)) echo '-' . $row_count; ?>">
        <td colspan="1" class="my-span1 my-border-left <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            &nbsp;
            <input type="hidden" 
                   class="<?php if (!isset($row_count)) echo 'sub-items'; ?>" 
                   name="sub_item_id<?php if (isset($row_count)) echo '_' . $row_count . '[]'; ?>" 
                   value="<?= $item['item_entity_id']; ?>_<?= $item['item_specific_id']; ?>" />
        </td>
        <td class="my-span1 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <b class="my-span1"><?= $item['type']; ?></b>
        </td>
        <td class="<?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <span><?= $item['name']; ?></span>
        </td>
        <td class="my-span2 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <?php if($item['item_entity_id'] == 1):?>
            <input type="text" autocomplete="off"
                   name="sub_weight_<?= $item['item_entity_id']; ?>_<?= $item['item_specific_id']; ?><?php if (isset($row_count)) echo '_' . $row_count; ?>"
                   class="required sub-item-weight <?php if (!isset($row_count)) echo 'sub-quantity-items-weight'; ?> my-span3" min="0" 
                   value="<?php if (isset($item['weight'])) echo $item['weight']; ?>"
                   onkeyup="update_total(this, 'ornament-item')"
                   />
            <?php else:?>
            <span class="pull-right"><?php if (isset($item['weight'])) echo sprintf('%.2f',$item['weight']); ?></span>
            <input type="hidden" autocomplete="off"
                   name="sub_weight_<?= $item['item_entity_id']; ?>_<?= $item['item_specific_id']; ?><?php if (isset($row_count)) echo '_' . $row_count; ?>"
                   class="required sub-item-weight <?php if (!isset($row_count)) echo 'sub-quantity-items-weight'; ?> my-span3" min="0" 
                   value="1"
                   onkeyup="update_total(this, 'ornament-item')"
                   />
            <?php endif;?>
        </td>
        <td class="my-span2 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <?php if ($item['item_entity_id'] == 1): ?>
                <span class="my-span2 pull-right">1</span>
                <input type="hidden" autocomplete="off" 
                       name="sub_quantity_<?= $item['item_entity_id']; ?>_<?= $item['item_specific_id']; ?><?php if (isset($row_count)) echo '_' . $row_count; ?>"
                       class="required sub-item-quantity <?php if (!isset($row_count)) echo 'sub-quantity-items-quantity'; ?> my-span3" min="0"
                       value="1"
                       onkeyup="update_total(this, 'ornament-item')"
                       />
                   <?php else: ?>
                <input type="text" autocomplete="off" 
                       name="sub_quantity_<?= $item['item_entity_id']; ?>_<?= $item['item_specific_id']; ?><?php if (isset($row_count)) echo '_' . $row_count; ?>"
                       class="required sub-item-quantity <?php if (!isset($row_count)) echo 'sub-quantity-items-quantity'; ?> my-span3" min="0"
                       value="<?php if (isset($item['quantity'])) echo $item['quantity']; else echo '1'; ?>"
                       onkeyup="update_total(this, 'ornament-item')"
                       />
                   <?php endif; ?>
        </td>
        <td class="my-span2 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <input type="text" autocomplete="off" 
                   name="sub_rate_<?= $item['item_entity_id']; ?>_<?= $item['item_specific_id']; ?><?php if (isset($row_count)) echo '_' . $row_count; ?>"
                   class="required my-span3 sub-item-rate <?php if (!isset($row_count)) echo 'sub-quantity-items-rate'; ?>" min="0"
                   value="<?php if (isset($item['rate'])) echo $item['rate']; else echo '1'; ?>"
                   onkeyup="update_total(this, 'ornament-item')"
                   />
        </td>
        <td class="my-span3 <?php if ($k == $count - 1) echo 'my-border-bottom'; ?>">
            <b class="price-ornament-item pull-right"><?php echo $price; ?></b>
        </td>
    </tr>
<?php endforeach; ?>