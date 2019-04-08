<?php 
$userid=$this->get_variable("userid");
$type=$this->get_variable("type");
$sort_id=$this->get_variable("sort_id");
$max=$this->get_variable("max");
$min=$this->get_variable("min");
$from_price=$this->get_variable("from_price");
$to_price=$this->get_variable("to_price");
$outofstock_chkd=$this->get_variable('outofstock_chkd');

$catid=$this->get_variable('catid');
$brandid=$this->get_variable('brandid');
$catname=$this->get_variable('catname');
$catnameoriginal=$this->get_variable('catnameoriginal');
$brandname=$this->get_variable('brandname');
$search=$this->get_variable('search');

$title="";

if($type=="featured")
$title=$this->get_label('featured products');
else if($type=="recent")
$title=$this->get_label('recent products');
else if($type=="special-offers" || $type=="special offers")
$title=$this->get_label('special offers');

$in="";
if($type !="category" && $catid >0)
$in=" - ";
	
if($catid >0 && $catnameoriginal !='')
$title.=$in.$catnameoriginal;

if($search !=0)
{
	$title=$this->get_label('search results of',array('x'=>$search));
	$this->dispatch("layout/header/$search");
}
else
	$this->dispatch("layout/header");

$productlist=$this->get_result('productlist');
if(count($productlist) >0)
{
?>

<script type='text/javascript'>									  
var startpage = 2;
$(window).scroll(function()
{
	var scrl_end=$("#scroll_end").val();
	var catid=$("#catid").val();
	if(scrl_end !='1')
	{
		if( ($(window).height()+$(".footer").height()+$(".copyright_div").height()) > ($(document).height()-$(window).scrollTop()))
		{
 			$('#loading_div').show();$("#scroll_end").val('1');
 			
			$.ajax({
		  	type: 'POST',
			url: "<?php echo $this->make_url("product/scroll");?>",
            data: {'type':'<?php echo $type;?>','catid':'<?php echo $catid;?>','brandid':'<?php echo $brandid;?>','sort_id':'<?php echo $sort_id;?>','from_price':'<?php echo floor($from_price);?>','to_price':'<?php echo ceil($to_price);?>','outofstock_chkd':'<?php echo $outofstock_chkd;?>','catname':'<?php echo $catname;?>','brandname':'<?php echo $brandname;?>','search':'<?php echo $search;?>','startpage':startpage},
            context: document.body
           }).done(function(data) 
           { 
	          if(data!='')
	          {
		         $("#scroll_end").val('0');
	          	 $(data).appendTo('#list-ca1-wrapper1');
	 		     startpage+=1;
	          }
	          else
	          {
	        	 $("#nomoreresults").show();
	           	 $("#scroll_end").val('1');
	          }
	           $('#loading_div').hide();
		});
	  }
   }
});
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

<style type="text/css">
#sortedSelectBoxIt{	width: 170px !important;}
</style>

<?php $this->dispatch("layout/compare_menu/li"); ?>
   
<input type="hidden" name="scroll_end" id="scroll_end" value="0"> 
<input type="hidden" name="catid" id="catid" value="<?php echo $catid;?>"> 
<input type="hidden" name="outofstock_chkd" id="outofstock_chkd" value="<?php echo $outofstock_chkd;?>"> 
  
<!-- PRODUCT LIST START -->
       
       
<div class="container">
<div class="left-category-head">
<a href="<?php echo $this->make_url('product/list/'.$type.'/0');?>"><?php echo $this->get_label('all categories')?></a> / <?php echo $this->get_category_path1($catid,'product/list/'.$type);?>
</div>
</div>
   
   
   
   
   
<div id="list-ca1-container1" class="ca1-container" style="height: auto;margin-top: 10px;">
            
<div class="leftpanel_div">

<?php $this->dispatch('layout/left/'.$type.'/'.$catid.'/'.$brandid.'/'.$sort_id.'/'.$from_price.'/'.$to_price.'/'.$outofstock_chkd.'/'.$catname.'/'.$brandname.'/'.$search);?>

    
<script type='text/javascript' src='<?php echo BASE.COMMON_DIR_PATH;?>js/ion.rangeSlider.min.js'></script>
	
<script type="text/javascript">
    $(document).ready(function(){
	var max="<?php echo ceil($max);?>",min="<?php echo floor($min);?>",from_price="<?php echo floor($from_price);?>",to_price="<?php echo ceil($to_price);?>";
$("#price_range").ionRangeSlider({
    min: min,
    max: max,
    from:from_price,
    to:to_price,
    type: 'double',
    prefix: "<?php echo Settings::get_instance()->read('currency_symbol');?>",
    prettify: true,
    hasGrid: true,
    onFinish: function (obj) 
    {
	    var type="<?php echo $type;?>",
	        sorted_id=$("#sorted").val(),
	        chkd=$("#outofstock_chkd").val(),
	        catid=$("#catid").val(),
	        brandid="<?php echo $brandid;?>",
	        catname="<?php echo $catname;?>",
	        brandname="<?php echo $brandname;?>",
	        search="<?php echo $search;?>";

	        window.location.href="<?php echo $this->make_url('product/list/');?>"+type+"/"+catid+"/"+brandid+"/"+sorted_id+"/"+obj.fromNumber+"/"+obj.toNumber+"/"+chkd+"/"+catname+"/"+brandname+"/"+search;
    }
});

$("#exclude_stock").click(function()
{
	var chkd=0;
    if ($(this).attr("checked") == "checked")
    chkd=1;
    else
    chkd=0;
    
	$("#outofstock_chkd").val(chkd);

	var type="<?php echo $type;?>",
	    sorted_id=$("#sorted").val(),
	    catid=$("#catid").val(),
	    brandid="<?php echo $brandid;?>",
	    from_price="<?php echo floor($from_price);?>",
	    to_price="<?php echo ceil($to_price);?>",
	    catname="<?php echo $catname;?>",
	    brandname="<?php echo $brandname;?>",
	    search="<?php echo $search;?>";

		window.location.href="<?php echo $this->make_url('product/list/');?>"+type+"/"+catid+"/"+brandid+"/"+sorted_id+"/"+from_price+"/"+to_price+"/"+chkd+"/"+catname+"/"+brandname+"/"+search;
  });

});	


function sortproducts()
{
	var type="<?php echo $type;?>",
		catid=$("#catid").val(),
		brandid="<?php echo $brandid;?>",
		sorted_id=$("#sorted").val(),
		from_price="<?php echo floor($from_price);?>",
		to_price="<?php echo ceil($to_price);?>",
		chkd=$("#outofstock_chkd").val(),
		catname="<?php echo $catname;?>",
		brandname="<?php echo $brandname;?>",
		search="<?php echo $search;?>";
	
		window.location.href="<?php echo $this->make_url('product/list/');?>"+type+"/"+catid+"/"+brandid+"/"+sorted_id+"/"+from_price+"/"+to_price+"/"+chkd+"/"+catname+"/"+brandname+"/"+search;
}
</script>

<div class="filterTitle left-price-head"><?php echo $this->get_label('price');?></div>


<input type="hidden" name="filter_type" id="filter_type" value="<?php echo $type;?>">
<input type="hidden" name="filter_brandid" id="filter_brandid" value="<?php echo $brandid;?>">
<input type="hidden" name="filter_from_price" id="filter_from_price" value="<?php echo $from_price;?>">
<input type="hidden" name="filter_to_price" id="filter_to_price" value="<?php echo $to_price;?>">
<input type="hidden" name="filter_catname" id="filter_catname" value="<?php echo $catname;?>">
<input type="hidden" name="filter_brandname" id="filter_brandname" value="<?php echo $brandname;?>">
<input type="hidden" name="filter_search" id="filter_search" value="<?php echo $search;?>">

<div class="pricerange_outer_div">

<div class="pricerange_inner_div">
	<input type="text" id="price_range"/>
</div>

</div>



<div class="filterTitle left-stock-head"><?php echo $this->get_label('stock');?></div>

<div class="left-stock-head-div">
<span><input type="checkbox" id="exclude_stock" name="exclude_stock" <?php if($outofstock_chkd==1){?> checked="checked" <?php }?>></span>&nbsp;
<span style="vertical-align: top;"><?php echo $this->get_label('exclude out of stock');?></span>
</div>
            
            
</div>
            
            
       
     <div class="list-page-banner"><img src="images/banner.png" border="0"></div>  
    
            
            
            
            <?php  if(count($productlist)>0) { ?>
				<div class="ca1-wrapper ca1-wrapper-details-page-div" id="list-ca1-wrapper1" >
				
				
				
				
				<div class="ca-contr-div1">
            
           
   
            <div class="ca-contr-div2" style="width: auto;"><p class="ca-contr-p individualtitlebgdiv"><?php echo $title;?></p></div> 
            
            
       
       <div class="sort sortdivbg">

				<select onchange="sortproducts(1);" name="sorted" class="select" id="sorted">
				<option value="1" <?php if($sort_id==1) {echo "selected";}?> ><?php echo $this->get_label('popularity');?></option>
				<option value="2" <?php if($sort_id==2) {echo "selected";}?> ><?php echo $this->get_label('newest to oldest');?></option>
				<option value="3" <?php if($sort_id==3) {echo "selected";}?>><?php echo $this->get_label('oldest to newest');?></option>
				<option value="4" <?php if($sort_id==4) {echo "selected";}?>><?php echo $this->get_label('price low to high');?></option>
				<option value="5" <?php if($sort_id==5) {echo "selected";}?>><?php echo $this->get_label('price high to low');?></option>
				</select>
		</div>
       
       </div>
       
       
        <div class="ca-contr-div3 width-96"></div>
      
				<?php 
				$i=0;
				foreach($productlist as $key=>$row)
				{ 
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
					
					
					
						<div class="ca1-item-main <?php if($row['prod_stock'] <1){?>ca1-item-main-out<?php } ?>">
					
						
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
			<div class="ca1-item-details" id="list-ca1-detailsid1-<?php echo $i;?>"><a href="<?php echo $this->make_url("product/details/".$row['id']."/".$row['page_title']);?>" title="<?php echo $this->get_label('view details');?>"><img alt="<?php echo $this->get_label('view details');?>" src="images/details.png"/></a></div>
			
		
			 <?php if($this->get_variable("userid")==""){
						 ?>
                        	<div class="ca1-item-wishlist" id="list-ca1-wishlistid1-<?php echo $i;?>"><a href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
						<?php }?>
						<?php if($this->get_variable("userid")!=""){
						 ?>
                        	<div class="ca1-item-wishlist" id="list-ca1-wishlistid1-<?php echo $i;?>"><a href="javascript:wishlist('<?php echo $row['id']?>')" title="<?php echo $this->get_label('add to wishlist');?>"><img alt="<?php echo $this->get_label('add to wishlist');?>" src="images/wishlist.png"/></a></div>
			
						<?php }?>
						
				<?php if($row['prod_stock'] <1){?>
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
                        
                        <div class="f_cart" <?php if($row['prod_stock'] >=1){?>onclick="cartAddition('<?php echo $row['id'];?>');"<?php }?> title="<?php echo $this->get_label('add to cart');?>"><?php echo $this->get_label('add to cart');?></div>
                        </div>    
                            
								
						</div>
                        
                        
                        
						
					</div>
					
					<?php } ?>
					
					</div>
					
					<div style="margin-top: 30px;text-align: center;display: none;" id="loading_div"><img src="images/loading.gif"></div>
					
					
					<?php } ?><!-- End cndn -->
					
					</div>
					
					<div style=" height:30px;"></div>
					
					 <?php  if(count($productlist)>0) { ?>
					
			<script type="text/javascript">
			$(document).ready(function() 
			{
			    $("#list-ca1-wrapper1 > .ca1-item").mouseenter(function()
			    {
				    if($(this).css("opacity") <1)
					return;
					thisid=this.id;
					thisarray=thisid.split('-');
					 
					$('#list-ca1-detailsid1-'+thisarray[2]).show(300);
					$('#list-ca1-wishlistid1-'+thisarray[2]).show(300);
				 });
				 
				 $("#list-ca1-wrapper1 > .ca1-item").mouseleave(function()
				 {
					 thisid=this.id;
					 thisarray=thisid.split('-');
					 
					 $('#list-ca1-detailsid1-'+thisarray[2]).hide(300);
					 $('#list-ca1-wishlistid1-'+thisarray[2]).hide(300);
				 });
			});
		    </script>
		
		<div class="container" id="nomoreresults" style="display: none;"><div class="nomoreresults_div"><?php echo $this->get_label('no more results');?></div></div>
					
					<div style="display: none;"><?php echo $this->get_variable('pagination');?></div>
					<?php }else{?> 
					
					<div style="min-height: 106px;position: relative;"><div class="norecords_div"><?php echo $this->get_label('no record');?></div></div>
					
					
					 <?php } ?>
					 
            
            <!-- PRODUCT LIST END -->


<?php $this->dispatch("layout/footer");?>