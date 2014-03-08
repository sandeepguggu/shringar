<div class="edit-class-category">
	<div class="content-header">
		<h3>Update Classification Category</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('classification/update_class_to_db?ajax=1'); ?>" method="post" id="form_edit_class_category" onsubmit="return false;">
		<input type="hidden" name="id" value="<?php echo isset($id) ? $id : ''; ?>" />
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
                    <input type="text" class="required" name="name" value="<?php echo isset($name) ? $name : ''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Parent:</label>
                <div class="controls">
                  <select name="parent_class">
                    <?php foreach($class as $c)
                    { 
                    // debugbreak();
                     if($c['id'] == $selected_parent_id){?>
                          <option value="<?php echo $c['id']?>" selected="selected"><?php echo $c['name']?></option>
                    <?php  }else{ ?>
                               <option value="<?php echo $c['id']?>"><?php echo $c['name']?></option>
                    <?php } 
					} ?>
                    </select>
                </div>
            </div>
            <div class="control-group hide">
                <label class="control-label">Sort Order:</label>
                <div class="controls">
                    <select name="sort_order">
                        <option value="0">ROOT</option>
                        <?php
                        if (isset($class)) {
                            foreach ($class as $c)
                            {
                                echo '<option value="' . $c['id'] . '"';
                                //TODO Sort Order Needs to be fixed
                                if (isset($selected_sort_order)) {
                                    echo ($c['id'] == $selected_parent_id) ? ' selected ' : '';
                                }
                                echo '>' . $c['name'] . '</option>';
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>
            <input type="hidden" name="parent_id" value="0" id="edit_class_parent_id" />
            <div class="control-group">
                <label class="control-label">Attributes:</label>
                <div class="controls autocomplete-jui">				
                    <div class="ui-widget input-append">
                        <input id="edit_category_class_attributes" type="text" class="input-add"/>
                        <span class="add-on search-image" id="edit_category_class_attributes_plus">
                            <i class="icon-plus"></i>
                        </span>
						<div id="class_attributes_tags" class=""></div>
                    </div>
                </div>
            </div>
			<input type="hidden" id="edit_class_attributes_row_count" value="<?php if(isset($row_total)) echo $row_total; ?>" />
			<table class="table table-striped table-bordered" id="edit_class_attributes_table">
				<tr>
					<th>Name</th>
					<th class="span1">Level</th>
					<th style="width: 20px">&nbsp</th>
				</tr>
				<?php 
					if(isset($html)) {
						echo $html;
					}
				?>
			</table>
        </div>
		<div class="content-footer">
            <button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
                <i class="icon-remove-circle icon-white"></i>
                &nbsp;Cancel
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
			<button type="button" class="btn btn-primary pull-right" onclick="$(this).submit(); $(this).fancbox.close();">
				<i class="icon-ok-circle icon-white"></i>
				&nbsp;Submit
			</button>
		</div>
	</form>
</div>
<script type="text/javascript">
	/*formValidate.submit('#form_edit_class_category', true);
	formValidate.messages();*/
    app.autocomplete('#edit_category_class_attributes', '/index.php/classification/suggest_attribute?json=1&from=class', classes.editSelect);
	element.click('#edit_category_class_attributes_plus', classes.edit);
    tree.create('#edit_class_tree', { select : classes.changeEditClassId });

    validation.bind({
        formId: '#form_edit_class_category',
        ajaxSubmit: true,
        reload: true
    });
    element.focus('.edit-class-category input, .edit-class-category textarea', validation.focus);
    element.key_up('.edit-class-category input, .edit-class-category textarea', validation.focus);
</script>