<script type="text/javascript">
    $(function(){
        add_ajaxSubmit('add-ornament-form');
    });
</script>
<?php if(isset($status)):?>
    <div class="alert-message <?php if($status == true) echo 'success'; else echo 'danger'; ?>"><?=$msg; ?></div>
<?php else: ?>
<span class="span16"><strong>Edit Ornament</strong> </span>
<br />
<br />
<form action="<?=site_url('product/edit_ornament_to_db?ajax=1');?>" id="edit-ornament-form">
	<table class="bordered-table">
		<tbody>
			<tr>
				<td><label for="ornament-name">Name</label></td>
				<td><input type="text" class="required" name="ornament-name" /></td>
			</tr>
			<tr>
				<td>Category</td>
				<td><select name="category_id" class="required">
						<option value="">[Select Category]</option>
             <?php
                        if (isset($category) && is_array($category)) {
                            foreach ($category as $c) {
                                echo '<option value="' . $c['id'] . '">' . $c['name'] . '</option>' . "\n";
                            }
                        }
                        ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td><label>Weight</label></td>
				<td><input type="text" class="required number" min="0" name="weight" />
					<select>
						<option value="g" selected="selected">g</option>
						<option value="kg">Kg</option>
				</select></td>
			</tr>
			<tr>
				<td><label>Metal</label></td>
				<td><select name="metal_id" class="required">
						<option value="">[Select Metal]</option>
             <?php
                        if (isset($metals) && is_array($metals)) {
                            foreach ($metals as $metal) {
                                echo '<option value="' . $metal['id'] . '">' . $metal['name'] . '</option>' . "\n";
                            }
                        }
                        ?>
                    </select>
				</td>
			</tr>
			<tr>
				<td><label for="metal-weight">Metal Weight</label></td>
				<td><input type="text" class="required" name="metal-weight" /> <select>
						<option value="g" selected="selected">g</option>
						<option value="kg">Kg</option>
				</select></td>
			</tr>
			<tr>
				<td><label>Stone Weight</label></td>
				<td><input type="text" class="required" name="stone-weight" /> <select>
						<option value="g" selected="selected">g</option>
						<option value="kg">Kg</option>
				</select></td>
			</tr>
			<tr>
				<td><label>Stone Cost</label></td>
				<td><input type="text" class="required number" min="0" name="weight" />
				</td>
			</tr>
			<tr>
				<td><label>Making Charges</label></td>
				<td><input type="text" class="required number" minlength="0"
					name="making-cost" /> <select name="making-cost-type">
						<option value="percent" selected="selected">%</option>
						<option value="kg">Rs. (fixed)</option>
				</select></td>
			</tr>
			<tr>
				<td><label>Wasting Charges</label></td>
				<td><input type="text" class="required number" minlength="0"
					name="wasting-cost" /> <select name="wasting-cost-type">
						<option value="percent" selected="selected">%</option>
						<option value="kg">Rs. (fixed)</option>
				</select></td>
			</tr>
		</tbody>
	</table>
	<input type="submit" class="btn primary" value="Add New Ornament" /> <input
		type="button" class="btn danger" value="Cancel"
		onclick="$.fancybox.close();" />
</form>
<?php endif; ?>