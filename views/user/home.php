<?php $this->dispatch("layout/header");?>
   
<div class="container mtop-20">
    	
<?php $this->dispatch("layout/login_left");?>

	<div class="accountData contentLeft" style="margin-bottom: 40px;">
                
	<h1 class="titleh1"><?php echo $this->get_label('my orders');?></h1>
				
<?php if($this->get_variable("tot")>0){ ?>  
				 
	<div class="manage_address_div1 div_bg brdr_right brd_left"><?php echo $this->get_label('order id');?></div>
    <div class="manage_address_div1 div_bg brdr_right"><?php echo $this->get_label('amount');?></div>
    <div class="manage_address_div div_bg brdr_right"><?php echo $this->get_label('order date');?></div>
    <div class="manage_address_div div_bg brdr_right"><?php echo $this->get_label('status');?></div>
	<div class="manage_address_div div_bg"><?php echo $this->get_label('action');?></div>
                   
<?php 
    $orderitem=$this->get_result('orderitem');
    foreach($orderitem as $key=>$row)
    {
?>
     <div class="manage_address_div1 brd_left brdr_right brdr_btm"> #<?php echo $row['id']; ?></div>
                       
     <div class="manage_address_div1 brdr_right brdr_btm"><?php echo $this->get_money_format($row['grand_cost']);?></div>
     <div class="manage_address_div brdr_right brdr_btm"><?php echo $this->get_date_format(2,$row['order_date'])?></div>
     <div class="manage_address_div brdr_right brdr_btm"> <?php echo $this->get_order_status($row['id'])?></div>
     <div class="manage_address_div brdr_right brdr_btm">
     
     <?php if($row['status']==2){?>
			<a href="<?php echo $this->make_url("order/reorder");?>/<?php echo $row['id']; ?>" class="cartAddition buttonArrange" title="<?php echo $this->get_label('reorder');?>"><?php echo $this->get_label('reorder');?></a>
	 <?php }?>	
			
			<a href="<?php echo $this->make_url("order/details");?>/<?php echo $row['id']; ?>" class="cartAddition buttonArrange" title="<?php echo $this->get_label('order details');?>"><?php echo $this->get_label('details');?></a>
			<?php 
			
			if($row['status']==2 && $row['payment_method'] !=0){

			?>
				<a href="<?php echo $this->make_url("payment/details/").$this->get_payment_summary_id($row['id'],$this->get_variable('user_id'));?>" class="cartAddition buttonArrange" title="<?php echo $this->get_label('payment details');?>"><?php echo $this->get_label('payments');?></a>
     		<?php } ?>
     		
     		<?php 
			
     		$pay_date=$row['payment_date'];
     		$grand_cost=$row['grand_cost'];
     		$payment_go=0;
     		if($pay_date==0 && $grand_cost>0)
     			$payment_go=1;
     		
     		
     		if($payment_go==1){

			?>
			
	<!--<form action="https://www.sandbox.paypal.com/cgi-bin/webscr" method="post" name="paynow_<?php echo $row['id']; ?>" id="paynow_<?php echo $row['id']; ?>">-->
	<form action="https://www.paypal.com/cgi-bin/webscr" method="post" name="paynow_<?php echo $row['id']; ?>" id="paynow_<?php echo $row['id']; ?>">
    <input type="hidden" name="cmd" value="_xclick">
	<input type="hidden" name="item_name" value="<?php echo Settings::get_instance()->read('engine_name')." - ".$this->get_label('payments');?>">
	<input type="hidden" name="item_number" value="<?php echo $row['id'];?>">
	<input type="hidden" name="amount" id="amount" value="<?php echo $grand_cost;?>">
	<input type="hidden" name="currency_code" value="<?php echo Settings::get_instance()->read('paypal_currency');?>">
	<input type="hidden" name="notify_url" value="<?php echo $this->make_url('payment/paypal_ipn')?>">
	<input type="hidden" name="cancel_return" value="<?php echo $this->make_url('payment/cancel')?>">
	<input type="hidden" name="business" value="<?php echo Settings::get_instance()->read('paypal_email');?>">
	<input type="hidden" name="no_shipping" value="1">
	<input type="hidden" name="no_note" value="0">
	<input type="hidden" name="custom" value="<?php echo $this->get_variable('user_id');?>">
	<input type="hidden" name="rm" value="2">
	<input type="hidden" name="return" value="<?php echo $this->make_url('payment/paypal_success')?>">
	
	<a href="javascript:void(0);" onclick="paynow('<?php echo $row['id']; ?>')" class="cartAddition buttonArrange" title="<?php echo $this->get_label('proceed to payment');?>"><?php echo $this->get_label('pay now');?></a>
    
    
	</form>
	
	
 	
	<?php } ?>
     		
     		
     		
     		
     </div>

<?php } 
 echo "<div class='public_pagination_div'>".$this->get_variable('pagination')."</div>";
    }
   else if($this->get_variable("tot")==0){ 
	echo $this->get_label('no orders');
}
    ?>			
</div>		
	
				
</div>
 

<script type="text/javascript">
function paynow(id)
{
	 $( "#paynow_"+id).submit();
}
</script>
	
<?php $this->dispatch("layout/footer");?>