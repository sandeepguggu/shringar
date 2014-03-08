<?php

$_SESSION['pickupData'] = $_REQUEST;


?>
<div class="category">
    <h3>Booking Confirmation</h3>
    <form action="<?php echo site_url('rent/submitPickup'); ?>" method="post" id="form_invoice" class="form-horizontal">
        <div class="content-subject">
			<?php if(isset($success)): ?>
				<div class="label label-success flash-message"><?php echo $success; ?></div>
			<?php elseif(isset($failed)): ?>
				<div class="label label-warning flash-message"><?php echo $failed; ?></div>
			<?php endif;?>
            <div class="label label-warning">Fill the Form</div>
            <div class="control-group">
                <label class="control-label">Customer Id:</label>
                <div class="controls autocomplete-jui">
                        <input type="hidden" id="cname" name="cname"  /><?php echo $_REQUEST['cname']; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Delivery Date:</label>
                <div class="controls autocomplete-jui">
                        <input type="hidden" name="delivery_date" id="hasDatePicker" />
                        <?php echo $_REQUEST['delivery_date']; ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">No of Days:</label>
                <div class="controls autocomplete-jui">
                        <input type="hidden" name="return_date" id="return_date" />
                        <?php echo $_REQUEST['return_date']; ?>
                </div>
            </div>

            <!-- <div class="control-group">
                <label class="control-label">Category:</label>
                <div class="controls">
                     <select name="category_id" id="category_id">
                        <option value="0">ROOT</option>
                        <?php
                        if (isset($categories)) {
                            foreach ($categories as $c)
                            {
                                echo '<option value="' . $c['id'] . '">' . $c['category_name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div> -->
            
            <br/><br/>
            <style>
    .product_attr{
        display:none;
    }
</style>
            <table class="table table-striped table-bordered" id="add_product_table">
                <tr>
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Rent Quantity</th>
                    <th>Rent Price</th>

               </tr>
               <?php
                if(isset($_REQUEST['pcomponents'])) {
                    foreach($_REQUEST['pcomponents'] as $item=>$val) {
                    ?>
                        <tr>
                            <td><?php echo $_REQUEST['pcomponent_cid'][$item];?></td>
                            <td><?php echo $_REQUEST['pcomponent_name'][$item]; ?></td>
                            <td><?php echo $_REQUEST['pcomponent_quantity'][$item];?>
                            </td>
                            <td><?php echo $_REQUEST['pcomponent_price'][$item];?><input type="hidden" class="rentPrice required" size="10" 
                            value='<?php echo $_REQUEST['pcomponent_price_'.$val];?>' name="component_price_<?php echo $val;?>" onBlur="rent_products.updatePrice();">
                            <input type="hidden" class="rentPriceOrginal" size="10" value='<?php echo $component['rent_price'];?>'>
                            </td>
                        </tr>
                    <?php
                    }
                }
               if(isset($_REQUEST['components'])) {
                    foreach($_REQUEST['components'] as $component) {
                        ?>
                        <tr>
                            <td><?php echo $component; ?><input type="hidden" name="components[]" value="<?php echo $component;?>"/></td>
                            <td><?php  echo $_REQUEST['component_name_'.$component]; ?>
                            <td><?php echo $_REQUEST['component_quantity_'.$component];?>
                            <td><?php echo $_REQUEST['component_price_'.$component];?>
                            <td>No Components</td>
                        </tr>
                        <?php
                    }
               }
               ?>
            </table>
    <div style="float:right;border:0px solid #ccc;margin:10px;"> 
        <div class="bill-label">Total Rent:</div>
        <div class="bill-field"><?php echo $_REQUEST['total_rent'];?><input type="hidden" value="<?php echo $_REQUEST['total_rent'];?>" name="total_rent" id="total_rent" readonly/> </div>
        <div class="bill-label">Deposit :</div>
        <div class="bill-field"> <?php echo $_REQUEST['deposit'];?><input type="hidden" value="<?php echo $_REQUEST['deposit'];?>" name="total_rent" id="advance_amount"/> </div>
        
    </div>

        </div>
        <div class="content-footer" style="clear:both;">
            <input type="submit" class="btn btn-primary pull-right" value="Next">
                    
            <span class="pull-right">&nbsp;&nbsp;</span>

        </div>
    </form>
</div>
<script type="text/javascript">
    formValidate.submit('#form_invoice', false);
    formValidate.messages();
    app.autocomplete('#add_product_name', '/index.php/rent/select_product?json=1&from=class', products.selectBrand);
    element.blur('#add_product_name',rent_products.displayGrid);
    $('#hasDatePicker').datepicker({'minDate':0});

</script>

