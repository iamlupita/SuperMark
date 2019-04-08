<?php 
$this->dispatch("layout/header");

$res=$this->get_result('res');
$value=$res[0];
?>

<div class="sub_menu"><?php echo $this->get_label('payment details');?></div>


<table style="width: 100%;">

<tr>
	<td width="30%"><?php echo $this->get_label('transaction id');?></td>
	<td width="10%">:</td>
	<td width="60%"><?php echo $value['txnid'];?></td>
</tr>

<tr><td height="15px" colspan="3"></td></tr>
<tr>
	<td width="30%"><?php echo $this->get_label('order id');?></td>
	<td width="10%">:</td>
	<td width="60%"><a href="<?php echo $this->make_url('sales/details/').$value['order_id']; ?>">#<?php echo $value['order_id'];?></a></td>
</tr>

<tr><td height="15px" colspan="3"></td></tr>
<tr>
	<td width="30%"><?php echo $this->get_label('user');?></td>
	<td width="10%">:</td>
	<td width="60%">
	
	
	<?php 
$username=$this->get_user_email($value['userid']);
if($username !=''){?>
<a href="<?php echo $this->make_url('user/profile/').$value['userid']; ?>"><?php echo $username;?></a>
<?php }else{?>
<?php echo $this->get_label('deleted');?>
<?php }?>
   	
	
	</td>
</tr>

<tr><td height="15px" colspan="3"></td></tr>

<tr>
	<td width="30%"><?php echo $this->get_label('amount');?></td>
	<td width="10%">:</td>
	<td width="60%"><?php echo $this->get_money_format($value['amount']);?></td>
</tr>


<tr><td height="15px" colspan="3"></td></tr>

<tr>
	<td width="30%"><?php echo $this->get_label('currency');?></td>
	<td width="10%">:</td>
	<td width="60%"><?php echo $value['currency'];?></td>
</tr>


<tr><td height="15px" colspan="3"></td></tr>

<tr>
	<td width="30%"><?php echo $this->get_label('payer email');?></td>
	<td width="10%">:</td>
	<td width="60%"><?php echo $value['payeremail'];?></td>
</tr>


<tr><td height="15px" colspan="3"></td></tr>

<tr>
	<td width="30%"><?php echo $this->get_label('receiver email');?></td>
	<td width="10%">:</td>
	<td width="60%"><?php echo $value['receiveremail'];?></td>
</tr>


<tr><td height="15px" colspan="3"></td></tr>


<tr>
	<td width="30%"><?php echo $this->get_label('status');?></td>
	<td width="10%">:</td>
	<td width="60%"><?php echo $value['status'];?></td>
</tr>


<tr><td height="15px" colspan="3"></td></tr>


<tr>
	<td width="30%"><?php echo $this->get_label('payment date');?></td>
	<td width="10%">:</td>
	<td width="60%"><?php if($value['receivedate']>0){echo $this->get_date_format(2,$value['receivedate']);}?></td>
</tr>


<tr><td height="15px" colspan="3"></td></tr>


<tr><td colspan="3" height="10px"></td></tr>

<tr>
<td colspan="2"></td>
<td><a href="javascript:history.back(-1)"><?php echo $this->get_label('manage payments');?></a></td>
</tr>


</table>

<?php $this->dispatch("layout/footer");?>