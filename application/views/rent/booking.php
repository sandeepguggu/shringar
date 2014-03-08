<div class="category">
    <h3>Booking</h3>
    
    <form action="<?php echo site_url('rent/invoiceConfirmation'); ?>" method="post" id="form_invoice" class="form-horizontal">
        
             <a class="btn btn-primary pull-right" id="vendor_add_btn">View All Bookings</a>
        <div class="content-subject">
			<?php if(isset($success)): ?>
				<div class="label label-success flash-message"><?php echo $success; ?></div>
			<?php elseif(isset($failed)): ?>
				<div class="label label-warning flash-message"><?php echo $failed; ?></div>
			<?php endif;?>
            <div class="control-group">
             <div class="label label-warning">Fill the Form</div>
                <label class="control-label">Customer Id:</label>
                <div class="controls autocomplete-jui">
                        <input type="hidden" id="customer_ac" name="cname" class="required span3" autocomplete="off" value="" /> 
                        <input type="hidden" id="customer_id" name="customer_id" value="1">                         <br>
                </div>
            </div>

            
            <div class="control-group">
                <label class="control-label">Delivery Date:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="delivery_date" id="hasDatePicker" class="required span3 hasDatePicker" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">No of Days:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="return_date" id="return_date" class="required span3 number"  min="1" value="1" onBlur="rent_products.updatePrice();"/>
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
                <label class="control-label">Product:</label>
                <div class="controls autocomplete-jui">
                        <input type="text" name="product" class="required span3" id="add_product_name" />
                        <span id="no_records_msg" style="margin-left: 20px;color:#FF0000;"></span>
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
                    <th>Product Id</th>
                    <th>Product Name</th>
                    <th>Rent Quantity</th>
                    <th>Rent Price</th>
                    <th>Components</th>
               </tr>
            </table>
    <div style="float:right;border:0px solid #ccc;margin:10px;"> 
        <div class="bill-label">Total Rent: </div>
        <div class="bill-field"><input type="text" value="" name="total_rent" id="total_rent" readonly/> </div><br/>
        <div class="bill-label">Deposit :</div>
        <div class="bill-field"><input type="text" value="" name="deposit" id="advance_amount" onBlur="rent_products.updateBalance();"/> </div>
        <div class="bill-label">Balance :</div>
        <div class="bill-field"><input type="text" value="" name="balance" id="balance_amount" readonly/> </div>
        
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
    app.autocomplete('#add_product_name', '/index.php/rent/select_product?json=1&from=class', rent_products.displayGrid);
    //element.blur('#add_product_name',rent_products.displayGrid);
 $('#hasDatePicker').datepicker({'minDate':0});
    app.autocomplete('#customer_ac', '<?php echo site_url('customer/suggest_customer?json=1&from=po'); ?>', rent_products.selectCustomer);
   $("#vendor_add_btn").click(function(e){
     $.ajax({
                type:'GET',
                url:site_url + '/rent/viewbookings?ordertype=1',
                data:{},
                success:function (data) {
                    $('.category').html(data);
                    $(".table-bordered").find('a').fancybox();
                }
            })
     
   
   })
</script>