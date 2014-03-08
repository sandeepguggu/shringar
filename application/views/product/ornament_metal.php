<tr>
    <td class="my-span1">
        <span class="pull-right"><?= $id ?></span>
    </td>
    <td>
        <?php echo $name; ?>
        <input type="hidden" value="<?php echo '1_'.$id;?>" name="item_id[]">
        <input type="hidden" name='item_specific_id_<?php echo $item_entity_id; ?>' value="<?php echo $id; ?>" class="selected-metal-ids" />
    </td>
    <td class="my-span1">
        <input type="button" class="btn primary danger" onclick="remove_row(this, 'metal')" value="Remove" />
    </td>
</tr>
