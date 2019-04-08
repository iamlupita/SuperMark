<link rel="stylesheet" href="css/cart.css" type="text/css" />
<script type='text/javascript' src='<?php echo BASE?>common/js/jquery-1.7.2.min.js'></script>

<script type="text/javascript" src="<?php echo BASE.COMMON_DIR_PATH?>js/jquery.raty.min.js"></script>			
<script type="text/javascript">
$(function() {
    $.fn.raty.defaults.path = 'images';
    var score="<?php echo $this->get_variable('rate');?>";
   
$('#star-rating').raty({ score: score, width: 455, hints: ['Rate this 1 star out of 5','Rate this 2 stars out of 5','Rate this 3 stars out of 5','Rate this 4 stars out of 5','Rate this 5 stars out of 5'],click: function(score1, evt) {$("#rate").val(score1);} });



});
</script>

<?php
$validate=array(
	"review"=>array(
			"notNull"=>array($this->get_message("mandatory"))
			)
	);
$form=$this->create_form();
$form->start("reviewrate",$this->make_url("product/review"),"post",$validate); ?>
            
   	<div class="container review-popup-conatiner-div">
      
                
				<h1 class="review-popup-h1"><?php echo $this->get_label('write a review');?></h1>
				
               <div class="review-popup-mandatory-div">
               <?php echo $this->get_label('compulsory message');?>
               </div>
               
               <div class="review-popup-div1">
               <strong><?php echo $this->get_label('your review'); ?> </strong><span class="mandatory">*</span>
               
               </div>
               
               <div class="review-popup-div2">
               
               	<textarea class="textStyle review-popup-textarea"  name="review" id="review"><?php echo $this->get_variable('review');?></textarea>
                
               </div>
               


<div class="review-popup-div1">

<strong><?php echo $this->get_label('your rating'); ?> </strong><span class="mandatory">*</span>

</div>

<div class="review-popup-div2"><div id="star-rating"></div></div>



<div class="review-popup-submit-div">

<input type="submit" name="Submit" value="<?php echo $this->get_label('submit'); ?>" class="cartAddition">
<input type="hidden" name="rate" id="rate" value="<?php echo $this->get_variable('rate');?>">
<input type="hidden" name="prod_id" id="prod_id" value="<?php echo $this->get_variable('prod_id');?>">
<input type="hidden" name="userid" id="userid" value="<?php echo $this->get_variable('userid');?>">
            
</div>
		
        	
<?php $form->end(); ?>
				
 </div>