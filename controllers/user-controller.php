<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";
class UserController extends AppController
{
	function before_execute()
	{
		if($this->get_action()=="home" || $this->get_action()=="change_password" || $this->get_action()=="payments" || $this->get_action()=="wishlist" || $this->get_action()=="edit_profile"  || $this->get_action()=="edit_address" || $this->get_action()=="manage_address" || $this->get_action()=="add_address")
		{
		    if(LoginHelper::validate_user_login()==0)
			$this->flash($this->get_message('login to continue'), $this->make_url('user/login'),0);
		}
	}

	function email_check_action()
	{
		$db= DBLayer::get_instance();
		$username=$this->read_page_param(1);
		
		if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$username)) 
		{
			echo 'error';
			die;
		}
		
		$id=$db->read_single_column("select id from ".TABLE_PREFIX."users where email=?",array($username));
	
		if($id >0)
		echo "unavailable";
		else
		echo "available";
		
		die;
	}
	
	
	function register_action()
	{
		if(LoginHelper::validate_user_login()!=0)
		{
			header("Location:".$this->make_url('user/home'));
			exit;
		}
		$this->set_title($this->get_label('register'));
		$min_pass_len=Settings::get_instance()->read('min_pass_len');
		$email=$pwd=$rpwd=$name="";
		if(isset($_POST['email']))
		{
			$email=$this->read_post_param('email');
			$pwd=$this->read_post_param('pwd');
			$rpwd=$this->read_post_param('rpwd');
			$name=$this->read_post_param('name');
			$terms=$this->read_post_param("terms");
			if($email==""||$pwd==""||$rpwd=="" || $name=="")
			{
				$this->set_notice("mandatory");
			}
			elseif(DBLayer::get_instance()->read_single_column("select id from ".TABLE_PREFIX."users where email=?", array($email)))
			{
				$this->set_notice("email not available");
			}
			elseif(!UtilityHelper::is_valid_email($email))
			{
				$this->set_notice("email format");
			}
			elseif((strlen($pwd)<$min_pass_len) || (strlen($rpwd)<$min_pass_len) )
			{
				$this->set_notice("password length");
			}
			elseif($pwd!=$rpwd)
			{
				$this->set_notice("password mismatch");
			}
			elseif($terms !=1)
			{
				$this->set_notice("terms condition agree");
			}
			else
			{
				$db= DBLayer::get_instance();
				$t=time();
				$res=$db->execute_query("INSERT INTO ".TABLE_PREFIX."users (`password`,`name`,`email`,joindate,status,image,last_login) values (?,?,?,?,?,?,?)",array(md5($pwd),$name,$email,$t,-2,'',0));
				$id=$res->get_last_id();
				
				$confirmurl=BASE."index.php?page=user/confirm_email/".$id."/".$this->mybase64_encode($email)."/".md5($id.$email);
				
				$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=2");
				$result1=$res1->fetch_assoc();
				$subject=$result1['sub'];
				$message=$result1['body'];
				
				
				$subject=str_ireplace('{ENGINE}', Settings::get_instance()->read('engine_name'),$subject);
				$message=str_ireplace('{ENGINE}', Settings::get_instance()->read('engine_name'),$message);
				$message=str_ireplace('{NAME}',$name,$message);
				$message=str_ireplace('{CONFIRMURL}', $confirmurl,$message);
				
				UtilityHelper::send_mail($email,$subject,$message);
				
				$this->flash($this->get_message('registration success'), BASE);
				die;
				
			}
	  }	
		
		$this->set_variable("min_pass_len",$min_pass_len);
		$this->set_variable("name",$name);
		$this->set_variable("email",$email);
		$this->set_variable("pwd",$pwd);
		$this->set_variable("rpwd",$rpwd);
		
	}
	
	function confirm_email_action()
	{
		$uid=$this->read_page_param(1);
		$email=$this->mybase64_decode($this->read_page_param(2));
		$mdvalue=$this->read_page_param(3);
		$set_time=0;
	
		$mdvalue_new=md5($uid.$email);
	
		if($mdvalue_new != $mdvalue)
		{
			$this->flash($this->get_message('invalid operation'),BASE);
			exit;
		}
		else
		{
			$db= DBLayer::get_instance();
	
			$res=$db->execute_query("select email,status,password from ".TABLE_PREFIX."users where id=?",array($uid));
			$result=$res->fetch_assoc();
			$email=$result['email'];
			$status=$result['status'];
			$password=$result['password'];
			$name=$result['name'];
	
			if($status==-2)
			{
				$t=time();
				$res=$db->execute_query("update ".TABLE_PREFIX."users set status=?,last_login=? where id=?",array(1,$t,$uid));
	
				setcookie(COOKIE_LOGINID,$uid,0,$this->get_base_path(),$this->get_base_domain());
				setcookie(COOKIE_USERNAME,$email,0,$this->get_base_path(),$this->get_base_domain());
				setcookie(COOKIE_PASSWORD,$password,0,$this->get_base_path(),$this->get_base_domain());
	
				setcookie(COOKIE_SOCIALLOGIN,"",0,$this->get_base_path(),$this->get_base_domain());
				setcookie(COOKIE_SOCIALLOGINEMAIL,"",0,$this->get_base_path(),$this->get_base_domain());
				setcookie(COOKIE_FBLOGINSUCCESS,"",0,$this->get_base_path(),$this->get_base_domain());
				setcookie(COOKIE_GPTOKEN,"",0,$this->get_base_path(),$this->get_base_domain());
	
				$res1=$db->execute_query("select sub,body from ".TABLE_PREFIX."emailtemplates where id=1");
				$result1=$res1->fetch_assoc();
	
				$subject=$result1['sub'];
				$message=$result1['body'];
	
				$message=str_ireplace("{ENGINE}", Settings::get_instance()->read('engine_name'),$message);
				$subject=str_ireplace("{ENGINE}", Settings::get_instance()->read('engine_name'),$subject);
	
				$message=str_ireplace("{NAME}", $name,$message);
				$message=str_ireplace("{EMAIL}", $email,$message);
				
				UtilityHelper::send_mail($email, $subject, $message);
				
				$this->flash($this->get_message('reg success'), $this->make_base_url('user/home'));
				exit;
			}
			else
			{
				$this->flash($this->get_message('invalid operation'),BASE,0);
				exit;
			}
		}
	}
	
	function home_action()
	{
		$this->set_title($this->get_label('home'));	
		$db= DBLayer::get_instance();
		$user_id=$this->read_cookie_param(COOKIE_LOGINID);
		$tot=$db->read_single_column("select count(id) from ".TABLE_PREFIX."order where user_id=?",array($user_id));
		$this->set_variable("tot",$tot);
		$this->set_variable("user_id",$user_id);
		
		$sql="select * from ".TABLE_PREFIX."order where user_id=? order by order_date desc";
		$pagination = new Pagination($sql,array($user_id));
		$res=$pagination->get_result();
		$this->set_result("orderitem",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	}
	
	function payments_action()
	{
		$db=DBLayer::get_instance();
		$uid=$this->read_cookie_param(COOKIE_LOGINID);
		$query = "select * from ".TABLE_PREFIX."payment_summary where uid=? ORDER BY id desc";
		$pagination = new Pagination($query,array($uid));
		$res=$pagination->get_result();
		$this->set_result("res",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	
	}
	
	function login_action()
	{
		
		if(LoginHelper::validate_user_login()!=0)
		{
			header("Location:".$this->make_url('user/home'));
			exit;
		}
		
		$db= DBLayer::get_instance();
		
		if($_POST)
		{
				$msg="";
				$username=$this->read_post_param('username');
				$password=$this->read_post_param('password');
				
				if($username=="" || $password=="")
				{
					$this->set_notice('mandatory');
				}
				else
				{
				$this->set_variable('username',$username);
				$this->set_variable('password',$password);
				
				$query="select id from ".TABLE_PREFIX."users where email=? and password=?";
				$res=$db->execute_query($query,array($username,md5($password)));
				
				$value2=$res->fetch_assoc();
				$id=$value2['id'];
				$orig_password=$db->read_single_column("select password from ".TABLE_PREFIX."users where email=? and status=1", array($username));

				if(md5($password)== $orig_password)
				{
						$t=time();
						$sql="update ".TABLE_PREFIX."users set last_login=? where id=?";
						$res=$db->execute_query($sql,array($t,$id));
						
						setcookie(COOKIE_LOGINID,$id,0,$this->get_base_path(),$this->get_base_domain());
						setcookie(COOKIE_USERNAME,$username,0,$this->get_base_path(),$this->get_base_domain());
						setcookie(COOKIE_PASSWORD,$orig_password,0,$this->get_base_path(),$this->get_base_domain());
						
						setcookie(COOKIE_SOCIALLOGIN,"",0,$this->get_base_path(),$this->get_base_domain());
						setcookie(COOKIE_SOCIALLOGINEMAIL,"",0,$this->get_base_path(),$this->get_base_domain());
						setcookie(COOKIE_FBLOGINSUCCESS,"",0,$this->get_base_path(),$this->get_base_domain());
						setcookie(COOKIE_GPTOKEN,"",0,$this->get_base_path(),$this->get_base_domain());
				
					$this->flash($this->get_message('login success'), $this->make_url('user/home'));						
		}
		else
		{
			$this->set_notice('invalid login');
		}
		}
		}
		
		if($this->read_page_param(1)=="expired")
		{
			$msg= "login exp";
			$this->set_notice($msg);
		}
		else if($this->read_page_param(1)=="logout")
		{
			$msg="logout";
			$this->set_notice($msg,1);
		}
		
		if(DEMO_MODE)
		{
			$username=$db->read_single_column("select email from ".TABLE_PREFIX."users where id=1");
			$password="demo";
				
			$this->set_variable('username',$username);
			$this->set_variable('password',$password);
		}
		else
		{
			$this->set_variable('username','');
			$this->set_variable('password','');
		}
		
	}

	function logout_action()
	{
		setcookie(COOKIE_LOGINID,"",0,$this->get_base_path(),$this->get_base_domain());
		setcookie(COOKIE_USERNAME,"",0,$this->get_base_path(),$this->get_base_domain());
		setcookie(COOKIE_PASSWORD,"",0,$this->get_base_path(),$this->get_base_domain());
		
		setcookie(COOKIE_SOCIALLOGIN,"",0,$this->get_base_path(),$this->get_base_domain());
		setcookie(COOKIE_SOCIALLOGINEMAIL,"",0,$this->get_base_path(),$this->get_base_domain());
		setcookie(COOKIE_FBLOGINSUCCESS,"",0,$this->get_base_path(),$this->get_base_domain());
		setcookie(COOKIE_GPTOKEN,"",0,$this->get_base_path(),$this->get_base_domain());
		
		header("Location: ".$this->make_url("user/login/logout"));
		die;
	}

	function change_password_action()
	{
		$this->set_title($this->get_label('change password'));
		if(!DEMO_MODE || (DEMO_MODE ==TRUE && $this->read_cookie_param(COOKIE_LOGINID) !=1 ))
		{		
				
				$min_pass_len=Settings::get_instance()->read('min_pass_len');
				
				if($_POST)
				{
								
					$current_pwd=$this->read_post_param('current_pwd');
					$pwd=$this->read_post_param('pwd');
					$rpwd=$this->read_post_param('rpwd');
					if($current_pwd=="" || $pwd==""||$rpwd=="")
					{
						$this->set_notice("mandatory");
					}
					else if(md5($current_pwd)!=DBLayer::get_instance()->read_single_column("select password from ".TABLE_PREFIX."users where id=?", 
							array($this->read_cookie_param(COOKIE_LOGINID))))
					{
						$this->set_notice("password wrong");
					}
					else if((strlen($pwd)<$min_pass_len) || (strlen($rpwd)<$min_pass_len) )
					{
						$this->set_notice("password length");
					}
					else if($pwd!=$rpwd)
					{
						$this->set_notice("password mismatch");
					}
					else
					{
						$id=$this->read_cookie_param(COOKIE_LOGINID);
						$db= DBLayer::get_instance();
						$sql="update ".TABLE_PREFIX."users set password=? where id=?";
						$res=$db->execute_query($sql,array(md5($pwd),$id));
						
						setcookie(COOKIE_PASSWORD,md5($pwd),0,$this->get_base_path(),$this->get_base_domain());
						
						$this->flash($this->get_message('password resetted'), $this->make_url('user/change_password'));
						die;
					}
				
				$this->set_variable("pwd",$pwd);
				$this->set_variable("rpwd",$rpwd);
				$this->set_variable("current_pwd",$current_pwd);
				}
				
				$this->set_variable("min_pass_len",$min_pass_len);
				
		}
		else 
		{
			$this->flash($this->get_message('demo mode'), BASE);
			exit;
		}		
			
	}
	
	function reset_password_action()
	{
		$this->set_title($this->get_label('reset password'));
		$username="";
		
	if($_POST)
	{
		$db= DBLayer::get_instance();
		$username=$this->read_post_param('username');
		
		$demo_id=$db->read_single_column("select id from ".TABLE_PREFIX."users where email=?",array($username));
		
		
		if(!DEMO_MODE || (DEMO_MODE ==TRUE && $demo_id !=1 ))
		{
	
					if($username=="")
					{
						$this->set_notice("mandatory");
					}
					else
					{
						
						$query="select email,password,name from ".TABLE_PREFIX."users where email=?";
						$res=$db->execute_query($query,array($username));
						$result=$res->fetch_assoc();
						$email=$result['email'];
						$password=$result['password'];
						$name=$result['name'];
			
						if($email=="")
						{
							$this->set_notice("user not exist");
						}
						else
						{
							$newpass=substr($password,0,8);
							$newpassword=md5($newpass);
							$up="update ".TABLE_PREFIX."users set password=? where email=?";
							$up1=$db->execute_query($up,array($newpassword,$username));
							$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=3";
							$res1=$db->execute_query($query1);
							$result1=$res1->fetch_assoc();
							$subject=$result1['sub'];
							$message=$result1['body'];
							
							$subject=str_replace("{ENGINE}", Settings::get_instance()->read('engine_name'),$subject);
							$message=str_replace("{ENGINE}", Settings::get_instance()->read('engine_name'),$message);
							
							$message=str_replace("{NAME}", $name,$message);
							$message=str_replace("{PASSWORD}", $newpass,$message);
							UtilityHelper::send_mail($email, $subject, $message);
							
							$this->flash($this->get_message('password resetted'), $this->make_url('user/login'));
						}
					}
		 }
		 else
		 {
		       	$this->flash($this->get_message('demo mode'), $this->make_url('user/login'));
		       	exit;
		 }	
				
	}
	$this->set_variable("username",$username);
 }
	
	
	function contact_us_action()
	{	
		$this->set_title($this->get_label('contact us'));
		$uid=$this->read_cookie_param(COOKIE_LOGINID);
		$this->set_variable('uid', $uid);
		$db= DBLayer::get_instance();
		
		if($_POST)
		{
			$xyz_email=Settings::get_instance()->read('general_notification_email');
			$email=$this->read_post_param('email');
			$subject=$this->read_post_param('subject');
			$query=$this->read_post_param('query');
			
			if((LoginHelper::validate_user_login()==0))
			{
				$usr="New Contact";
				$this->set_variable("emailenter",$email);	
					
			}
			else
			{
				
				$username=$this->read_cookie_param(COOKIE_USERNAME);
				$usr=$username."'s Support Request";
			}
			
			
			$this->set_variable("subject",$subject);
			$this->set_variable("query",$query);
			if($email =="" || $subject =="" || $query =="")
			{
				$this->set_notice("mandatory");
			}
			else if(!UtilityHelper::is_valid_email($email))
			{
				$this->set_notice("email format");
			}
			else 
			{
				
			$subject1=$usr."-".$subject;
			UtilityHelper::send_mail($xyz_email, $subject1, nl2br($query),"",$email,$email);
			
			$this->flash($this->get_message('query submitted'), $this->make_url('user/contact_us'));
			exit;	
				
			}
			
		}
	}
		
	
	
	function edit_profile_action()
	{
	
		$userid=$this->read_cookie_param(COOKIE_LOGINID);
		$db= DBLayer::get_instance();
		$sql="select name,email from ".TABLE_PREFIX."users where id=?";
		$res=$db->execute_query($sql,array($userid));
		$row=$res->fetch_assoc();
		$this->set_variable("userid",$userid);
		$this->set_variable("name",$row['name']);
		$this->set_variable("email",$row['email']);
		
		if($_POST)
		{
			$name=$this->read_post_param('name');
			$id=$this->read_cookie_param(COOKIE_LOGINID);
			if($name=="")
			{
				$this->set_notice("mandatory");
			}
			else{
					$sql="update ".TABLE_PREFIX."users set name=? where id=?";
					$res=$db->execute_query($sql,array($name,$id));
					$this->flash($this->get_message('personal info updated'), $this->make_url('user/edit_profile'));
				    exit;
			}
		}
		
	}
	
	
	function wishlist_action()
	{
			
		$id=$this->read_cookie_param(COOKIE_LOGINID);
		$db= DBLayer::get_instance();
		$tot=$db->read_single_column("select count(id) from ".TABLE_PREFIX."wishlist where user_id=?",array($id));
		$this->set_variable("tot",$tot);
		
		$sql="SELECT w.id,w.user_id,w.pro_id,p.name,p.mrp,p.description FROM ".TABLE_PREFIX."wishlist w JOIN ".TABLE_PREFIX."product p ON w.pro_id=p.id WHERE w.user_id=? and p.status=1 order by w.id desc";
		$pagination = new Pagination($sql,array($id));
		$res=$pagination->get_result();
		$this->set_result("wishlist",$res,array('description'));
		$this->set_variable("pagination",$pagination->links(),0);
		
		
	}
	
	function remove_wishlist_action()
	{
		$pro_id=$this->read_page_param(1);
		$id=$this->read_page_param(2);
		$db= DBLayer::get_instance();
		$res=$db->execute_query("delete from ".TABLE_PREFIX."wishlist where id=?",array($id));
		
		
		$count=intval($this->get_wishlist_count());
		
		echo $count; exit;
	}
	
	
	function manage_address_action()
	{
		$this->set_title($this->get_label('manageaddress'));	
		$db= DBLayer::get_instance();
		$user_id=$this->read_cookie_param(COOKIE_LOGINID);
		$tot=$db->read_single_column("select count(id) from ".TABLE_PREFIX."user_address where user_id=?",array($user_id));
		$this->set_variable("tot",$tot);
		
		$sql="select * from ".TABLE_PREFIX."user_address where user_id=? order by id desc";
		$pagination = new Pagination($sql,array($user_id));
		$res=$pagination->get_result();
		$this->set_result("shipaddress",$res);
		$this->set_variable("pagination",$pagination->links(),0);
	}
	
	function add_address_action()
	{
		
		$db= DBLayer::get_instance();
		if($_POST)
		{
			
			$user_id=$this->read_cookie_param(COOKIE_LOGINID);
			$name=$this->read_post_param('name');
			$address1=$this->read_post_param('address1');
			$address2=$this->read_post_param('address2');
			$phone=$this->read_post_param('phone');
			$country=$this->read_post_param('country');
			$city=$this->read_post_param('city');
			$state=$this->read_post_param('state');
			$zipcode=$this->read_post_param('zipcode');
			
			
			$this->set_variable("name",$name);
			$this->set_variable("address1",$address1);
			$this->set_variable("address2",$address2);
			$this->set_variable("phoneno",$phone);
			$this->set_variable("city",$city);
			$this->set_variable("country",$country);
			$this->set_variable("state",$state);
			$this->set_variable("zipcode",$zipcode);
			
			
			
			if($name=="" || $address1=="" || $phone=="" || $country=="" || $city=="" || $state=="" || $zipcode=="")
			{
				$this->set_notice("mandatory");
			}
			else
			{
				$sql="INSERT INTO ".TABLE_PREFIX."user_address (`user_id`,`name`,`address1`,`address2`,`phoneno`,`city`,`country`,`state`,`zipcode`) values (?,?,?,?,?,?,?,?,?)";
				$res=$db->execute_query($sql,array($user_id,$name,$address1,$address2,$phone,$city,$country,$state,$zipcode));
				
				$this->flash($this->get_message('addaddress'), $this->make_url('user/manage_address'));
				die;
			}
		}
		
		$res=$db->execute_query("select * from ".TABLE_PREFIX."countries ORDER BY cname");
		$this->set_result("countries",$res);
		
		
	}
	
	function edit_address_action()
	{
		
			if($_POST)
			$id=$this->read_post_param('address_id');
			else
			$id=$this->read_page_param(1);
		
			$this->set_variable("id",$id);
			
			if(!$this->get_user_address_exists($id))
			{
				$this->flash($this->get_message('invalid id'), $this->make_url('user/manage_address'),0);
				exit;
			}
			
			$db= DBLayer::get_instance();
			
			$res=$db->execute_query("select * from ".TABLE_PREFIX."user_address where id=?",array($id));
			$row=$res->fetch_assoc();
			
			$this->set_variable("name",$row['name']);
			$this->set_variable("address1",$row['address1']);
			$this->set_variable("address2",$row['address2']);
			$this->set_variable("phoneno",$row['phoneno']);
			$this->set_variable("city",$row['city']);
			$this->set_variable("country",$row['country']);
			$this->set_variable("state",$row['state']);
			$this->set_variable("zipcode",$row['zipcode']);
			
			$res=$db->execute_query("select * from ".TABLE_PREFIX."countries ORDER BY cname");
			$this->set_result("countries",$res);
		
		if($_POST)
		{
			$name=$this->read_post_param('name');
			$address1=$this->read_post_param('address1');
			$address2=$this->read_post_param('address2');
			$phone=$this->read_post_param('phone');
			$country=$this->read_post_param('country');
			$city=$this->read_post_param('city');
			$state=$this->read_post_param('state');
			$zipcode=$this->read_post_param('zipcode');
			
			if($name=="" || $address1=="" || $phone=="" || $country=="" || $city=="" || $state=="" || $zipcode=="")
			{
				$this->set_notice("mandatory");
			}
			else
			{
				$sql="update ".TABLE_PREFIX."user_address set name=?,address1=?,address2=?,phoneno=?,city=?,country=?,state=?,zipcode=? where id=?";
				$res=$db->execute_query($sql,array($name,$address1,$address2,$phone,$city,$country,$state,$zipcode,$id));
				$this->flash($this->get_message('updateaddress'), $this->make_url('user/manage_address'));
				die;
			}
		}
		
	}
	function delete_address_action()
	{
		$db= DBLayer::get_instance();
		$id=$this->read_page_param(1);
		$res=$db->execute_query("delete from ".TABLE_PREFIX."user_address where id=?",array($id));
		
		echo "1"; 
		exit;
	}
};
?>