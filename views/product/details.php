<?php 
$proid=$this->get_variable("proid");
$this->dispatch("layout/header/details/".$proid);
?>
<style>
.zoomLens
{
	z-index: 1000 !important;
}
.zoomWindow
{
left: 235px !important;
}
</style>



<script type="text/javascript" src="<?php echo BASE.COMMON_DIR_PATH;?>js/jquery.elevateZoom-3.0.3.min.js"></script>


<script type="text/javascript" src="<?php echo BASE.COMMON_DIR_PATH;?>js/fancybox.js"></script>

<script type="text/javascript" src="<?php echo BASE.COMMON_DIR_PATH;?>js/jquery.raty.min.js"></script>
<script type="text/javascript">
$(function() {
    $.fn.raty.defaults.path = 'images';
    var score="<?php echo $this->get_variable('rating_avg');?>";
    var ratings_msg="<?php echo $this->get_variable('rating_avg')." ".$this->get_label('stars');?>";
$('#star-rating').raty({ readOnly: true, score: score, width: 100, hints: [ratings_msg,ratings_msg,ratings_msg,ratings_msg,ratings_msg] });
});

function add_review_details()
{
		popup(600,400,500,"#review_details_div");
		$("#review_details_div > #full_content").html($("#iframe_review_details_add").html());
}
$(function() {
	$('#review_details_atag').click(function() {
		var target = $(this.hash);
		target = target.length ? target : $('#review_iframe_div');
		if (target.length) {
		$('html,body').animate({
		 scrollTop: target.offset().top
		}, 1000);
		return false;
	}
		
});	  

 $('#review_details_atag1').click(function() {
	  var target = $(this.hash);
	  target = target.length ? target : $('#review_iframe_div');
	  if (target.length) {
		$('html,body').animate({
		  scrollTop: target.offset().top
		}, 1000);
		return false;
	  }
	
  });
  
});

</script>

  <?php 
  		if($this->get_variable("pro_image_file")==1)
 		$img_pi=BASE.DATA_DIR."/prodimages/".$proid."/t_".$this->get_variable("imagename");
  		else 
 		$img_pi=BASE.DATA_DIR."/logo/".$this->get_variable("default_ad_image");
 
  		
  		$img_pi=urlencode($img_pi);
  		
  		 $lnk=$this->make_url("product/details/".$proid."/".$this->escape($this->get_seo_title($proid)));
  		 $lnk=urlencode($lnk);	

  		 
  		$desc=$this->get_variable('proname');
  		
  	?> 
  	
  	
  	<?php if(Settings::get_instance()->read('social_share_links')==1){?>
      <script type="text/javascript">
      function fbclick()
      {
      var sharer = "https://www.facebook.com/sharer/sharer.php?u="+"<?php echo $lnk;?>";
      window.open(sharer, 'sharer', 'width=626,height=436,top=200,left=400');
      }


      function twclick()
      {
      var sharer ="https://twitter.com/intent/tweet?text="+"<?php echo $desc;?>"+"&url="+"<?php echo $lnk;?>"+"&via=<?php echo Settings::get_instance()->read('engine_name');?>";

       window.open(sharer, 'sharer', 'width=626,height=436,top=200,left=400');
      }
      function piclick()
      {		
      var sharer = "http://pinterest.com/pin/create/button/?url="+"<?php echo $lnk;?>"+";media="+"<?php echo $img_pi;?>"+";description="+"<?php echo $desc;?>";
      window.open(sharer, 'sharer', 'width=626,height=436,top=200,left=400');
      }

     function gpclick()
      {
      var sharer = "https://plus.google.com/share?url="+"<?php echo $lnk;?>";
      window.open(sharer, 'sharer', 'width=626,height=436,top=200,left=400');
      }
     
       function liclick()
       {
          var sharer="https://www.linkedin.com/cws/share?url="+"<?php echo $lnk;?>";
          window.open(sharer, 'sharer', 'width=626,height=436,top=200,left=400');
        }
         
      </script>
  <?php } ?>
  
  <script type="text/javascript">

  jQuery( window ).scroll(function() {

	  var tflag=0;
	  if($(document).scrollTop()>=230)
	  {
		  if(tflag==0)
			  tflag=1;
		  if(tflag==1){
		  $("#cmpdiv_main").css("top","0");
		   $("#cmpdiv_main").css("position","fixed");}
	  }
	  else
	  {
		  if(tflag==1)
			  tflag=0;
		  if(tflag==0){
		  $("#cmpdiv_main").css("top","");
		   $("#cmpdiv_main").css("position","relative");}
	  }

});
  
