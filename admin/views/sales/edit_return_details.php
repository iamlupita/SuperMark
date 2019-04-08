<?php
$paramstatus=$this->get_variable('paramstatus');
$validate=array(
		"status=>2" => array(

		"amount"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"amount"=>array(
				"isNumeric"=>array($this->get_message("positive integer"))
		)),
		"remarks"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)

);
?>

<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-ui-1.8.23.custom.min.js' ></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/common.js'></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE.ADMIN_DIR.'/';?>css/jquery.selectBoxIt.css" />
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery.selectBoxIt.min.js'></script> 
<script type="text/javascript">
$(document).ready(function() {
	$('select').selectBoxIt({
	    showEffect: "fadeIn",
	    showEffectSpeed: 400,
	    hideEffect: "fadeOut",
	    hideEffectSpeed: 400});	
});
</script>
<style>
body {background: none;}
.selectboxit-text {max-width: 300px !important;}

</style>


<div class="sub_menu"><?php echo $this->get_label('return-refund product');?>

<a class="closeButton" style="position: relative;float: right;top: -5px;">X</a>

</div>
<?php 
     $form=$this->create_form();
     $form->start("return_request",$this->make_url("sales/edit_return_details"),"post",$validate);
 ?>
 <?php 
    $res=$this->get_result('res');
    foreach($res as $key=>$row)
    {
    
    ?>
        
<table style="width: 95%;margin-left: 10px;" cellpadding="0" cellspacing="0">
 
   
   <tr>
    <td  width="30%;"><?php echo $this->get_label('quantity');?></td>
	<td><input type="text" id="quantity" name="quantity" value="<?php echo $row['qty'];?>" disabled="disabled" class="textStylePadding" style="background: #ECECEC;">
	</td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
     <td><?php echo $this->get_label('reason for refund');?></td>
	 <td><textarea rows="4" cols="30"  id="reason" name="reason" disabled="disabled"  class="textStylePadding" style="background: #ECECEC;"><?php echo $row['reason'];?></textarea></td>
     </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
    <td><?php echo $this->get_label('amount');?><span class="mandatory">*</span></td>
	<td><input  id="amount" name="amount" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php if($row['amount']!="" && $row['amount']>0){echo $row['amount'];}?>" class="textStylePadding"> </td>
  </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
   <tr>
     <td><?php echo $this->get_label('remarks');?><span class="mandatory">*</span></td>
	<td ><textarea rows="4" cols="30"  id="remarks" name="remarks" class="textStylePadding"><?php echo $row['admin_remarks'];?></textarea></td>
     </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
     <tr>
     
     <td><?php echo $this->get_label('status');?><span class="mandatory">*</span></td>
     <td>
     <select name="status" id="status">
     <option value="1" <?php if($row['stat']==1){?> selected="selected" <?php }?> ><?php echo $this->get_label('requested');?></option>
     <option value="2" <?php if($row['stat']==2){?> selected="selected" <?php }?> ><?php echo $this->get_label('approved');?></option>
     <option value="3" <?php if($row['stat']==3){?> selected="selected" <?php }?> ><?php echo $this->get_label('rejected');?></option>
     </select>
     </td>
     
     </tr>
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
  
  <tr><td>&nbsp;</td>
  
  <td>
   <input type="hidden" name="paramstatus" value="<?php echo $paramstatus;?>">
   <input type="hidden" name="return_id" value="<?php echo $row['return_id'];?>">
   <input type="hidden" name="order_id" value="<?php echo $row['order_id'];?>">
   <input type="hidden" name="redirect_page" value="<?php echo $this->get_variable('redirect_page');?>">
   <input type="submit" name="sub" value="<?php echo $this->get_label('save');?>" class="btn btn-default">
  </td>
  
  </tr>
  
  
  <tr><td colspan="2" style="height:10px !important;"></td></tr>
  
     
     
  </table>
<?php } ?>
<?php $form->end(); ?>  
<script type="text/javascript">
$(document).ready(function(){
$('.closeButton').click(function(){
$('.popup-outer', window.parent.document).hide();
});
});
</script>