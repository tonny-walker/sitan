<?php
namespace Home\Controller;

class IndexController extends BaseController 
{
    public function index()
    {
    	$imges = M('himages')
                ->where(array('status'=>array('eq','1')))
                ->select();
    	$this->assign('images',$imges);
        $cimage = M('cimages')->select();
        // var_dump($cimage);
        $this->assign('cimage',$cimage);
        $this->display();
    }


}