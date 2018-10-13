<?php
namespace app\index\controller;
use think\Db;
use think\Request;
use think\Model;

class User extends Common
{

	public function regist(Request $request){

		$model = model('User');//模型
		$db = db('User');//数据表
		//$data = input();

		if($request->isGet()){ return $this->fetch(); }

		//调用模型进行Ajax--用户名校验
		$this->regAjaxUser();

		//短信接口验证
		$this->smsApi();

		//获取验证码
		//$captcha = $model->captcha();
		//验证码返回校验
		//if($captcha === false){ $this->error($model->getError()); }
		
		//调用模型作提交进行各种验证 -- 短信/用户名/密码/
		$result = $model->regist();
		if($result === false){
			$this->error($model->getError());
		}
		$this->success('ok','login');

	}
//----------------------Ajax--用户名校验---------------------------
	public function regAjaxUser(){
		$data = input();
		//获取数据进行Ajax--用户名校验
		$return = db('User')->where('username','=',$data['username'])->select();
		if($return){
			return json(['status'=>0,'msg'=>'用户名已存在']);
		}else{
			return json(['status'=>1,'msg'=>'用户名可用']);
		}
	}


//----------------------验证码---------------------------
	public function captcha(){
		$captcha = new \think\captcha\Captcha();
		return $captcha->entry();
	}



//----------------------调用接口---发送短信验证码---------------------------
	public function smsApi(){
		$tel = input('tel');	//获取提交的手机号码
		$code = rand(1000,9999);	//获取随机数

		$content = get_sms($tel,$code);	//调用公共库接口
		if($content){
		    $result = json_decode($content,true);
		    $error_code = $result['error_code'];
		    if($error_code == 0){
		        //状态为0，说明短信发送成功
		        // echo "短信发送成功,短信ID：".$result['result']['sid'];
		        // 如果成功将随机验证码加入session中
		        session('telsms',['code'=>$code,'time'=>time()]);
		        return json(['status'=>1,'msg'=>'短信发送成功']);
		    }else{
		        //状态非0，说明失败
		        // $msg = $result['reason'];
		        // echo "短信发送失败(".$error_code.")：".$msg;
		        return json(['status'=>0,'msg'=>'短信发送失败']);
		    }
		}else{
		    //返回内容异常，以下可根据业务逻辑自行修改
		    // echo "请求发送短信失败";
		    return json(['status'=>2,'msg'=>'请求发送短信失败']);
		}

		
	}

	public function test(){
		$a = model('User')->regist();
		dump($a);
	}


}