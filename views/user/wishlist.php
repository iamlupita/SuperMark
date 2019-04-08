<?php $this->dispatch("layout/header");?>

   <div class="container mtop-20">
<?php $this->dispatch("layout/login_left");?>
<div class="accountData contentLeft" style="margin-bottom:40px;">

<h1 class="titleh1"><?php echo $this->get_label('wishlist');?> </h1>

	 <?php if($this->get_variable("tot")==0){ ?>         
   
 <div class="wishlist-empty"><?php echo $this->get_label('wishlist empty');?> </div>     
                              
	 <?php 
    }
   else if($this->get_variable("tot") >0){ 
   
    $wishlist=$this->get_result('wishlist');
    foreach($wishlist as $key=>$row)
    {
    
    ?>
    <div>
          <div class="wishlist-div" id="wish<?php echo $row['pro_id']; ?>">
		  
          	<div class="wishlist-img-div">
          	
          	<div>
          	          	
                <a href="<?php echo $this->make_url("product/details/".$row['pro_id']."/".$row['name']);?>">
                
                <?php 
                list($widthimage,$heightimage) = @getimagesize($this->get_product_image($row['pro_id']));
				$dimension=$this->get_image_dimension($widthimage,$heightimage,1);
				$dimensionarray=explode('_',$dimension);
               	
                ?>
                <img style="height: <?php echo $dimensionarray[1]."px";?>;width: <?php echo $dimensionarray[0]."px";?>" src="<?php echo $this->get_product_image($row['pro_id']); ?>" style="width:200px;height:150px;" /></a>
				</div>
            </div>
            
            <div class="wishlist-content-div">
            
            <div style="width:100%; max-height:50px; overflow:hidden;"><b style="font-size:14px;word-break:break-all;"><?php echo $this->escape($this->get_product_name($row['pro_id'])); ?></b></div>
                            
             <div class="wishlist-content-brand">
             <?php 
             $brnd_name=$this->escape($this->get_brand_name($row['pro_id']));
             if($brnd_name!=""){?>
             <b><?php echo $this->get_label('brand');?> : </b><?php echo $brnd_name; ?>
             <?php } ?>
             </div>                              
                                       
              <div class="wishlist-content-category"><b><?php echo $this->get_label('category path');?> : </b><?php echo $this->escape($this->get_category_name($this->get_product_category($row['pro_id']))); ?> </div>                             
                                    
           	<div class="wishlist-content-dec"><?php echo substr($row['description'], 0, 100); ?></div>
	
	 <div style="width:100%; height:40px; float:left;">
	 
	 <div class="productRateDisplay contentLeft">
	 
	 <?php 
	 $prd_pricing=$this->get_product_pricing($row['pro_id']);
	 
	 $price_diff=$this->get_price_difference($row['mrp'],$prd_pricing);
	 $save_str="";
	 if($price_diff>0)
	 	$save_str=$this->get_label('you save',array('x'=>$price_diff));
	 
	 ?>
          <b class="itemRate"><?php echo $this->get_money_format($prd_pricing);?></b>
         
        	<b class="itemRate previousPrice"><?php echo $this->get_money_format($row['mrp']); ?></b> 
         
		<div class="priceColor contentLeft"><?php echo $save_str;?></div>
     </div>
	
	</div>
	
	
	<div class="wishlist-content-btns">
         <a class="cartAddition" href="javascript:cartAddition('<?php echo $row['pro_id']; ?>')"><?php echo $this->get_label('add to cart');?></a>
         <a class="cartAddition" href="javascript:removewishlist('<?php echo $row['pro_id']; ?>','<?php echo $row['id']; ?>')"><?php echo $this->get_label('remove from wishlist');?></a>
   </div>
   
   </div>
						
            </div>
          </div>
          
 <?php 
    }
    echo "<div class='public_pagination_div'>".$this->get_variable('pagination')."</div>";
    }
    ?>	
		
            </div>
    </div>

<?php $this->dispatch("layout/footer");?>	