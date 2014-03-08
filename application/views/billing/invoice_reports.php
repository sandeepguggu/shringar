<div class="create_btn" align="center">
    <a class="btn content-menu" href="<?php echo site_url('invoice/new_invoice'); ?>">&nbsp;CREATE</a>
    <!--<a class="btn content-menu" href="<?php /*echo site_url('invoice/saved'); */?>">&nbsp;SAVED&nbsp;&nbsp;</a>-->
    <a class="btn content-menu selected" href="#">REPORTS</a>
</div>
<div class="invoice-reports content-menu-body">
    <div class="content-header">
        <h3>Invoice Reports</h3>
        <!--<b class="pull-right">Date: <?php /*echo date('M jS,  Y'); */?></b>-->
    </div>
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
                <button type="button" id="invoice_report_btn" class="btn btn-primary">Submit</button>
            </label>
        </div>
    </div>
    <div class="content-subject">
        <?php
        if (isset($grid)) {
            echo $grid;
        }
        ?>
    </div>
</div>
<script type="text/javascript">    
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
 $("#invoice_report_btn").click(function(){
      $("#overlay").show();
     var from_date = $("#reports_date_from").val();
      var to_date = $("#reports_date_to").val();
    //  var branch = $("#branch").val();   
             $.ajax({
            url:site_url + '/invoice/invoice_reports?ajax=1',
            data:{
                from_date :from_date,
                to_date : to_date,
                date : 1,
               // branch : branch
            },
            type:'GET',
            success:function (data) {
               $(".content-subject").html(data);
               $("#overlay").hide();
            }
        });
     
 });
 </script>