
<div class="add-category">
    <div class="content-header">
        <h3>Add Product</h3>
    </div>
    <form action="<?php echo site_url('rent/updateProducttoDB?ajax=1'); ?>" method="post" onsubmit="return false;" id="form_add_product" class="form-horizontal">
            <div class="content-subject">
			<?php if(isset($success)): ?>
				<div class="label label-success flash-message"><?php echo $success; ?></div>
			<?php elseif(isset($failed)): ?>
				<div class="label label-warning flash-message"><?php echo $failed; ?></div>
			<?php endif;?>
            <div class="label label-warning">Fill the Form</div>
            <div class="control-group">
                <label class="control-label">Name:</label>
                <div class="controls">
                    <input type="text" class="required span3" name="product_name" value="<?php echo isset($product['product_name'])?$product['product_name']:''; ?>"/>
                    
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Description:</label>
                <div class="controls">
                    <textarea type="text" class="required span3" name="description"><?php echo isset($product['description'])?$product['description']:''; ?></textarea>
                </div>
            </div>
            <!--<div class="control-group">
                <label class="control-label">Purchased Date:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="purchased_date" class="required span3" value="<?php echo isset($product['purchase_date'])?$product['purchase_date']:''; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Quantity:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="quantity" class="required span3" value="<?php echo isset($product['quantity'])?$product['quantity']:''; ?>"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Purchased Price:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="purchase_price" class="required span3" value="<?php echo isset($product['purchase_price'])?$product['purchase_price']:''; ?>"/>
                </div>
            </div>-->
            <div class="control-group">
                <label class="control-label">Rent Price:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="rent_price" class="required span3 number" value="<?php echo isset($product['rent_price'])?$product['rent_price']:''; ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Quantity:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="quantity" class="required span3 number" value="<?php echo isset($product['quantity'])?$product['quantity']:''; ?>"/>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">Category:</label>
                <div class="controls">
                    <select name="category_id" class="required span3">
                        <option value="0">ROOT</option>
                        <?php
                            if(isset($categories)){
                                foreach($categories as $c){
                                    echo '<option value="'.$c['id'].'"';
                                    if(isset($product['category_id'])){
                                            echo ($c['id'] == $product['category_id'])?' selected ':'';
                                    }
                                    echo '>'.$c['category_name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <!--<div class="control-group">
                <label class="control-label">Deposit:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="deposit" class="required span3" value="<?php echo isset($product['deposit'])?$product['deposit']:''; ?>"/>
                </div>
            </div>-->
            <div class="control-group">
                <label class="control-label">Components:</label>
                <div class="controls autocomplete-jui">				
                    <div class="ui-widget input-append">
                         <input id="add_component_class_attributes" type="text" class="input-add"/>
                            <span class="add-on search-image" id="add_component_class_attributes_plus">
                            <i class="icon-plus"></i>
                        </span>
			<div id="class_attributes_tags" class=""></div>
                    </div>
                </div>
            </div>
            
            <input type="text" id="add_component_attributes_row_count" value="<?php echo count($components);?>" />
            <table class="table table-striped table-bordered" id="add_component_attributes_table">
                <tr>
                        <th class="">Name</th>
                        <!--<th>Quanatity</th>
                        <th>Rent Price</th>-->
                        <th style="width: 20px">&nbsp</th>
                </tr>
                <?php

                    if(isset($components)){
                        $i = 0;
                        foreach($components as $c){
                            $i++;
                            ?>

                            <tr>
                                <td>
                                    <input type="hidden" name="componentrids[]" value="<?php echo $c['rid'];?>"/>
                                    <?php echo $c['name'];?>
                                </td>
                                <!--<td><?php echo $c['quantity']; ?></td>
                                <td><?php echo $c['rent_price'];?></td>-->
                                <td><button type="button" class="btn btn-danger action-button" onClick="rent_products.deleteComponent(<?php echo $c['rid'];?>);$(this).parents('tr').remove();">
                                        <i class="icon-trash icon-white"></i></button>
                                </td>
                            </tr>
                <?php
                        }
                    }
                    else{
                          echo "abc"; die();
                    }
                  
                ?>
            </table>
            <input type="hidden" name="id" value="<?php echo isset($product['id'])?$product['id']:''; ?>"/>
        </div>
            <div class="content-footer">
                <button type="submit" class="btn btn-primary pull-right">
                        <i class="icon-ok-circle icon-white"></i>
                        &nbsp;Submit
                </button>
                <span class="pull-right">&nbsp;&nbsp;</span>
                <button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
                        <i class="icon-remove-circle icon-white"></i>
                        &nbsp;Cancel
                </button>
            </div>
    </form>
</div>
<script type="text/javascript">
	formValidate.submit('#form_add_product', true);
	formValidate.messages();
        element.click('#add_component_class_attributes_plus', rent_products.addComponent);
        app.autocomplete('#add_component_class_attributes', '/index.php/rent/suggest_component?json=1&from=product', components.addSelect);
        //element.click('#add_component_class_attributes_plus', components.add);
</script>
