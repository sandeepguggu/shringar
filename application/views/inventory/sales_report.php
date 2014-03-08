<div class="content-header">
    <h3>Sales Report</h3>
</div>
    

<div class="search-filter block">
    <div class=" row-fluid">
        <label class="span2">
            <span>From</span>
            <input type="text" id="reports_date_from" value="<?php echo isset($_REQUEST['from']) ? $_REQUEST['from'] : ''; ?>">
        </label>
        <label class="span2">
            <span>To</span>
            <input type="text" id="reports_date_to" value="<?php echo isset($_REQUEST['to']) ? $_REQUEST['to'] : ''; ?>">
        </label>
        <label class="span2">
            <span class="search-filter-search-label">X</span>
            <button type="button" id="filter_reports_btn" class="btn btn-primary" style="marigin-left:10px">Submit</button>
        </label>

    </div>
</div>
<div class="content-subject" id="reports_grid">
    <?php
    if (isset($grid)) {
        echo $grid;
    }
    ?>
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
    element.click('#filter_reports_btn', sales_report.filter);
    //element.change('#reports-drop-down', reports.filter);
 $(".view_items").fancybox();
</script>