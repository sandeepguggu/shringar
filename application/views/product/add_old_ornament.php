<script type="text/javascript">
    $(function(){
        add_ajaxSubmit('add-old_ornament-form');
    });
</script>
<?php if(isset($status)):?>
    <div class="alert-message <?php if($status == true) echo 'success'; else echo 'danger'; ?>"><?=$msg; ?></div>
<?php else: ?>
<span class="span16"><strong>Add Old Ornament</strong> </span>
<br />
<br />
<form action="<?=site_url('product/add_old_ornament_to_db?ajax=1');?>" id="add-old_ornament-form">
	<table class="bordered-table">
		<tbody>
			<tr>
				<td><label for="old_ornament-name">Name</label></td>
				<td><input type="text" class="required" name="old_ornament-name" /></td>
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
				<td><label for="deterioration">Deterioration&nbsp;(%)</label></td>
				<td><input type="text" class="required number" name="deterioration" /></td>
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

		</tbody>
	</table>
	<input type="submit" class="btn primary" value="Add New Old Ornament" /> <input
		type="button" class="btn danger" value="Cancel"
		onclick="$.fancybox.close();" />
</form>
<?php endif; ?>