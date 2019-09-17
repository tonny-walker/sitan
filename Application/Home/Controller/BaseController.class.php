<?php 
namespace Home\Controller;
use Think\Controller;

//公共的控制器类
class BaseController extends Controller
{
    //初始化的方法
    public function _initialize()
    {
        // 初始化加载友情链接
        $data2 = M('Blogroll')
                ->where(array('status'=>array('eq', '1')))
                ->select();
        // V($data);die;
        $this->assign('Blogroll', $data2);
    }


}