<?php
namespace app\admin\controller;
use think\Db;

/**
* 
*/
class Type extends Common
{
	
	public function index(){
		
		$data = db('type')->select();
		$this->assign('data',$data);
		if($this->request->isGet()){
			return $this->fetch();
		}

	}

	public function add(){
		if($this->request->isGet()){
			return $this->fetch();
		}
		db('type')->insert(input());
		$this->success('ok','index');
	}

	public function del(){
		$id = input('id');
		db('type')->where('id',$id)->delete();
		$this->success('ok','index');
	}

	public function edit(){
		$id = input('id');
		if($this->request->isGet()){
			$info = db('type')->where('id',$id)->find();
			$this->assign('info',$info);
			return $this->fetch();
		}

		$data = input();
		db('type')->where('id',$id)->update($data);
		$this->success('ok','index');
	}

}