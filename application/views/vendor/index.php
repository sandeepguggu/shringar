<div class="vendors" id="vendors-content-id">
    <div class="content-header">
        <h3>Mange Vendors</h3>
        <a id="vendor_add_btn" href="<?php echo site_url('vendor/add?ajax=1'); ?>"
           class="btn btn-primary fancybox pull-right">
            <i class="icon-user icon-white"></i>
            Add Vendor
        </a>

        <div class="pull-right">&nbsp; &nbsp;</div>
        <div class="pull-right input-append">
            <input class="span2" type="text" id="vendor-search-field"/>
			<span class="add-on search-image" id="vendor-search-btn">
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
    element.click('#vendor-search-btn', BIZ.app.search, {

        field:'#vendor-search-field',
        search:1,
        url:'',
        targetDiv:'#vendors-content-id'
    });
    element.key_up('#vendor-search-field', BIZ.app.search, {
        field:'#vendor-search-field',
        search:0,
        url:'',
        targetDiv:'#vendors-content-id'
    });

</script>