<?php
include_once COMMON_DIR_PATH.'helpers'.DS."login-helper.php";
include_once COMMON_DIR_PATH.'helpers'.DS."utility-helper.php";
class UserController extends AppController
{
function before_execute()
	{
		if(LoginHelper::validate_admin_login()==0)
			{
				$this->flash($this->get_message('login failed'), $this->make_url('index/index'),0);
			}
	}
	
	function manage_action()
	{
		$this->set_title($this->get_label('manage user'));
		
		$db=DBLayer::get_instance();
		
		if($_POST)
		{
			$status=$this->read_post_param("status");
		}
		else 
		{
			$status=$this->read_page_param(1);
		}
		
		if($status=="")
		$status=-1;
		
		
		$this->set_variable("status",$status);
		
		$status_str="";
		if($status !=-1)
		{
			$status_str=" where status=?";
		}
		else 
		{
			$status_str="where 1=?";
			$status="1";
		}
	
		$sql="select * from ".TABLE_PREFIX."users ".$status_str." order by id desc";
		$pagination = new Pagination($sql,array($status));
		$res=$pagination->get_result();
		$this->set_result("res",$res);
		$this->set_variable("pagination",$pagination->links(),0);

	}

	function block_action()
	{

		$id=$this->read_page_param(1);
		$from=$this->read_page_param(2);
		
		$profile=$from;
		if($from=="p")
			$from="";
		
		if(!$this->get_user_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/manage/'.$from),0);
			exit;
		}
		
		$db=DBLayer::get_instance();
		if(!DEMO_MODE ||(DEMO_MODE == TRUE && $row['id']!=1))
		{
			$db->execute_query("update ".TABLE_PREFIX."users set status=0 where id=?",array($id));
			
			$uname=$this->get_user_name($id);
			$email=$this->get_user_email($id);
			
			$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=4";// to user.. Account Status Updated - Inactive
			$res1=$db->execute_query($query1);
			$result1=$res1->fetch_assoc();
			$subject=$result1['sub'];
			$message=$result1['body'];
			
			$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
			$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
				
			$message=str_replace("{NAME}",$uname,$message);
			$message=str_replace("{STATUS}",$this->get_label('inactive'),$message);
			
			UtilityHelper::send_mail($email,$subject,nl2br($message));
			
			if($profile=="p")
				$this->flash($this->get_message('user blocked'), $this->make_url('user/profile/'.$id));
			else
				$this->flash($this->get_message('user blocked'), $this->make_url('user/manage/'.$from));
			die;
		}
		else
		{
			$this->flash($this->get_message('demo mode'), $this->make_url('user/manage/'.$from));
			exit;
		}
	}
	
	function delete_action()
	{
		
		$id=$this->read_page_param(1);
		$from=$this->read_page_param(2);
		
		if(!$this->get_user_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/manage/'.$from),0);
			exit;
		}
		

		$db=DBLayer::get_instance();
		$res=$db->execute_query("delete from ".TABLE_PREFIX."users where id=?",array($id));
		$res=$db->execute_query("delete from ".TABLE_PREFIX."user_address where user_id=?",array($id));
		$res=$db->execute_query("delete from ".TABLE_PREFIX."product_rating where user_id=?",array($id));
		$res=$db->execute_query("delete from ".TABLE_PREFIX."wishlist where user_id=?",array($id));
		
		
		
		
		
		$this->flash($this->get_message('user deleted'), $this->make_url('user/manage'));
		exit;
	}

	function activate_action()
	{
		$id=$this->read_page_param(1);
		$from=$this->read_page_param(2);
		$profile=$from;
		if($from=="p")
			$from="";
		
		if(!$this->get_user_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/manage/'.$from),0);
			exit;
		}
		$db=DBLayer::get_instance();
		$db->execute_query("update ".TABLE_PREFIX."users set status=1 where id=?",array($id));
		
		$uname=$this->get_user_name($id);
		$email=$this->get_user_email($id);
			
		$query1="select sub,body from ".TABLE_PREFIX."emailtemplates where id=4";// to user.. Account Status Updated - Active
		$res1=$db->execute_query($query1);
		$result1=$res1->fetch_assoc();
		$subject=$result1['sub'];
		$message=$result1['body'];
			
		$subject=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$subject);
		$message=str_replace("{ENGINE}",Settings::get_instance()->read('engine_name'),$message);
		
		$message=str_replace("{NAME}",$uname,$message);
		$message=str_replace("{STATUS}",$this->get_label('active'),$message);
			
		UtilityHelper::send_mail($email,$subject,nl2br($message));
		
		if($profile=="p")
			$this->flash($this->get_message('user activated'), $this->make_url('user/profile/'.$id));
		else
			$this->flash($this->get_message('user activated'), $this->make_url('user/manage'));
		die;

	}
	
	function profile_action()
	{
		$this->set_title($this->get_label('user profile'));
		
		$id=$this->read_page_param(1);
		
		if(!$this->get_user_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/manage'),0);
			exit;
		}
		
		$db=DBLayer::get_instance();
		$sql="select * from ".TABLE_PREFIX."users where id=?";
		$res=$db->execute_query($sql,array($id));
		$this->set_result('res', $res);
	}
	
	function order_items_action()
	{
		
		$this->disable_notice_area();
		$db=DBLayer::get_instance();
		
		$id=$this->read_page_param(1);
		
		$uid=$this->set_variable("uid",$id);
		
		if(!$this->get_user_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/manage'),0);
			exit;
		}
		
		
		$sql="select * from ".TABLE_PREFIX."order where user_id=? order by id desc";
		
		$pagination1 = new Pagination($sql,array($id));
		$res2=$pagination1->get_result();
		$this->set_result("res2",$res2);
		$this->set_variable("pagination1",$pagination1->links(),0);
	}
	
	function wishlist_items_action()
	{
		$db=DBLayer::get_instance();
		$this->disable_notice_area();
		$id=$this->read_page_param(1);
		
		if(!$this->get_user_exists($id))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/manage'),0);
			exit;
		}
		
		$sql1="select * from ".TABLE_PREFIX."wishlist where user_id=? order by id desc";
		$pagination = new Pagination($sql1,array($id));
		$res1=$pagination->get_result();
		$this->set_result("res1",$res1);
		$this->set_variable("pagination",$pagination->links(),0);
	}

	function login_action()
	{
		$uid=$this->read_page_param(1);
		
		
		if(!$this->get_user_exists($uid))
		{
			$this->flash($this->get_message('invalid id'), $this->make_url('user/manage'),0);
			exit;
		}
		
		$db= DBLayer::get_instance();
		$sql1="select email,password from ".TABLE_PREFIX."users where id=?";
		$res1=$db->execute_query($sql1,array($uid));
		$value1=$res1->fetch_assoc();
		$username=$value1['email'];
		$password=$value1['password'];
		
		setcookie(COOKIE_LOGINID,$uid,0,$this->get_base_path(),$this->get_base_domain());
		setcookie(COOKIE_USERNAME,$username,0,$this->get_base_path(),$this->get_base_domain());
		setcookie(COOKIE_PASSWORD,$password,0,$this->get_base_path(),$this->get_base_domain());
		
		header("Location: ".$this->make_base_url("user/home"));
		exit;
	}
	
};
?>