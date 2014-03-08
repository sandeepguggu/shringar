<div class="edit-category">
	<div class="content-header">
		<h3>Update Category</h3>
	</div>
	<form class="form-horizontal" action="<?php echo site_url('rent/updateCategoryDB?ajax=1'); ?>" method="post" id="form_edit_category" onsubmit="return false;">		
            <input type="hidden" name="id" value="<?php echo isset($id)?$id:''; ?>" />
            <div class="content-subject">
                <?php if(isset($success)): ?>
                        <div class="label label-success flash-message"><?php echo $success; ?></div>
                <?php elseif(isset($failed)): ?>
                        <div class="label label-warning flash-message"><?php echo $failed; ?></div>
                <?php endif;?>	
			
            <div class="label label-warning">Fill</div>
		<div class="control-group">
                <label class="control-label">Category Name:</label>
                <div class="controls">
                    <input type="text" name="category_name" class="required" value="<?php echo isset($category['category_name'])?$category['category_name']:''; ?>" />
                    <input type="hidden" name="id"  value="<?php echo isset($category['id'])?$category['id']:''; ?>" />
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">Parent Category:</label>
                <div class="controls">
                    <select name="parent_id">
                        <option value="0">[ROOT]</option>
                        <?php
                            if(isset($categories)){
                                foreach($categories as $c){
                                    echo '<option value="'.$c['id'].'"';
                                    if(isset($category['id'])){
                                            echo ($c['id'] == $category['parent_id'])?' selected ':'';
                                    }
                                    echo '>'.$c['category_name'].'</option>';
                                }
                            }
                        ?>
                    </select>
                </div>
            </div>
            <div class="content-footer">
                <button type="submit" class="btn btn-primary pull-right">
                        <i class="icon-ok-circle icon-white"></i>
                        &nbsp;Update
                </button>
                <span class="pull-right">&nbsp;&nbsp;</span>
                <button type="button" class="btn btn-danger pull-right" onclick="$.fancybox.close()">
                        <i class="icon-remove-circle icon-white"></i>
                        &nbsp;Cancel
                </button>
            </div>
        </div>
	</form>
</div>
<script type="text/javascript">
	formValidate.submit('#form_edit_category', true);
	formValidate.messages();
</script>