<?php
include_once COMMON_DIR_PATH.DS.'helpers'.DS."login-helper.php";
include_once(LIB_DIR_PATH."FCKeditor/fckeditor.php") ;
class EmailtemplateController extends AppController
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
		$this->set_title($this->get_label('email templates'));
		$db= DBLayer::get_instance();
		$sql="select * from ".TABLE_PREFIX."emailtemplates order by id desc";
		$res=$db->execute_query($sql);
		$this->set_result('res', $res);
	}

	
	function edit_action()
	{
		$this->set_title($this->get_label('edit email templates'));
		
		
		$db= DBLayer::get_instance();
		

		if($_POST)
		$id=$this->read_post_param('id');
        else 
        $id=$this->read_page_param(1);	
		
 		if(!$this->get_emailtemplate_exists($id))
		{
		$this->flash($this->get_message('template invalid'), $this->make_url('emailtemplate/manage'),0);
		exit;
		}
		
		
		if($_POST)
		{
			$sub=$this->read_post_param('sub');
			$body=$this->read_post_param('body');
			
		
			$this->set_variable("id",$id);
			$this->set_variable("sub",$sub);
			$this->set_variable("body",$body,0);
			
			if($body=="" || $id=="" || $sub=="")
			{
				$this->set_notice("mandatory");
			}
			else
			{
				$sql="update ".TABLE_PREFIX."emailtemplates set sub=?,body=? where id=?";
				$res=$db->execute_query($sql,array($sub,$body,$id));
				
				$this->flash($this->get_message('emailtemplate edited'), $this->make_url('emailtemplate/manage'));
				exit;
			}
		}
		else 
		{
			$sql="select * from ".TABLE_PREFIX."emailtemplates where id=?";
			$res=$db->execute_query($sql,array($id));
			$row=$res->fetch_assoc();
			$this->set_variable("id",$row['id']);
			$this->set_variable("sub",$row['sub']);
			$this->set_variable("body",$row['body'],0);
		}

		
	}


};
?>