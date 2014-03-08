<script type="text/javascript">
$(document).ready(function(){
 $("#date").daterangepicker();
 var myDate=new Date();
 month  = myDate.getUTCMonth()+1;
 if(month < 10){ var today = myDate.getUTCFullYear()+"-0"+month+"-"+myDate.getUTCDate();}
 else { var today = myDate.getUTCFullYear()+"-"+month+"-"+myDate.getUTCDate();}
 $("#date").val(today);
 $("#checkbox").hide();
 $("#entity-type").hide();
   var cache = {}, lastXhr;
	var pcache = {}, plastXhr;

	$('.inventory-report .entity-name').autocomplete({
		appendTo: $('.inventory-report .entity-name').parents('.autocomplete-jui'),
		minLength: 2,
		source: function( request, response ) {
			var term = request.term;
			if ( term in cache ) {
				response( cache[ term ] );
				return;
			}
		   if($('.entity-list').val()== 3) 
			   {
				lastXhr = $.getJSON( "/index.php/inventory/get_ornament_name?json=1", request, function( data, status, xhr ) {
					cache[ term ] = data;
					if ( xhr === lastXhr ) {
						response( data );
					}
				});
			   }
			 else 
			 {
				lastXhr = $.getJSON( "/index.php/inventory/get_entity_name?json=1", request, function( data, status, xhr ) {
					cache[ term ] = data;
					if ( xhr === lastXhr ) {
						response(data);
					//  alert (jQuery.parseJSON(data));
					}
				}); 
			 }  
		
		},
		select: function(e,ui) {
		 if(ui.item.ornament_id)
				{
				  $('.inventory-report #ornament_id').val(ui.item.ornament_id);
				  $('.entity-name').focusout(function(){
				   $.ajax({
			  type: 'GET',
				  url: <?php site_url()?>'/index.php/inventory/ornament_report/'+$(".entity-list").val()+'/'+$("#ornament_id").val()+'/'+ $("#date").val(),
						success: function(data) {
							var data1 = jQuery.parseJSON(data);
							 $(".report-table").show();
							 $('.report-table').html(data1.html);
						}
					}); 
				   })
				}
			 else {
				   $('.inventory-report #entity_id').val(ui.item.entity_id);
				  $('.inventory-report #specific_id').val(ui.item.specific_id);
			 }   
		}
	});
 $('.entity-name').change(function(){
			 if ($('.entity-name').val().length >0)     
			 {
				  if($('.entity-list').val()== 3)
				 {
					$("#checkbox").hide(); 
				 }
			  else {    $('#type').removeAttr('checked'); $("#checkbox").show(); }
			 
			 }
			 else {$("#checkbox").hide(); $('#type').removeAttr('checked');
 $(".report-table").hide();}
		});
 $('#type').click(function(){
		 if($("#entity_id").val()!="" && $("#specific_id").val()!="")
		 {
			$.ajax({
			  type: 'GET',
					   
						url: <?php site_url()?>'/index.php/inventory/report_as_bullion/'+$("#entity_id").val()+'/'+$("#specific_id").val()+'/'+ $("#date").val(),
						success: function(data) {
							var data1 = jQuery.parseJSON(data);
							 $(".report-table").show();
							 $('.report-table').html(data1.html);
						}
					}); 
   }
  else { alert('Please Search for avaliable Entity Name');}
 });
 
 $('#type1').click(function(){
		 if($("#entity_id").val()!="" && $("#specific_id").val()!="")
		 {
		  $.ajax({
			  type: 'GET',
						url: <?php site_url()?>'/index.php/inventory/report_as_subitem/'+$("#entity_id").val()+'/'+$("#specific_id").val()+'/'+ $("#date").val(),
						success: function(data) {
							var data1 = jQuery.parseJSON(data);
							 $(".report-table").show();
							 $('.report-table').html(data1.html);
						}
					}); 
   }
	else { alert('Please Search for avaliable Entity Name');}
 });
 $('.entity-list').change(function(){
	 $('#entity-name').val(" ");
	 $('#entity-type').show();
	 $('.report-table').html("Please Select above");
   })  
 });
</script>
<div class="inventory-report">
	<!-- User Access Message -->
	<?php if (isset($access)): ?>
		<h3><?= $access ?></h3>
	<?php else: ?>
		<h3 class="pull-left">Report</h3>
		<br />
		<hr />
		<form>
			<fieldset class="my-block">
				<label for="date" class="pull-left span2">Select Date</label>
				<input id="date" class="pull-left span3" style="float: left" type="text" name="date" autocomplete="off" />
				 <span class="span1 pull-left">&nbsp;</span>
				  <label class="pull-left span2">Entity Type</label>
				<div class="entity">
							  <select class="pull-left entity-list">
							<option value="0">Select-One</option>
							 <?php  echo $dropdown; ?>
							</select>
						   </div>
				  <span class="span1 pull-left">&nbsp;</span>
				<div id="entity-type">
				   <label class="pull-left span2">Entity Name</label>
				<div class="entity-type">
				  <div class="autocomplete-jui">
							<div class="ui-widget">
								<input type="text" class="entity-name" autocomplete="off" />
							   <input type="hidden" id="entity_id">
							   <input type="hidden" id="specific_id">
							   <input type="hidden" id="ornament_id">
							</div>
						</div>
						</div></div><br/>
					   <span id="checkbox">Boolean&nbsp;<input type="radio" id="type" name="type" value="1"/>&nbsp;&nbsp;&nbsp;SubItem&nbsp;<input type="radio" name="type" id="type1" value="2"/></span>
			</fieldset>
			</div>
		</form>
		<span class="report-table"></span>
<?php endif; ?>