</script>
<?php $this->dispatch("layout/compare_menu/de"); ?>
  	
   	<div class="container"> 
    
    
    <div class="heading-div">
    
   
   
   
   <div style="width:828px; float:left;">
  	 <p style="padding:8px;"><?php echo $this->get_variable('categ_path');?></p>
   </div>
   
   
<div style="width:150px; float:left; margin-top:8px;">
                            
 <a href="javascript:void(0)" title="<?php echo $this->get_label('share via facebook');?>" onclick="fbclick();"><img src="images/fb1.png" style="width: auto !important;" /></a>

 <a href="javascript:void(0)" title="<?php echo $this->get_label('share via twitter');?>" onclick="twclick('<?php echo $twdesc;?>');"><img src="images/tw1.png" style="width: auto !important;" /></a>
 
 <a href="javascript:void(0)" title="<?php echo $this->get_label('share via google plus');?>" onclick="gpclick();"><img src="images/gp1.png" style="width: auto !important;" /></a>

<a href="javascript:void(0)" title="<?php echo $this->get_label('share via linkedin');?>" onclick="liclick();"><img src="images/li1.png" style="width: auto !important;" /></a>
                            
<a href="javascript:void(0)" title="<?php echo $this->get_label('share via pinterest');?>" onclick="piclick('<?php echo strip_tags($fsumm);?>');"><img src="images/pi1.png" style="width: auto !important;" /></a>
                            
 </div>
    
</div>

          
          	
<div class="">
               <div class="detailsZone">
               		
