<?php 
$tab=$this->get_variable("tab");

$this->dispatch("layout/header/3/_31".$tab);


$validate=array(
		"engine_name"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"country"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"address1"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"state"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"city"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"phone"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"zipcode"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"paypal_email"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isEmail"=>array($this->get_message("invalid email address"))
		),
		"min_pass_len"=>array(
				"notNull"=>array($this->get_message("mandatory")),
                "isInteger"=>array($this->get_message("positive integer"))
	    ),
		"paypal_currency"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"currency"=>array(
				"notNull"=>array($this->get_message("mandatory"))
		),
		"pending_orders_period"=>array(
				"notNull"=>array($this->get_message("mandatory")),
                "isInteger"=>array($this->get_message("positive integer"))
	    ),
		"product_popularity_period"=>array(
				"notNull"=>array($this->get_message("mandatory")),
                "isInteger"=>array($this->get_message("positive integer"))
	    ),
		"fb_login_enabled=>1"=>array(
				
			"fb_app_id"=>array(
					"notNull"=>array($this->get_message("mandatory"))
			),
			"fb_secret"=>array(
					"notNull"=>array($this->get_message("mandatory"))
			)
				
		),
		
		"gp_login_enabled=>1"=>array(
				
			"google_client_id"=>array(
					"notNull"=>array($this->get_message("mandatory"))
			),
			"google_client_secret"=>array(
					"notNull"=>array($this->get_message("mandatory"))
			),
			"google_developer_key"=>array(
					"notNull"=>array($this->get_message("mandatory"))
			)
				
		)
);


$validate1=array(
		"img_maxsize"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isInteger"=>array($this->get_message("positive integer"))
		),
		"img_maxht"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isInteger"=>array($this->get_message("positive integer"))
		),
		"img_maxwt"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isInteger"=>array($this->get_message("positive integer"))
		),
		"ad_title"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isInteger"=>array($this->get_message("positive integer"))
		),
		"desc_length"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isInteger"=>array($this->get_message("positive integer"))
		),
		"refund_request_period"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isInteger"=>array($this->get_message("positive integer"))
		),
		"compare_list_count"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isInteger"=>array($this->get_message("positive integer"))
		)
);



$validate2=array(
		"email_address"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isEmail"=>array($this->get_message("invalid email address"))
		),
		"admin_email"=>array(
				"notNull"=>array($this->get_message("mandatory")),
				"isEmail"=>array($this->get_message("invalid email address"))
		),
		"smtp_sender_email"=>array(
				"notNull"=>array($this->get_message("not null")),
				"isEmail"=>array($this->get_message("invalid email address"))
		),
		"smtp_sender_name"=>array(
				"notNull"=>array($this->get_message("not null"))
		)
);





?>

<script type="text/javascript">


function LoadFBSettings()
{
	if($("#fb_login_enabled").val() ==1)
	{
		$("#FB1").show();
		$("#FB2").show();
		$("#FB3").show();
		$("#FB4").show();
	}
	else
	{
		$("#FB1").hide();
		$("#FB2").hide();
		$("#FB3").hide();
		$("#FB4").hide();
	}
}
function LoadGPSettings()
{
	if($("#gp_login_enabled").val() ==1)
	{
		$("#GP1").show();
		$("#GP2").show();
		$("#GP3").show();
		$("#GP4").show();
		$("#GP5").show();
		$("#GP6").show();
	}
	else
	{
		$("#GP1").hide();
		$("#GP2").hide();
		$("#GP3").hide();
		$("#GP4").hide();
		$("#GP5").hide();
		$("#GP6").hide();
	}
}

function load_demo_position()
{
	if($("#currency_position").val()==1)
	$("#demo_position").html($("#currency").val()+' '+10);	
	else if($("#currency_position").val()==2)
	$("#demo_position").html(10+' '+$("#currency").val());	
}

function show_tab(tab)
{
	if(tab==1)
	{
	    $("#gs").show();
	    $("#as").hide();
	    $("#es").hide();
	    $("#tab").val(1);
	}
	else if(tab==2)
	{
		$("#as").show();
		$("#gs").hide();
		$("#es").hide();
	    $("#tab").val(2);
	}
	else if(tab==4)
	{
		$("#es").show();
		$("#gs").hide();
		$("#as").hide();
	    $("#tab").val(4);
	}

	$('#tb1').css('background-color','#D8E9F8');
	$('#tb2').css('background-color','#D8E9F8');
	$('#tb3').css('background-color','#D8E9F8');
	$('#tb4').css('background-color','#D8E9F8');

	$('#tb1').css('border-bottom','1px solid #CCCCCC');
	$('#tb2').css('border-bottom','1px solid #CCCCCC');
	$('#tb3').css('border-bottom','1px solid #CCCCCC');
	$('#tb4').css('border-bottom','1px solid #CCCCCC');
	

	$('#tb'+tab).css('background-color','#FFFFFF');
	$('#tb'+tab).css('border-bottom','1px solid #FFFFFF');

		
}


