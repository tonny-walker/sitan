<?php
namespace Admin\Controller;

class IndexController extends AdminController 
{
    public function index()
    {
       $this->redirect('Categorys/index');
    }

}