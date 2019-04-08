<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head><link rel="stylesheet" href="css/style.css" type="text/css" /></head>
<body style="background: none;">
<div  class="inner_iframe">
<table  style="width: 100%;" cellpadding="0" cellspacing="0">

<tr>
 <td colspan="4">
<table class="data_table" cellpadding="0" cellspacing="0" style="width: 100%">

  <tr >
    
    <td class="dt_head_td" width="100%"><?php echo $this->get_label('product');?></td>
  </tr>  
<?php 

$res1=$this->get_result('res1');

if(count($res1)==0)
{
?>
<tr><td class="dt_data_td"><?php echo $this->get_label('no records found');?></td></tr>
<?php
}
else
	{
	
		foreach ($res1 as $key=> $row)
		{
		?>
		<tr class="dt_data_tr_active">
		<td class="dt_data_td"><a target="_parent" href="<?php echo $this->make_url("product/details/".$row['pro_id']);?>"><?php echo $this->escape($this->get_product_name($row['pro_id'])); ?></a></td>
		</tr>
		<?php 
		}
	?>
	 <tr>
	    <td class="dt_data_td border-bottom"><?php echo $this->get_variable('pagination');?></td>
	  </tr> 
	<?php   
}
?>		
</table>	

</td>
</tr>
</table>
</div>
</body>
</html>