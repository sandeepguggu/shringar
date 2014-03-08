<script type="text/javascript">
    $(document).ready(function () {
        $('#invoice_date').daterangepicker();
        $('#invoice_date').focusout(function () {
            if ($('#invoice_date').val().length > 0 && $('#invoice_date').val() != " ") {

                $.ajax({
                    type:'GET',
                    url:'http://local.alice.com/index.php/billing/invoice_report/1/' + $("#invoice_date").val(),
                    success:function (data) {
                        var data1 = jQuery.parseJSON(data);
                        $('#report2').html(data1);
                    }
                });
            }
        })

    });
</script>

<?php //print_r($output); ?>
<div class="scheme">
	<!-- User Access Message -->
<?php if (isset($access)): ?>
    <h3><?= $access ?></h3>
    <?php else: ?>
    <h3 class="pull-left">Report</h3>
    <br/>
    <hr/>
		<form>
            <h3>Date</h3>
            <fieldset>
                <div class="my-block">
                    <div class="contact-class" style="width: 50%; float: left">
                        <div>
                            <div class="text_contact1"><label for="invoice_date">Select Date</label></div>
                            <input id="invoice_date" class="pull-left span3" style="float: left" type="text" name="date"
                                   autocomplete="off"/>
                        </div>
                    </div>
            </fieldset>
            <div id="report1" style="width: 100%;">
                <span id="report2"></span>
            </div>
			</div>
		</form>
	<?php endif; ?>
</div>
