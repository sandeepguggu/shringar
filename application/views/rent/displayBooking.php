
<div class="category">
    <form action="<?php echo site_url('rent/pickupConfirmation'); ?>" method="post" id="form_invoice" class="form-horizontal">
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
                        <input type="text" id="customer_ac" name="cname" class="required span3" autocomplete="off" value="<?php echo $customerInfo['fname']." ".$customerInfo['lname'];?>" />
                        <input type="hidden" id="customer_id" name="customer_id" value="<?php echo $bookingData['customer_id'];?>">
                        <input type="hidden" name="bookingId" value="<?php echo $bookingData['id'];?>"/>
                        <input type="hidden" name="orderType" value="2"/>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Delivery Date:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="delivery_date" id="hasDatePicker" class="required span3 hasDatePicker" value="<?php echo $bookingData['delivery_date'];?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">No of Days:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="return_date" id="return_date" class="required span3 number" value="<?php echo $bookingData['noofdays'];?>" min="1"/>
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
            <div class="control-group">
                <label class="control-label">Costume:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="product" class="span3" id="add_product_name"/>
                </div>
            </div>
            
            <br/><br/>
            <style>
    .product_attr{
        display:none;
    }
</style>
            <table class="table table-striped table-bordered" id="add_product_table">
                <tr>
                    <th>S.No</th>
                    <th>Product Name</th>
                    <th>Rent Quantity</th>
                    <th>Rent Price</th>
                    <th></th>
               </tr>
               <?php

               foreach($bookingComponentData as $component) {
               ?>
               
                   <tr>
                        <td><?php echo $component['id'];?><input type="hidden" name="pcomponents[]" value="<?php echo $component['bid'];?>"/></td>
                        <td><?php echo $component['name']; 
                            if($component['product_id'] != 1) {
                                echo " (".$component['product_name'].")";
                            }
                            ?>
                        <input type="hidden" value="<?php echo $component['name']; 
                            if($component['product_id'] != 1) {
                                echo " (".$component['product_name'].")";
                            }
                            ?>"  class="attribute_name" name="pcomponent_name[]"/>
                        <input type="hidden" value="<?php echo $component['product_id'];?>"  name="pcomponent_pid[]"/>
                        <input type="hidden" value="<?php echo $component['id'];?>"  name="pcomponent_cid[]"/>
                        </td>
                        <td><input type="text" class="requiredQuantity required"  
                            size="10" value="<?php echo $component['quantity']; ?>"  onBlur="rent_products.updateTotal();" name="pcomponent_quantity[]"/>
                        </td>
                        <td><input type="text" class="rentPrice required" size="10" 
                            value='<?php echo $component['rent_price'];?>' name="pcomponent_price[]" onBlur="rent_products.updatePrice();">
                <input type="hidden" class="rentPriceOrginal" size="10" value='<?php echo $component['rent_price'];?>'>
                        </td>
                        <td>&nbsp;</td>
                    </tr>
                    

               <?php
               }
               ?>
            </table>
    <div style="float:right;border:0px solid #ccc;margin:10px;"> 
        <div class="bill-label">Total Rent:</div>
        <div class="bill-field"><input type="text" value="<?php echo $bookingData['total_rent'];?>" name="total_rent" id="total_rent" readonly/> </div><br/>
        <div class="bill-label">Deposit :</div>
        <div class="bill-field"><input type="text" value="<?php echo $bookingData['deposit'];?>" class="required" name="deposit" id="advance_amount"/> </div>
        
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
    app.autocomplete('#add_product_name', '/index.php/rent/select_product?json=1&page=pickup', rent_products.displayGrid);
    //element.blur('#add_product_name',rent_products.displayGrid);
    $('#hasDatePicker').datepicker({'minDate':0});
    app.autocomplete('#customer_ac', '<?php echo site_url('customer/suggest_customer?json=1&from=po'); ?>', rent_products.selectCustomer);

</script>