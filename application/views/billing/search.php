<style>
.box {
	width:100%;
}
.left {
	float:left;
}
.right {
	float:right;
}
.clr {
	clear:both;
}
.b {
	font-weight:bold;
}
.mt_10 {
	margin-top:10px;
}
.mt_20 {
	margin-top:20px;
}
.ui-autocomplete-loading {
	background: white url('/resources/css/images/ui-anim_basic_16x16.gif') right center no-repeat;
}
</style>

<script type="text/javascript">

$(function() {
	$("#search_invoice_search").keyup(function(){
		if($(this).val().trim().length > 0){
			$("#search_show_invoice").load("<?php echo site_url('/invoice/suggest'); ?>",{'term' : $(this).val(),'html':1,'from':'search'});
		}
	});

	$('.twenty-bills').click(function() {
		$.fancybox.showActivity();
                $.ajax({
                    url:site_url + '/invoice/latest_invoices/20',
                    method:'POST', 
                    data : {date : 1} ,                 
                    success:function (data) {                                                
                       $('#search_show_invoice').html(data);
                    },
                    complete:function (xhr, status) {
                        $.fancybox.hideActivity();
                    },
                    statusCode:{
                        404:function () {
                            alert("page not found");
                        },
                        500:function () {
                            alert("Database Error occured");
                        }
                    }
                });
	})
});
</script>
<h3>Search Invoice</h3>
<hr />

	 <div class="search-filter block">
        <div class=" row-fluid">
            <label class="span2">
                <span>From</span>
                <input type="text" id="reports_date_from"
                       value="<?php echo isset($from) ? $from : ''; ?>">
            </label>
            <label class="span2">
                <span>To</span>
                <input type="text" id="reports_date_to"
                       value="<?php echo isset($to) ? $to : ''; ?>">
            </label>
            <label class="span1">
                <span class="search-filter-search-label">X</span>
                <button type="button" id="invoice_srch_btn" class="btn btn-primary">Submit</button>
            </label>
        </div>
    </div> 
    <div class="invoice_search">
	 <div class="autocomplete-jui">
        <div class="ui-widget">
            <label for="search_invoice_search" style="width:250px;"> Invoice Id / Customer Mobile: </label>
            <input id="search_invoice_search" />
            <input type="button" class="btn btn-primary twenty-bills" style="margin: -8px 0 0 50px;" value="Last 20 Invoices" />
        </div>
    </div> 
     
</div>
<br /><br />
<div id="search_show_invoice">
  <?php if(isset($grid)) { echo $grid; } ?>
</div>
<script>
$(document).ajaxComplete(function(){
 $(".table-bordered").find('a').fancybox();
})
    $('#reports_date_from').datetimepicker({
        onClose:function (dateText, inst) {
            var endDateTextBox = $('#reports_date_to');
            if (endDateTextBox.val() != '') {
                var testStartDate = new Date(dateText);
                var testEndDate = new Date(endDateTextBox.val());
                if (testStartDate > testEndDate)
                    endDateTextBox.val('');
            }
            else {
                endDateTextBox.val('');
            }
        },
        onSelect:function (selectedDateTime) {
            var start = $(this).datetimepicker('getDate');
            $('#reports_date_to').datetimepicker('option', 'minDate', new Date(start.getTime()));
        }

    });
    $('#reports_date_to').datetimepicker({
        onClose:function (dateText, inst) {
            var startDateTextBox = $('#reports_date_from');
            if (startDateTextBox.val() != '') {
                var testStartDate = new Date(startDateTextBox.val());
                var testEndDate = new Date(dateText);
                if (testStartDate > testEndDate)
                    startDateTextBox.val('');
            }
            else {
                startDateTextBox.val('');
            }
        },
        onSelect:function (selectedDateTime) {
            var end = $(this).datetimepicker('getDate');
            $('#reports_date_from').datetimepicker('option', 'maxDate', new Date(end.getTime()));
        }
    });
   // element.click('#filter_reports_btn', reports.filter);
   // element.change('#reports-drop-down', reports.filter);
 $("#invoice_srch_btn").click(function(){
      $("#overlay").show();
     var from_date = $("#reports_date_from").val();
      var to_date = $("#reports_date_to").val();
    //  var branch = $("#branch").val();   
             $.ajax({
            url:site_url + '/invoice/latest_invoices?ajax=1',
            data:{
                from_date :from_date,
                to_date : to_date,
                date : 1,
               // branch : branch
            },
            type:'GET',
            success:function (data) {
               $("#search_show_invoice").html(data);
               $("#overlay").hide();
            }
        });
     
 });

</script>