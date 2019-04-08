<?php 
$cartcound=$this->get_variable('cartcound');
if($cartcound >0)
{
?>
 
<h2 class="cart_popup" id="items"><?php echo $this->get_label('cart items');?> (<label id="cart-count-label" class="alertColor"><?php echo $cartcound;?></label>)</h2>


<div class="cartRow cart_popup_head">
<table class="checkout_table">
		<tr>
		<td style="padding-left: 10px;width: 265px;"><?php echo $this->get_label('product');?> </td>
		<td style="color: #C9D94E;width: 110px;"><?php echo $this->get_label('item price');?></td>
		<td style="width: 110px;"><?php echo $this->get_label('quantity');?></td>
		<td style="color: #C9D94E;width: 115px;"><?php echo $this->get_label('subtotal');?></td>
		<td style="width: 30px;"></td>
		</tr>
</table>
</div>
		

<div style="overflow-y: auto;height: 170px;">
<div class="itemsDisplay" style="padding-top: 5px;">
		
		
<?php 
    $orderitem=$this->get_result('cartitem');$i=0;
    foreach($orderitem as $key=>$row)
    {
    $i++;
    ?>
    
    <div class="cartRow" id="view_cart_<?php echo $row['id'];?>" style="margin-top: 5px;width: 635px;">
			<table class="cartRowTable" cellpadding="0" cellspacing="0" >
			
			<tr>    	
			<td width="55px">
			 <?php 
                list($widthimage,$heightimage) = @getimagesize($this->get_product_image($row['id']));
				$dimension=$this->get_image_dimension($widthimage,$heightimage,11);
				$dimensionarray=explode('_',$dimension);
               	
                ?>
            <div class='cartImage' style="padding-right: 4px;">
            <div> 
			<img style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>" src="<?php echo $this->get_product_image($row['id']);?>" />
			</div> 
			</div> 
			</td>
			
			<td width="190px" style="padding-left: 5px;"><div class="cartProductTitle"><?php echo $this->escape($this->get_product_name($row['id'])); ?></div></td>
			<td width="100px">  <div align="left" class="alertColor">
			<?php 
			if($row['prod_stock']<1 || $row['status']==0)
				 echo $this->get_label('not available');
			else
				echo  $this->get_money_format($this->get_product_pricing($row['id']));?>
			</div></td>
			
			
			<td width="95px">
			<?php 
			
			if($row['prod_stock']<1 || $row['status']==0)
				 echo $this->get_label('not available');
			else{?>
			<input type="text" class="cartRowQty" id="qty<?php echo $row['id'] ?>" value="<?php echo $this->get_quantity_from_cookie($row['id']); ?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');if(this.value><?php echo $row['prod_stock'] ?>){$('#changesubmit_<?php echo $row['id'] ?>').hide();alert('<?php echo $this->get_message('quantity exceeded stock');?>');}else{$('#changesubmit_<?php echo $row['id'] ?>').show();}"/>
            <input class="cartRowSave" id="changesubmit_<?php echo $row['id'] ?>" type="button"  value="Save" onclick="changeQuantity(<?php echo $row['id'] ?>);"/>
		<?php } ?>
			</td>
			
			<td width="95px"> <div id="costsetup_x" class="alertColor" style="padding-left: 6px;"> <div align="left" id="cost_x<?php echo $row['id'];?>">
			
			
			<?php 
			if($row['prod_stock']<1 || $row['status']==0)
				 echo $this->get_label('not available');
			else
				echo  $this->get_money_format($this->get_product_pricing($row['id'],$this->get_quantity_from_cookie($row['id'])));?>
			
			</div></div></td>
			
			<td width="40px"><a href="javascript:onClick=removeFromCart(<?php echo $row['id'];?>);"><span class="cartRowRemove">X</span></a></td>
			
			</tr>
			
			
		</table></div>
		<?php 
    }
    ?>	
		</div>
		
		</div>
		
		<div class="cartGrandTotal">
		
		<div class="cartLabel"><span style="font-weight: bold;"><?php echo $this->get_label('grand total');?></span> <span class="cartTotal alertColor"><?php echo $this->get_money_format($this->get_grand_total('',1))?></span> </div>
		
		<div class="alertColor" style="margin-top: 8px;"><?php echo $this->get_label('shipping cost notice');?></div>
		
		
		<div style="margin-top: 25px;">
		<a href="<?php echo $this->make_url("index/index");?>" class="purchaseItems orderShip"><span style="float: left;padding-top: 7px;"><?php echo $this->get_label('continue shopping');?></span><img src="images/cart.png" style="width: 30px;height: 30px;"></a>
		<a href="<?php echo $this->make_url("cart/checkout");?>" class="purchaseItems placeOrder"><span><?php echo $this->get_label('proceed checkout');?></span></a>
		
		</div>
		
		</div>
		@#@#@#@#<?php echo $cartcound; ?>
<?php 
}
else 
{?>
<a href="<?php echo $this->make_url("index/index");?>"><img src="images/emptyCart.png" /></a>@#@#@#@#<?php echo $cartcound; ?>
<?php }?>