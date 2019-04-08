<?php 
$this->dispatch("layout/header");
?>

<script type='text/javascript' src='<?php echo BASE.COMMON_DIR_PATH;?>js/skdslider.js'></script>
<script type="text/javascript">
		jQuery(document).ready(function(){
			jQuery('#homepage_banner').skdslider({delay:5000, animationSpeed: 2000,showNextPrev:true,showPlayButton:false,autoSlide:true,animationType:'fading'});
			
		});
</script>

<script type='text/javascript' src='<?php echo BASE.COMMON_DIR_PATH;?>js/jquery.contentcarousel.js'></script>
<?php 
$banners=$this->get_result('banners');
if(count($banners) >0)
{
?>
<div class="skdslider">
<ul id="homepage_banner" class="slides">
<?php 
  foreach($banners as $key=>$row)
   {
 ?>
 <li>
<?php 
   if($row['type']==1) 
   $click_url=$this->make_url("product/details/".$row['type_id'].'/'.$this->escape($this->get_seo_title($row['type_id'])));
   else
   $click_url=$this->make_url("product/list/category/".$row['type_id']);
?>
<a href="<?php echo $click_url;?>"><img src="<?php echo DATA_DIR;?>/banners/<?php echo $row['image']; ?>" alt="<?php echo $this->get_label('banner image');?>" /></a>
</li>
<?php } ?>

  </ul>  
</div>

<?php } ?>



   
<?php  
$smallbanners=$this->get_result('smallbanners');   
if(count($smallbanners) >0)
{
	?>
	<div class="container">
	<div class="small-banner-outer">
	<?php 
	$ii=1;
	$iii=1;
	$string1='';
	$string2='';
	$string3='';
	
	foreach($smallbanners as $key1=>$row1)
	{
  
   if($row1['type']==1) 
   $click_url=$this->make_url("product/details/".$row1['type_id'].'/'.$this->escape($this->get_seo_title($row1['type_id'])));
   else
   $click_url=$this->make_url("product/list/category/".$row1['type_id']);
   
   
	
	if($iii ==1)
	{
		$string1.='<div class="small-banner-inner-left ';
		if($ii ==1)
		$string1.='	left-active "';
		else 
		$string1.='" style="display:none" ';
		
		$string1.=' ><a href="'.$click_url.'"><img src="'.DATA_DIR.'/banners/'.$row1['image'].'" /></a>';
		
		$string1.='<div class="small-banner-caption"><h2><a href="'.$click_url.'">'.$this->get_label('shop now').'<img src="images/go1.png"/></a></h2></div>';
		
		$string1.='</div>';
		
		
		
		
		
	}
	
	if($iii ==2)
	{
		$string2.='<div class="small-banner-inner-middle ';
		if($ii ==2)
		$string2.='	middle-active "';
		else
		$string2.='" style="display:none" ';
		
		$string2.=' ><a href="'.$click_url.'"><img src="'.DATA_DIR.'/banners/'.$row1['image'].'" /></a>';
		
		$string2.='<div class="small-banner-caption"><h2><a href="'.$click_url.'">'.$this->get_label('shop now').'<img src="images/go1.png"/></a></h2></div>';
		
		$string2.='</div>';
	}
	
	if($iii ==3)
	{
		$string3.='<div class="small-banner-inner-right ';
		if($ii ==3)
		$string3.='	right-active "';
		else
		$string3.='" style="display:none" ';
		
		$string3.=' ><a href="'.$click_url.'"><img src="'.DATA_DIR.'/banners/'.$row1['image'].'" /></a>';
		
		$string3.='<div class="small-banner-caption"><h2><a href="'.$click_url.'">'.$this->get_label('shop now').'<img src="images/go1.png"/></a></h2></div>';
		
		$string3.='</div>';
		
    }
	
	
		if($iii ==3)
		$iii=1;
		else
		$iii=$iii+1;
		
		
		$ii=$ii+1;
	}

	
	if($string1 !='')
	$string1='<div class="small-banner-outer-left">'.$string1.'</div>';
	
	if($string2 !='')
	$string2='<div class="small-banner-outer-middle">'.$string2.'</div>';
	
	if($string3 !='')
	$string3='<div class="small-banner-outer-right">'.$string3.'</div>';
	
	echo $string1.$string2.$string3;
	?>
	</div>
	</div>
	<?php 
	
}
   
