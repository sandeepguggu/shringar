<ul
	class="ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all">
	<li style="display: none; width: 0px; height: 0px;"
		class="ui-state-default ui-corner-top"><a href="">Preloaded</a>
	</li>
	<li class="first ui-state-default ui-corner-top"><a href="<?php echo site_url('po')?>"><span
			class="span_img per_order"></span>PURCHASE ORDER</a>
	</li>
	<li class="ui-state-default ui-corner-top"><a href="<?php echo site_url('grn')?>"><span
			class="span_img grn"><em>Loading…</em>
		</span>GRN</a>
	</li>
	<li
		class="ui-state-default ui-corner-top ui-tabs-selected ui-state-active"><a
		href="<?php site_url('vendor')?>"><span class="span_img mng_ven"><em>Loading…</em>
		</span>Manage Vendors</a>
	</li>
	<li class="ui-state-default ui-corner-top"><a href="<?php site_url('brand')?>brand"><span
			class="span_img brand"></span>Manage Brands</a>
	</li>
	<li class="ui-state-default ui-corner-top"><a href="<?php site_url('category')?>category"><span
			class="span_img mng_cat"></span>Manage Category</a>
	</li>
	<li class="ui-state-default ui-corner-top"><a href="<?php site_url('po')?>product"><span
			class="span_img mng_prd"></span>Manage Products</a>
	</li>
</ul>

<?php 
echo $output;
?>