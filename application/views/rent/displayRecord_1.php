<?php
$product = $data['products'];
if(count($product) > 0 && $product['name'] != '') {
?>
    <tr>
        <td><?php echo $product['id']; ?><input type="hidden" name="items[]" value="<?php echo $product['id'];?>"/></td>
        <td><?php echo $product['name']; ?>
            <input type="hidden" value="<?php echo $product['name'];?>"  class="attribute_name" name="item_name_<?php echo $product['id'];?>"/></td>
        <td><input type="text" class="requiredQuantity required"  
                   size="10" value=''  onBlur="rent_products.updateTotal();" name="item_quantity_<?php echo $product['id'];?>"/></td>
        <td><input type="text" class="rentPrice required" size="10" 
                   value='<?php echo $product['rent_price'];?>' name="item_price_<?php echo $product['id'];?>" onBlur="rent_products.updatePrice();">
        <input type="hidden" class="rentPriceOrginal" size="10" value='<?php echo $product['rent_price'];?>'></td>
        <td><a class="btn btn-primary action-btn fancybox" id="product_<?php echo $product['id'];  ?>"
            onclick="rent_products.componentsData(<?php echo $product['id'];  ?>);">Components</a></td>
    </tr>
    <tr id="product_attr_<?php echo $product['id'];  ?>" class="product_attr">
         <td colspan="6">
            <?php 
            if(count($components) > 1) {
                ?>
             <div>
                        <div style="float:left;clear: both;width: 100px;">&nbsp;
                        </div>
                        <div style="float:left;width: 100px;"><b>Name</b></div>
                        <div style="float:left;width: 100px;"><b>Rent Price</b></div>
                <?php
                foreach ($components as $component) {
                ?>
                        
                        <div style="float:left;clear: both;width: 100px;"><input type="checkbox" checked value="<?php echo $component['rent_price'] ?>" 
                                onclick="rent_products.updateComponentPrice(this);" class="rentComponents" name="component_<?php echo $product['id'];?>_<?php echo $component['id'] ?>"/>
                        </div>
                        <div style="float:left;width: 100px;"><?php echo $component['name']; ?></div>
                        <div style="float:left;width: 100px;"><?php echo $component['rent_price']; ?></div>
                        <input type="hidden" name="component_price_<?php echo $component['id'];?>" value="<?php echo $component['rent_price'] ?>" class="componentPrice"/>
                        <input type="hidden" name="component_name_<?php echo $component['id'];?>" value="<?php echo $component['name'] ?>" class="componentPrice"/>
                        <input type="hidden" name="component_id_<?php echo $product['id'];?>[]" value="<?php echo $component['id'];?>"/></div>
                <?php 
                } // end: foreach
                echo "</div>";
            } else {
                ?>
                    No Components.
                <?php
            } // end:if

            ?>
            </td>
    </tr>    
<?php
} 
?>
<?php
$pcomponents = $data['components'];

if(count($pcomponents) > 0) {
?>
    <tr>
        <td><?php echo $pcomponents['cid']; ?><input type="hidden" name="components[]" value="<?php echo $pcomponents['cid'];?>"/></td>
        <td><?php echo $pcomponents['name']; ?>
            <input type="hidden" value="<?php echo $pcomponents['name'];?>"  class="attribute_name" name="component_name_<?php echo $pcomponents['cid'];?>"/></td>
        <td><input type="text" class="requiredQuantity required"  
                   size="10" value=''  onBlur="rent_products.updateTotal();" name="component_quantity_<?php echo $pcomponents['cid'];?>"/></td>
        <td><input type="text" class="rentPrice required" size="10" 
                   value='<?php echo $pcomponents['rent_price'];?>' name="component_price_<?php echo $pcomponents['cid'];?>" onBlur="rent_products.updatePrice();">
        <input type="hidden" class="rentPriceOrginal" size="10" value='<?php echo $pcomponents['rent_price'];?>'></td>
        <td><a class="btn btn-primary action-btn fancybox" id="product_<?php echo $pcomponents['cid'];  ?>"
            onclick="rent_products.componentsData(<?php echo $pcomponents['cid'];  ?>);"></a></td>
    </tr>
    
<?php
} 
?>