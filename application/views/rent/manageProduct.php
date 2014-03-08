<?php if (isset($access)): ?>
    <?php echo $access; ?>
<?php elseif (isset($error_msg)): ?>
    <?php echo $error_msg; ?>
<?php else: ?>
    <div class="product">
        <div class="content-header">
            <h3>Manage Rent Products</h3>
            <a href="<?php echo site_url('rent/addProduct?ajax=1'); ?>" class="btn btn-primary fancybox pull-right" id="vendor_add_btn">Add Product</a>
            <div class="pull-right">&nbsp; &nbsp;</div>
		<div class="pull-right input-append">
			<input class="span2" type="text" />
			<span class="add-on search-image">
				<i class="icon-search"></i>
			</span>
		</div>
        </div>
        <br />
        <div class="data-grid">
            <?php if (isset($grid)) echo $grid; ?>
        </div>
    </div>
<?php endif; ?>
<script type="text/javascript">
    fancyBox.bind();
</script>