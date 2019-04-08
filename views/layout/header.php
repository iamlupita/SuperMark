<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="shortcut icon" href="images/favicon.ico" type="image/x-icon">
<link rel="icon" href="images/favicon.ico" type="image/x-icon">
<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
<title>
<?php 
if($this->get_title('')=="")
echo Settings::get_instance()->read('engine_name');
else
echo Settings::get_instance()->read('engine_name')."-".$this->get_title();


$userid=$this->get_variable('userid');
$expery=$this->get_variable('expery');
$login= $this->get_variable('login');
$keyword=$this->get_variable('keyword');
$description=$this->get_variable('description');
$search=$this->get_variable('search');
$cartpage=$this->get_variable('cartpage');

$productid=$this->get_variable('productid');
$detailpage=$this->get_variable('detailpage');




$cpath= $this->get_base_path();
$cdomain=$this->get_base_domain();


?>
</title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo DEFAULT_CHARSET; ?>">
<meta name="keywords" content="<?php echo $keyword;?>" />
<meta name="description" content="<?php echo $description;?>" />




<?php 
if($detailpage ==1)
{
	?>
	
	<meta property="og:title" content="<?php 
	if($this->get_title('')=="")
	echo Settings::get_instance()->read('engine_name');
	else
	echo Settings::get_instance()->read('engine_name')."-".$this->get_title();?>" />

	<meta property="og:url" content="<?php echo $this->make_url("product/details/".$productid."/".$this->get_title());?>" />
	<meta property="og:description" content="<?php echo $description;?>" />
	
	
	
	<?php 
	$productimage=$this->get_result('productimage');
	if(count($productimage) >0)
	{
		foreach($productimage as $pkey=>$pvalue)
		{?>
			<meta property="og:image" content="<?php echo BASE.DATA_DIR."/prodimages/".$productid."/".$pvalue['pro_image_file'];?>" />
		<?php 
		}
	}
	else 
	{?>
	<meta property="og:image" content="<?php echo BASE.DATA_DIR;?>/logo/<?php echo Settings::get_instance()->read('default_ad_image');?>" />
	<?php 
	}
}?>


<script type='text/javascript' src='<?php echo BASE;?>common/js/jquery-1.7.2.min.js'></script>
<script type='text/javascript' src='<?php echo BASE;?>common/js/jquery-ui-1.8.23.custom.min.js' ></script>
<script type='text/javascript' src='<?php echo BASE.COMMON_DIR_PATH;?>js/common.js'></script>
<script type='text/javascript' src='<?php echo BASE;?>common/js/jquery.selectBoxIt.min.js'></script> 

<script type='text/javascript' src='<?php echo BASE.COMMON_DIR_PATH;?>js/jquery.custom-scrollbar.js'></script>


<link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE;?>css/jquery.selectBoxIt.css" />
<link rel="stylesheet" type="text/css" media="all" href="<?php echo BASE;?>css/cart.css" />
<link href='http://fonts.googleapis.com/css?family=Raleway' rel='stylesheet' type='text/css'>
<link rel="shortcut icon" href="favicon.ico">
 
 <script type="text/javascript">
$(document).ready(function() {
	$('select').selectBoxIt({
	    showEffect: "fadeIn",
	    showEffectSpeed: 400,
	    hideEffect: "fadeOut",
	    hideEffectSpeed: 400});	



	 $('body').click(
				function(event) {
					//event.stopPropagation();

					$('#searchSuggResult').slideUp(300);

					
				});
	


    
});
</script>
 
