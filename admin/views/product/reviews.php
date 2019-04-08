<?php 
$this->dispatch("layout/header/8/_02");
$prod_id=$this->get_variable('prod_id');
?>
<script type="text/javascript" src="<?php echo BASE;?>common/js/jquery.raty.min.js"></script>	
 <script type="text/javascript">
 $(function() {
	    $.fn.raty.defaults.path = "<?php echo BASE.'images';?>";
 })
 
 function review_details(id)
{
	$("#editdiv").show();
	$("#review_details_div").html( $("#review_details_"+id).html());

}
</script>
 
 
<div id="editdiv" style="display:none ;">
<div class="behind_div">


<div class="popup" id="review_details_div">

 </div>
 
 
 </div></div>


<div class="sub_menu"><div style="float: left;overflow: hidden;width: 600px;height: 18px;"><?php echo $this->get_label('manage reviews')." - ";?><a href="<?php echo $this->make_url('product/details/'.$prod_id);?>"><?php echo $this->escape($this->get_product_name($prod_id));?></a></div></div>
<table style="width: 100%" class="data_table" cellpadding="0" cellspacing="0">
 


  <tr >
    <td class="dt_head_td" width="28%"><?php echo $this->get_label('email');?></td>
    
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('rate');?></td>
    
    <td class="dt_head_td" width="28%"><?php echo $this->get_label('review');?></td>
    
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('date');?></td>
    
    <td class="dt_head_td" width="10%"><?php echo $this->get_label('status');?></td>
    
    <td class="dt_head_td" width="12%"><?php echo $this->get_label('actions');?></td>
    
  </tr>  

<?php 
$res=$this->get_result('res');$i=0;
foreach($res as $key=>$row)
{
	$i++;
?>


<script type="text/javascript">
$(function() {
   
var score="<?php echo $row['rate'];?>";
   
$('#star-rating1'+<?php echo $i;?>).raty({ readOnly:true, score: score, hints: ['1 star','2 stars','3 stars',' 4 stars','5 stars'],click: function(score1, evt) {$("#rate").val(score1);} });
$('#star-rating'+<?php echo $i;?>).raty({ readOnly:true, score: score, hints: ['1 star','2 stars','3 stars',' 4 stars','5 stars'],click: function(score1, evt) {$("#rate").val(score1);} });

});
</script>


<tr><td colspan="6">
<div id="review_details_<?php echo $row['id'];?>" style="display: none;">

<div class="sub_menu"><?php echo $this->get_label('reviews details');?>   
<a class="closeButton" onclick="$('#editdiv').hide();" style="position: relative;float: right;top: -5px;">X</a>
</div>


<table style="width: 100%;">

<tr>
<td width="5%"></td>
<td width="15%"><?php echo $this->get_label('email');?></td>
<td width="5%"></td>
<td width="75%"><a href="<?php echo $this->make_url("user/profile/".$row['user_id']);?>"><?php echo $this->get_user_email($row['user_id']);?></a></td>
</tr>

<tr><td colspan="4" height="15px"></td></tr>

<tr>
<td width="5%"></td>
<td width="15%"><?php echo $this->get_label('rate');?></td>
<td width="5%"></td>
<td width="75%"><div id="star-rating1<?php echo $i;?>"></div></td>
</tr>

<tr><td colspan="4" height="15px"></td></tr>

<tr>
<td width="5%"></td>
<td width="15%"><?php echo $this->get_label('review');?></td>
<td width="5%"></td>
<td width="75%"><?php echo $row['review'];?></td>
</tr>


<tr><td colspan="4" height="15px"></td></tr>

<tr>
<td width="5%"></td>
<td width="15%"><?php echo $this->get_label('date');?></td>
<td width="5%"></td>
<td width="75%"><?php echo $this->get_date_format(2,$row['time']);?></td>
</tr>

</table>
 
 
</div>

</td></tr>

  <tr <?php if($row['status']==0){ ?> class="dt_data_tr_inactive" <?php }else if($row['status']==1){?> class="dt_data_tr_active" <?php }?>>
    <td class="dt_data_td">
    
    <a href="<?php echo $this->make_url("user/profile/".$row['user_id']);?>"><?php echo $this->get_user_email($row['user_id']); ?></a>

    </td>
    

    
    
    <td class="dt_data_td"><div id="star-rating<?php echo $i;?>"></div></td>
    
     <td class="dt_data_td">
    <?php echo substr($row['review'], 0,70);?>
     </td>
    
    <td class="dt_data_td">
    <?php echo $this->get_date_format(3,$row['time']);?></td>
    
    

    <td class="dt_data_td">
    <?php echo $this->get_review_status($row['status'])?></td>
    
    <td class="dt_data_td">
    <?php 
 
    	if($row['status']!=1) 
    	{
    	?>
    	<a href="<?php echo $this->make_url("product/activate_review/".$row['id'].'/'.$row['prod_id']);?>"><img alt="<?php echo $this->get_label('activate'); ?>" src="images/activate.png" title="<?php echo $this->get_label('activate'); ?>" /></a>
    	<?php 
    	}
	
	    if($row['status']!=0) 
	    {
	    ?><a href="<?php echo $this->make_url("product/block_review/".$row['id'].'/'.$row['prod_id']);?>"><img alt="<?php echo $this->get_label('block'); ?>" src="images/block.png" title="<?php echo $this->get_label('block'); ?>" /></a>
	    <?php 
	    }
	    ?> 
  <a href="<?php echo $this->make_url("product/delete_review/".$row['id'].'/'.$row['prod_id']);?>" onclick="return confirm('Do you really want to delete item?')"><img alt="<?php echo $this->get_label('delete'); ?>" src="images/delete.png" title="<?php echo $this->get_label('delete'); ?>" /></a>
  
  <a href="javascript:void(0);" onclick="review_details(<?php echo $row['id'];?>)"><img alt="<?php echo $this->get_label('review details'); ?>" src="images/view.png" title="<?php echo $this->get_label('review details'); ?>" /></a>
  
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