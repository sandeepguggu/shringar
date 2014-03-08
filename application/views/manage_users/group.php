<div class="manage-groups">
    <div class="content-header">
        <h3>Mange Groups</h3>
        <a href="<?php echo site_url('manage_users/createGroup?ajax=1&reload=1'); ?>"
           class="btn btn-primary fancybox pull-right">
            <i class="icon-tags icon-white"></i>
            Create Group
        </a>

        <div class="pull-right">&nbsp; &nbsp;</div>
        <div class="pull-right input-append">
            <input class="span2" type="text"/>
			<span class="add-on search-image">
				<i class="icon-search"></i>
			</span>
        </div>
    </div>
    <div class="content-subject">
        <div class="data-grid">
            <?php if (isset($grid)) echo $grid; ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    fancyBox.bind();
</script>