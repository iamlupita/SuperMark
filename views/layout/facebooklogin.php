<?php
if(LoginHelper::validate_user_login())
{
	echo '<span style="color:red">'.$this->get_label('you are already logged in').'</span>';
	exit;
}
  		
if(!isset($_SESSION)) 
{
     session_start();
}

$facebook = new Facebook(array(
  'appId'  => Settings::get_instance()->read('fb_app_id'),
  'secret' => Settings::get_instance()->read('fb_secret'),
));
	
$fbsuccess=0; 
$user = false;

if(isset($_COOKIE[COOKIE_SOCIALLOGIN]) && $_COOKIE[COOKIE_SOCIALLOGIN]=="fb" && Settings::get_instance()->read('fb_login_enabled') ==1)
$fbsuccess=1;


$user = $facebook->getUser();// See if there is a user from a cookie

$fbconnect=0;
$fbconnect = $this->read_cookie_param(COOKIE_FBLOGINSUCCESS);
	
if($user && $fbsuccess==0 && $fbconnect==1 && Settings::get_instance()->read('fb_login_enabled') ==1) 
{
   	try {
    		// Proceed knowing you have a logged in user who's authenticated.
    		$user_profile = $facebook->api('/'+$user);//print_r($user_profile);die;
    	} 
    	catch (FacebookApiException $e) 
    	{
    		$user = null;
    	}
    	
    $email=$user_profile['email'];
    $firstname=$user_profile['first_name'];
    $lastname=$user_profile['last_name'];
    $name=$firstname." ".$lastname;
    $db= DBLayer::get_instance();
    
    $countval=$db->read_single_column("SELECT id FROM ".TABLE_PREFIX."users WHERE email=?",array($email));
    if($countval =="")
    {
    	$enc_pwd=base64_encode(substr(md5($email),0,10));
    	$res=$db->execute_query("INSERT INTO ".TABLE_PREFIX."users (email,name,status,joindate,last_login,password) values (?,?,?,?,?,?)",array($email,$name,1,time(),time(),$enc_pwd));
    	$id=$res->get_last_id();
    	
    	setcookie(COOKIE_LOGINID,$id,0,$this->get_base_path(),$this->get_base_domain());
    	setcookie(COOKIE_SOCIALLOGIN,"fb",0,$this->get_base_path(),$this->get_base_domain());
    	setcookie(COOKIE_SOCIALLOGINEMAIL,$email,0,$this->get_base_path(),$this->get_base_domain());
    
    	header("Location: ".$this->make_base_url("user/home"));
		exit;
    }
    else
    {
    	$res1=$db->execute_query("select * from ".TABLE_PREFIX."users where email=?",array($email));
    	$result1=$res1->fetch_assoc();
    	if($result1['status']==1)
    	{  			
    		$id=$result1['id'];
    		
    		setcookie(COOKIE_LOGINID,$id,0,$this->get_base_path(),$this->get_base_domain());
    		setcookie(COOKIE_SOCIALLOGIN,"fb",0,$this->get_base_path(),$this->get_base_domain());
    		setcookie(COOKIE_SOCIALLOGINEMAIL,$email,0,$this->get_base_path(),$this->get_base_domain());
    			
    		header("Location: ".$this->make_base_url("user/home"));
			exit;
    	}
    }
} 

if($fbsuccess==0 && $fbconnect==0 && Settings::get_instance()->read('fb_login_enabled') ==1)
{
   if(Settings::get_instance()->read('fb_app_id') !="")
   {?>
    <script type="text/javascript">  

    var today = new Date();
    today.setTime( today.getTime() );
    today.setHours(today.getHours()+1);
    today.setMinutes(0);
    today.setSeconds(0);
    
    function Set_Cookie( name, value, expires, path, domain, secure ) 
    {	
    	if ( expires )
    	{
    		expires = expires * 1000 * 60 * 60 ;
    	}
    	var expires_date = new Date( today.getTime() + (expires) );
    	document.cookie = name + "=" +escape( value ) + ";expires=" + expires_date.toGMTString()  + ( ( path ) ? ";path=" + path : "" ) + ( ( domain ) ? ";domain=" + domain : "" ) + ( ( secure ) ? ";secure" : "" );
    }

    function fb_login() 
    {
		var uri = encodeURI('<?php echo $this->make_base_url("layout/facebooklogin");?>');
		
    	FB.getLoginStatus(function(response) 
    	{
    	  if (response.status === 'connected') 
          {
    		    // the user is logged in and has authenticated your
    		    // app, and response.authResponse supplies
    		    // the user's ID, a valid access token, a signed
    		    // request, and the time the access token 
    		    // and signed request each expire
    		    var uid = response.authResponse.userID;
    		    var accessToken = response.authResponse.accessToken;

    		    Set_Cookie('<?php echo COOKIE_FBLOGINSUCCESS;?>', 1, 0 ,'<?php echo $this->get_base_path();?>','<?php echo $this->get_base_domain();?>');
    		    
    		    window.opener.location.href = "<?php echo $this->make_base_url("layout/facebooklogin");?>";
    		    //window.opener.location.reload();
    		    window.close();
    	  } 
    	  else if (response.status === 'not_authorized') 
          {
   			  window.location = encodeURI("https://www.facebook.com/dialog/oauth?client_id=<?php echo Settings::get_instance()->read('fb_app_id');?>&redirect_uri="+uri+"&response_type=token&scope=email,user_birthday");
    		    // the user is logged in to Facebook, 
    		    // but has not authenticated your app
    	  } 
    	  else 
          {
    		  window.location = encodeURI("https://www.facebook.com/dialog/oauth?client_id=<?php echo Settings::get_instance()->read('fb_app_id');?>&redirect_uri="+uri+"&response_type=token&scope=email,user_birthday");
    	    // the user isn't logged in to Facebook.
    	  }
     },true);
}
    
	window.fbAsyncInit = function() 
	{
	    	FB.init({
	    	  appId      : <?php echo $facebook->getAppID() ?>,
	    	  status     : true,
	    	  cookie     : true,
	    	  xfbml      : true
	});
	fb_login();
};

  	(function(d){
    	 var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
    	 if (d.getElementById(id)) {return;}
    	 js = d.createElement('script'); js.id = id; js.async = true;
    	 js.src = "//connect.facebook.net/en_US/all.js";
    	 ref.parentNode.insertBefore(js, ref);
    	}(document));

    	
</script>
<?php } 
} ?>