<script type="text/javascript">
 var today = new Date();
 today.setTime( today.getTime() );
 today.setHours(today.getHours()+1);
 today.setMinutes(0);
 today.setSeconds(0);

 function Get_Cookie( name )
 {
     var start = document.cookie.indexOf( name + "=" );
     var len = start + name.length + 1;
     if ( ( !start ) && ( name != document.cookie.substring( 0, name.length ) ) )
     {
         return null;
     }

     if ( start == -1 ) return null;
     var end = document.cookie.indexOf( ";", len );
     if ( end == -1 ) end = document.cookie.length;
     return unescape( document.cookie.substring( len, end ) );
 }

 function Set_Cookie( name, value, expires, path, domain, secure ) 
 {	
 	if ( expires )
 	{
 		expires = expires * 1000 * 60 * 60 ;
 	}
 	var expires_date = new Date( today.getTime() + (expires) );
 	document.cookie = name + "=" +escape( value ) + ";expires=" + expires_date.toGMTString()  + ( ( path ) ? ";path=" + path : "" ) + ( ( domain ) ? ";domain=" + domain : "" ) + ( ( secure ) ? ";secure" : "" );
 }

 function Delete_Cookie( name, path, domain ) 
 {
 	if ( Get_Cookie( name ) ) document.cookie = name + "=" +
 			( ( path ) ? ";path=" + path : "") +
 			( ( domain ) ? ";domain=" + domain : "" ) +
 			";expires=Thu, 01-Jan-1970 00:00:01 GMT";
 }

 
$(document).ready(function(){

get_cart_items(0);

$(".cartCount").click(function(){
	get_cart_items(1);
	
				
			});


<?php if($cartpage ==1){?>
$('.cart_box').hide();
$('.search_box').css('float','right');
<?php }?>			

});




function changeQuantity(pro_id)
{
var quantity=$("#qty"+pro_id).val();

if(quantity >0)
{
	$.ajax(
		{
			type: "GET",
			url: "<?php echo $this->make_url("cart/change_quantity/");?>"+pro_id+"/"+quantity,
			success: function(msg)
			{
					if(msg=="stock")
					alert("<?php echo $this->get_message('quantity exceeded stock');?>");
					else if(msg=='quantity')
			  		alert("<?php echo $this->get_message('invalid quantity');?>");
					else
					{
							var n=msg.split("@#");	
							
							$('#cost_x'+pro_id).html(n[0]);
							$('#grand_cost').html(n[1]);
							var msg1="<?php echo $this->get_message('quantity updated');?>";
							set_jnotice(1,msg1)
							$('#changesubmit_'+pro_id).hide();
							get_cart_items(0);
					}
			}
		});	
}
else
	alert("<?php echo $this->get_message('invalid quantity');?>");
}

function sortcategoryproducts(cat_id)
{
var sorted_id=$("#sorted").val();

$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("product/sort_category_products/");?>"+sorted_id+"/"+cat_id,
		success: function(msg)
			{
			$('#setvalue').html(msg);
}
		});			   
			
}
function sortcategorydetailsproducts(cat_id)
{
var sorted_id=$("#sorted").val();

$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("product/sort_category_details_products/");?>"+sorted_id+"/"+cat_id,
		success: function(msg)
			{
			$('#setvalue').html(msg);
}
		});			   
			
}



function wishlist(pro_id)
{
	$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("product/add_wishlist/");?>"+pro_id,
		success: function(msg)
			{
				if(msg >0)
				{
					$('.wishspan').html(msg);
					$('.wishouter').show();	
					
					set_jnotice(1,'<?php echo $this->get_message("sucesswishlist"); ?>');
				}
				else
				{
					set_jnotice(0,'<?php echo $this->get_message("existwishlist"); ?>');
				}
			
			
			
			}
		});		   
						
}
function removewishlist(pro_id,user_id)
{
	$.ajax(
		{
		type: "GET",
		url: "<?php echo $this->make_url("user/remove_wishlist/");?>"+pro_id+"/"+user_id,
		success: function(msg)
			{
			$("#wish"+pro_id).hide();
			var message="<?php echo $this->get_message('wishlist remove success');?>";

			if(msg ==0)
			$('.wishouter').hide();	
				
			$('.wishspan').html(msg);
			
			set_jnotice(1,message);
			}
		});			   
				   
				   
						
}

function cartAddition(value) 
{   
   var name="<?php echo COOKIE_CART_ITEMS;?>";
	
   var oldvalue=Get_Cookie(name);
	   newvalue='';
	   cookielength=0;
	   cnt=0;
    if(oldvalue !=null && oldvalue !="")
    { 
    	oldvalue_data=oldvalue.split(',');
		cookielength=oldvalue_data.length;
    	for(i=0;i< cookielength;i++)
   		{
    		olditems=oldvalue_data[i].split('-');
    		if(value == olditems[0])
    		{
        		alert("<?php echo $this->get_message('item exist in cart');?>");
        		return;
    		}

    		if(olditems[1] >0)
    		cnt=parseInt(cnt)+parseInt(olditems[1]);
    		
   	    }
        newvalue=oldvalue+","+value+'-1';
    }
    else
    {
    	newvalue=value+'-1';
    }

    if(newvalue !="")
    {
	    Set_Cookie(name,newvalue,1000,"<?php echo $cpath;?>","<?php echo $cdomain;?>");
	    set_jnotice(1,'<?php echo $this->get_message("addcart");?>');
	    

	    cnt=parseInt(cnt)+1;
	    $('#setcartitem').html(cnt);
	    $('#setcartitem').show();
    }
}



