<?php
namespace app\admin\controller;
// use think\Controller;

class Login extends Common{
	public $is_check_login = false;
//----------------------显示登陆---------------------------
	public function login(){
		// 显示登陆页面
		if($this->request->isGet()){
			return $this->fetch();
		}

		// 提交数据
		$model = model('Admin');
		$result = $model->login();

		if($result === false){
			$this->error($model->getError());
		}
		$this->success('登陆成功','admin/index/index');

	}
//----------------------显示登陆---------------------------

//----------------------退出登陆---------------------------
	public function logout(){
		cookie('admin_id',null);
		$this->success('退出成功','admin/login/login');
	}
//----------------------退出登陆---------------------------

//----------------------验证码---------------------------
	public function captcha(){
		$captcha = new \think\captcha\Captcha();
		return $captcha->entry();
	}
//----------------------验证码---------------------------



}