<?php 
    if(isset($row_count)) {
        $row = '_'.$row_count;
    } else {
        $row = '';
    }
?>
<tr>
    <td>
        <?php echo $name; ?>
        <input type="hidden" name="attribute_row[]" class="<?php if(! isset($row_count)) echo 'row-temp-id';?>" value="<?php if(isset($row_count)) echo $row_count;?>" />
        <input type="hidden" value="<?php echo $id;?>" name="attribute_id<?php echo $row;?>" class="<?php if(! isset($row_count)) echo 'row-temp';?>" />
        <input type="hidden" value="<?php echo $name;?>" name="attribute_name<?php echo $row;?>" class="attribute_name <?php if(! isset($row_count)) echo 'row-temp';?>" />
        <input type="hidden" value="<?php echo $level;?>" name="attribute_level<?php echo $row;?>" class="<?php if(! isset($row_count)) echo 'row-temp';?>" />
        <?php if(!empty($newAdded)): ?>
        <input type="hidden" value="yes" name="newAdd<?php echo $row;?>" class="<?php if(! isset($row_count)) echo 'row-temp';?>" />
        <?php endif; ?>
    </td>
    <td class="my-span1">
        <span class="my-span1"><?php if($level == 1) echo 'Primary'; else if($level == 2) echo 'Secondary'; ?></span>
    </td>
    <td class="my-span1">
        <input type="button" class="btn primary danger" onclick="$(this).parents('tr').remove();" value="Remove" />
    </td>
</tr>