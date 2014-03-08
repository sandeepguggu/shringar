<?php
$reload = 'true';
?>
<div class="create-group">
    <div class="content-header">
        <h3><?php echo $groupName; ?> - Permissions</h3>
    </div>
    <form class="form-horizontal" action="<?php echo site_url('manage_users/saveGroupPermissions'); ?>" method="post"
          id="form-group-permissions">
        <input type="hidden" name="groupId" value="<?php echo $groupId; ?>">

        <div class="content-subject">
            <div id="group-permissions-id">
                <?php
                function buildMenu($menu, $groupTab, $margin = 0)
                {
                    echo '<ul class="list-style-none">';
                    foreach ($menu as $i => $mMenu):
                        echo '<li class="parent">';
                        $data = array(
                            'class' => 'parentTab',
                            'name' => 'tabsPer[' . $i . ']',
                            'id' => 'tabsPer[' . $i . ']',
                            'value' => $i,
                        );
                        $data['checked'] = '';
                        foreach ($groupTab as $key => $val) {
                            if ($val == $i) {
                                $data['checked'] = 'checked';
                                break;
                            }
                        }
                        echo '<label class="checkbox"><input type="checkbox" ' . $data['checked'] . ' id="' . $data['id'] . '" class="' . $data['class'] . '" value="' . $data['value'] . '" name="' . $data['name'] . '">' . $mMenu['title'] . '</label>';
                        if (isset($mMenu['children'])) {
                            buildMenu($mMenu['children'], $groupTab);
                        }
                        echo '</li>';
                    endforeach;
                    echo '</ul>';
                }
                buildMenu($fullMenu, $groupTab);
                ?>
            </div>
        </div>
        <div class="content-footer">
            <button type="button" class="btn btn-danger pull-right action-btn" onclick="$.fancybox.close()">
                <i class="icon-remove-circle icon-white"></i>
                &nbsp;Cancel
            </button>
            <span class="pull-right">&nbsp;&nbsp;</span>
            <button type="submit" class="btn btn-primary pull-right action-btn">
                <i class="icon-ok-circle icon-white"></i>
                &nbsp;Submit
            </button>
        </div>
    </form>
</div>
<script type="text/javascript">
    validation.bind({
        formId:'#form-group-permissions',
        ajaxSubmit:true,
        reload: <?php echo $reload ?>
    });
    element.change('#group-permissions-id input[type=checkbox]', manageUsers.groupPermissions);
</script>

<!--
<div class='mainInfo'>
	<h1>Assign Group Permission</h1>
	<?php /*if($submitId == 'submitGrpData'): */?>
		<p>Please assign the group permission below.</p>
	<?php /*else: */?>
		<p>Please select the group from below.</p>
	<?php /*endif; */?>
	<div id="infoMessage" style="color: red;"><?php /*echo empty($message) ? '' : $message; */?></div>
	<div id="infoMessage" style="color: green;"><?php /*echo empty($sucMesg) ? '' : $sucMesg; */?></div>
	<div id="createUserForm">
		<?php /*echo form_open("manage_users/groupPermission");*/?>
			<?php /*echo form_hidden('submitId', $submitId); */?>
			<p>Group Name:<br />
			<?php /*$js = 'onchange="submitThisForm();this.form.submit();"'; */?>
			<?php /*echo form_dropdown('groups', $groups, set_value('groups'), $js);*/?>
			</p>
			<?php /*if($submitId == 'submitGrpData'): */?>
			<p>Tab/Menu (s):<br />
			<?php /*
				//echo "<pre>";
				//print_r($fullMenu);
				//exit;
			*/?>
			<?php /*
				function buildMenu($menu, $groupTab, $margin = 0)
				{
					echo '<ul style="margin: 0 0 0 '.$margin.'px;">';
					foreach($menu as $i => $mMenu): 
						echo '<li class="parent">';
						$data = array(
							'class'	=>	'parentTab',
							'name'	=>	'tabsPer['.$i.']',
							'id'	=>	'tabsPer['.$i.']',
							'value'	=>	$i,
						);
						foreach($groupTab as $key => $val){
							if($val == $i){
								$data['checked'] = 'checked';
								break;
							}
						}
						echo form_checkbox($data);
						echo form_label($mMenu['title'], 'tabsPer['.$i.']');
						if(!empty($mMenu['children'])):
							echo '<ul style="margin: 0 0 0 30px;">';
							foreach($mMenu['children'] as $j => $sMenu):
								echo '<li>';
								$data = array(
									'class'	=>	'childTab',
									'name'	=>	'tabsPer['.$j.']',
									'value'	=>	$j,
									'id'	=>	'tabsPer['.$j.']',
								);
								foreach($groupTab as $key => $val){
									if($val == $j){
										$data['checked'] = 'checked';
										break;
									}
								}
								echo form_checkbox($data);
								echo form_label($sMenu['title'], 'tabsPer['.$j.']');
								echo '</li>';
								if(isset($sMenu['children']))
									buildMenu($sMenu['children'], $groupTab, $margin+30);
							endforeach;
							echo '</ul>';
						endif;
						echo '</li>';
					endforeach;
					echo '</ul>';
				}
				buildMenu($fullMenu, $groupTab);
			*/?>
			</p>
			<p><?php /*echo form_submit(array('name'=> 'submitme', 'value' => 'Submit', 'class' => 'btn primary'));*/?></p>
			<?php /*endif; */?>
		<?php /*echo form_close();*/?>
	</div>

</div>
<script type="text/javascript">
function submitThisForm(){
	$('input[name=submitId]').val('displayGrpData');
}
$(document).ready(function(){
	$('.childTab').click(function(){
		if($(this).parents('.parent').find('ul').find('input[type=checkbox]:checked').length === 0)
			$(this).parents('.parent').find('.parentTab').removeAttr('checked');
		if($(this).attr('checked'))
			$(this).parents('.parent').find('.parentTab').attr('checked', 'checked');

	});
	$('.parentTab').click(function(){
		if($(this).next().next().length === 0){
			return true;
		}
		if($(this).next().next().find('input[type=checkbox]:checked').length === 0)
			$(this).parents('.parent').find('.parentTab').removeAttr('checked');
		else
			$(this).parents('.parent').find('.parentTab').attr('checked', 'checked');
	});
});
</script>-->