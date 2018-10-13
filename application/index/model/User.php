<?php 
namespace app\index\model;
use think\Model;
use think\Db;
/**
* 
*/
class User extends Model
{
	
//----------------------验证码---------------------------
	public function captcha(){
		$data = input();

		// 调用第三方验证验证方式
		$captcha = new \think\captcha\Captcha();

		if($captcha->check($data['captcha']) === false){
			$this->error = '验证码错误';
			return false;
		}
	}
//----------------------短信/用户名/密码验证---------------------------

	public function regist(){
		$data = input();

		if($this->get(['username'=>$data['username']])){
			$this->error = '用户名存在';
			return false;
		}

		if($this->get(['tel'=>$data['tel']])){
			$this->error = '手机号存在';
			return false;
		}

		if($this->get(['username'=>$data['username']])){
			$this->error = '用户名存在';
			return false;
		}

		if(session('telsms')['code'] != $data['telsms']){
			$this->error = '验证码不正确';
			return false;
		}

		$data['salt']=rand(100000,999999);
		$data['pwd']=md6($data['password'],$data['salt']);

		$this->allowField(true)->save($data);

		//销毁session
		session('telsms',null);

	}

}