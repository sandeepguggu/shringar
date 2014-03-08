<script>
$(document).ready(function(){
     $("#frm_update_product").validate({
            rules: {
                sell_price : {
                    required: true,
                    min: 0
                }
            },
            submitHandler: function(form) {
		 $.ajax({
		  type: 'POST',
		  url: form.action,
		  data: $(form).serialize(),
		  success: ajax_success
		  }); 
		 
		 return false;
            }
        });
});
</script>
<?php
if(isset($success)){
	echo '<div class="alert-message success">'.$success.'</div>';
}
if(isset($failed)){
	echo '<div class="alert-message danger">'.$success.'</div>';
}
?>
<span class="span16"><strong>Update Category</strong></span> <br /><br />
<form action="<?php echo site_url('product/update_to_db?ajax=1'); ?>" method="post" id="frm_update_product" onsubmit="return false;">
<input type="hidden" name="id" value="<?php echo isset($id)?$id:''; ?>" />
    <table class="bordered-table">
        <tr>
            <td>Name</td>
            <td><input type="text" name="name" class="required" value="<?php echo isset($name)?$name:''; ?>" /></td>
        </tr>
         <tr>
            <td>Sell Price</td>
            <td><input type="text" id="sell_price" name="sell_price" class="required" value="<?php echo isset($sell_price)?$sell_price:''; ?>" /></td>
        </tr>
        <tr>
            <td>Mfg Barcode</td>
            <td><input type="text" name="barcode" value="<?php echo isset($barcode)?$barcode:''; ?>" /></td>
        </tr>
        <tr>
            <td>Category</td>
            <td><select name="category_id">
                <?php
				if(isset($category)){
					foreach($category as $c){
						echo '<option value="'.$c['id'].'"';
						if(isset($selected_category_id)){
							echo ($c['id'] == $selected_category_id)?' selected ':'';
						}
						echo '>'.$c['name'].'</option>';
					}
				}
				?>
                </select></td>
        </tr>
        <tr>
            <td>Brand</td>
            <td><select name="brand_id">
                <?php
				if(isset($brand)){
					foreach($brand as $b){
						echo '<option value="'.$b['id'].'"';
						if(isset($selected_brand_id)){
							echo ($b['id'] == $selected_brand_id)?' selected ':'';
						}
						echo '>'.$b['name'].'</option>';
					}
				}
				?>
                </select></td>
        </tr>
    </table>
    <input type="submit" class="btn primary" value="Update"/>
    <input type="button" class="btn danger" value="Cancel" onclick="$.fancybox.close();" />
</form>
