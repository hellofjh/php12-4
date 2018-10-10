<?php
namespace app\admin\controller;
use think\Db;

/**
* 
*/
class Rule extends Common
{
	
	public function add()
	{
		if($this->request->isGet()){
			$data = db('Rule')->select();
			$return = get_cate_tree($data);
			$this->assign('rules',$return); 
			return $this->fetch();
		}

		db('Rule')->insert(input());
		$this->success('ok','index');
	}

	public function index()
	{
		if($this->request->isGet()){
			$data = db('Rule')->select();
			$this->assign('data',$data);
			return $this->fetch();
		}
	}

	public function del(){
		$id = input('id');
		db('Rule')->where('id',$id)->delete();
		$this->success('ok','index');
	}

	public function edit(){
		if($this->request->isGet()){
			$data = db('Rule')->select();
			$return = get_cate_tree($data);
			$this->assign('rules',$return); 

			$id = input('id');
			$show = db('Rule')->where('id',$id)->find();
			$this->assign('show',$show);

			return $this->fetch();
		}

		
		db('Rule')->update(input());
		$this->success('ok','index');
	}

}