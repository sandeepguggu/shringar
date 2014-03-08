<div class="attributes">
	<div class="content-header">
		<h3>Mange Attributes</h3>
		<a href="<?php echo site_url('attribute/add?ajax=1'); ?>" class="btn btn-primary fancybox pull-right">
			<i class="icon-briefcase icon-white"></i>
			New Attribute
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