<?php 
namespace Admin\Controller;

class BlogrollController extends AdminController
{
    // 显示友情链接列表
    public function index()
    {
        $blogroll = M('blogroll');//实例化blogroll对象
        $count = $blogroll->count();//查询满足条件的总记录数
        $Page = new \Think\Page($count,5);//实例化分页类 传入总数和每页显示数
        // 定制分页样式
        $Page->setConfig('header','<span class="total">共<b>%TOTAL_ROW%</b>条数据，第<b>%NOW_PAGE%</b>页/共<b>%TOTAL_PAGE%</b>页</span>');
        $Page->setConfig('prev','上一页');
        $Page->setConfig('next','下一页');
        $Page->setConfig('last','末页');
        $Page->setConfig('first','首页');
        $Page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END% %HEADER%');
        $show = $Page->show();//分页显示输出
        // 进行分页数据查询 limit方法的参数要使用page类的属性
        $list = $blogroll
                ->order('id')
                ->limit($Page->firstRow.','.$Page->listRows)
                ->select();
        // V($list);exit;
        $this->assign('list', $list);//赋值数据集
        $this->assign('page',$show);//赋值分页输出
        $this->display('Blogroll/index');//输出模板
    }


    // 删除友情链接
    public function delete()
    {
        if(D('Blogroll')->delete($_GET['id']) > 0){
            $this->success("删除成功！",U('Blogroll/index'));
        }else{
            $this->error("删除失败鸟...");
        }
    }

    // 添加友情链接
    public function doadd()
    {
            $a = $_POST;
            // V($a);die;
            if(!D('Blogroll')->create()){
                $this->error(D('Blogroll')->getError());
                exit;
            }

            if(D('Blogroll')->add($a) > 0){
                $this->success("添加成功！",U('Blogroll/index'));
            }else{
                $this->error("添加失败！");
            }
        
    }

    // 加载修改友情链接
    public function edit()
    {
        //查出数据
        $data = D('blogroll')->where(array('id'=>array('eq',I('id'))))->find();
        // V($data);exit;
        // 向模板分配数据
        $this->assign('vo', $data);
        $this->display('Blogroll/edit');
    }

    // 执行修改友情链接
    public function save()
    {
        if(!D('Blogroll')->create()){
                $this->error(D('Blogroll')->getError());
                exit;
            }
            // $a=$_POST;
            // V($a);eixt;
            //执行修改 
            if(D('Blogroll')->save() >= 0){
                $this->success("修改成功！",U('Blogroll/index'));
            }else{
                $this->error("修改失败");
            }
    }


}