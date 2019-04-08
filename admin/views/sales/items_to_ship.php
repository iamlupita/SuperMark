<?php $this->dispatch("layout/header/5/_51");?>
<div class="sub_menu"><?php echo $this->get_label('pending products to ship');?></div>
<table style="width: 100%" class="data_table">
		<tr>
		
		
		
		<td width="10%" class="dt_head_td" ><b><?php echo $this->get_label('order id');?></b></td>
		<td width="25%" class="dt_head_td" ><b><?php echo $this->get_label('item');?></b></td>
		<td class="dt_head_td"  width="20%"><?php echo $this->get_label('client');?></td>
		<td class="dt_head_td"  width="30%" style="text-align: center;"><?php echo $this->get_label('quantity');?> [<?php echo $this->get_label('pending');?> / <?php echo $this->get_label('total');?>]</td>
		
		
		
		<td width="20%" class="dt_head_td" ><?php echo $this->get_label('action');?></td></tr>
 <?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>		
	<tr>
	<td class='dt_data_td'>#<?php echo $row['order_id'];?></td>
		<td class='dt_data_td'>
		
		<div class="productNameBanner" style="width: 180px;">
	
		<?php 
$productname=$this->escape($this->get_product_name($row['pro_id']));
if($productname !=''){?>
<a style="color: #000000;" href="<?php echo $this->make_url("product/details/".$row['pro_id']);?>"><?php echo $productname;?></a>
<?php }else{?>
<?php echo $this->get_label('deleted');?>
<?php }?>
		
		
		
		
		
		</div>
		
		</td>
		<td class='dt_data_td'>
		
		<?php 
$username=$this->get_user_email($row['user_id']);
if($username !=''){?>
<a href="<?php echo $this->make_url('user/profile/').$row['user_id']; ?>"><?php echo $username;?></a>
<?php }else{?>
<?php echo $this->get_label('deleted');?>
<?php }?>
		
		 </td>
		
		<td  class='dt_data_td' style="text-align: center;">
					
					
					<?php 
$shquantity=$this->get_shipping_count($row['order_id'],$row['id'],1);
$dequantity=$this->get_shipping_count($row['order_id'],$row['id'],2);
$noquantity=$this->get_shipping_count($row['order_id'],$row['id'],3);
$retquantity=$this->get_return_count($row['order_id'],$row['id']);
$differance=intval($row['quantity'])-($shquantity+$dequantity+$noquantity);
?>
					




<label class="pendingdiv"><?php echo $differance;?></label><label> / <?php echo $row['quantity'];?></label>


					
					
					
					
					
					
					 </td>
		
		
		<td  class='dt_data_td' >
			<a href="<?php echo $this->make_url('sales/details/').$row['order_id']; ?>"" style="padding-left: 5px;" ><img  src="images/enable_footer.png" title="<?php echo $this->get_label('order details');?>" /></a>
		</td>
					
	</tr>
			
<?php } 

if(count($res) >0){?>
<tr><td class='dt_data_td border-bottom' colspan="5" align="center"><?php echo $this->get_variable('pagination');?></td></tr>
<?php }
?>						
</table> 
<?php $this->dispatch("layout/footer");?>