function get_cart_items(from)
{
	var name="<?php echo COOKIE_CART_ITEMS;?>";

	var cart_items=Get_Cookie(name);


	if(cart_items=="" || cart_items==null)
	{
		$('#setcartitem').html('0');
		$('#setcartitem').hide();
		$("#full_content").html('<a class="empty-cart" href="<?php echo $this->make_url("index/index");?>"></a>');

		if(from ==1)
		popup(655,405,500,"#cart_popup_div");
	}
	else
	{
		if(from ==1)
		$('.clickloading').show();
		
		$.ajax({
			type: "POST",
			url: "<?php echo $this->make_url("cart/update");?>",
			data: "",
			success: function(msg)
			  {

					$('.clickloading').hide();

				  
					var messagedata=msg.split("@#@#@#@#");	
					$("#full_content").html(messagedata[0]);

					if(messagedata[1] >0)
					{
						$('#setcartitem').html(messagedata[1]);	
						$('#setcartitem').show();
					}
					else
					{
						$('#setcartitem').html('0');	
						$('#setcartitem').hide();
					}

					if(from ==1)
					popup(655,405,500,"#cart_popup_div");	
			   }
			});
	}
}

function removeFromCart(value)
{
	var name="<?php echo COOKIE_CART_ITEMS;?>";
	var cnt=0;
	var newvalue='';
    var oldvalue=Get_Cookie(name);
    if(oldvalue!=null && oldvalue!="")
    { 
    	oldvalue_data=oldvalue.split(',');
    	cookielength=oldvalue_data.length;
    	
    	for(i=0;i < cookielength;i++)
   		{
    		olditems=oldvalue_data[i].split('-');

    		if(value !=olditems[0] && olditems[1] >0)
    		{
        		if(newvalue !='')
        		newvalue=newvalue+',';

       			newvalue=newvalue+olditems[0]+'-'+olditems[1];
       			cnt=parseInt(cnt)+parseInt(olditems[1]);
    		}
   	    }
    }

    Set_Cookie( name, newvalue,1000,"<?php echo $cpath;?>","<?php echo $cdomain;?>");
    set_jnotice(1,'<?php echo $this->get_message("itemremove");?>');

	$('#setcartitem').html(cnt);	
	if(cnt >0)
	$('#setcartitem').show();
	else
	$('#setcartitem').hide();


					
	$('#cart-count-label').html(cnt);	
	
    if(newvalue=="")
   	$("#full_content").html('<a class="empty-cart" href="<?php echo $this->make_url("index/index");?>"></a>');

    $("#view_cart_"+value).remove();

    get_cart_items(0);
}
</script>
 
 <script type="text/javascript">
function LoadMore(id)
{
	var mpid=$('#mpid').val();

	if(mpid !='')
	{
		mpidarray=mpid.split('_');
		var mpidcount=mpidarray.length;

		for(i=0;i<mpidcount;i++)
		{
			$('#morediv_'+mpidarray[i]).hide(200);
			$('#morespan_'+mpidarray[i]).show();
			$('#hidespan_'+mpidarray[i]).hide();
		}
	}

	
	$('#morediv_'+id).show();
	$('#morespan_'+id).hide();
	$('#hidespan_'+id).show();
}

function HideMore(id)
{
	$('#morediv_'+id).hide();
	$('#morespan_'+id).show();
	$('#hidespan_'+id).hide();
}

</script>


</head>

<body>

<!-- HEADER START -->


<div class="blackBg"></div>
        <div class="popUpwindow"></div>
		
		 <div class="popDetails">
								 
			<div class="my-popup-content" id="cart_popup_div">
                  	<div class="contents" id="full_content"></div>  
                                       
				<a class="closeButton" onclick="popout()">X</a>
			</div>
						
						
		 </div>	

