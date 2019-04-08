<?php $this->dispatch("layout/header");?>
   
<div class="container mtop-20">
    	
<?php $this->dispatch("layout/login_left");
$payments=$this->get_result('res');
$cnt=count($payments);
?>

	<div class="accountData contentLeft" style="margin-bottom: 40px;">
                
	<h1 class="titleh1"><?php echo $this->get_label('payment details');?></h1>
				
<?php if($cnt>0){ ?>  
				 
	<div class="manage_address_div1 div_bg brdr_right brd_left"><?php echo $this->get_label('order id');?></div>
    <div class="manage_address_div1 div_bg brdr_right"><?php echo $this->get_label('amount');?></div>
    <div class="manage_address_div div_bg brdr_right"><?php echo $this->get_label('payment date');?></div>
    <div class="manage_address_div div_bg brdr_right"><?php echo $this->get_label('payment type');?></div>
	<div class="manage_address_div div_bg"><?php echo $this->get_label('action');?></div>
                   
<?php 
   
    foreach($payments as $key=>$row)
    {
?>
     <div class="manage_address_div1 brd_left brdr_right brdr_btm"><a href="<?php echo $this->make_url("order/details/").$row['order_id'];?>">#<?php echo $row['order_id']; ?></a></div>
                       
     <div class="manage_address_div1 brdr_right brdr_btm"><?php echo $this->get_money_format($row['amount']);?></div>
     <div class="manage_address_div brdr_right brdr_btm"><?php echo $this->get_date_format(2,$row['received_date'])?></div>
     <div class="manage_address_div brdr_right brdr_btm"> <?php echo $this->get_payment_mode($row['payment_type'])?></div>
     <div class="manage_address_div brdr_right brdr_btm">
			<a class="cartAddition" title="<?php echo $this->get_label('payment details');?>" href="<?php echo $this->make_url("payment/details");?>/<?php echo $row['id']; ?>" ><?php echo $this->get_label('payment details');?></a>
     </div>

<?php } 

	echo "<div class='public_pagination_div'>".$this->get_variable('pagination')."</div>";

    }
   else { 
	echo $this->get_label('no record');
}
    ?>			
</div>		
				
</div>
<?php $this->dispatch("layout/footer");?>