<?php 
$this->dispatch("layout/header");
$res=$this->get_result('res');
$value=$res[0];
?>

<div class="container mtop-20">

<?php $this->dispatch("layout/login_left");?>

<div class="accountData contentLeft" style="margin-bottom: 40px;">

	<h1 class="titleh1"><?php echo $this->get_label('payment details');?></h1>
	
	<div class="width-left"><?php echo $this->get_label('your paypal transaction is completed');?></div>
	<div class="mtop-20 width-left" ><b><?php echo $this->get_label('payment details');?></b></div>
	
	<div class="trnsucs_div mtop-20">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('transaction id');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $value['txnid'];?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('order id');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><a href="<?php echo $this->make_url('order/details/').$value['order_id']; ?>">#<?php echo $value['order_id'];?></a></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('amount');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $this->get_money_format($value['amount']);?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('currency');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $value['currency'];?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('payer email');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $value['payeremail'];?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('receiver email');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $value['receiveremail'];?></div>
	
	</div>
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('status');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php echo $value['status'];?></div>
	
	</div>
	
	
	<div class="trnsucs_div">
	
		<div class="trnsucs_sub_div1"><?php echo $this->get_label('payment date');?></div>
		<div class="trnsucs_sub_div2">:</div>
		<div class="trnsucs_sub_div3"><?php if($value['receivedate']>0){echo $this->get_date_format(2,$value['receivedate']);}?></div>
	
	</div>
	
</div>
	
</div>

<?php $this->dispatch("layout/footer");?>