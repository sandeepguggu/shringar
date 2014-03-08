<div class="content-menu-body">
    <div class="content-header">
        <h3>VAT REPORT</h3>
     <div class="pull-right">&nbsp; &nbsp;</div>
    </div>
     <div class="search-filter block">
        <div class=" row-fluid">
            <label class="span2">
                <span>From</span>
                <input type="text" id="reports_date_from"
                       value="<?php echo isset($_REQUEST['from']) ? $_REQUEST['from'] : ''; ?>">
            </label>
            <label class="span2">
                <span>To</span>
                <input type="text" id="reports_date_to"
                       value="<?php echo isset($_REQUEST['to']) ? $_REQUEST['to'] : ''; ?>">
            </label>
            <label class="span1">
                <span class="search-filter-search-label">X</span>
                <button type="button" id="vat_report_btn" class="btn btn-primary">Submit</button>
            </label>
            <label class="span1">
                <span class="search-filter-search-label">X</span>
                <button type="button" class="btn btn-primary"><a id="btnExcel" href="<?php echo site_url('inventory/vat_report_excel')?>" target="_blank" style="color:white;">Excel</a></button>
            </label>

        </div>
    </div>
    <div class="content-subject" id="reports_grid">
    </div>
 </div>
 <script type="text/javascript">
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
 $("#vat_report_btn").click(function(){
      $("#overlay").show();
     var from_date = $("#reports_date_from").val();
      var to_date = $("#reports_date_to").val();
    //  var branch = $("#branch").val();   
             $.ajax({
            url:site_url + '/inventory/get_vat_report?ajax=1',
            data:{
                from_date :from_date,
                to_date : to_date,
               // branch : branch
            },
            type:'GET',
            success:function (data) {
               $("#reports_grid").html(data);
               $("#overlay").hide();
            }
        });
     
 });
 function paginated_report(from,to,page)
{
    $("#overlay").show();
    if(from == "")
    {
      var  from = 0;
    }
    if(to == "")
    {
      var  to = 0;
    }
    $.ajax({
        type: 'POST',
        url:site_url+'/inventory/get_vat_report/'+from+'/'+to+'/'+page,
        success: function(data) {
            $('#reports_grid').html(data);
             $("#overlay").hide();
        }
    });
}
$("#reports_date_from ,#reports_date_to").change(function(){
    
    var from = $("#reports_date_from").val().replace(/\//g,'-');
    var to = $("#reports_date_to").val().replace(/\//g,'-');
   // var branch = $("#branch").val();
    //var href =  $("#btnExcel").attr('href');
    var href = site_url + '/inventory/vat_report_excel';
    
    if(from != "")
    {
      href = href + '/'+from;   
    }else{
        href = href +'/0'
    }
    if(to != "")
    {
         href = href + '/'+to; 
    }else{
        href = href +'/0'
    }
    
 $("#btnExcel").attr('href',href);
});
 </script> 