<?php
/*$product = $data['products'];
if(count($product) > 0 && $product['name'] != '') {
    if(count($components) > 1) {
        ?>
        <?php
        foreach ($components as $component) {
        ?>
            <tr>
                <td><?php echo $component['id'];?><input type="hidden" name="pcomponents[]" value=""/></td>
                <td><?php echo $component['name']; ?><?php echo ' ('.$product['name'].')';?>
                <input type="hidden" value="<?php echo $component['name']; ?><?php echo ' ('.$product['name'].')';?>"  class="attribute_name" name="pcomponent_name[]"/>
                <input type="hidden" value="<?php echo $product['id'];?>"  name="pcomponent_pid[]"/>
                <input type="hidden" value="<?php echo $component['id'];?>"  name="pcomponent_cid[]"/>
                </td>
                <td><input type="text" class="requiredQuantity required"  
                   size="10" value=''  onBlur="rent_products.updateTotal();" name="pcomponent_quantity[]" min="1"/>
                </td>
                <td><input type="text" class="rentPrice required" size="10" 
                   value='<?php echo $component['rent_price'];?>' name="pcomponent_price[]" onBlur="rent_products.updatePrice();">
        <input type="hidden" class="rentPriceOrginal" size="10" value='<?php echo $component['rent_price'];?>'>
                </td>
                <td><a href="#" onClick="$(this).parents('tr').remove();rent_products.updatePrice();">Delete</a></td>
            </tr>

        <?php 
        } // end: foreach
    }
            ?>
  
<?php
} 
?>
<?php
$pcomponents = $data['components'];

if(count($pcomponents) > 0) {
?>
    <tr>
        <td><?php echo $pcomponents['cid'];?><input type="hidden" name="pcomponents[]" value=""/></td>
        <td><?php echo $pcomponents['name']; ?>
        <input type="hidden" value="<?php echo $pcomponents['name']; ?>"  class="attribute_name" name="pcomponent_name[]"/>
        <input type="hidden" value="1"  name="pcomponent_pid[]"/>
        <input type="hidden" value="<?php echo $pcomponents['cid'];?>"  name="pcomponent_cid[]"/>
        </td>
        <td><input type="text" class="requiredQuantity required"  
            size="10" value=''  onBlur="rent_products.updateTotal();" name="pcomponent_quantity[]" min="1"/>
        </td>
        <td><input type="text" class="rentPrice required" size="10" 
            value='<?php echo $pcomponents['rent_price'];?>' name="pcomponent_price[]" onBlur="rent_products.updatePrice();">
<input type="hidden" class="rentPriceOrginal" size="10" value='<?php echo $pcomponents['rent_price'];?>'>
        </td>
        <td><a href="#" onClick="$(this).parents('tr').remove();rent_products.updatePrice();">Delete</a></td>
    </tr>
    
<?php
} */
?>


<tr>
        <td><?php echo $data['products']['id'];?><input type="hidden" name="product_id[]" value="<?php echo $data['products']['id'];?>"/></td>
        <td><?php echo $data['products']['name'];?><input type="hidden" name="product_name[]" value="<?php echo $data['products']['name'];?>"/></td>
        <td><input type="text" class="requiredQuantity required"  
                   size="10" value='1'  onBlur="rent_products.updateTotal();" name="product_quantity[]" min="1"/>
        </td>

        <td><input type="text" class="rentPrice required" size="10" 
                   value='<?php echo $data['products']['rent_price'];?>' name="product_price[]" onBlur="rent_products.updatePrice();">
        <input type="hidden" class="rentPriceOrginal" size="10" value='<?php echo $data['products']['rent_price'];?>'>
        </td>
        <td>
        <?php  
        if(isset($component))
            print_r($component); ?>
        <input type="hidden" name="components[]" value="<?php print_r($component); ?>" />

        </td>


</tr>