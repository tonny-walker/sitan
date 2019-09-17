<?php
namespace Home\Controller;
use Think\Controller;

class PublicController extends Controller 
{
    public function login()
    {
		// 初始化加载友情链接
	    $data2 = M('Blogroll')
	            ->where(array('status'=>array('eq', '1')))
	            ->select();
	    // V($data);die;
	    $this->assign('Blogroll', $data2);
        $this->display('Public/login');
    }

    //执行登陆
	public function dologin()
	{
		//接收用户名和密码
		$username = I('post.username');
		$password = I('post.password');

		// dump($username);
		// dump($password);
		// exit;
		//验证
		$user = M('yonghu');
		$d = $user
			->field('status')
			->where(array('tel'=>$username))
			->find();
		// dump($d);
		// exit;
		if($d['status'] == '0'){
			$this->error('您的账户已被冻结，请联系管理员！');
			exit;
		}
		$data = $user->where(array('tel'=>$username))->find();
		// echo $user->getLastSql();
		// exit;
		if (!$data) {
			$this->error('用户名不存在！');
			exit;
		}
		//验证密码
		if ($data['pwd'] != md5($password)) {
			$this->error('密码不正确');
			exit;
		}
		//把用户信息添加到session
		$_SESSION['user'] = $data;

		//跳转到首页
		$this->redirect('Index/index');
	}


	//退出 
	public function logout()
	{
		//清空session
		unset($_SESSION['user']);
		//跳转
		$this->redirect('Public/login');
	}


}