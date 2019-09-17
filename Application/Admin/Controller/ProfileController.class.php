<?php 
namespace Admin\Controller;

//用户管理 控制器
class ProfileController extends AdminController
{
	private $code;//短信验证

	//用户信息
	public function index ()
	{
		$uid = $_SESSION['admin_user']['id'];
		$info = M('user_info')
				->where(array('uid'=>$uid))
				->select();
		$data = $info['0'];
		$data['id'] = $uid;
		$data['username'] = $_SESSION['admin_user']['username'];
		$data['name'] = $_SESSION['admin_user']['name'];
		$this->assign('data',$data);
		$this->display('index');
	}



	public function reset ()
	{
		$a = rand('10000','99999');
		$_SESSION['code'] = $a;
		send_sms_code('18516051096',$a);
	}


}