?>  
<script type="text/javascript">
function ShowLeft()
{


	if($('.small-banner-inner-left').length ==1)
	{
		$(".left-active").fadeOut(4000);
		$(".left-active").fadeIn(4000);
	}
	else
	{
	      var length=$('.small-banner-inner-left').length;
	      var currentindex=$('.left-active').index();
	      var newindex=parseInt(currentindex)+1;
		  if(newindex ==length)
		  newindex=0;

		  $(".small-banner-inner-left").removeClass('left-active');
		  $(".small-banner-inner-left:eq("+newindex+")").addClass("left-active");    

		  $(".small-banner-inner-left").fadeOut(4000);
		  $(".left-active").fadeIn(4000);
	}
}


function ShowMiddle()
{
	if($('.small-banner-inner-middle').length ==1)
	{
		$(".middle-active").fadeOut(2000);
		$(".middle-active").fadeIn(2000);
	}
	else
	{
		  var length=$('.small-banner-inner-middle').length;
		  var currentindex=$('.middle-active').index();
		  var newindex=parseInt(currentindex)+1;
		  if(newindex ==length)
		  newindex=0;

		  $(".small-banner-inner-middle").removeClass('middle-active');
		  $(".small-banner-inner-middle:eq("+newindex+")").addClass("middle-active");    

		  $(".small-banner-inner-middle").fadeOut(4000);
		  $(".middle-active").fadeIn(4000);
	}
}


function ShowRight()
{
	if($('.small-banner-inner-right').length ==1)
	{
		$(".right-active").fadeOut(2000);
		$(".right-active").fadeIn(2000);
	}
	else
	{
		  var length=$('.small-banner-inner-right').length;
		  var currentindex=$('.right-active').index();
		  var newindex=parseInt(currentindex)+1;
		  if(newindex ==length)
		  newindex=0;

		  $(".small-banner-inner-right").removeClass('right-active');
		  $(".small-banner-inner-right:eq("+newindex+")").addClass("right-active");    

		  $(".small-banner-inner-right").fadeOut(4000);
		  $(".right-active").fadeIn(4000);
	}
}

$(document).ready(function()
{
	if($('.small-banner-outer-left').length > 0)
	setInterval("ShowLeft()", 5000);

	if($('.small-banner-outer-middle').length > 0)
	setInterval("ShowMiddle()", 7000);

	if($('.small-banner-outer-right').length > 0)
	setInterval("ShowRight()", 9000);

});

