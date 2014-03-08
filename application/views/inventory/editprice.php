<form name="edit" method="post" action="<?php echo site_url()?>/inventory/price"> 
<input type ="hidden" name ="eid" value="<?php echo $pricedetails['item_entity_id']?>"/>
<input type ="hidden" name ="sid" value="<?php echo $pricedetails['item_specific_id']?>"/>
<table>
<tr><td>Rs<input type ="text" name ="price" value="<?php echo $pricedetails['price']?>"/></td></tr>
<tr><td align="right"><input type="submit" name = "submit" value="Change"></input></td></tr>
</table>
</form>