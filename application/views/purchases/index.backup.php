<?php
if(!isset($ajax)){
	$ajax = false;
}
$cur_tab = 1;
if(!isset($tab)){
	$tab = 'default';
}
$tabs = array();
$tabs[] = array("index"=>2, "title"=>  '<span class="span_img per_order"></span>' . "PURCHASE ORDER", 	"name"=>"po", "href"=>site_url('po?tabs=1'), "class"=>"first");
$tabs[] = array("index"=>3, "title"=> '<span class="span_img grn"></span>' . "GRN" , 			"name"=>"grn", 		"href"=>site_url('grn?tabs=1'), "class"=>"");
$tabs[] = array("index"=>4, "title"=> '<span class="span_img mng_ven"></span>' . "Manage Vendors" , "name"=>"vendor", 	"href"=>site_url('vendor?tabs=1'), "class"=>"");
$tabs[] = array("index"=>5, "title"=> '<span class="span_img brand"></span>' . "Manage Brands", 	"name"=>"brand", 	"href"=>site_url('brand?tabs=1'), "class"=>"");
$tabs[] = array("index"=>6, "title"=> '<span class="span_img mng_cat"></span>' . "Manage Category","name"=>"category", "href"=>site_url('category?tabs=1'), "class"=>"");
$tabs[] = array("index"=>7, "title"=> '<span class="span_img mng_prd"></span>'."Manage Products","name"=>"product", 	"href"=>site_url('product?tabs=1'), "class"=>"");
$tabs[] = array("index"=>8, "title"=> '<span class="span_img mng_prd"></span>'."GRN REPORT","name"=>"report", 	"href"=>site_url('product/grn_report?tabs=1'), "class"=>"");

if($ajax === false){
?>
<div class="purchases-page" id="tabs">
	<ul>
		<li style="display:none; width:0px; height:0px;"><a href="#tabs-1">Preloaded</a></li>
		 <?php
		 
		 foreach($tabs as $t){
			 echo '<li class="'.(($t['name'] == $tab)?'ui-tabs-selected ':'').$t['class'].'">';
			 if($t['name'] == $tab){
				 echo '<a href="#tabs-'.$t['index'].'">'.$t['title'].'</a>'; 
			 }else{
				  echo '<a href="'.$t['href'].'">'.$t['title'].'</a>';
			 }
			 echo '</li>';
			 $cur_tab++;
		 }
		?>
	</ul>
	<div id="tabs-1">
		<h2>Purchases &  Inventory Section</h2>
		<div style="margin-left:20px;">
			<ul>
				<li>Create New PO</li>
				<li>GRN</li>
			</ul>
		</div>
	</div>
	<?php
	foreach($tabs as $t){
		if($tab == $t['name']  && $t['index'] != 1){
			echo '<div id="tabs-'.$t['index'].'">';
			echo $output;
			echo '</div>';
		}
	}
	?>
</div>
<?php
}else{
	echo $output;
}
?>