</script>
  
   
   
   
 
   
   
   <script type="text/javascript">

  jQuery( window ).scroll(function() {

	  var tflag=0;
	  if($(document).scrollTop()>=750)
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
   <?php $this->dispatch("layout/compare_menu/fe"); ?>
   
   
    <!-- FEATURED PRODUCT CATEGORY START -->
          
   
   <?php if(Settings::get_instance()->read('featured_product_listing_homepage')==1){?>
   
   	<?php 
    $feproduct=$this->get_result('feproduct');
    if(count($feproduct)>0)
    {
   
    
    ?>
   
   <div id="ca1-container-1" class="ca1-container">
            
            <div class="ca-contr-div1">
            
            <div class="ca-contr-div2"><p class="ca-contr-p titlebgdiv"><?php echo $this->get_label('featured products');?></p></div> 
            
            
       
       </div>
       
        <div class="ca-contr-div3 width-97"></div>
      
       
            
				<div class="ca1-wrapper" id="ca1-wrapper-1">
				<?php 
				$i=0;
				foreach($feproduct as $key=>$row)
				{
					 $i++;
				
				
				$pcat=$row['cat_id'];
				$pname=$row['name'];
				$purl=$this->make_url("product/details/".$row['id']."/".$row['page_title']);
				
				$prprice=$this->get_product_pricing($row['id']);
				$ppricing=$this->get_money_format($prprice);
				$pimage=$this->get_product_image($row['id']);
				
				?>
				
				<input type="hidden" name="catid_fe_<?php echo $row['id'];?>" id="catid_fe_<?php echo $row['id'];?>" value="<?php echo $pcat;?>" />
				<input type="hidden" name="name_fe_<?php echo $row['id'];?>" id="name_fe_<?php echo $row['id'];?>" value="<?php echo $pname; ?>" />
				<input type="hidden" name="url_fe_<?php echo $row['id'];?>" id="url_fe_<?php echo $row['id'];?>" value="<?php echo $purl;?>" />
				<input type="hidden" name="price_fe_<?php echo $row['id'];?>" id="price_fe_<?php echo $row['id'];?>" value="<?php echo $ppricing; ?>" />
				<input type="hidden" name="image_fe_<?php echo $row['id'];?>" id="image_fe_<?php echo $row['id'];?>" value="<?php echo $pimage; ?>" />
				<?php
				list($widthimage,$heightimage) = @getimagesize($pimage);	
				$dimension=$this->get_image_dimension($widthimage,$heightimage,10);
				$dimensionarray=explode('_',$dimension);
				?>
				<input type="hidden" name="width_fe_<?php echo $row['id'];?>" id="width_fe_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[0]; ?>" />
				<input type="hidden" name="height_fe_<?php echo $row['id'];?>" id="height_fe_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[1]; ?>" />
				
				
				
				
				
				
					<div class="ca1-item ca1-item-<?php echo $i;?> <?php if($row['prod_stock'] < 1){?>stock-opacity<?php }?>" id="ca1-itemid-<?php echo $i;?>">
					
					
					
						<div class="ca1-item-main <?php if($row['prod_stock']<1){?>ca1-item-main-out<?php } ?>">
					
					
					
					
						
			<div class="ca1-icon image-box">
			
			
			<div>
			<a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>">
            
<?php
list($widthimage,$heightimage) = @getimagesize($pimage);	
$dimension=$this->get_image_dimension($widthimage,$heightimage,9);
$dimensionarray=explode('_',$dimension);


$offeravailable=$this->get_available_offer($row['id']);
$spofferavailable=$this->get_special_offer_available($row['id']);

?>
             
            <img src="<?php echo $pimage; ?>" style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>"  />

            </a>
            </div>
							
			 <div class="ca1-item-details" id="ca1-detailsid-1-<?php echo $i;?>"><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>" title="<?php echo $this->get_label('view details');?>"><img alt="<?php echo $this->get_label('view details');?>" src="images/details.png"/></a></div>
			
		
			 <?php if($this->get_variable("userid")==""){?>
             <div class="ca1-item-wishlist" id="ca1-wishlistid-1-<?php echo $i;?>" ><a href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
 			 <?php }?>
			 <?php if($this->get_variable("userid")!=""){ ?>
             <div class="ca1-item-wishlist" id="ca1-wishlistid-1-<?php echo $i;?>"><a href="javascript:wishlist('<?php echo $row['id']?>')" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			 <?php }?>
				
				<?php if($row['prod_stock']<1){?>
					<div class="outofstock"><?php echo $this->get_label('out of stock');?></div>
          		<?php } ?>
								
			<?php if($offeravailable ==1){?>
				<div class="offer" <?php  if($spofferavailable ==1){ echo 'style="background-color:#A2B034;"';}?>><div><?php echo $this->get_offer_price($row['mrp'],$prprice); ?>%</div> <div><?php echo $this->get_label('off1');?></div></div>
            <?php } ?> 
                    
			</div>	
							
            <h3><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>"><?php echo $pname; ?></a></h3>
            
             
             <h4><?php echo $ppricing; ?>
             <div>
             <?php 
             if($offeravailable ==1)
             {
             	?>
             	
             	<?php  if($spofferavailable ==1){?>
             	<div class="limited-banner"><img src="images/limited.png" /></div>
             	<?php }?>
             	
             	
                <div><?php echo $this->get_money_format($row['mrp']); ?></div>
                <?php } ?> 
             </div>    
             </h4>
                            
            <form>
            <h6>
            
      <span class="custom-checkbox">
    <input type="checkbox" class="ckbox" onclick="compare_clicked(<?php echo $row['id'];?>,'fe');" value="<?php echo $row['id'];?>" <?php if($this->get_product_exist_cookie($row['id'])==1){ echo "checked";}?> id="chk_compare_fe_<?php echo $row['id'];?>" name="chk_compare_fe_<?php echo $row['id'];?>" />
    <span class="box"><span class="tick"></span></span>
</span>

<label for="index_com_chk_f_<?php echo $row['id'];?>" title="" style="padding-left:5px;"><?php echo $this->get_label('add to compare');?></label>
            
            
        </h6>

        </form>
                            
                        <div class="f_product <?php if($row['prod_stock']<1){?>f_product-out<?php } ?>">
                        
                        <div class="f_image">
                        <img src="images/ad_cart.png"/></div>
                        
                        <div class="f_cart" <?php if($row['prod_stock'] >=1){?>onclick="cartAddition('<?php echo $row['id'];?>');"<?php }?> title="<?php echo $this->get_label('add to cart');?>"><?php echo $this->get_label('add to cart');?></div>
                        </div>    
                            
								
						</div>
                        
                        
                        
						
					</div>
					
					<?php } ?>
					
					</div>
					</div>
					
					
					<div style=" height:50px;"></div>
					
		    <script type="text/javascript">
			$('#ca1-container-1').contentcarousel();
			$(document).ready(function() 
			{
			    $("#ca1-wrapper-1 > .ca1-item").mouseenter(function()
				{
					if($(this).css("opacity") <1)
					return;
					thisid=this.id;
					thisarray=thisid.split('-');
						 
					$('#ca1-detailsid-1-'+thisarray[2]).show(300);
					$('#ca1-wishlistid-1-'+thisarray[2]).show(300);
			 	});
				 
			 	$("#ca1-wrapper-1> .ca1-item").mouseleave(function()
				{
					if($(this).css("opacity") <1)
					return;
					thisid=this.id;
					thisarray=thisid.split('-');
					 
					$('#ca1-detailsid-1-'+thisarray[2]).hide(300);
					$('#ca1-wishlistid-1-'+thisarray[2]).hide(300);
				 });
			});
			</script>
					
					<?php }} ?>
            
            <!-- FEATURED PRODUCT CATEGORY END -->           
            
            
            <!-- Horizontal Banner --> 
            <?php echo $this->get_horizontal_banner(-1);?>
            <!-- Horizontal Banner --> 
                      
         <!-- RECENT PRODUCT CATEGORY START -->
            
     <?php if(Settings::get_instance()->read('recent_product_listing_homepage')==1){?>
   
   	<?php 
   	
   	$recentproduct=$this->get_result('recentproduct');
    if(count($recentproduct)>0)
    {
    
    ?>
   
   <div id="ca1-container-2" class="ca1-container">
            
            <div class="ca-contr-div1" >
            
            <div class="ca-contr-div2"><p class="ca-contr-p titlebgdiv"><?php echo $this->get_label('recent products');?></p></div> 
            
            
       
       </div>
       
        <div class="ca-contr-div3 width-97"></div>
      
            
				<div class="ca1-wrapper" id="ca1-wrapper-2">
				<?php 
				$i=0;
				foreach($recentproduct as $key=>$row)
				{
					 $i++;
					 
					 $pcat=$row['cat_id'];
					 $pname=$row['name'];
					 $purl=$this->make_url("product/details/".$row['id']."/".$row['page_title']);
					 
					 $prprice=$this->get_product_pricing($row['id']);
					 $ppricing=$this->get_money_format($prprice);
					 $pimage=$this->get_product_image($row['id']);
					 
					 ?>
					 
					 <input type="hidden" name="catid_re_<?php echo $row['id'];?>" id="catid_re_<?php echo $row['id'];?>" value="<?php echo $pcat;?>" />
					 <input type="hidden" name="name_re_<?php echo $row['id'];?>" id="name_re_<?php echo $row['id'];?>" value="<?php echo $pname; ?>" />
					 <input type="hidden" name="url_re_<?php echo $row['id'];?>" id="url_re_<?php echo $row['id'];?>" value="<?php echo $purl;?>" />
					 <input type="hidden" name="price_re_<?php echo $row['id'];?>" id="price_re_<?php echo $row['id'];?>" value="<?php echo $ppricing; ?>" />
					 <input type="hidden" name="image_re_<?php echo $row['id'];?>" id="image_re_<?php echo $row['id'];?>" value="<?php echo $pimage; ?>" />
					 <?php
					 list($widthimage,$heightimage) = @getimagesize($pimage);
					 $dimension=$this->get_image_dimension($widthimage,$heightimage,10);
					 $dimensionarray=explode('_',$dimension);
					 ?>
					 <input type="hidden" name="width_re_<?php echo $row['id'];?>" id="width_re_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[0]; ?>" />
					 <input type="hidden" name="height_re_<?php echo $row['id'];?>" id="height_re_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[1]; ?>" />
					 
					 
					 
					 
					 
				
					<div class="ca1-item ca1-item-<?php echo $i;?> <?php if($row['prod_stock'] < 1){?>stock-opacity<?php }?>" id="ca1-itemid-<?php echo $i;?>">
					
					
					
						<div class="ca1-item-main <?php if($row['prod_stock']<1){?>ca1-item-main-out<?php } ?>">
					
						
			<div class="ca1-icon image-box">
			<div>

			
			<a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>">
            
<?php
list($widthimage,$heightimage) = @getimagesize($pimage);	
$dimension=$this->get_image_dimension($widthimage,$heightimage,9);
$dimensionarray=explode('_',$dimension);

$offeravailable=$this->get_available_offer($row['id']);
$spofferavailable=$this->get_special_offer_available($row['id']);
?>

            
            <img src="<?php echo $pimage; ?>" style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>;"  />
            
            </a>
            </div>
							
			<div class="ca1-item-details" id="ca1-detailsid-2-<?php echo $i;?>"><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>" title="<?php echo $this->get_label('view details');?>"><img alt="<?php echo $this->get_label('view details');?>" src="images/details.png"/></a></div>
			
			 <?php if($this->get_variable("userid")==""){
						 ?>
                        	<div class="ca1-item-wishlist" id="ca1-wishlistid-2-<?php echo $i;?>"><a href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
						<?php }?>
						<?php if($this->get_variable("userid")!=""){
						 ?>
                        	<div class="ca1-item-wishlist" id="ca1-wishlistid-2-<?php echo $i;?>"><a href="javascript:wishlist('<?php echo $row['id']?>')" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
						<?php }?>
			
			<?php if($row['prod_stock']<1){?>
					<div class="outofstock"><?php echo $this->get_label('out of stock');?></div>
          		<?php } ?>
          		
			<?php if($offeravailable ==1){?>
				<div class="offer" <?php  if($spofferavailable ==1){ echo 'style="background-color:#A2B034;"';}?>><div><?php echo $this->get_offer_price($row['mrp'],$prprice); ?>%</div> <div><?php echo $this->get_label('off1');?></div></div>
             <?php }?>
                            
			</div>	
							
            <h3><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>"><?php echo $pname; ?></a></h3>
            
             
           <h4><?php echo $ppricing; ?>
             <div>
             <?php 
             if($offeravailable ==1)
             {
             	?>
             	
             	<?php  if($spofferavailable ==1){?>
             	<div class="limited-banner"><img src="images/limited.png" /></div>
             	<?php }?>
             	
             	
                <div><?php echo $this->get_money_format($row['mrp']); ?></div>
                <?php } ?>   
                </div>  
             </h4>
                              
            <form>
            <h6>
            
      <span class="custom-checkbox">
    <input type="checkbox" class="ckbox" onclick="compare_clicked(<?php echo $row['id'];?>,'re');" value="<?php echo $row['id'];?>" <?php if($this->get_product_exist_cookie($row['id'])==1){ echo "checked";}?> id="chk_compare_re_<?php echo $row['id'];?>" name="chk_compare_re_<?php echo $row['id'];?>" />
    <span class="box"><span class="tick"></span></span>
</span>

<label for="index_com_chk_r_<?php echo $row['id'];?>" title="" style="padding-left:5px;"><?php echo $this->get_label('add to compare');?></label>
            
            
        </h6>

        </form>
                            
                        <div class="f_product <?php if($row['prod_stock']<1){?>f_product-out<?php } ?>">
                        
                        <div class="f_image">
                        <img src="images/ad_cart.png"/></div>
                        
                       
                        <div class="f_cart" <?php if($row['prod_stock'] >=1){?>onclick="cartAddition('<?php echo $row['id'];?>');"<?php }?> title="<?php echo $this->get_label('add to cart');?>"><?php echo $this->get_label('add to cart');?></div>
                        </div>    
                            
								
						</div>
                        
                        
                        
						
					</div>
					
					<?php } ?>
					
					</div>
					</div>
					
					
					<div style=" height:100px;"></div>
					
		    <script type="text/javascript">
			$('#ca1-container-2').contentcarousel();
			$(document).ready(function() 
			{
				 $("#ca1-wrapper-2 > .ca1-item").mouseenter(function()
				 {
				 	 if($(this).css("opacity") <1)
					 return;
					 thisid=this.id;
					 thisarray=thisid.split('-');
					 
					 $('#ca1-detailsid-2-'+thisarray[2]).show(300);
					 $('#ca1-wishlistid-2-'+thisarray[2]).show(300);
				 });
				 $("#ca1-wrapper-2 > .ca1-item").mouseleave(function()
				 {
					 if($(this).css("opacity") <1)
					 return;
					 thisid=this.id;
					 thisarray=thisid.split('-');
					 
					 $('#ca1-detailsid-2-'+thisarray[2]).hide(300);
					 $('#ca1-wishlistid-2-'+thisarray[2]).hide(300);
				 });
			});
		    </script>
					
					<?php }} ?>
					
					
		<!-- RECENT PRODUCT CATEGORY END -->
		
		
			<!-- Horizontal Banner --> 
            <?php echo $this->get_horizontal_banner(-2);?>
            <!-- Horizontal Banner --> 
            
		<!-- FEATURED CATEGORY START -->			
					
	<?php if(Settings::get_instance()->read('featured_category_listing_homepage')==1){?>
   
	<?php 
	
   	$feat_categ=$this->get_array('feat_categ');
    if(count($feat_categ)>0)
    {
   		$cat_flg="";
    	$i=0;
			
			for($k=0;$k<count($feat_categ);$k++)
			{
				$i++;
				$row=$feat_categ[$k];
				
				
				$pcat=$row['cat_id'];
				$pname=$row['name'];
				$purl=$this->make_url("product/details/".$row['id']."/".$row['page_title']);
				$prprice=$this->get_product_pricing($row['id']);
				$ppricing=$this->get_money_format($prprice);
				$pimage=$this->get_product_image($row['id']);
				
				?>
				
				<input type="hidden" name="catid_ce_<?php echo $row['id'];?>" id="catid_ce_<?php echo $row['id'];?>" value="<?php echo $pcat;?>" />
				<input type="hidden" name="name_ce_<?php echo $row['id'];?>" id="name_ce_<?php echo $row['id'];?>" value="<?php echo $pname; ?>" />
				<input type="hidden" name="url_ce_<?php echo $row['id'];?>" id="url_ce_<?php echo $row['id'];?>" value="<?php echo $purl;?>" />
				<input type="hidden" name="price_ce_<?php echo $row['id'];?>" id="price_ce_<?php echo $row['id'];?>" value="<?php echo $ppricing; ?>" />
				<input type="hidden" name="image_ce_<?php echo $row['id'];?>" id="image_ce_<?php echo $row['id'];?>" value="<?php echo $pimage; ?>" />
				<?php
				list($widthimage,$heightimage) = @getimagesize($pimage);
				$dimension=$this->get_image_dimension($widthimage,$heightimage,10);
				$dimensionarray=explode('_',$dimension);
				?>
				<input type="hidden" name="width_ce_<?php echo $row['id'];?>" id="width_ce_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[0]; ?>" />
				<input type="hidden" name="height_ce_<?php echo $row['id'];?>" id="height_ce_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[1]; ?>" />
				
				
				
				
				
				



<?php if($cat_flg !=$row['cat_id']){?>


   <div id="ca1-container<?php echo $row['cat_id'];?>" class="ca1-container">
            
            <div class="ca-contr-div1">
            
            <div class="ca-contr-div2"><p class="ca-contr-p titlebgdiv"><?php echo strtoupper($row['cat_name']);?></p></div> 
            
            
      
       
       </div>
       
        <div class="ca-contr-div3 width-97"></div>
      
            
				<div class="ca1-wrapper" id="ca1-wrapper<?php echo $row['cat_id'];?>">
		
		
				
	<?php } ?>			
	

				
					<div class="ca1-item ca1-item-<?php echo $i;?> <?php if($row['prod_stock'] < 1){?>stock-opacity<?php }?>" id="ca1-itemid-<?php echo $i;?>">
					
					
					
						<div class="ca1-item-main <?php if($row['prod_stock']<1){?>ca1-item-main-out<?php } ?>">
					
						
			<div class="ca1-icon image-box">
			
			<div>
			<a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>">
            
<?php
list($widthimage,$heightimage) = @getimagesize($pimage);	
$dimension=$this->get_image_dimension($widthimage,$heightimage,9);
$dimensionarray=explode('_',$dimension);

$offeravailable=$this->get_available_offer($row['id']);
$spofferavailable=$this->get_special_offer_available($row['id']);
?>


            <img src="<?php echo $pimage; ?>" style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>;"  />
            
            </a>
			</div>				
			<div class="ca1-item-details" id="ca1-detailsid<?php echo $row['cat_id'];?>-<?php echo $i;?>"><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>" title="<?php echo $this->get_label('view details');?>"><img alt="View Details" src="images/details.png"/></a></div>
			
			
			 <?php if($this->get_variable("userid")==""){
						 ?>
                        	<div class="ca1-item-wishlist" id="ca1-wishlistid<?php echo $row['cat_id'];?>-<?php echo $i;?>"><a href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
						<?php }?>
						<?php if($this->get_variable("userid")!=""){
						 ?>
                        	<div class="ca1-item-wishlist" id="ca1-wishlistid<?php echo $row['cat_id'];?>-<?php echo $i;?>"><a href="javascript:wishlist('<?php echo $row['id']?>')" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
						<?php }?>
			
			<?php if($row['prod_stock']<1){?>
					<div class="outofstock"><?php echo $this->get_label('out of stock');?></div>
          		<?php } ?>
          		
			<?php if($offeravailable ==1){?>
				<div class="offer" <?php  if($spofferavailable ==1){ echo 'style="background-color:#A2B034;"';}?>><div><?php echo $this->get_offer_price($row['mrp'],$prprice); ?>%</div> <div><?php echo $this->get_label('off1');?></div></div>
            <?php } ?>
                        
			</div>	
							
            <h3><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>"><?php echo $pname; ?></a></h3>
            
             
            <h4><?php echo $ppricing; ?>
             <div>
             <?php 
             
             if($offeravailable ==1)
             {
	             ?>
             	 
			    <?php  if($spofferavailable ==1){?>
             	<div class="limited-banner"><img src="images/limited.png" /></div>
             	<?php }?>
             	             	 
                 <div><?php echo $this->get_money_format($row['mrp']); ?></div>
                 <?php } ?>   
                 </div>  
             </h4>
                             
            <form>
            <h6>
            
      <span class="custom-checkbox">
    <input type="checkbox" class="ckbox" onclick="compare_clicked(<?php echo $row['id'];?>,'ce');" value="<?php echo $row['id'];?>" <?php if($this->get_product_exist_cookie($row['id'])==1){ echo "checked";}?> id="chk_compare_ce_<?php echo $row['id'];?>" name="chk_compare_ce_<?php echo $row['id'];?>" />
    <span class="box"><span class="tick"></span></span>
</span>

<label for="index_com_chk_c_<?php echo $row['id'];?>" title="" style="padding-left:5px;"><?php echo $this->get_label('add to compare');?></label>
            
            
        </h6>

        </form>
                            
                        <div class="f_product <?php if($row['prod_stock']<1){?>f_product-out<?php } ?>">
                        
                        <div class="f_image">
                        <img src="images/ad_cart.png"/></div>
                        
                         <div class="f_cart" <?php if($row['prod_stock'] >=1){?>onclick="cartAddition('<?php echo $row['id'];?>');"<?php }?> title="<?php echo $this->get_label('add to cart');?>"><?php echo $this->get_label('add to cart');?></div>
                       
                        </div>    
                            
								
						</div>
                        
                        
                        
						
					</div>
					
					
					
					<?php 

					if(isset($feat_categ[$k+1]))
					$a=1;
					else
					$a=0;
					
					if($a==0 || ($a==1 &&  $row['cat_id'] != $feat_categ[$k+1]['cat_id']))
						{
					?>
					
					
					</div>
					</div>
					
					
					<div style=" height:50px;"></div>
					
		    <script type="text/javascript">
			$("#ca1-container<?php echo $row['cat_id'];?>").contentcarousel();
			$(document).ready(function() 
			{
				 $("#ca1-wrapper<?php echo $row['cat_id'];?> > .ca1-item").mouseenter(function()
				 {
					if($(this).css("opacity")< 1)
					return;
					thisid=this.id;
					thisarray=thisid.split('-');
					 
					$("#ca1-detailsid<?php echo $row['cat_id'];?>-"+thisarray[2]).show(300);
					$("#ca1-wishlistid<?php echo $row['cat_id'];?>-"+thisarray[2]).show(300);
				 });
				 $("#ca1-wrapper<?php echo $row['cat_id'];?> > .ca1-item").mouseleave(function()
				 {
					 if($(this).css("opacity") <1)
					 return;
					 thisid=this.id;
					 thisarray=thisid.split('-');
					 
					 $("#ca1-detailsid<?php echo $row['cat_id'];?>-"+thisarray[2]).hide(300);
					 $("#ca1-wishlistid<?php echo $row['cat_id'];?>-"+thisarray[2]).hide(300);
				 });
			});
			</script>
				
				
				
				
				
				
			<!-- Horizontal Banner --> 
            <?php echo $this->get_horizontal_banner($row['cat_id']); ?>
            <!-- Horizontal Banner --> 
				
				
				
				
				
            
				<?php } ?>
				
				<?php 
				
				$cat_flg=$row['cat_id'];
		} ?>
				
				
	<?php }}	
	?>
            <div style=" height:50px;"></div>
         <!-- FEATURED CATEGORY END -->   
		
<?php $this->dispatch("layout/footer");?>