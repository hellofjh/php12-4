<?php
namespace app\admin\model;
use think\Model;
use think\Db;

class Admin extends Model{

	public function login(){
		$data = input();
		// 调用第三方验证验证方式
		$captcha = new \think\captcha\Captcha();
		if($captcha->check($data['captcha']) === false){
			$this->error = '验证码错误';
			return false;
		}
		//调用Admin::get查询出对应的数据表行
		$user_info = Admin::get(
				[
					'pwd'=>md5($data['password']),
					'username'=>$data['username']
				]
			);

		if(!$user_info){
			$this->error = '用户名或密码错误';
			return false;
		}

		//保存用户登陆信息
		$time = isset($data['remember'])?3600*24*7:0;
		cookie('admin_info',$user_info->toArray(),$time);

	}

	public function addAdmin(){
		$data = input();
		// dump($data);exit;
		$user_info = Admin::get(['username'=>$data['username']]);
		if($user_info){
			$this->error = "已存在用户名";
			return FALSE;
		}
		
		//密码加密
		$data['pwd'] = md5($data['pwd']);
		return $this->save($data);
	}

	public function updateAdmin()
	{
		// 1、接受参数
		$data = input();
		// 检查用户名对的重复
		$where = [
			'username'=>$data['username'],
			'id'=>['neq',$data['id']]
		];
		$user_info = Admin::get($where);
		if($user_info){
			$this->error = '用户名重复';
			return FALSE;
		}
		if($data['password']){
			// 有提交密码 修改密码
			$data['password']=md5($data['password']);
		}else{
			// 没有提交密码表示不修改
			unset($data['password']);
		}
		return $this->isUpdate(true)->allowField(true)->save($data);
	}

}