<div class="contentOuter">

                <div class="header_top">
                <div class="container">
                
                <div class="header_right">
                
                <ul>
                <li style="width: 180px;">
                
                  <?php 
				if($login==1)
				{ ?>
            	<?php echo $this->get_label('welcome');?> &nbsp; <?php echo $this->get_variable("username");?>
                  <?php }
                else
				 {?>
                <?php echo $this->get_label('welcome');?> &nbsp; <?php echo $this->get_label('guest');?>
                 <?php }?>
                
                </li>
                <li><a href="<?php echo $this->make_url("user/wishlist");?>" title="<?php echo $this->get_label('wishlist');?>" <?php if($this->get_variable('wishlist_tab')!=""){ echo 'class="'.$this->get_variable('wishlist_tab').'"';} ?> ><?php echo $this->get_label('wishlist').' '.$this->get_wishlist_cnt();?></a></li>
               
                <?php 
				if($login!=1)
				{ ?>
                	 <li><a href="<?php echo $this->make_url("user/login");?>" title="<?php echo $this->get_label('signin');?>" <?php if($this->get_variable('signin_tab')!=""){ echo 'class="'.$this->get_variable('signin_tab').'"';} ?>><?php echo $this->get_label('signin');?></a></li>  
                	 <li><a href="<?php echo $this->make_url("user/register");?>" title="<?php echo $this->get_label('register');?>" <?php if($this->get_variable('reg_tab')!=""){ echo 'class="'.$this->get_variable('reg_tab').'"';} ?> ><?php echo $this->get_label('register');?></a></li> 
			
              <?php }
                else
				 {?>
					 <li><a href="<?php echo $this->make_url("user/home");?>" title="<?php echo $this->get_label('my account');?>" <?php if($this->get_variable('myaccount_tab')!=""){ echo 'class="'.$this->get_variable('myaccount_tab').'"';} ?> ><?php echo $this->get_label('my account');?></a></li>
 					 <li><a href="<?php echo $this->make_url("user/logout");?>" title="<?php echo $this->get_label('logout');?>"><?php echo $this->get_label('logout');?></a></li>
                	
               <?php }?>
                </ul>
                </div>
                
                
                <div class="header_left">
                
<?php 

	$facebook_url=Settings::get_instance()->read('facebook_url');
	$googleplus_url=Settings::get_instance()->read('googleplus_url');
	$linkedin_url=Settings::get_instance()->read('linkedin_url');
	$twitter_url=Settings::get_instance()->read('twitter_url');
?>
<?php 
	if($facebook_url!=""){?>
         <a target="_blank" href="http://facebook.com/<?php echo $facebook_url;?>" title="<?php echo $this->get_label('facebook');?>"><img class="socialmedia_icons" src="images/facebook.png" alt="<?php echo $this->get_label('facebook');?>"></a>
<?php }
   if($googleplus_url!=""){?>
        <a target="_blank" href="https://plus.google.com/<?php echo $googleplus_url;?>" title="<?php echo $this->get_label('google+');?>"><img class="socialmedia_icons" src="images/googleplus.png" alt="<?php echo $this->get_label('google+');?>"></a>
<?php }
   if($linkedin_url!=""){?>
   		<a target="_blank" href="http://linkedin.com/company/<?php echo $linkedin_url;?>" title="<?php echo $this->get_label('linkedin');?>"> <img class="socialmedia_icons" src="images/linkedin.png" alt="<?php echo $this->get_label('linkedin');?>"></a>
<?php }
  if($twitter_url!=""){?>
  <a target="_blank" href="http://twitter.com/<?php echo $twitter_url;?>" title="<?php echo $this->get_label('twitter');?>"><img class="socialmedia_icons" src="images/twitter.png" alt="<?php echo $this->get_label('twitter');?>"></a>
<?php } ?>
                
                </div>
                
                </div>
                </div>
                
                
                
                
                
<div class="text_header">

