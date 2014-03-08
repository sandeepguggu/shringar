<div class="category">
	<div class="content-header">
		<h3>Mange Tax category</h3>
		<a id="vendor_add_btn" href="<?php echo site_url('category/add?ajax=1'); ?>" class="btn btn-primary fancybox pull-right">
			<!--<i class="icon-tags icon-white"></i>-->
			Add Category
		</a>
		<div class="pull-right">&nbsp; &nbsp;</div>
		<div class="pull-right input-append">
			<input class="span2" type="text" />
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