function load_smtp()
{
	if($("#smtp_mailing").val()=="true")
	{
		$("#smtp_tab").show();
	}
	else
	{
		$("#smtp_tab").hide();
	}
}

</script>

<table    style="width: 100%;">



<tr><td colspan="4" class="heading_td"><strong><?php echo $this->get_label('shopping cart settings');?></strong></td></tr>

<tr><td colspan="4" height="20px"></td></tr>



  <tr class="statistics_header">
    <td onclick="show_tab(1);"  id="tb1"><?php echo $this->get_label('general settings');?></td>
    <td onclick="show_tab(2);"  id="tb2"><?php echo $this->get_label('item settings');?></td>
    <td onclick="show_tab(3);"  id="tb3" style="display: none;"></td>
    <td onclick="show_tab(4);"  id="tb4"><?php echo $this->get_label('email settings');?></td>
  </tr>


 
<tr id="gs"><td colspan="4" id="gs_td">
<?php 
$form=$this->create_form();
$form->start("general_settings",$this->make_url("system/configure/1"),"post",$validate);


$engine_name=$this->get_variable("engine_name");
$country=$this->get_variable("country");

$address1=$this->get_variable("address1");
$address2=$this->get_variable("address2");
$state=$this->get_variable("state");
$city=$this->get_variable("city");
$phone=$this->get_variable("phone");
$zipcode=$this->get_variable("zipcode");

$min_pass_len=$this->get_variable("min_pass_len");
$paypal_email=$this->get_variable("paypal_email");
$paypal_auth_token=$this->get_variable("paypal_auth_token");
$paypal_currency=$this->get_variable("paypal_currency");
$currency=$this->get_variable("currency");
$currency_position=$this->get_variable("currency_position");
$public_page_logo=$this->get_variable("public_page_logo");
$countries=$this->get_variable("countries");
$featured_product_listing_homepage=$this->get_variable("featured_product_listing_homepage");
$featured_category_listing_homepage=$this->get_variable("featured_category_listing_homepage");
$recent_product_listing_homepage=$this->get_variable("recent_product_listing_homepage");

$fb_login_enabled=$this->get_variable("fb_login_enabled");
$gp_login_enabled=$this->get_variable("gp_login_enabled");
$fb_app_id=$this->get_variable("fb_app_id");
$fb_secret=$this->get_variable("fb_secret");
$google_client_id=$this->get_variable("google_client_id");
$google_client_secret=$this->get_variable("google_client_secret");
$google_developer_key=$this->get_variable("google_developer_key");


$social_promotion_links=$this->get_variable("social_promotion_links");
$social_share_links=$this->get_variable("social_share_links");
$facebook_url=$this->get_variable("facebook_url");
$twitter_url=$this->get_variable("twitter_url");
$googleplus_url=$this->get_variable("googleplus_url");
$linkedin_url=$this->get_variable("linkedin_url");


$pending_orders_period =$this->get_variable("pending_orders_period");
$product_popularity_period=$this->get_variable("product_popularity_period");


$banner_img_maxht=$this->get_variable("banner_img_maxht");
$banner_img_maxwt=$this->get_variable("banner_img_maxwt");

?>
<table  width="100%"  border="0">

<tr><td colspan="2" height="5px"></td></tr>
<tr><td colspan="2" class="heading_td"><strong><?php echo $this->get_label('general settings');?></strong></td></tr>
<tr><td colspan="2" height="5px"></td></tr>

