 <td colspan="6">
<?php 
if(count($components) > 1) {
    foreach ($components as $component) {
    ?>
        <div>
            <input type="checkbox" checked value="<?php echo $component['id'] ?>" 
                    onclick="rent_products.updateComponentPrice(this);" class="rentComponents"/>
            <input type="hidden" value="<?php echo $component['rent_price'] ?>" class="componentPrice"/>&nbsp;&nbsp;<?php echo $component['name']; ?></div>

    <?php 
    } // end: foreach
} else {
    ?>
        No Components.
    <?php
} // end:if

?>
 </td>