<div class="container">

	<div class="logo_div">
	 
	
        	<?php if($this->get_variable("public_page_logo")!='') { ?>
        	<a href="<?php echo BASE;?>" class="contentLeft"><img src="<?php echo DATA_DIR;?>/logo/<?php echo $this->get_variable("public_page_logo");?>" /></a>
        	<?php }else{ ?>
        	<a href="<?php echo BASE;?>" class="contentLeft logoName"><?php echo Settings::get_instance()->read('engine_name');?></a>
        	<?php }?>
        	

	</div>
    <div class="search_box">


 
 <div style="margin-top:49px;">
 
 
 
<div style="float:left">

<input type="text" id="searchInput" class="searchInput" value="<?php echo $search;?>" name="searchInput" autocomplete="off" placeholder="<?php echo $this->get_label('search products here');?>" /> 
 
</div>

<div style="float:left">
<input type="button" name="submit" value="<?php echo $this->get_label('search');?>"  class="button searchInput_btn" id="searchInput_btn">	


</div>

<div class="searchSuggResult" id="searchSuggResult" style="display: none;"></div>  

 
</div>

    
    
    
    </div>
    <div class="cart_box">
    
    <div class="cartCount">
    <p class="cartHead"><?php echo $this->get_label('cart');?>&nbsp;</p>
    <img src="images/cart.png" />
    <div class="cartPopUp" id="setcartitem" style="display: none;"></div>
    </div>
    
    <div class="clickloading"><img src="images/loading.gif"/></div>
    </div>
</div>
</div>
</div>


<script type="text/javascript">

$(document).ready(function(){


	$("#catlistingss_li").mouseenter(function(){
		
		$("#categories_list").fadeIn(300);

		$(".scroller-div").customScrollbar();
		
	});

	$("#catlistingss_li").mouseleave(function(){

		$("#categories_list").fadeOut(200);
		
	});


	$("#searchInput_btn").click(function(){

		var search = $("#searchInput").val();
	
	if(search!='')
	{
		
		if(typeof $("#filter_type").val() != 'undefined')
			var type=$("#filter_type").val();
		else
			var type='category';

		if(typeof $("#catid").val() != 'undefined')
				var catid=$("#catid").val();
			else
				var catid=0;

		if(typeof $("#filter_brandid").val() != 'undefined')
				var brandid=$("#filter_brandid").val();
			else
				var brandid=0;

		if(typeof $("#sorted").val() != 'undefined')
			var sorted_id=$("#sorted").val();
		else
			var sorted_id=1;


		if(typeof $("#filter_from_price").val() != 'undefined')
			var from_price=$("#filter_from_price").val();
		else
			var from_price='';

		if(typeof $("#filter_to_price").val() != 'undefined')
				var to_price=$("#filter_to_price").val();
			else
				var to_price='';
			
		
		if(typeof $("#outofstock_chkd").val() != 'undefined')
			var chkd=$("#outofstock_chkd").val();
		else
			var chkd=0;
			
		
		if(typeof $("#filter_catname").val() != 'undefined')
			var catname=$("#filter_catname").val();
		else
			var catname=0;
			
		
		if(typeof $("#filter_brandname").val() != 'undefined')
			var brandname=$("#filter_brandname").val();
		else
			var brandname=0;


		window.location.href="<?php echo $this->make_url('product/list/');?>"+type+"/"+catid+"/"+brandid+"/"+sorted_id+"/"+from_price+"/"+to_price+"/"+chkd+"/"+catname+"/"+brandname+"/"+search;

	}
		
	return false;

	});


	 $("#searchInput").keyup(function (e) {
		 SearchSuggestion(e);
	  });
	   

	  $("#searchInput").keypress(function (e) {
		  SearchSuggestion(e);
	  }); 

	  $("#searchInput").click(function (e) {
		  SearchSuggestion(e);
	  });

	  
	
	
});