<div class="zoom_main_outer">
<input type="hidden" id="currentclick" name="currentclick" value="0" />   
<?php
$totalcount=0;	 
if($this->get_variable("pro_image_file")==1){ 
	
list($widthimage,$heightimage) = @getimagesize(DATA_DIR."/prodimages/".$proid."/".$this->get_variable("imagename"));
$dimension=$this->get_image_dimension($widthimage,$heightimage,5);
$dimensionarray=explode('_',$dimension);
?>
<?php 
$productimage=$this->get_result('productimage');
$totalcount=count($productimage);
?>
<div class="updiv">
<?php if($totalcount >4){?>
<img style="display:none;" onclick="SlideThumb(1);" id="uparrow" src="images/upnew.png" title="<?php echo $this->get_label('up');?>" alt="<?php echo $this->get_label('up');?>"/>
<?php }?>
</div>



<div class="zoom_image_outer">
<div class="zoom_image_inner">
<img id="zoom_body" style="width: <?php echo $dimensionarray[0];?>px;height: <?php echo $dimensionarray[1];?>px;" src="<?php echo DATA_DIR;?>/prodimages/<?php echo $proid;?>/<?php echo $this->get_variable("imagename");?>" data-zoom-image="<?php echo DATA_DIR;?>/prodimages/<?php echo $proid;?>/<?php echo $this->get_variable("imagename");?>"/> 
</div>  
</div>




<div class="zoom_thumb_outer">
<div class="zoom_thumb_inner" id="zoom_thumb_inner">
<?php 
$jj=0;
foreach($productimage as $key=>$prod_images){

	list($twidthimage,$theightimage) = @getimagesize(DATA_DIR."/prodimages/".$prod_images['pro_id']."/t_".$prod_images['pro_image_file']);
	$tdimension=$this->get_image_dimension($twidthimage,$theightimage,4);
	$tdimensionarray=explode('_',$tdimension);	
	
	
	
	list($widthimage,$heightimage) = @getimagesize(DATA_DIR."/prodimages/".$prod_images['pro_id']."/".$prod_images['pro_image_file']);
	$dimension=$this->get_image_dimension($widthimage,$heightimage,5);
	$dimensionarray=explode('_',$dimension);
	
	list($owidthimage,$oheightimage) = @getimagesize(DATA_DIR."/prodimages/".$prod_images['pro_id']."/".$prod_images['pro_image_file']);
	
	?> 

<div id="zoom_thumb_<?php echo $prod_images['id'];?>"  class="zoom_thumb <?php if($jj==0){?>zoom_thumb_selected<?php }?>" onclick="LoadCurrentZoom(<?php echo $prod_images['id'];?>);">
<div><a onclick="LoadCurrentZoom(<?php echo $prod_images['id'];?>);" id="thumb_a_<?php echo $prod_images['id'];?>" href="javascript:void(0);" data-image="<?php echo DATA_DIR;?>/prodimages/<?php echo $prod_images['pro_id']; ?>/s_<?php echo $prod_images['pro_image_file']; ?>" data-zoom-image="<?php echo DATA_DIR;?>/prodimages/<?php echo $prod_images['pro_id']; ?>/<?php echo $prod_images['pro_image_file']; ?>" ><img id="thumb_<?php echo $prod_images['id'];?>" width="<?php echo $tdimensionarray[0];?>px" height="<?php echo $tdimensionarray[1];?>px" src="<?php echo DATA_DIR;?>/prodimages/<?php echo $prod_images['pro_id']; ?>/t_<?php echo $prod_images['pro_image_file']; ?>" /></a></div>
</div>


<img id="zoom_<?php echo $prod_images['id'];?>" data-zoom-image="<?php echo DATA_DIR;?>/prodimages/<?php echo $prod_images['pro_id']; ?>/<?php echo $prod_images['pro_image_file']; ?>" src="<?php echo DATA_DIR;?>/prodimages/<?php echo $prod_images['pro_id']; ?>/<?php echo $prod_images['pro_image_file']; ?>" style="display: none;width: <?php echo $dimensionarray[0];?>px;height: <?php echo $dimensionarray[1];?>px;" />
<img id="zoom_dimension_<?php echo $prod_images['id'];?>" style="display: none;width: <?php echo $owidthimage;?>px;height: <?php echo $oheightimage;?>px;" />

<?php 
$jj=$jj+1;
}?>
</div>



</div>

<?php if($totalcount >4){?>
<div class="downdiv"><img id="downarrow" src="images/downnew.png" onclick="SlideThumb(2);" title="<?php echo $this->get_label('down');?>" alt="<?php echo $this->get_label('down');?>"/></div>
<?php }?>

     
	<?php }
	else{
		
		
list($widthimage,$heightimage) = @getimagesize(DATA_DIR."/logo/".$this->get_variable("default_ad_image"));
$dimension=$this->get_image_dimension($widthimage,$heightimage,5);
$dimensionarray=explode('_',$dimension);

?>

 
 
<div class="zoom_image_outer zoom_image_outer1" >
<div class="zoom_image_inner">
<img style="width: <?php echo $dimensionarray[0];?>px;height: <?php echo $dimensionarray[1];?>px;" src="<?php echo DATA_DIR;?>/logo/<?php echo $this->get_variable("default_ad_image");?>" /> 
</div>  
</div>
 
 
 <?php }?>


	
                    </div>
                    
                    
                    <div class="primaryDetails contentLeft" style="border-bottom:1px solid #eaeaea;">
                    	<div class="row first" style="border-top:none;">
                    	
                           
 
                            <h1 class="detailsH1"><?php echo $this->get_variable("proname");?></h1>
                            
                            
                            
                            
                            
                            <div class="contentLeft brand"><?php if($this->get_variable("brand_id")!="" && $this->get_variable("brand_id")!=0){echo $this->get_label('brand')." : ".$this->escape($this->get_brand_name($this->get_variable("brand_id")));} ?></div>
                            
                             
                             
                              <div class="cartStarRating" id="star-rating"></div>
                             
                             
                              <div class="cartStarRatingOptions">
                             <a id="review_details_atag" href="javascript:void(0);"><?php echo $this->get_variable('rate')." ".$this->get_label('ratings');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            
                             <a id="review_details_atag1" href="javascript:void(0);"><?php echo $this->get_variable('review_cnt')?> <?php echo $this->get_label('reviews');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                            
                            <?php if($this->get_variable("login")=="1"){?>
                            
                             <a href="javascript:void(0)"  onclick="add_review_details()" ><?php if($this->get_variable('user_reviewed')>0){echo $this->get_label('edit review');}else{echo $this->get_label('write a review');}?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                             
                             <?php }else{ ?>
                              <a href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('write a review');?>"><?php echo $this->get_label('write a review');?></a>&nbsp;&nbsp;|&nbsp;&nbsp;
                             
                              <?php } ?>
                             
                             <?php if($this->get_variable("userid")==""){
						 ?>
                        	<a class="wishList" href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('add to wishlist');?>"><?php echo $this->get_label('add to wishlist');?></a>
						<?php }?>
						<?php if($this->get_variable("userid")!=""){
						 ?>
                        	<a class="wishList" href="javascript:wishlist('<?php echo $proid;?>')" title="<?php echo $this->get_label('add to wishlist');?>"><?php echo $this->get_label('add to wishlist');?></a>
						<?php }?>
						
						
						
                             </div>
                             
                             