<tr><td></td><td height="10px"><?php echo $this->get_label('compulsory message');?></td></tr>
<tr><td colspan="2" height="10px"></td></tr>

 <tr>
 <td width="330px" height="30px"><?php echo $this->get_label('engine name'); ?></td>
 <td>
 <input type="hidden" name="tab" id="tab" value="1"/>
 
 <input name="engine_name" type="text" id="engine_name" value="<?php echo $engine_name;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('engine name'); ?>"><span class="mandatory">*</span></td>
 </tr>
 
 
 <tr><td colspan="2" height="10px"></td></tr> 
 
 <tr>
 <td height="30px"><?php echo $this->get_label('base country'); ?></td>
 <td>
  <select id="country" name="country">
       <option value="" selected="selected">Select</option>
        <?php $countries=$this->get_result('countries');
   		foreach($countries as $key=>$row)
    	{
    	?>
         <option value="<?php echo $row['ccode']; ?>" <?php if($row['ccode']==$country){?> selected="selected" <?php }?>><?php echo $row['cname']; ?></option>
        <?php } ?> 
  </select><span class="mandatory" style="padding-top: 40px;">*</span></td>
 </tr>
 
 
  <tr><td colspan="2" height="10px"></td></tr>
 
  <tr>
    <td><?php echo $this->get_label('address1'); ?></td>
    <td><input name="address1" type="text" id="address1" value="<?php echo $address1;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('address1'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
 
  <tr>
    <td><?php echo $this->get_label('address2'); ?></td>
    <td><input name="address2" type="text" id="address2" value="<?php echo $address2;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('address2'); ?>"></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
 
  <tr>
    <td><?php echo $this->get_label('state'); ?></td>
    <td><input name="state" type="text" id="state" value="<?php echo $state;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('state'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
 
  <tr>
    <td><?php echo $this->get_label('city'); ?></td>
    <td><input name="city" type="text" id="city" value="<?php echo $city;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('city'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
 
  <tr>
    <td><?php echo $this->get_label('phone no'); ?></td>
    <td><input name="phone" type="text" id="phone" value="<?php echo $phone;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('phone'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
 
  <tr>
    <td><?php echo $this->get_label('zip code'); ?></td>
    <td><input name="zipcode" type="text" id="zipcode" value="<?php echo $zipcode;?>" class="textStylePadding" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" placeholder="<?php echo $this->get_label('zip code'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
 
 
 
 
 
 
 
 <tr><td colspan="2" height="10px"></td></tr>
 
  <tr>
    <td><?php echo $this->get_label('paypal email'); ?></td>
    <td><input name="paypal_email" type="text" id="paypal_email" value="<?php echo $paypal_email;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('paypal email'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
 <tr><td colspan="2" height="10px"></td></tr>
 
 
 
  <tr>
    <td><?php echo $this->get_label('paypal auth token'); ?></td>
    <td><input name="paypal_auth_token" type="text" id="paypal_auth_token" value="<?php echo $paypal_auth_token;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('paypal auth token'); ?>"></td>
  </tr>
 
 <tr><td colspan="2" height="10px"></td></tr>
 
 
   <tr>
    <td><?php echo $this->get_label('Public page logo');?></td>
    <td>
    <input type="file" name="public_page_logo" id="public_page_logo" size="10" class="textStylePadding"/>
    <br>
    <div class="notification">[<?php echo $this->get_label('max logo dimension');?>]</div>
    <div class="notification">[<?php echo $this->get_label('supported image format');?>]</div>
    
   
    <?php if($public_page_logo !="") {?>
     <div style="height: 10px;"></div><img  src="../<?php echo DATA_DIR;?>/logo/<?php echo $public_page_logo;?>" border="0" width="150px"/>
    <a href="<?php echo $this->make_url("system/delete_image/1")?>"><img alt="<?php echo $this->get_label('delete');?>" src="images/delete1.png" title="<?php echo $this->get_label('delete');?>" /></a>
    <?php }?>
    </td>
  </tr>
 
 <tr><td colspan="2" height="10px"></td></tr>
   
    <tr>
    <td><?php echo $this->get_label('min pass'); ?></td>
    <td><input name="min_pass_len" type="text" id="min_pass_len" value="<?php echo $min_pass_len;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="8"  class="textStylePadding" placeholder="<?php echo $this->get_label('min pass'); ?>"><span class="mandatory">*</span> </td>
    </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
  
  
  
   <tr>
    <td><?php echo $this->get_label('paypal currency'); ?></td>
    <td><input name="paypal_currency" type="text" id="paypal_currency" value="<?php echo $paypal_currency;?>" size="8" class="textStylePadding" placeholder="<?php echo $this->get_label('paypal currency'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>

 <tr>
    <td><?php echo $this->get_label('currency symbol'); ?></td>
    <td><input name="currency" type="text" id="currency" value="<?php echo $currency;?>" size="8" class="textStylePadding" placeholder="<?php echo $this->get_label('currency symbol'); ?>"><span class="mandatory">*</span></td>
  </tr>
 <tr><td colspan="2" height="10px"></td></tr>
 
 
  <tr>
    <td><?php echo $this->get_label('currency position'); ?></td>
    <td>
    <select name="currency_position" id="currency_position" style="width: 103px;" onchange="load_demo_position()">
		<option value="1" <?php if($currency_position==1) { echo "selected"; }?>><?php echo $this->get_label('prefix');?></option>
		<option value="2" <?php if($currency_position==2) { echo "selected"; }?>><?php echo $this->get_label('suffix');?></option>
	</select>
	<span id="demo_position" style="color: red;padding-top: 15px;"></span>
    </td>
  </tr>
 

  
 <tr><td colspan="2" height="10px"></td></tr>

 <tr>
 <td><?php echo $this->get_label('featured product listing in homepage'); ?></td>
 <td>
 <select name="featured_product_listing_homepage" id="featured_product_listing_homepage" style="width: 85px;">
 <option value="1" <?php if($featured_product_listing_homepage==1) { echo "selected"; }?>><?php echo $this->get_label('enabled');?></option>
 <option value="0"  <?php if($featured_product_listing_homepage==0) { echo "selected"; }?>><?php echo $this->get_label('disabled');?></option>
 </select>
 </td>
 </tr>
 
 <tr><td colspan="2" height="10px"></td></tr>

 <tr>
 <td><?php echo $this->get_label('featured category listing in homepage'); ?></td>
 <td>
 <select name="featured_category_listing_homepage" id="featured_category_listing_homepage" style="width: 85px;">
 <option value="1" <?php if($featured_category_listing_homepage==1) { echo "selected"; }?>><?php echo $this->get_label('enabled');?></option>
 <option value="0"  <?php if($featured_category_listing_homepage==0) { echo "selected"; }?>><?php echo $this->get_label('disabled');?></option>
 </select>
 </td>
 </tr>
 
 <tr><td colspan="2" height="10px"></td></tr>

 <tr>
 <td><?php echo $this->get_label('recent product listing in homepage'); ?></td>
 <td>
 <select name="recent_product_listing_homepage" id="recent_product_listing_homepage" style="width: 85px;">
 <option value="1" <?php if($recent_product_listing_homepage==1) { echo "selected"; }?>><?php echo $this->get_label('enabled');?></option>
 <option value="0"  <?php if($recent_product_listing_homepage==0) { echo "selected"; }?>><?php echo $this->get_label('disabled');?></option>
 </select>
 </td>
 </tr>
 
 <tr><td colspan="2" height="20px"></td></tr>
<tr><td colspan="2" class="heading_td"><strong><?php echo $this->get_label('cron settings');?></strong></td></tr>
<tr><td colspan="2" height="15px"></td></tr>

<tr><td colspan="2" height="10px"></td></tr>
 
 <tr>
    <td><?php echo $this->get_label('no. of days to retain pending orders');?></td>
    <td><input size="5" name="pending_orders_period" type="text" id="pending_orders_period" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php echo $pending_orders_period;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('no. of days to retain pending orders'); ?>" /><span class="mandatory">*</span></td>
  </tr>
  
  <tr><td colspan="2" height="10px"></td></tr>
 
 <tr>
    <td><?php echo $this->get_label('sales period for determining product popularity');?></td>
    <td><input size="5" name="product_popularity_period" type="text" id="product_popularity_period" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" value="<?php echo $product_popularity_period;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('sales period for determining product popularity'); ?>" /><span class="mandatory">*</span></td>
  </tr>
  
  
  
  
<tr><td colspan="2" height="20px"></td></tr>
<tr><td colspan="2" class="heading_td"><strong><?php echo $this->get_label('slider banner settings');?></strong></td></tr>
<tr><td colspan="2" height="15px"></td></tr>

<tr><td colspan="2" height="10px"></td></tr>
 
    
 <tr>
 <td><?php echo $this->get_label('slider banner width in px'); ?></td>
 <td><input name="banner_img_maxwt" type="text" id="banner_img_maxwt" value="<?php echo $banner_img_maxwt;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('slider banner width in px'); ?>"><span class="mandatory">*</span></td>
 </tr>

<tr><td colspan="2" height="10px"></td></tr>   

  <tr>
  <td><?php echo $this->get_label('slider banner height in px'); ?></td>
  <td><input name="banner_img_maxht" type="text" id="banner_img_maxht" value="<?php echo $banner_img_maxht;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('slider banner height in px'); ?>"><span class="mandatory">*</span></td>
  </tr>
 

  
  
  
  
  

<tr><td colspan="2" height="20px"></td></tr>
<tr><td colspan="2" class="heading_td"><strong><?php echo $this->get_label('social profile settings');?></strong></td></tr>
<tr><td colspan="2" height="15px"></td></tr>


<!-- 
 <tr>
 <td><?php echo $this->get_label('social promotion links'); ?></td>
 <td>
 <select name="social_promotion_links" id="social_promotion_links" style="width: 85px;">
 <option value="1" <?php if($social_promotion_links==1) { echo "selected"; }?>><?php echo $this->get_label('enabled');?></option>
 <option value="0"  <?php if($social_promotion_links==0) { echo "selected"; }?>><?php echo $this->get_label('disabled');?></option>
 </select>
 </td>
 </tr>
 
 
 <tr><td colspan="2" height="10px"></td></tr> -->

 <tr>
 <td><?php echo $this->get_label('social media share links'); ?></td>
 <td>
 <select name="social_share_links" id="social_share_links" style="width: 85px;">
 <option value="1" <?php if($social_share_links==1) { echo "selected"; }?>><?php echo $this->get_label('enabled');?></option>
 <option value="0"  <?php if($social_share_links==0) { echo "selected"; }?>><?php echo $this->get_label('disabled');?></option>
 </select>
 </td>
 </tr>
 
 
 <tr><td colspan="2" height="10px"></td></tr>
 
 <tr>
    <td>http://www.facebook.com/</td>
    <td><input name="facebook_url" type="text" id="facebook_url" value="<?php echo $facebook_url;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('facebook profile name'); ?>" /></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
 
 <tr>
    <td>http://www.twitter.com/</td>
    <td><input name="twitter_url" type="text" id="twitter_url" value="<?php echo $twitter_url;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('twitter profile name'); ?>" /></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
  
   <tr>
    <td>https://plus.google.com/</td>
    <td colspan="2"><input name="googleplus_url" type="text" id="googleplus_url" value="<?php echo $googleplus_url;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('googleplus profile name'); ?>" /></td>
    </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
  
   <tr>
    <td>http://www.linkedin.com/</td>
    <td colspan="2"><input name="linkedin_url" type="text" id="linkedin_url" value="<?php echo $linkedin_url;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('linkedin profile name'); ?>" /></td>
    </tr>
    
 <tr><td colspan="2" height="10px"></td></tr>
 
 <tr>
 <td><?php echo $this->get_label('facebook login enabled'); ?></td>
 <td>
 <select name="fb_login_enabled" id="fb_login_enabled" style="width: 85px;" onchange="LoadFBSettings()">
 <option value="1" <?php if($fb_login_enabled==1) { echo "selected"; }?>><?php echo $this->get_label('yes');?></option>
 <option value="0"  <?php if($fb_login_enabled==0) { echo "selected"; }?>><?php echo $this->get_label('no');?></option>
 </select>
 </td>
 </tr>
 
 
 <tr><td colspan="2" height="10px"></td></tr>
 
 <tr id="FB1">
 <td><?php echo $this->get_label('facebook application id'); ?></td>
 <td><input name="fb_app_id" type="text" id="fb_app_id" value="<?php echo $fb_app_id;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('facebook developer id'); ?>"/><span class="mandatory">*</span></td>
 </tr>
 
  <tr id="FB2"><td colspan="2" height="10px"></td></tr>
  
 <tr id="FB3">
 <td><?php echo $this->get_label('facebook secret key'); ?></td>
 <td><input name="fb_secret" type="text" id="fb_secret" value="<?php echo $fb_secret;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('facebook secret key'); ?>"/><span class="mandatory">*</span></td>
 </tr> 
 
  <tr  id="FB4"><td colspan="2" height="10px"></td></tr>
  
 <tr>
 <td><?php echo $this->get_label('googleplus login enabled'); ?></td>
 <td>
 <select name="gp_login_enabled" id="gp_login_enabled" style="width: 85px;" onchange="LoadGPSettings()">
 <option value="1" <?php if($gp_login_enabled==1) { echo "selected"; }?>><?php echo $this->get_label('yes');?></option>
 <option value="0"  <?php if($gp_login_enabled==0) { echo "selected"; }?>><?php echo $this->get_label('no');?></option>
 </select>
 </td>
 </tr>
 
 
 <tr id="GP1"><td colspan="2" height="10px"></td></tr> 
 
 <tr id="GP2">
 <td><?php echo $this->get_label('google client id'); ?></td>
 <td><input name="google_client_id" type="text" id="google_client_id" value="<?php echo $google_client_id;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('google client id'); ?>"/><span class="mandatory">*</span></td>
 </tr> 
 
  <tr id="GP3"><td colspan="2" height="10px"></td></tr>
 
 <tr id="GP4">
 <td><?php echo $this->get_label('google secret key'); ?></td>
 <td><input name="google_client_secret" type="text" id="google_client_secret" value="<?php echo $google_client_secret;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('google secret key'); ?>"/><span class="mandatory">*</span></td>
 </tr>  
 
  <tr id="GP5"><td colspan="2" height="10px"></td></tr>
  
 <tr id="GP6">
 <td><?php echo $this->get_label('google developer key'); ?></td>
 <td><input name="google_developer_key" type="text" id="google_developer_key" value="<?php echo $google_developer_key;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('google developer key'); ?>"/><span class="mandatory">*</span></td>
 </tr>  
 


<tr><td colspan="2" height="10px"></td></tr>    <tr><td colspan="2" height="10px"></td></tr>        
      
<tr><td></td><td align="left"><input type="submit" name="submit" value="<?php echo $this->get_label('update');?>" class="btn btn-default"></td></tr>
      
<tr><td colspan="2" height="10px"></td></tr>    
</table>

<?php $form->end();?>

</td></tr>


 <tr id="as" style="display: none;"><td colspan="4" id="as_td">
     
     
 <?php 
$form1=$this->create_form();
$form1->start("item_settings",$this->make_url("system/configure/2"),"post",$validate1);
    
$img_maxsize=$this->get_variable("img_maxsize");
$img_maxwt=$this->get_variable("img_maxwt");
$img_maxht=$this->get_variable("img_maxht");
$thumb_img_maxwt=$this->get_variable("thumb_img_maxwt");
$thumb_img_maxht=$this->get_variable("thumb_img_maxht");
$small_img_maxwt=$this->get_variable("small_img_maxwt");
$small_img_maxht=$this->get_variable("small_img_maxht");
$ad_title=$this->get_variable("ad_title");
$desc_length=$this->get_variable("desc_length");
if($this->get_variable("item_image_count")>0)
	$item_image_count=$this->get_variable("item_image_count");
else
	$item_image_count='';

if($this->get_variable("refund_request_period")>0)
	$refund_request_period=$this->get_variable("refund_request_period");
else 
	$refund_request_period='';
	
	if($this->get_variable("compare_list_count")>0)
	$compare_list_count=$this->get_variable("compare_list_count");
else 
	$compare_list_count='';
$default_ad_image=$this->get_variable("default_ad_image");

?>


<table  width="100%"  border="0">


<tr><td colspan="2" height="5px"></td></tr>
<tr><td colspan="2" class="heading_td"><?php echo $this->get_label('item settings');?></td></tr>
<tr><td colspan="2" height="10px"></td></tr>

<tr><td colspan="2" height="10px"><?php echo $this->get_label('compulsory message');?></td></tr>
<tr><td colspan="2" height="10px">
<input type="hidden" name="tab" id="tab" value="2"/>
</td></tr>




  <tr>
    <td  width="330px"><?php echo $this->get_label('img maxsize'); ?></td>
    <td><input name="img_maxsize" type="text" id="img_maxsize" value="<?php echo $img_maxsize;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('img maxsize'); ?>"><span class="mandatory">*</span></td>
  </tr>
<tr><td colspan="2" height="10px"></td></tr>   

 <tr>
    <td><?php echo $this->get_label('img maxht'); ?></td>
    <td><input name="img_maxht" type="text" id="img_maxht" value="<?php echo $img_maxht;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('img maxht'); ?>"><span class="mandatory">*</span></td>
  </tr>

<tr><td colspan="2" height="10px"></td></tr>   

  <tr>
    <td><?php echo $this->get_label('img maxwt'); ?></td>
    <td><input name="img_maxwt" type="text" id="img_maxwt" value="<?php echo $img_maxwt;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('img maxwt'); ?>"><span class="mandatory">*</span></td>
  </tr>
 

<tr><td colspan="2" height="10px"></td></tr>   

   
 <tr>
    <td><?php echo $this->get_label('thumb img maxht'); ?></td>
    <td><input name="thumb_img_maxht" type="text" id="thumb_img_maxht" value="<?php echo $thumb_img_maxht;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('thumb img maxht'); ?>"><span class="mandatory">*</span></td>
  </tr>

<tr><td colspan="2" height="10px"></td></tr>   

  <tr>
    <td><?php echo $this->get_label('thumb img maxwt'); ?></td>
    <td><input name="thumb_img_maxwt" type="text" id="thumb_img_maxwt" value="<?php echo $thumb_img_maxwt;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('thumb img maxwt'); ?>"><span class="mandatory">*</span></td>
  </tr>
 

<tr><td colspan="2" height="10px"></td></tr>   

   
 <tr>
    <td><?php echo $this->get_label('small img maxht'); ?></td>
    <td><input name="small_img_maxht" type="text" id="small_img_maxht" value="<?php echo $small_img_maxht;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('small img maxht'); ?>"><span class="mandatory">*</span></td>
  </tr>

<tr><td colspan="2" height="10px"></td></tr>   

  <tr>
    <td><?php echo $this->get_label('small img maxwt'); ?></td>
    <td><input name="small_img_maxwt" type="text" id="small_img_maxwt" value="<?php echo $small_img_maxwt;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('small img maxwt'); ?>"><span class="mandatory">*</span></td>
  </tr>
 

<tr><td colspan="2" height="10px"></td></tr>   

   
 

   

   <tr>
    <td><?php echo $this->get_label('max prod title length'); ?></td>
    <td><input name="ad_title" type="text" id="ad_title" value="<?php echo $ad_title;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('max prod title length'); ?>"><span class="mandatory">*</span></td>
    </tr>

<tr><td colspan="2" height="10px"></td></tr>   

    <tr>
    <td><?php echo $this->get_label('max prod description length'); ?></td>
    <td><input name="desc_length" type="text" id="desc_length" value="<?php echo $desc_length;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('max prod description length'); ?>"><span class="mandatory">*</span></td>
    </tr>

<tr><td colspan="2" height="10px"></td></tr>   


<tr>
    <td><?php echo $this->get_label('max days allowable for refund request after delivery'); ?></td>
    <td><input name="refund_request_period" type="text" id="refund_request_period" value="<?php echo $refund_request_period;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('max days allowable for refund request after delivery'); ?>"><span class="mandatory">*</span></td>
</tr>

<tr><td colspan="2" height="10px"></td></tr> 


<tr>
    <td><?php echo $this->get_label('item image count'); ?></td>
    <td><input name="item_image_count" type="text" id="item_image_count" value="<?php echo $item_image_count;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('item image count'); ?>"><span class="mandatory">*</span></td>
</tr>


<tr style="display: none;"><td colspan="2" height="10px"></td></tr>  
<tr style="display: none;">
    <td><?php echo $this->get_label('no. of items available in compare list'); ?></td>
    <td><input name="compare_list_count" type="text" id="compare_list_count" value="<?php echo $compare_list_count;?>" onkeyup="this.value = this.value.replace(/[^0-9\.]/g,'');" size="5" class="textStylePadding" placeholder="<?php echo $this->get_label('no. of items available in compare list'); ?>"><span class="mandatory">*</span></td>
</tr>




<tr><td colspan="2" height="10px"></td></tr> 


  <tr>
    <td><?php echo $this->get_label('default ad image');?></td>
    <td>
    <input type="file" name="default_ad_image" id="default_ad_image" size="10" class="textStylePadding"/>
    <?php if($default_ad_image !="") {?>
    <img  src="../<?php echo DATA_DIR;?>/logo/<?php echo $default_ad_image;?>" border="0" width="100px"  />
    <a href="<?php echo $this->make_url("system/delete_image/2")?>">
    <img alt="<?php echo $this->get_label('delete');?>" src="images/delete1.png" title="<?php echo $this->get_label('delete');?>" /></a>
    <?php }?>
    <br>
    <div class="notification">[<?php echo $this->get_label('max default image dimension');?>]</div>
    <div class="notification">[<?php echo $this->get_label('supported image format');?>]</div>
    </td>
  </tr>

<tr><td colspan="2" height="10px"></td></tr>   

   
      
<tr><td></td><td><input type="submit" name="submit" value="<?php echo $this->get_label('update');?>" class="btn btn-default"></td></tr>
      
<tr><td colspan="2" height="10px"></td></tr>    

</table>
     
     
<?php $form1->end(); ?>     
     
     
     
</td></tr>
    
<tr id="es" style="display: none;"><td colspan="4" id="es_td">
    
   <?php 
$form3=$this->create_form();
$form3->start("email_settings",$this->make_url("system/configure/4"),"post",$validate2);
    
$admin_email=$this->get_variable("admin_email");
$smtp_mailing=$this->get_variable("smtp_mailing");
$smtp_auth=$this->get_variable("smtp_auth");
$smtp_debug=$this->get_variable("smtp_debug");
$smtp_host=$this->get_variable("smtp_host");
$smtp_user=$this->get_variable("smtp_user");
$smtp_password=$this->get_variable("smtp_password");
$smtp_port=$this->get_variable("smtp_port");
$smtp_secure=$this->get_variable("smtp_secure");
$smtp_sender_email=$this->get_variable("smtp_sender_email");
$smtp_sender_name=$this->get_variable("smtp_sender_name");
$email_address=$this->get_variable("email_address");
?>

<table  width="100%"  border="0">

<tr><td colspan="2" height="5px"></td></tr>
<tr><td colspan="2" class="heading_td"><?php echo $this->get_label('email settings');?></td></tr>
<tr><td colspan="2" height="5px"></td></tr>

<tr><td></td><td height="10px"><?php echo $this->get_label('compulsory message');?></td></tr>
<tr><td colspan="2" height="10px"><input type="hidden" name="tab" id="tab" value="4"/></td></tr>


 <tr>
    <td width="200px;"><?php echo $this->get_label('admin email address'); ?></td>
    <td><input name="email_address" type="text" id="email_address" value="<?php echo $email_address;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('admin email address'); ?>"><span class="mandatory">*</span></td>
  </tr>
  

<tr><td colspan="2" height="10px"></td></tr>

  <tr>
    <td><?php echo $this->get_label('general notification email'); ?></td>
    <td><input name="admin_email" type="text" id="admin_email" value="<?php echo $admin_email;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('general notification email'); ?>"><span class="mandatory">*</span></td>
  </tr>
  

<tr><td colspan="2" height="10px"></td></tr>

  
   <tr>
    <td><?php echo $this->get_label('smtp sender email'); ?></td>
    <td><input name="smtp_sender_email" type="text" id="smtp_sender_email" value="<?php echo $smtp_sender_email;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('smtp sender email'); ?>"><span class="mandatory">*</span></td>
  </tr>
 


<tr><td colspan="2" height="10px"></td></tr>


  <tr>
    <td><?php echo $this->get_label('smtp sender name'); ?></td>
    <td><input name="smtp_sender_name" type="text" id="smtp_sender_name" value="<?php echo $smtp_sender_name;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('smtp sender name'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
<tr><td colspan="2" height="10px"></td></tr>

  
    <tr>
    <td ><?php echo $this->get_label('smtp mailing'); ?></td>
    <td>
    <select name="smtp_mailing" id="smtp_mailing" style="width: 85px;" onchange="load_smtp()">
		<option value="true"  <?php if($smtp_mailing=="true") { echo "selected"; }?> ><?php echo $this->get_label('true');?></option>
		<option value="false" <?php if($smtp_mailing=="false") { echo "selected"; }?>><?php echo $this->get_label('false');?></option>
	</select>
    </td>
  </tr>


<tr><td colspan="2" height="10px"></td></tr>

<tr><td colspan="2">


 <table id="smtp_tab" style="display:none;width: 100%;" cellpadding="0" cellspacing="0">
    <tr>
    <td width="200px;"><?php echo $this->get_label('smtp auth'); ?></td>
    <td >
    <select name="smtp_auth" id="smtp_auth" style="width: 85px;">
		<option value="true"  <?php if($smtp_auth=="true") { echo "selected"; }?> ><?php echo $this->get_label('true');?></option>
		<option value="false" <?php if($smtp_auth=="false") { echo "selected"; }?>><?php echo $this->get_label('false');?></option>
	</select>
    </td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
    
  
    <tr>
    <td><?php echo $this->get_label('smtp debug'); ?></td>
    <td>
    <select name="smtp_debug" id="smtp_debug" style="width: 85px;">
		<option value="0" <?php if($smtp_debug==0) { echo "selected"; }?> ><?php echo $this->get_label('no');?></option>
		<option value="1" <?php if($smtp_debug==1) { echo "selected"; }?>><?php echo $this->get_label('yes');?></option>
	</select>
    </td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
    
   <tr>
    <td><?php echo $this->get_label('smtp host'); ?></td>
    <td><input name="smtp_host" type="text" id="smtp_host" value="<?php echo $smtp_host;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('smtp host'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
    
   <tr>
    <td><?php echo $this->get_label('smtp user'); ?></td>
    <td><input name="smtp_user" type="text" id="smtp_user" value="<?php echo $smtp_user;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('smtp user'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
    
  <tr>
    <td><?php echo $this->get_label('smtp password'); ?></td>
    <td><input name="smtp_password" type="password" id="smtp_password" value="<?php echo $smtp_password;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('smtp password'); ?>"><span class="mandatory">*</span></td>
  </tr>
  
  <tr><td colspan="2" height="10px"></td></tr>
    
  <tr>
    <td><?php echo $this->get_label('smtp port'); ?></td>
    <td><input name="smtp_port" type="text" id="smtp_port" value="<?php echo $smtp_port;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('smtp port'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
    
  <tr>
    <td><?php echo $this->get_label('smtp secure'); ?></td>
    <td><input name="smtp_secure" type="text" id="smtp_secure" value="<?php echo $smtp_secure;?>" class="textStylePadding" placeholder="<?php echo $this->get_label('smtp secure'); ?>"><span class="mandatory">*</span></td>
  </tr>
 
  <tr><td colspan="2" height="10px"></td></tr>
  
 
  </table>
  



</td></tr>






<tr><td colspan="2" height="10px"></td></tr>     
<tr><td></td><td ><input type="submit" name="submit" value="<?php echo $this->get_label('update');?>" class="btn btn-default" ></td></tr>
<tr><td colspan="2" height="10px"></td></tr>    
      
      </table>
     
     
  <?php $form3->end(); ?>           
     
     
     
     </td></tr>

</table>



<?php $this->dispatch("layout/footer");?>
<script type="text/javascript">
show_tab(<?php echo $tab;?>);
load_demo_position();
load_smtp();
LoadFBSettings();
LoadGPSettings();
</script>