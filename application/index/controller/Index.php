<?php
namespace app\index\controller;
use think\Db;

class Index extends Common
{
   
   public function index(){

   		$data = [];
   		$data['hot'] = db('Goods')->where('is_hot',1)->order('id desc')->limit(5)->select();
   		$data['rec'] = db('Goods')->where('is_rec',1)->order('id desc')->limit(5)->select();
   		$data['new'] = db('Goods')->where('is_new',1)->order('id desc')->limit(5)->select();
   		// dump($data);exit;
   		$this->assign('data1',$data);
   		//赋值区分首页
   		$this->assign('homepage',1);
   		return $this->fetch();	
   }

}