<div id="iframe_review_details_add" style="display: none;">
<iframe src="<?php echo $this->make_url('product/review/'.$proid);?>" width="100%" height="400px" frameborder="0"></iframe>
</div>

                        
                       <div class="row last">
                       
                       <div style="width:100%;">
                       
                       <div style="width:68%; height:118px; float:left;">
                       
                       
                      
             			<div style="width:100%; height:41px; margin-top:30px;">
             			
             			<?php 
             			
             			$prd_pricing=$this->get_product_pricing($proid);
             			
             			$price_diff=$this->get_price_difference($this->get_variable("mrp"),$prd_pricing);
             			$save_str="";
             			if($price_diff >0)
             			$save_str=$this->get_label('you save',array('x'=>$price_diff));
             			
             			
             			?>
             
                       	<b class="itemRate" style="padding:5px;"><?php echo $this->get_money_format($prd_pricing) ?></b>
                       
                       	<b class="itemRate previousPrice" style="padding-top:5px;padding-left: 5px;"><?php echo $this->get_money_format($this->get_variable("mrp")); ?></b> 
                        </div>
                        <div style="width:100%; height:20px; padding-left:5px;">
						<div class="priceColor contentLeft"><?php echo $save_str;?></div>
                        </div></div>
                        
                        
                        <div class="cartDetailsRight">
                        
  

                            
                           <div class="cartSpecialDivs"><b style="font-size:14px; color: #009900;"><?php echo $this->get_label('gift wrapping');?>:</b></div>
                           <div class="cartSpecialDivs"> 
                           <?php 
                           if($this->get_variable("wrap_status")==1) 
                           echo $this->get_label('wrapactive');
                           else
                           echo  $this->get_label('wrapinactive');
                           ?>
                           </div>
                             
                           <div class="cartSeperation"></div>
                             
                             
                             
                             <?php 
         					 if($this->get_variable("prod_stock") >0) {?>    
                             <div class="cartSpecialDivs">
        					 <h2 style='font-size:16px;'class='instock'><?php echo $this->get_label('in stock');?></h2><span><?php echo $this->get_label('delivered in 2-4 business days');?></span>  
		 					 </div>
		 					 <?php }?>
       
					         <?php if($this->get_variable("prod_stock")==0){  ?>
					       	 <div class="cartSpecialDivs">
					         <h2 class='nostock'><?php echo $this->get_label('out of stock');?></h2>  
					         </div>
					         <?php }?>					
        </div>
                        
                        
		 </div></div>
                        
                        

                        
                        
    <div class="actionDiv">
    
    
    			<?php 
    			$pcat=$this->get_variable("cat_id");
				$pname=$this->get_variable("proname");
				$purl=$this->make_url("product/details/".$proid."/".$this->get_variable("page_title"));
				$ppricing=$this->get_money_format($this->get_product_pricing($proid));
				$pimage=$this->get_product_image($proid);
				
				?>
				
				<input type="hidden" name="catid_de_<?php echo $proid;?>" id="catid_de_<?php echo $proid;?>" value="<?php echo $pcat;?>" />
				<input type="hidden" name="name_de_<?php echo $proid;?>" id="name_de_<?php echo $proid;?>" value="<?php echo $pname; ?>" />
				<input type="hidden" name="url_de_<?php echo $proid;?>" id="url_de_<?php echo $proid;?>" value="<?php echo $purl;?>" />
				<input type="hidden" name="price_de_<?php echo $proid;?>" id="price_de_<?php echo $proid;?>" value="<?php echo $ppricing; ?>" />
				<input type="hidden" name="image_de_<?php echo $proid;?>" id="image_de_<?php echo $proid;?>" value="<?php echo $pimage; ?>" />
				<?php
				list($widthimage,$heightimage) = @getimagesize($pimage);	
				$dimension=$this->get_image_dimension($widthimage,$heightimage,10);
				$dimensionarray=explode('_',$dimension)
				?>
				<input type="hidden" name="width_de_<?php echo $proid;?>" id="width_de_<?php echo $proid;?>" value="<?php echo $dimensionarray[0]; ?>" />
				<input type="hidden" name="height_de_<?php echo $proid;?>" id="height_de_<?php echo $proid;?>" value="<?php echo $dimensionarray[1]; ?>" />
    
    
    
    
    
	<?php 
    if($this->get_variable("prod_stock") >0){  
    ?>     
        <div style="float:left;height: 45px;">
      
          <a class="primaryDetails-cartButton" href="javascript:cartAddition('<?php echo $proid;?>')"><?php echo $this->get_label('add to cart');?></a>
			  
           </div>    
      <?php   }  ?>  
           
           <div style="float:right;height: 45px;">
           
         <span id="compare_link_<?php echo $proid;?>">         
         
         <div class="primaryDetails-compareButton cmpadding" style="padding:12px 48px;<?php if($this->get_product_exist_cookie($proid)==1){?>display:none;<?php }?>" onclick="add_compare(<?php echo $proid;?>,'de')"><?php echo $this->get_label('add to compare');?></div>
         <div class="primaryDetails-compareButton cmpremoveing" <?php if($this->get_product_exist_cookie($proid)==0){?>style="display: none;"<?php }?> onclick="remove_compare(<?php echo $proid;?>,'de');"><?php echo $this->get_label('remove from compare');?></div>
         </span>
         </div>
                        
              
                        
                        </div>
                  
                        
                        
                       </div> 
                       
                      
                       
                       
                       </div>
                       
                       </div>
  						
                       
                    </div>
                    
                    
                    
                    <div class="cartDetails adress_div">
                    
                    <h2 class="detailsH2"><?php echo $this->get_label('seller details');?></h2>
                    
                    
                    
                    <?php 
                    if(Settings::get_instance()->read('address1')!="")
					echo Settings::get_instance()->read('address1');?><br />
                                    
					<?php 
                    if(Settings::get_instance()->read('city')!="")
                    echo Settings::get_instance()->read('city');?><br />
									
					<?php 
					if(Settings::get_instance()->read('state')!="")
                    echo Settings::get_instance()->read('state');?><br />
                                    
                    <?php 
					if(Settings::get_instance()->read('country')!="")
                    echo $this->get_country_name(Settings::get_instance()->read('country'));?>
                    -
                    <?php 
                    if(Settings::get_instance()->read('zipcode')!="")
                    echo Settings::get_instance()->read('zipcode');?><br />
									
					<?php if(Settings::get_instance()->read('phone')!="")
                    echo $this->get_label('phone no');?> : <?php echo Settings::get_instance()->read('phone');?><br />                                    
                                    
                    </div>
  
    <div class="cartDetails shipping_details_Div">
                  
  
   <?php 
    $shipping_classes=$this->get_result('shipping_classes');
    foreach($shipping_classes as $key=>$ship)
    {
   
    ?> 
    <div style="width:33.33%; float:left;"> 
    
       <h2 class="detailsH2"><?php echo $this->get_label('local shipping'); ?></h2>
          <?php echo $this->get_label('pickup'); ?> : <?php  if($ship['local_pickup']=='1'){echo $this->get_label('available');}else {echo $this->get_label('not available');}?><br>   	 
          
          <?php 
		  
		  if($ship['local_shipping_type']=='1')
		  	echo $this->get_label('free shipping');
		else if($ship['local_shipping_type']=='2')
		  echo $this->get_label('flat rate for any quantity')." - ".$this->get_money_format($ship['local_price']);
		else if($ship['local_shipping_type']=='3'){
		  echo $this->get_label('price per unit')." - ".$this->get_money_format($ship['local_price'])."<br />";
		   if($ship['local_price_per_additional_unit']>0)
		  echo $this->get_label('price per additional unit')." - ".$this->get_money_format($ship['local_price_per_additional_unit'])."<br />";
		   if($ship['local_free_units']>0)
		  echo $this->get_label('free shipping above X units',array('x'=>$ship['local_free_units']))."<br />";
		}
		  ?>
          
                 
                <div style="margin-top: 5px;">
                <?php 
                $zipcookie='';
                if(isset($_COOKIE[COOKIE_ZIP]))
                $zipcookie=$_COOKIE[COOKIE_ZIP];
               	?>
                
                
                <label style="font-size: 14px;"><?php echo $this->get_label('check delivery option');?></label>
                <input type="text" class="ziptext" name="clientzipcode" id="clientzipcode" value="<?php echo $zipcookie;?>" placeholder="<?php echo $this->get_label('enter zipcode');?>" /> 
                <input class="zipbutton" type="button" name="zipbutton" id="zipbutton" onclick="ShippingAvailabiity();" value="<?php echo $this->get_label('check');?>" />
                <input type="hidden" name="zipstring" id="zipstring" value="<?php echo $ship['local_pickup_zipcodes'];?>" />
                <span class="zipavailable"><?php echo $this->get_label('delivery available');?></span>
                <span class="zipnotavailable"><?php echo $this->get_label('delivery not available');?></span>
                </div> 
                 
                 
                 
                 
                                        
     </div>
     
      <div style="width:33.33%; float:left;">
           <h2 class="detailsH2"><?php echo $this->get_label('national shipping'); ?></h2>
                                       
                                    	
		 <?php 
		  
		 if($ship['nat_shipping_type']=='0')
		  	echo $this->get_label('no shipping');
		 else if($ship['nat_shipping_type']=='1')
		  	echo $this->get_label('free shipping');
		 else if($ship['nat_shipping_type']=='2')
		  echo $this->get_label('flat rate for any quantity')." - ".$this->get_money_format($ship['nat_price']);
		 else if($ship['nat_shipping_type']=='3'){
		  echo $this->get_label('price per unit')." - ".$this->get_money_format($ship['nat_price'])."<br />";
		  if($ship['nat_price_per_additional_unit']>0)
		  echo $this->get_label('price per additional unit')." - ".$this->get_money_format($ship['nat_price_per_additional_unit'])."<br />";
		  if($ship['nat_free_units']>0)
		  echo $this->get_label('free shipping above X units',array('x'=>$ship['nat_free_units']))."<br />";
		}
		  ?>
     </div>
                                        
    <?php }?>
                                    	
                                    	
           <div style="width:33.33%; float:left;">
                <h2 class="detailsH2"><?php echo $this->get_label('international shipping'); ?></h2>
                                          
			<?php 
		  
				 if($ship['inat_shipping_type']=='0')
				 echo $this->get_label('no shipping');
				 else if($ship['inat_shipping_type']=='1')
				 echo $this->get_label('free shipping');
				 else if($ship['inat_shipping_type']=='2')
				 echo $this->get_label('flat rate for any quantity')." - ".$this->get_money_format($ship['inat_price']);
				 else if($ship['inat_shipping_type']=='3'){
				 echo $this->get_label('price per unit')." - ".$this->get_money_format($ship['inat_price'])."<br />";
				 if($ship['inat_price_per_additional_unit']>0)
				 echo $this->get_label('price per additional unit')." - ".$this->get_money_format($ship['inat_price_per_additional_unit'])."<br />";
				 if($ship['inat_free_units']>0)
				 echo $this->get_label('free shipping above X units',array('x'=>$ship['inat_free_units']))."<br />";
				}
		  ?>
          
        </div>                            
                                    	 
                                    	 
                                    	 
  </div>
  
                   <div class="cartDetails cartDescription" >
                       
                       <?php if($this->get_variable('warranty_description')!=""){?>
                       
                       <h2 class="descriptionH2"><?php echo $this->get_label('warranty description');?></h2>
                        <br />
                       
                        <div class="clear"></div>
                      
                       <div class="description-special"><?php echo $this->get_variable('warranty_description');?></div>
                       
                       <div class="clear"></div>
                        <br>
                       <?php } ?>
                       
                       <h2 class="descriptionH2"><?php echo $this->get_label('description');?></h2>
                       
                        <div class="clear"></div>
                        <br />
                       <div class="description-special"><?php echo $this->get_variable('descrip');?></div>
                       
                       </div>
                       
                       
                      
                      
                    <?php if($this->get_customfield_values($proid,$this->get_variable("cat_id"))!=""){?>
                    	<div class="cartDetails" style="width: 100%;">                   							
	                        <div style="width:990px; margin-top:20px;">
	                        	<h1 class="cartFeatures"><?php echo $this->get_label('keyfeatures of',array('x'=>$this->escape($this->get_product_name($proid))));?></h1>
	             				<?php echo $this->get_customfield_values($proid,$this->get_variable("cat_id")); ?> 		
		                	</div>                                                                 
	               		</div>
               	<?php }?>
            </div>
            <div class="bottom"></div>
        
        
  
    

  

