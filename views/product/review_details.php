<link rel="stylesheet" href="css/cart.css" type="text/css" />
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-1.7.2.min.js'></script>
<script type="text/javascript" src="<?php echo BASE.COMMON_DIR_PATH?>js/jquery.raty.min.js"></script>	
<?php $prod_id=$this->get_variable('prod_id');?> 
<script type="text/javascript">
$(function() {
    $.fn.raty.defaults.path = 'images';
});
</script>

   	<div class="container" style="margin-top:30px;">
                
				<h1 style="border-bottom:1px solid #eaeaea; color:#888888;"><?php echo $this->get_label('reviews of',array('x'=>$this->escape($this->get_product_name($prod_id))));?></h1>
				<div class="clear"></div>
            
            
            <div class="clear"></div>
            
<?php

$reviews=$this->get_result('reviews');
$reviewcount=count($reviews);
$i=0;
foreach($reviews as $key=>$row)
{
	$i++;
?>
			<div style="width:990px; border-bottom:1px solid #eaeaea; margin-top:20px; padding-bottom:15px;">
			<div>
			
<script type="text/javascript">
$(function() {
   
var score="<?php echo $row['rate'];?>";
$('#star-rating'+<?php echo $i;?>).raty({ readOnly:true, score: score, hints: ['1 star','2 stars','3 stars',' 4 stars','5 stars'],click: function(score1, evt) {$("#rate").val(score1);} });

});
</script>
		
		</div>
			
            <div style="width:860px; float:left; height:50px;">
		<div style="width:100%;height:25px; float:left;">
			<div id="star-rating<?php echo $i;?>"></div></div>
			<div style="width:100%; height:25px; float:left;"><?php echo $this->get_user_email($row['user_id']);?></div></div>
			
            
            <div style="width:130px; height:50px; float:left;"><?php if($row['user_id']==$this->read_cookie_param(COOKIE_LOGINID)){?><img src="images/cert-buyer.png" border="0"><?php } ?></div>
            
			<div>
			<div style="width:990px; padding:15px 0px 0px 0px; text-align:justify;"><?php echo $row['review'];?></div>
		
			
			
		</div>
		
		</div>
	
<?php } ?>
<?php if($reviewcount ==0){ ?>
<div style="margin-top: 20px;">
<?php echo $this->get_label('no record'); ?>
</div>
<?php }?>		

</div>