<?php 
$this->dispatch("layout/header");
$currency_symbol=Settings::get_instance()->read('currency_symbol');
$currency_position=Settings::get_instance()->read('currency_position');

$cpath= $this->get_base_path();
$cdomain=$this->get_base_domain();

?>
  <script type="text/javascript">

  function ChangeReorderQuantity(pro_id)
  {
  var quantity=$("#reorder_qty"+pro_id).val();

  if(quantity !="" && quantity >0){
	  
	  var grandtotal=$("#reorder_grandtotal").val();

	  var old_qty=parseFloat($('#reorder_prod_qty_'+pro_id).val());
	  
  $.ajax(
  		{
  		type: "GET",
  		url: "<?php echo $this->make_url("cart/change_reorder_quantity/");?>"+pro_id+"/"+quantity+"/"+grandtotal+"/"+old_qty,
  		success: function(msg)
  			{

  			if(msg=="stock")
  			alert("<?php echo $this->get_message('quantity exceeded stock');?>");
  			else if(msg=='quantity')
  			alert("<?php echo $this->get_message('invalid quantity');?>");
  			else{
  					var n=msg.split("@#@");	
  					
  					$('#reorder_cost_x'+pro_id).html(n[0]);
  					$('#reorder_grand_cost').html(n[1]);
  					$('#reorder_grandtotal').val(n[2]);
  					$('#reorder_prod_price_'+pro_id).val(n[3]);
  					$('#reorder_prod_qty_'+pro_id).val(quantity);
  					var msg1="<?php echo $this->get_message('quantity updated');?>";
  					set_jnotice(1,msg1);
  					$('#reorder_save_'+pro_id).hide();
  				}
  			}
  		});	
  }
  else
  	alert("<?php echo $this->get_message('invalid quantity');?>");
}


  function ReorderRemove(id)
  {
	  	 var pro_ids=$("#reorder_pro_ids").val();

		 var gtotal=$('#reorder_grandtotal').val();
		 var prod_price=$('#reorder_prod_price_'+id).val();
		 var prod_qty=$('#reorder_prod_qty_'+id).val();

		 var prod_amt=parseFloat(prod_price)*parseFloat(prod_qty);

		 gtotal=parseFloat(gtotal)-parseFloat(prod_amt);

		 var currency_position="<?php echo $currency_position;?>";
		 var currency_symbol="<?php echo $currency_symbol;?>";
		 
		 if(currency_position==1)
		 gtotal_format=currency_symbol+" "+gtotal;
		 else if(currency_position==2)
		 gtotal_format=gtotal+" "+currency_symbol;

		 $('#reorder_grandtotal').val(gtotal);
		 $('#reorder_grand_cost').html(gtotal_format);

		 $("#reorder_view_cart_"+id).remove();

		 stringnew='';
		 arrays=pro_ids.split(',');
		 arraylength=arrays.length;
		 for(ii=0;ii < arraylength;ii++)
		 {
			if(arrays[ii] != id)
			{
				if(stringnew !='')
				stringnew=stringnew+',';
			
				stringnew=stringnew+arrays[ii];
			}
		 }

		$("#reorder_pro_ids").val(stringnew);

		if(stringnew =='')
		window.location.href="<?php echo $this->make_url('user/home');?>"; 
  }

  function ReorderSubmit()
  {
	  if( $("#reorder_pro_ids").val()=="")
	  {
		  alert("<?php echo $this->get_message('empty product list');?>");
		  return false;
	  }
	  else
	  {
		  var name="<?php echo COOKIE_REORDER_ITEMS;?>";
		  
		  var ids=$("#reorder_pro_ids").val();
		  var cookie_str="";
		  var ids_arr=ids.split(',');
		  for(var i=0;i < ids_arr.length;i++)
		  {
			  if(cookie_str !='')
			  cookie_str=cookie_str+',';
			  
			  cookie_str+=ids_arr[i]+"-"+$('#reorder_prod_qty_'+ids_arr[i]).val();
		  }
		  if(cookie_str !="")
		  {
		     Set_Cookie(name, cookie_str, 1000 , "<?php echo $cpath;?>","<?php echo $cdomain;?>") ;
			 window.location.href="<?php echo $this->make_url('cart/checkout/1');?>";
		  }
	  }
  }
</script>
  

<div class="container mtop-20">
<?php $this->dispatch("layout/login_left");?>
<div class="accountData contentLeft" style="margin-bottom:40px;">

<h1 class="titleh1"><?php echo $this->get_label('reorder');?> </h1>
          
<div class="reorder_chkout_title_div">
	<div class="reorder_chkout_title_subdiv1"><?php echo $this->get_label('product');?></div>
	<div class="reorder_chkout_title_subdiv2"><?php echo $this->get_label('item price');?></div>
	<div class="reorder_chkout_title_subdiv3"><?php echo $this->get_label('quantity');?></div>
	<div  class="reorder_chkout_title_subdiv2"><?php echo $this->get_label('subtotal');?></div>
	<div class="reorder_chkout_title_subdiv4"><?php echo $this->get_label('action');?></div>