<iframe src="<?php echo $this->make_url('product/review_details/'.$proid);?>" width="100%" height="400px" frameborder="0" id="review_iframe_div"></iframe>



<div class="popDetails">  	
	<div id="review_details_div" >
                  	<div class="contents" id="full_content"> 
                  	</div>
                  	
                  	<a class="closeButton" onclick="popout()">X</a>
                  	
     </div>
</div> 
<script type="text/javascript">

function ShippingAvailabiity()
{
	var zip=$('#clientzipcode').val();
	var zipstring=$('#zipstring').val();
	var zipstringarray=zipstring.split(',');
	var zipstringarraylength=zipstringarray.length;
	var avail=0;
	for(i=0;i < zipstringarraylength;i++)
	{
		if(zipstringarray[i] !='')
		{
			var rangelength=zipstringarray[i].length;
			if(zipstringarray[i][rangelength-1] =='/' && zipstringarray[i][0] =='/')
			{
				pattern=eval(zipstringarray[i]+'i');
				if(zip.match(pattern) !=null)
				{
					avail=1;	
					break;
				}
				else
					continue;
			}
			
			var ziparray=zipstringarray[i].split(':');
			var ziparraylength=ziparray.length;

			if(ziparraylength ==1)
			{
				if($.trim(ziparray[0]) == zip)
				{
					avail=1;	
					break;
				}
			}
			else if(ziparraylength ==2)
			{
				if(zip >= $.trim(ziparray[0]) && zip <= $.trim(ziparray[1]))
				{
					avail=1;	
					break;
				}
			}
		}
	}

	$('.zipavailable').hide();
	$('.zipnotavailable').hide();
	
	if(avail ==1)
	$('.zipavailable').show();
	else if(avail ==0)	
	$('.zipnotavailable').show();

    Set_Cookie("<?php echo COOKIE_ZIP;?>",zip,1000 ,"<?php echo $this->get_base_path();?>","<?php echo $this->get_base_domain();?>") ;
	
		
	
}


		  
$(document).ready(function(){

	$('#currentclick').val(0);

<?php if($this->get_variable("pro_image_file")==1){ ?>

	
	$("#zoom_body").elevateZoom({gallery: "zoom_thumb_inner",cursor: 'pointer',zoomWindowWidth: 400,zoomWindowHeight: 400,zoomWindowPosition:'9',loadingIcon:'images/loading.gif'}); 



	$("#zoom_body").bind("click", function(e) { 
	var ez = $('#zoom_body').data('elevateZoom');	 
	$.fancybox(ez.getGalleryList());
	return false; 
	});


	
$('.zoom_main_outer').hover(function(){
	selectid=$('.zoom_thumb_selected').attr('id');
	selectid=selectid.replace('zoom_thumb_','');
	if($('#zoom_dimension_'+selectid).width() < 400 || $('#zoom_dimension_'+selectid).height() < 400)
	{
			$(".zoomLens").css("border","none");
			$(".zoomLens").css("background-color","");
			$(".zoomLens").css("max-width","50px");
			$(".zoomLens").css("max-height","50px");
			$(".zoomWindow").css("visibility","hidden");
	}
});

<?php }?>
	

});

