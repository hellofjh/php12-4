<?php
namespace app\index\controller;
use think\Controller;

/*
*	公共控制器
 */

class Common extends Controller
{
    public function __construct()
    {
    	parent::__construct();

    	//获取所有分类
    	$category = db('category')->select();
    	$data = get_cate_tree($category,0,1);
    	// dump($data);
    	$this->assign('data',$data);
    }

}
