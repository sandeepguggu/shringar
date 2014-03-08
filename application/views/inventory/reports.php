<div class="content-header">
    <h3>Reports</h3>

    <!--
    <div class="pull-right">&nbsp; &nbsp;</div>
    <div class="pull-right input-append">
        <input class="span2" type="text"/>
			<span class="add-on search-image">
				<i class="icon-search"></i>
			</span>
    </div>
    -->

    <!--
    <div class="pull-right">&nbsp; &nbsp;</div>
    <div class="pull-right">
        <select class="" id="reports-drop-down">
            <?php
            $reports_t = array(
                array(
                    'name' => 'R1',
                    'value' => 'r1'
                ), array(
                    'name' => 'R2',
                    'value' => 'r2'
                ),
            );
            $rpt_t = isset($_REQUEST['rpt_t']) ? $_REQUEST['rpt_t'] : '';
            foreach($reports_t as $v) {
                $selected_rpt = '';
                if($v['value'] == $rpt_t) {
                    $selected_rpt = ' selected';
                }
                echo '<option value="'.$v['value'].'"'.$selected_rpt.'>'.$v['name'].'</option>';
            }
            ?>
        </select>
    </div>
    -->
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
        <label class="span3">
            <span>Brand</span>
            <select id="reports_brand_id">
                <option value="0">All</option>
                <?php
                if (isset($brands)) {
                    foreach ($brands as $c) {
                        $selected = '';
                        if (isset($_REQUEST['brand_id']) && $_REQUEST['brand_id'] == $c['id']) {
                            $selected = ' selected ';
                        }
                        echo '<option value="' . $c['id'] . '" ' . $selected . '>' . $c['name'] . '</option>';
                    }
                }
                ?>
            </select>
        </label>
        <label class="span3">
            <span>Class</span>
            <select id="reports_class_id">
                <?php
                $selected_id = isset($_REQUEST['class_id']) ? $_REQUEST['class_id'] : 0;
                $this->load->view('class/tree_drop_down', array('tree' => $class_tree, 'class_id' => $selected_id));
                ?>
            </select>
        </label>
        <label class="">
            <span class="search-filter-search-label">X</span>
            <button type="button" id="filter_reports_btn" class="btn btn-primary">Submit</button>
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
    element.click('#filter_reports_btn', reports.filter);
    element.change('#reports-drop-down', reports.filter);
</script>