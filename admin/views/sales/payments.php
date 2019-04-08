<?php 
$this->dispatch("layout/header/5/_53");
?>
<div class="sub_menu"><?php echo $this->get_label('payment details');?></div>
<table style="width: 100%" class="data_table">

  <tr>
    <td class="dt_head_td" width="22%"><?php echo $this->get_label('user');?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('order id');?></td>
    <td class="dt_head_td" width="15%"><?php echo $this->get_label('amount');?></td>
    <td class="dt_head_td" width="26%"><?php echo $this->get_label('payment date');?></td>
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('type');?></td>
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('action');?></td>
  </tr>  

<?php 
$res=$this->get_result('res');
foreach($res as $key=>$row)
{

?>

  <tr>
    <td class="dt_data_td">
     	
        
<?php 
$username=$this->get_user_email($row['uid']);
if($username !=''){?>
<a href="<?php echo $this->make_url('user/profile/').$row['uid']; ?>"><?php echo $username;?></a>
<?php }else{?>
<?php echo $this->get_label('deleted');?>
<?php }?>
   	
     	
     	
 </td>
    
     <td class="dt_data_td">
      	<a href="<?php echo $this->make_url('sales/details/').$row['order_id']; ?>">#<?php echo $row['order_id'];?></a>
    </td>
    
      <td class="dt_data_td">
  		 <?php echo $this->get_money_format($row['amount'])  ?>
    </td>
    
      <td class="dt_data_td">
  		 <?php echo $this->get_date_format(2,$row['received_date'])?>
    </td>
    
    <td class="dt_data_td">
       	<?php echo $this->get_payment_mode($row['payment_type'])?>
    </td>

<td class="dt_data_td" style="text-align: center;">
		<a href="<?php echo $this->make_url("sales/payment_details/").$row['id'];?>"><img  src="images/view.png" title="<?php echo $this->get_label('payment details');?>" /></a>  
</td>  

</tr>

<?php 
} 
?>
<?php 
if(count($res)==0) 
{
?>
  <tr>
    <td class="dt_data_td border-bottom" colspan="6"><?php echo $this->get_label('no record'); ?></td>
  </tr>
<?php 
} 
else
{
?>
   <tr>
    <td class="dt_data_td border-bottom" colspan="6" align="center"><?php echo $this->get_variable('pagination');?></td>
   </tr>
<?php 
}
?>
</table>
<?php $this->dispatch("layout/footer");?>