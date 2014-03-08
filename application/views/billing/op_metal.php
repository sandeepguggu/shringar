<?php
//    $weight = isset($weight) ? $weight : 0;
//    $vat_percentage = isset($vat_percentage) ? $vat_percentage : $vat_rate;
?>
<tr>
    <td class="my-span1 my-border-bottom my-border-left">
        <span class="my-span1"><?php echo  $id; ?></span>
    </td>
    <td class="my-border-bottom">
        <span><?php echo  $name; ?></span>
        <input class="selected_Metal_ids" type="hidden" name="item_id[]" value="<?php echo $item_entity_id.'_'.$id; ?>" />
    </td>
    <td class="my-span1 my-border-bottom">
        <input type="text" autocomplete="off" 
               name="fineness_<?php echo $item_entity_id.'_'.$id; ?>"
               class="required number metal-fineness my-span3" min="0"
               onkeyup="update_total(this, 'Metal')"
               value="0"
               />
    </td>
    <td class="my-span3 my-border-bottom">
        <input type="text" autocomplete="off" 
               name="gross_weight_<?php echo $item_entity_id.'_'.$id; ?>"
               class="required number metal-gross-weight my-span3" min="0"
               onkeyup="update_total(this, 'Metal')"
               value="0"
               />
    </td>
    <td class="my-span3 my-border-bottom">
        <input type="text" autocomplete="off" 
               name="net_weight_<?php echo $item_entity_id.'_'.$id; ?>"
               class="required number metal-net-weight my-span3" min="0"
               onkeyup="update_total(this, 'Metal')"
               value="0"
               />
    </td>
    <td class="my-span3 my-border-bottom">
        <input type="text" autocomplete="off"
               name="rate_<?php echo $item_entity_id.'_'.$id; ?>"
               class="required number metal-rate my-span3" min="0"
               onkeyup="update_total(this, 'Metal')"
               value="0"
               />
    </td>
    <td class="my-border-bottom">
        <b class="price-metal pull-right">0.00</b>
    </td>
    <td class="my-span1 my-border-bottom my-border-right">
        <input type="button" class="btn primary danger my-span1" onclick="remove_row(this, 'Metal');" value="Remove" />
    </td>
</tr>