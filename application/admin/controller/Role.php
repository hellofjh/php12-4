<?php
namespace app\admin\controller;
use think\Db;

class Role extends Common{

	public function add(){
		if($this->request->isGet()){
			return $this->fetch();
		}

		$data = db('Role')->insert(input());
		if($data){
			$this->success('ok','index');
		}
	}

	public function index(){
		if($this->request->isGet()){
			$data = db('Role')->select();
			$this->assign('data',$data);
			return $this->fetch();
		}
	}

	public function edit(){
		$role_id = input('id');
		// 保留超级管理员不容许修改
		if($role_id<=1){
			$this->error('参数错误');
		}
		if($this->request->isGet()){
			$info = Db::name('role')->where('id',$role_id)->find();
			$this->assign('info',$info);
			return $this->fetch();
		}
		Db::name('role')->update(input());
		$this->success('ok','index');
	}

	public function del(){
		$role_id = input('id');
		// 保留超级管理员不容许修改
		if($role_id<=1){
			$this->error('参数错误');
		}
		Db::name('role')->where('id',$role_id)->delete();
		$this->success('ok','index');
	}

	// 为角色分配权限
	public function disfetch()
	{
		// 显示所有的权限
		if($this->request->isGet()){
			// 获取所有的权限
			$rules = model('Rule')->getRules();
			// dump($rules);
			$this->assign('rules',$rules);
			return $this->fetch();
		}
		$role_id = input('id');
		// 接受提交的权限的id
		$rule_ids = input('rule/a');
		// 将权限id转换为字符串格式
		$rule_ids = implode(',', $rule_ids);
		Db::name('Role')->where('id',$role_id)->update(['rule_ids'=>$rule_ids]);
		$this->success('ok','index');
	}

}