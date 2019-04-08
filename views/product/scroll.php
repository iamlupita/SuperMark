<?php 
				$i=$this->get_variable('startpages');
				$ca1str=$this->get_variable('ca1str');
				
				$products=$this->get_result('products');
				if(count($products)>0)
				{
				foreach($products as $key=>$row)
				{
					 //$i=0;
					 
					 $i++;
					 
					 
					 $pcat=$row['cat_id'];
					 $pname=$row['name'];
					 $purl=$this->make_url("product/details/".$row['id']."/".$row['page_title']);
					 $prprice=$this->get_product_pricing($row['id']);
					 $ppricing=$this->get_money_format($prprice);
					 $pimage=$this->get_product_image($row['id']);
					 
					 ?>
					 
					 <input type="hidden" name="catid_li_<?php echo $row['id'];?>" id="catid_li_<?php echo $row['id'];?>" value="<?php echo $pcat;?>" />
					 <input type="hidden" name="name_li_<?php echo $row['id'];?>" id="name_li_<?php echo $row['id'];?>" value="<?php echo $pname; ?>" />
					 <input type="hidden" name="url_li_<?php echo $row['id'];?>" id="url_li_<?php echo $row['id'];?>" value="<?php echo $purl;?>" />
					 <input type="hidden" name="price_li_<?php echo $row['id'];?>" id="price_li_<?php echo $row['id'];?>" value="<?php echo $ppricing; ?>" />
					 <input type="hidden" name="image_li_<?php echo $row['id'];?>" id="image_li_<?php echo $row['id'];?>" value="<?php echo $pimage; ?>" />
					 <?php
					 list($widthimage,$heightimage) = @getimagesize($pimage);
					 $dimension=$this->get_image_dimension($widthimage,$heightimage,10);
					 $dimensionarray=explode('_',$dimension);
					 ?>
					 <input type="hidden" name="width_li_<?php echo $row['id'];?>" id="width_li_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[0]; ?>" />
					 <input type="hidden" name="height_li_<?php echo $row['id'];?>" id="height_li_<?php echo $row['id'];?>" value="<?php echo $dimensionarray[1]; ?>" />
					 					 
					 
					 
					 
				
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
							
			<div class="ca1-item-details" id="<?php echo $ca1str;?>ca1-detailsid1-<?php echo $i;?>"><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>" title="<?php echo $this->get_label('view details');?>"><img alt="<?php echo $this->get_label('view details');?>" src="images/details.png"/></a></div>
			
		
			 <?php if($this->get_variable("userid")==""){
						 ?>
                        	<div class="ca1-item-wishlist" id="<?php echo $ca1str;?>ca1-wishlistid1-<?php echo $i;?>"><a href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
						<?php }?>
						<?php if($this->get_variable("userid")!=""){
						 ?>
                        	<div class="ca1-item-wishlist" id="<?php echo $ca1str;?>ca1-wishlistid1-<?php echo $i;?>"><a href="javascript:wishlist('<?php echo $row['id']?>')" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
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
    <input type="checkbox" class="ckbox" onclick="compare_clicked(<?php echo $row['id'];?>,'li');" value="<?php echo $row['id'];?>" <?php if($this->get_product_exist_cookie($row['id'])==1){ echo "checked";}?> id="chk_compare_li_<?php echo $row['id'];?>" name="chk_compare_li_<?php echo $row['id'];?>" />
    <span class="box"><span class="tick"></span></span>
</span>

<label for="index_com_chk_f_<?php echo $row['id'];?>" title="" style="padding-left:5px;"><?php echo $this->get_label('add to compare');?></label>
            
            
        </h6>

        </form>
                            
                        <div class="f_product <?php if($row['prod_stock']<1){?>f_product-out<?php } ?>">
                        
                        <div class="f_image">
                        <img src="images/ad_cart.png"/></div>
                        
                        <div class="f_cart" onclick="cartAddition('<?php echo $row['id'];?>')" title="<?php echo $this->get_label('add to cart');?>"><?php echo $this->get_label('add to cart');?></div>
                        </div>    
                            
								
						</div>
                        
                        
                        
						
					</div>
					
					
			<script type="text/javascript">
			$(document).ready(function() 
			{
				$("#<?php echo $ca1str;?>ca1-wrapper1 > .ca1-item").mouseenter(function()
				{
					if($(this).css("opacity") <1)
					return;
				
					thisid=this.id;
					thisarray=thisid.split('-');
					 
					$('#<?php echo $ca1str;?>ca1-detailsid1-'+thisarray[2]).show(300);
					$('#<?php echo $ca1str;?>ca1-wishlistid1-'+thisarray[2]).show(300);
				 });
				 
				 $("#<?php echo $ca1str;?>ca1-wrapper1 > .ca1-item").mouseleave(function()
				 {
					 thisid=this.id;
					 thisarray=thisid.split('-');
					 
					 $('#<?php echo $ca1str;?>ca1-detailsid1-'+thisarray[2]).hide(300);
					 $('#<?php echo $ca1str;?>ca1-wishlistid1-'+thisarray[2]).hide(300);
				 });
			});
		    </script>
		
		
					
					<?php }} ?>