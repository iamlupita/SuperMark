<?php
$validate=array(
		"qty"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"qty"=>array(
				"isPositive"=>array($this->get_message("positive integer"))
		),
		"reason"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		)

);

?>
<style>
textarea, .textStyle { width: 249px!important;}
textarea {border: 1px solid #CCCCCC;}
</style>
<link rel="stylesheet" href="css/cart.css" type="text/css" />
<link rel="stylesheet" type="text/css" media="all" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css">
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-ui-1.8.23.custom.min.js' ></script>
<script type='text/javascript' src='<?php echo BASE?>common/js/common.js'></script>

<link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE;?>css/jquery.selectBoxIt.css" />
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery.selectBoxIt.min.js'></script> 


<?php 
     $form=$this->create_form();
     $form->start("return_request",$this->make_url("order/edit_return_details"),"post",$validate);
 ?>
 
 <div class="edit_ret_title"><?php echo $this->get_label('return request');?></div>
 
 <?php 
 
  if($this->get_variable('stat')==1 || $this->get_variable('stat')==""){
    ?>

<div class="ret_qty_div1">

<div class="ret_qty_div2"><?php echo $this->get_label('quantity');?><span class="mandatory">*</span></div>
<div class="ret_qty_div3"><input type="text" name="qty" id="qty" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php echo $this->get_variable('qty');?>" class="textStyle" autocomplete="off"/></div>

</div>

<div class="ret_reason_div1">

<div class="ret_reason_div2"><?php echo $this->get_label('reason');?><span class="mandatory">*</span></div>
<div class="ret_reason_div3"><textarea rows="5" cols="60" name="reason" id="reason"><?php echo $this->get_variable('reason');?></textarea></div>

</div>

<div class="ret_exp_submit_div">
<input type="hidden" name="return_id" value="<?php echo $this->get_variable('return_id');?>" />
<input type="hidden" name="shipment_id" value="<?php echo $this->get_variable('shipment_id');?>" />
<input type="hidden" name="order_item_id" value="<?php echo $this->get_variable('order_item_id');?>" />
<input type="submit" name="submit" value="<?php echo $this->get_label('return request');?>"/>
</div>

<?php }else{?>
<div class="ret_exp_div"><?php echo $this->get_label('return request period expired');?></div>
<?php } ?>
<?php $form->end(); ?>  