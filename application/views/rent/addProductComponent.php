<?php
if(count($components) > 0) {
    foreach($components as $component) {
    ?>
    <tr>
        <td>
            <input type="hidden" name="components[]" value="<?php echo $component['id'];?>"/>
            <?php echo $component['name'];?>
        </td>
        <!--<td><?php echo $component['quantity']; ?></td>
        <td><?php echo $component['rent_price'];?></td>-->
        <td><button type="button" class="btn btn-danger action-button" onclick="$(this).parents('tr').remove()">
                <i class="icon-trash icon-white"></i></button>
</td>
    </tr>
    <?php
    } 
} else {
 ?>
    <tr>
        <td>

            <input type="text" class="required span2" name="component_name[]" value="<?php echo $name;?>"/>
        </td>
        <!--<td><input type="text" class="required span1" name="component_quantity[]" value=""/></td>
        <td><input type="text" class="required span1" name="component_rentprice[]" value=""/></td>-->
        <input type="hidden" class="required span1" name="component_quantity[]" value="0"/>
        <input type="hidden" class="required span1" name="component_rentprice[]" value="0"/>
        <td><button type="button" class="btn btn-danger action-button" onclick="$(this).parents('tr').remove()">
                <i class="icon-trash icon-white"></i></button></td>
    </tr>
<?php
}
?>