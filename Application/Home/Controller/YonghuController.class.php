<?php 
namespace Home\Controller;

//用户管理 控制器
class YonghuController extends BaseController
{
	private $_model = null; //数据库操作类

	//执行添加操作
	public function doadd()
	{
		if(!D('Yonghu')->create()){
			$this->error(D('Yonghu')->getError());
			exit;
		}

		if(D('Yonghu')->add() > 0){
			$this->success("注册成功！",U('Public/login'));
		}else{
			$this->error("添加失败！");
		}
	}
	
	//执行添加操作
	public function index()
	{
		// exit;
		$this->display();
	}

	//删除操作
	public function del()
	{
		//把用户角色表中相关的也删除
		if($this->_model->delete($_GET['id']) > 0 && $this->_user_role->where(array('uid'=>array('eq',$_GET['id'])))->delete()){
			$this->success("删除成功！",U('User/index'));
		}else{
			$this->error("删除失败");
		}
	}

	//加载修改页面
	public function edit()
	{
		//查出数据
		$vo = $this->_model->where(array('id'=>array('eq',I('id'))))->find();
		//向模板分配数据
		$this->assign('vo', $vo);
		//加载模板
		$this->display();
	}

	//执行修改操作
	public function save()
	{
		//初始化
		if(!$this->_model->create()){
			$this->error($this->_model->getError());
			exit;
		}
		//执行修改 
		if($this->_model->save() >= 0){
			$this->success("修改成功！",U('User/index'));
		}else{
			$this->error("修改失败");
		}
	}

	//浏览 角色信息
	public function rolelist()
	{
		//查询节点信息
		$list = $this->_role->where('status=1')->select();
		//查询当前用户信息
		$users = $this->_model->where(array('id'=>array('eq',I('id'))))->find();

		//获取当前用户的角色信息
		$rolelist = $this->_user_role->where(array('uid'=>array('eq',I('id'))))->select();

		$myrole = array(); //定义空数组
		//对用户的角色进行重组
		foreach($rolelist as $v){
			$myrole[] = $v['rid'];
		}

		//分配数据
		$this->assign("list",$list);
		//分配当前用户信息
		$this->assign('users',$users);
		//分配该用户的角色信息
		$this->assign('role',$myrole);

		//加载模板
		$this->display();
	}

	//保存用户角色
	public function saverole()
	{
		//判读必须选择一个角色
		if(empty($_POST['role'])){
			$this->error("请选择一个角色！");
		}
		$uid = $_POST['uid'];
		//清除用户所有的角色信息，避免重复添加
		$this->_user_role->where(array('uid'=>array('eq',$uid)))->delete();

		foreach(I('role') as $v){
			$data['uid'] = $uid;
			$data['rid'] = $v;
			//执行添加
			$this->_user_role->data($data)->add();
		}

		$this->success("角色分配成功",U('User/index'));

	}

	public function doajax()
	{
		// 验证账号
		$name = trim($_POST['username']);
		$namelist = M('yonghu')->where(array('tel'=>array('eq', $name)))->find();
		if ($namelist) {
			// 验证密码
		$pwd = md5(trim($_POST['password']));
		// var_dump($pwd);array('tel'=>array('eq', $name))
		$pwdlist = M('yonghu')->where(array('tel'=>array('eq', $name),'pwd'=>array('eq',$pwd)))->find();
			if ($pwdlist) {
				echo '密码正确';
			} else {
				echo '密码不匹配';
			}
		}else{
			echo '用户不存在';
		}

		

	}


}