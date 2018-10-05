<?php
namespace app\admin\model;
use think\Model;

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
		cookie('admin_id',$user_info->id,$time);

	}

}