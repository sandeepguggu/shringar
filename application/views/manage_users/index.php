<?php
if(!isset($ajax)){
	$ajax = false;
}
$cur_tab = 1;
if(!isset($tab)){
	$tab = 'default';
}
$tabs = array();
$tabs[] = array("index"=>2, 
				"title"=> "Users", 
				"name"=>"user", 
				"href"=>site_url('manage_users/user?tabs=1'), 
				"class"=>"first",
				'url' => 'manage_users/user'
			);
$tabs[] = array("index"=>3, 
				"title"=> "Groups", 			
				"name"=>"group", 		
				"href"=>site_url('manage_users/group?tabs=1'), 
				"class"=>"",
				'url' => 'manage_users/group'
			);
$tabs[] = array("index"=>4, 
				"title"=> "Group Permission", 			
				"name"=>"group_permission", 		
				"href"=>site_url('manage_users/groupPermission?tabs=1'), 
				"class"=>"",
				'url' => 'manage_users/groupPermission'
			);
if($ajax === false){
?>
<div id="tabs" class="ui-tabs">
	<ul class="ui-tabs-nav">
		<li class="hide"><a href="#tabs-1">Preloaded</a></li>
		 <?php
        foreach ($tabs as $t) {
            echo '<li class="' . (($t['name'] == $tab) ? 'ui-tabs-selected ' : '') . $t['class'] . '" url="' . $t['url'] . '">';
            if ($t['name'] == $tab) {
                echo '<a href="#ui-tabs-' . $t['index'] . '">' . $t['title'] . '</a>';
            } else {
                echo '<a href="' . $t['href'] . '">' . $t['title'] . '</a>';
            }
            echo '</li>';
            $cur_tab++;
        }
        ?>
	</ul>
	<div id="tabs-1">
		
		<div class="indexPageContainer">
			<h2>Manage User</h2>
			<div>
			<ul>
				<li>You can create users</li>
				<li>You can create group</li>
				<li>You can assign permission to the group</li>
			</ul>
			</div>
		</div>
	</div>
	<?php
    foreach ($tabs as $t) {
        if ($tab == $t['name']) {
            echo '<div id="ui-tabs-' . $t['index'] . '">';
            echo $output;
            echo '</div>';
        }
    }
    ?>
</div>
<script>
    $(function () {
        tabs.bind({
            tabsId:'#tabs'
        });
    });
</script>
<?php
}else{
	echo $output;
}
?>