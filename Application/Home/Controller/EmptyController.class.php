<?php 
namespace Home\Controller;

use Home\Controller\BaseController;
class EmptyController extends BaseController
{

	public function index()
	{
		echo "404<br>";
	}

	public function _empty()
	{
        echo "查无此人";
	}
}