</div>

<div class="itemsDisplay" style="padding-top: 5px;">
		
<?php 
	$i=0;
	$ids="";
	$gr_cost=0;
    $orderitem=$this->get_result('cartitem');
 
    foreach($orderitem as $key=>$row)
    {
    	$i++;
    
	    $prod_price=$this->get_product_pricing($row['id']);
	    $prod_qty=$this->get_quantity_from_order_items($this->get_variable('order_id'),$row['id']);
	    $sub_total=$prod_qty*$prod_price;
    
    	$gr_cost+=$sub_total;
    
    	if($ids !='')
    	$ids.=',';
    	
    	$ids.=$row['id'];
    ?>
    <div class="cartRow" id="reorder_view_cart_<?php echo $row['id'];?>" style="margin-top: 5px;width: 730px;">
    
    <input type="hidden" id="reorder_prod_qty_<?php echo $row['id'];?>" value="<?php echo $prod_qty;?>">
	<input type="hidden" id="reorder_prod_price_<?php echo $row['id'];?>" value="<?php echo $prod_price;?>">
	
	
	<div class="reorder_list_outer">
	
		<?php 
		    list($widthimage,$heightimage) = @getimagesize($this->get_product_image($row['id']));
			$dimension=$this->get_image_dimension($widthimage,$heightimage,11);
			$dimensionarray=explode('_',$dimension);
		               	
		 ?>
 <div class="cartImage" style="width: 50px;float: left;">
 
<div>
			<img style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>" src="<?php echo $this->get_product_image($row['id']);?>" />
		</div>
		
		 </div>
		
		<div class="reorder_list_col1">
			<?php echo $this->escape($this->get_product_name($row['id'])); ?>
		</div>
		
		<div class="reorder_list_col2 alertColor" >
			<?php 
			if($row['prod_stock'] < 1 || $row['status']==0)
			echo $this->get_label('not available');
			else
			echo  $this->get_money_format($prod_price);
			?>
		</div>
		
		<div class="reorder_list_col3">
			<?php 
				if($row['prod_stock']< 1 || $row['status']==0)
				echo $this->get_label('not available');
				else{?>
				<input type="text" class="reorder_quantity" id="reorder_qty<?php echo $row['id'] ?>" value="<?php echo $prod_qty;?>" onkeyup="this.value=this.value.replace(/[^0-9]/g,'');if(this.value><?php echo $row['prod_stock'] ?>){$('#reorder_save_<?php echo $row['id'] ?>').hide();alert('<?php echo $this->get_message('quantity exceeded stock');?>');}else{$('#reorder_save_<?php echo $row['id'];?>').show();}"/>
	            <input class="reorder_save" id="reorder_save_<?php echo $row['id'] ?>" type="button"  value="<?php echo $this->get_label('save');?>" onclick="ChangeReorderQuantity(<?php echo $row['id'] ?>);"/>
			<?php } ?>
		
		</div>
		
		<div class="reorder_list_col4">
		
			<div id="reorder_costsetup_x" class="alertColor"> 
				<div align="left" id="reorder_cost_x<?php echo $row['id'];?>">
					
					<?php 
					if($row['prod_stock'] < 1 || $row['status']==0)
					echo $this->get_label('not available');
					else
					echo  $this->get_money_format($sub_total);
					?>
					
					</div>
				</div>
			
		
		</div>
		
		<div class="reorder_list_col5">
		
			<a href="javascript:onClick=ReorderRemove(<?php echo $row['id'];?>);" title="<?php echo $this->get_label('cancel');?>"><span class="reorder_close" >X</span></a>
			
		</div>
		
	</div>
		
		</div>
		
<?php     }    ?>	
    
		
		<input type="hidden" id="reorder_grandtotal" value="<?php echo $gr_cost;?>">
		<input type="hidden" id="reorder_pro_ids" value="<?php echo $ids;?>">
			
			
	</div>
		
		
		<div class="reorder_total" >
		
		<div class="reorder_total_label"><span style="font-weight: bold;"><?php echo $this->get_label('grand total');?></span> <span class="reorder_total_amount alertColor" id="reorder_grand_cost"><?php echo $this->get_money_format($gr_cost)?></span> </div>
		
		<div class="alertColor" style="margin-top: 8px;"><?php echo $this->get_label('shipping cost notice');?></div>
		
		
		<div style="margin-top: 25px;">
		<a href="javascript:void(0);" onclick="ReorderSubmit();" class="purchaseItems placeOrder"><span><?php echo $this->get_label('proceed checkout');?></span></a>
		
		</div>
		
		</div>
		
		
		
        </div>
        
        
    </div>
    
<?php $this->dispatch("layout/footer");?>