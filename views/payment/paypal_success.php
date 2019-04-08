<?php $this->dispatch("layout/header");?>

<div class="container mtop-20 mbot-30" style="min-height: 200px;">

	<h1 class="titleh1"><?php echo $this->get_label('paypal success');?></h1>
	
	<div class="width-left"><?php echo $this->get_label('Your paypal transaction is completed');?></div>
	<div class="mtop-20 width-left" ><b><?php echo $this->get_label('payment details');?></b></div>
	
	<div class="trnsucs_div mtop-20">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('payment status');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_variable('payment_status');?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('payment amount');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_variable('payment_amount');?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('payment currency');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_variable('payment_currency');?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('transaction id');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_variable('txn_id');?></div>
	
	</div>
	<?php if($this->get_variable('payer_email')!=""){?>
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('payer email');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_variable('payer_email');?></div>
	
	</div>
	<?php }if($this->get_variable('receiver_email')!=""){?>
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('receiver email');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_variable('receiver_email');?></div>
	
	</div>
	<?php }?>
	<?php 
		if($this->get_variable('payment_status')!="Completed")
		{
	?>
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('pending reason');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_variable('pending_reason');?></div>
	
	</div>
	
	<?php } ?>
	
</div>


<?php $this->dispatch("layout/footer");?>