function SearchSuggestion(e)
{
	var search = $("#searchInput").val();
	
	var code = e.keyCode || e.which;

	slength=search.length;
	if(slength < 3)
	{
		$("#searchSuggResult").html('').hide();
		return;
	}

	if(search!='')
	{
		
		if(typeof $("#filter_type").val() != 'undefined')
			var type=$("#filter_type").val();
		else
			var type='category';

		if(typeof $("#catid").val() != 'undefined')
				var catid=$("#catid").val();
			else
				var catid=0;

		if(typeof $("#filter_brandid").val() != 'undefined')
				var brandid=$("#filter_brandid").val();
			else
				var brandid=0;

		if(typeof $("#sorted").val() != 'undefined')
			var sorted_id=$("#sorted").val();
		else
			var sorted_id=1;


		if(typeof $("#filter_from_price").val() != 'undefined')
			var from_price=$("#filter_from_price").val();
		else
			var from_price='';

		if(typeof $("#filter_to_price").val() != 'undefined')
				var to_price=$("#filter_to_price").val();
			else
				var to_price='';
			
		
		if(typeof $("#outofstock_chkd").val() != 'undefined')
			var chkd=$("#outofstock_chkd").val();
		else
			var chkd=0;
			
		
		if(typeof $("#filter_catname").val() != 'undefined')
			var catname=$("#filter_catname").val();
		else
			var catname=0;
			
		
		if(typeof $("#filter_brandname").val() != 'undefined')
			var brandname=$("#filter_brandname").val();
		else
			var brandname=0;


		if(code !='13')
		{
		  if(search.length >=3)
			{
					$.ajax(
					{
					type: "GET",
					url: "<?php echo $this->make_url("layout/search/");?>"+type+"/"+catid+"/"+brandid+"/"+sorted_id+"/"+from_price+"/"+to_price+"/"+chkd+"/"+catname+"/"+brandname+"/"+search,
					success: function(res)
						{
						
						$("#searchSuggResult").html(res).slideDown('300');
			
						}
					});	
			
			
				}
			else
				$("#searchSuggResult").html('').hide();
			
		}
		else if(code=='13')
		window.location.href="<?php echo $this->make_url('product/list/');?>"+type+"/"+catid+"/"+brandid+"/"+sorted_id+"/"+from_price+"/"+to_price+"/"+chkd+"/"+catname+"/"+brandname+"/"+search;

	}
return false;
	
}
</script>

				
				<div class="menu_bar" style="border-bottom:2px solid #c9d94e;">
                
                <div class="container" style="width: 990px;">
                
                <div class="navbar">
                
                <ul>
                
                <li><a class="navbar-a" href="<?php echo BASE;?>" class="<?php echo $this->get_variable('home_tab');?>" title="<?php echo $this->get_label('home');?>"><?php echo $this->get_label('home');?></a></li>
              
                <li id="catlistingss_li">
                
                <a class="navbar-a" href="javascript:void(0);" ><?php echo $this->get_label('categories');?></a>
                 <ul >
               
                
                <li style="">
                
                <div id="categories_list" class="container category_list_conatiner_div gray-skin scroller-div" >


<div class="category_item_div">
    <?php 

    $tabstructure=$this->get_variable("tabstructure");
   echo $tabstructure;
    
    ?>
</div> 

</div>
                
                </li>
                
                
                </ul>
                </li>
                
                
                <li><a class="navbar-a" href="<?php echo $this->make_url("product/list/featured");?>" class="<?php echo $this->get_variable('featured_tab');?>" title="<?php echo $this->get_label('featured products');?>"><?php echo $this->get_label('featured products');?></a></li>
                <li><a class="navbar-a" href="<?php echo $this->make_url("product/list/recent");?>" class="<?php echo $this->get_variable('recent_tab');?>" title="<?php echo $this->get_label('recent products');?>"><?php echo $this->get_label('recent products');?></a></li>
                <li><a class="navbar-a" href="<?php echo $this->make_url("product/list/special-offers");?>" class="<?php echo $this->get_variable('special_tab');?>" title="<?php echo $this->get_label('special offers');?>"><?php echo $this->get_label('special offers');?></a></li>
                <li><a class="navbar-a" href="<?php echo $this->make_url("index/about");?>" class="<?php echo $this->get_variable('about_tab');?>" title="<?php echo $this->get_label('about us');?>"><?php echo $this->get_label('about us');?></a></li>
                <li><a class="navbar-a" href="<?php echo $this->make_url("user/contact_us");?>" class="<?php echo $this->get_variable('contact_tab');?>" title="<?php echo $this->get_label('contact us');?>"><?php echo $this->get_label('contact us');?></a></li>
 
                </ul>
  
                </div>
                
                </div>
   
                </div>
               
<!-- HEADER END -->

 <div><!-- FOR CAT LIST CLOSED IN FOOTER -->