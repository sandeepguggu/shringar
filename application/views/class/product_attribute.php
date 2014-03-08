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
    </td>
    <td class="">
        <input type="text" class="required my-span5 <?php if(! isset($row_count)) echo 'row-temp';?>" name="attribute_value<?php echo $row;?>" />
    </td>
    <td class="span1">
        <span class="my-span1"><?php if($level == 1) echo 'Primary'; else if($level == 2) echo 'Secondary'; ?></span>
    </td>
    <td class="span1">
        <input type="checkbox" name="attribute_checked<?php echo $row;?>" class="my-span1 <?php if(! isset($row_count)) echo 'row-temp';?>"/>
    </td>
    <td style="width: 20px">
        <input type="button" class="btn primary danger" onclick="$(this).parents('tr').remove();" value="Remove" />
    </td>
</tr>


<tr>
	<td>
		<?php echo isset($name) ? $name: ''; ?>
		<input type="hidden" name="attribute_row[]" value="<?php echo $row_count?>" />
		<input type="hidden" value="<?php echo isset($id) ? $id: ''; ?>" name="attribute_id_<?php echo $row_count?>" />
		<input type="hidden" value="<?php echo isset($name) ? $name: ''; ?>" name="attribute_name_<?php echo $row_count?>" class="attribute_name" />
		<input type="hidden" value="<?php echo isset($level) ? $level: ''; ?>" name="attribute_level_<?php echo $row_count?>"/>
		<input type="hidden" value="0" name="attribute_state_<?php echo $row_count?>"/>
	</td>
	<td>
		<span><?php if($level == 1) echo 'Primary'; else if($level == 2) echo 'Secondary'; ?></span>
	</td>
	<td style="width: 20px">
		<button type="button" class="btn btn-danger action-button" onclick="classes.remove(this)">
			<i class="icon-trash icon-white"></i>
		</button>
	</td>
</tr>