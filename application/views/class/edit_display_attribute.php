<tr>
    <td>
        <?php
        $display_name = (!is_null($display_name) && $display_name != '') ? $display_name : $name;
        ?>
        <?php echo $display_name; ?>
        <input type="hidden" name="attribute_row[]" value="<?php echo $row_count?>"/>
        <input type="hidden" value="<?php echo isset($id) ? $id : ''; ?>" name="attribute_id_<?php echo $row_count?>"/>
        <input type="hidden" value="<?php echo isset($name) ? $name : ''; ?>"
               name="attribute_name_<?php echo $row_count?>" class="attribute_name"/>
        <input type="hidden" value="<?php echo isset($level) ? $level : ''; ?>"
               name="attribute_level_<?php echo $row_count?>"/>
        <input type="hidden" value="0" name="attribute_state_<?php echo $row_count?>"/>
    </td>
    <td>
        <span><?php if ($level == 1) echo 'Primary'; else if ($level == 2) echo 'Secondary'; ?></span>
    </td>
    <td style="width: 20px">
        <button type="button" class="btn btn-danger action-button" onclick="classes.remove(this)">
            <i class="icon-trash icon-white"></i>
        </button>
    </td>
</tr>