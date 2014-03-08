<script>
$(document).ready(function(){
 //  alert($("#cash").val());
    $("#cash").on('keyup',function(){
       
       var total = parseFloat($("#total_amt").val(),10).toFixed(2);
       var cash = (parseInt($("#cash").val()) > 0) ? parseFloat($("#cash").val(),10).toFixed(2) : 0;
       if(cash > total)
       {
            $(".error-cash").html("Cash amount exceeds total amt");
            $("#split_btn").attr('disabled','disabled');
       } else{
        $(".error-cash").html(" ");
       var card = total - cash;
       $("#card").val(card);
        $("#split_btn").removeAttr('disabled');
	   }
    })
    
    $("#card").on('keyup',function(){
       var total = parseFloat($("#total_amt").val(),10).toFixed(2);
       var card = (parseInt($("#card").val()) > 0) ? parseFloat($("#card").val(),10).toFixed(2) : 0;
       if(card > total)
       {
            $(".error-card").html("Card amount exceeds total amt");
             $("#split_btn").attr('disabled','disabled');
       } else{
        $(".error-card").html(" ");
       var cash = total - card;
       $("#cash").val(cash);
        $("#split_btn").removeAttr('disabled');
	   }
    })
    
    $("#split_btn").click(function(){
    
     if($("#split_btn").prop('disabled') == false)
     {
                var card = (parseInt($("#card").val()) > 0) ? parseFloat($("#card").val(),10).toFixed(2) : 0;
                var cash = (parseInt($("#cash").val()) > 0) ? parseFloat($("#cash").val(),10).toFixed(2) : 0;
                 var id = $("#bill_id").val();
                 $.ajax({
                    url:site_url + '/invoice/submit_split_bill',
                    method:'POST', 
                    data : {card : card,
                              cash:cash,
                              id :id
                    } ,                 
                    success:function (data) {                                                
                      // $('.success-bill-split').html('Bill Split has been succesfully applied');
                       $.fancybox.close();
                    },
                });
	 }
	 
});
})
</script>

<div class="invoice_split_bill_wrapper">
<input type="hidden" value="<?php echo $id?>" id="bill_id"/>
<div class="invoice_split_bill_label">Total Amount : <span id="total"><?php echo $amount['total_amount'];?></span><input type="hidden" id="total_amt" value="<?php echo $amount['total_amount']?>"/></div>
<span class="success-bill-split"></span>
<div class="invoice_split_bill_inner_wrapper">
<div class="invoice_split_bill_text">Paid By Cash</div>
<div class="invoice_split_bill_value"><input type="text" id="cash" value="<?php echo $amount['paid_by_cash']?>"/> </div>
<span class="error-cash"></span>
</div>


<div class="invoice_split_bill_inner_wrapper">
<div class="invoice_split_bill_text">Paid By Card</div>
<div class="invoice_split_bill_value"><input type="text" id="card" value="<?php echo $amount['paid_by_card']?>"/> </div>
<span class="error-card"></span>
</div>

</div>
<button type="button" id="split_btn" class="btn btn-primary">Split</button>