function SlideThumb(type)
{
	total=<?php echo $totalcount;?>;
	currentclick=$('#currentclick').val();
	var top=$(".zoom_thumb_inner").css('top');
	top=top.replace('px','');

	if(type ==1)
	top=parseFloat(top)+55;
	else
	top=parseFloat(top)-55;

	
	$(".zoom_thumb_inner").animate({"top": top+'px'});

	if(type ==2)
	{
		currentclick=parseInt(currentclick)+1;
		
		$("#uparrow").show();

		if(total ==(parseInt(currentclick)+4))
		$("#downarrow").hide();
	}
	else if(type ==1)
	{
		currentclick=parseInt(currentclick)-1;

		if(currentclick ==0)
		$("#uparrow").hide();

		if(total >(parseInt(currentclick)+4))
		$("#downarrow").show();
	}
	
	$('#currentclick').val(currentclick);
	
}
function LoadCurrentZoom(id)
{

	

$('#zoom_body').width($('#zoom_'+id).width()+'px');
$('#zoom_body').height($('#zoom_'+id).height()+'px');
$('#zoom_body').attr('src',$('#zoom_'+id).attr('src'));
$('#zoom_body').attr('data-zoom-image',$('#zoom_'+id).attr('data-zoom-image'));

$('.zoom_thumb').removeClass('zoom_thumb_selected');
$('#zoom_thumb_'+id).addClass('zoom_thumb_selected');


$("#zoom_body").show('scale',500);




if($('#zoom_dimension_'+id).width() < 400 || $('#zoom_dimension_'+id).height() < 400)
{

	
		$(".zoomLens").css("border","none");
		$(".zoomLens").css("background-color","");
		$(".zoomLens").css("max-width","50px");
		$(".zoomLens").css("max-height","50px");
		$(".zoomWindow").css("visibility","hidden");

}
else
{
	$(".zoomLens").css("border","1px solid #000000");
	$(".zoomLens").css("background-color","white");
	$(".zoomLens").css("max-width","");
	$(".zoomLens").css("max-height","");

	
	$(".zoomWindow").css("visibility","visible");
}
	



}
		  
</script>

<?php $this->dispatch("layout/footer");?>