<?php
if(LoginHelper::validate_user_login())
{
	echo '<span style="color:red">'.$this->get_label('you are already logged in').'</span>';
	return;
}

if(!isset($_SESSION)) 
{
     session_start();
}

$gpsuccess=0;

if(isset($_COOKIE[COOKIE_SOCIALLOGIN]) && $_COOKIE[COOKIE_SOCIALLOGIN]=="gp" && Settings::get_instance()->read('gp_login_enabled') ==1)
$gpsuccess="1";

$var=$this->read_page_param(1);

$gClient = new Google_Client();
$gClient->setApplicationName('Google App');
$gClient->setClientId(Settings::get_instance()->read('google_client_id'));
$gClient->setClientSecret(Settings::get_instance()->read('google_client_secret'));
$gClient->setRedirectUri($this->make_base_url("layout/googlelogin"));
$gClient->setDeveloperKey(Settings::get_instance()->read('google_developer_key'));

try 
{
	$google_oauthV2 = new Google_Oauth2Service($gClient);
}
catch(Exception $e)
{
	//echo $e;die;
}

if (isset($_GET['code']))
{
	$gClient->authenticate($_GET['code']);
	$_SESSION['token'] = $gClient->getAccessToken();
	header('Location: ' . filter_var($this->make_base_url("layout/googlelogin")."/1", FILTER_SANITIZE_URL));
	exit;
}


if (isset($_SESSION['token']))
{
	$gClient->setAccessToken($_SESSION['token']);
	setcookie(COOKIE_GPTOKEN,$_SESSION['token'],$set_time,$this->get_base_path(),$this->get_base_domain());
	
	if($var==1)
	{
		echo '<script type="text/javascript">window.opener.location.href="'.$this->make_base_url("layout/googlelogin").'";</script>';
		echo '<script type="text/javascript">window.close();</script>';
		die;
	}
}


if($gClient->getAccessToken() && $gpsuccess==0 && Settings::get_instance()->read('gp_login_enabled') ==1)
{
     //Get user details if user is logged in
     try
     {
     	$user= $google_oauthV2->userinfo->get();
     }
     catch(Exception $e)
     {
    	//echo $e;die;
     }
     
     $user_id = $user['id'];
     $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
     $firstname = filter_var($user['given_name'], FILTER_SANITIZE_SPECIAL_CHARS);
     $lastname = filter_var($user['family_name'], FILTER_SANITIZE_SPECIAL_CHARS);
 	 $name=$firstname." ".$lastname;
 	 
     $db= DBLayer::get_instance();
     
     $countval=$db->read_single_column("SELECT id FROM ".TABLE_PREFIX."users WHERE email=?",array($email));
     if($countval =="")
     {
     	$enc_pwd=base64_encode(substr(md5($email),0,10));
     	$res=$db->execute_query("INSERT INTO ".TABLE_PREFIX."users (email,name,status,joindate,last_login,password) values (?,?,?,?,?,?)",array($email,$name,1,time(),time(),$enc_pwd));
     	$id=$res->get_last_id();
     
     	setcookie(COOKIE_LOGINID,$id,0,$this->get_base_path(),$this->get_base_domain());
     	setcookie(COOKIE_SOCIALLOGIN,"gp",0,$this->get_base_path(),$this->get_base_domain());
     	setcookie(COOKIE_SOCIALLOGINEMAIL,$email,0,$this->get_base_path(),$this->get_base_domain());
     
        echo '<script type="text/javascript">window.opener.location.reload(true);</script>';
     	echo '<script type="text/javascript">window.close();</script>';
     		
     	//header("Location: ".$this->make_base_url("user/home"));
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
     		setcookie(COOKIE_SOCIALLOGIN,"gp",0,$this->get_base_path(),$this->get_base_domain());
     		setcookie(COOKIE_SOCIALLOGINEMAIL,$email,0,$this->get_base_path(),$this->get_base_domain());
     	?>
   		<script type="text/javascript">window.opener.location.reload(true);window.close();</script>;
   		<?php 
     	//header("Location: ".$this->make_base_url("user/home"));
		exit;
     	}
     }
}
else
{
    //get google login url
    try
    {
   		$authUrl = $gClient->createAuthUrl();
    }
	catch(Exception $e)
	{
		//echo $e;die;
	}
}


if(isset($authUrl) && $gpsuccess==0 && Settings::get_instance()->read('gp_login_enabled') ==1) //user is not logged in, show login button
{
	header("Location:".$authUrl);
	exit;
    //echo '<a href="'.$authUrl.'"><img src="images/logingoogle.png" class="logingoogle"/></a>';
}
?>