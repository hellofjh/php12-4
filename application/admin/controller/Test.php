<?php
namespace app\admin\controller;
// use think\Controller;
use think\Request;
use think\Session;
use think\Validate;
// use app\admin\model\Category;

class test extends Common{
	public function index(){
		echo url('admin/test/index',['id'=>5],'','');
	}

	public function requestMethod(Request $request){
		// dump($request->isGet());
		// dump($request->isPost());
		// echo $request->module();
		// echo $request->controller();
		// echo $request->action();
		// echo $request->pathinfo();
		dump(input('get.'));
	}

	public function testrequest(){
		// $data = 1;
		$data = [
			'a'=>['name'=>1,'age'=>2],
			'b'=>['name'=>3,'age'=>4]
		];
		if($this->request->isGet()){
			$this->assign('data',$data);
			return $this->fetch();
		}
		dump(input('one'));
	}

	public function testModel(){
		// $model = model('category');
		// dump($model);
		// $res = Category::get(1);
		// dump($res);
		// $model = model('category');
		$model = new \app\admin\model\Category;
		// dump($model->all(['id'=>['gt',3]]));
		$data = $model->where('id','>',3)->find();
		dump($data->toArray());
	}

	public function SessionT(){
		//设置session--助手函数
		// session('id','123');
		// session('name','123');
		// session('age','123');
		// 获取session
		// session('id');
		// tp方法
		// Session::set('page','1');
		// dump(Session::get('name'));
		// 原始方法
		session_start();
		dump($_SESSION);
	}

	public function Vercode1(){
		// return $this->fetch();
		// session_start();
		// dump($_SESSION);
		// 第三方验证方法调用
		$obj = new \think\captcha\Captcha();
		return $obj->entry();
		// $obj = new \think\captcha\Captcha();
		// dump($obj->check(input('key')));
	}

	public function Vercode(){
		// $obj = new \think\captcha\Captcha();
		// dump($obj->check());
		// dump(password_hash('root', PASSWORD_DEFAULT));
		// $passwordHash=password_hash('root', PASSWORD_DEFAULT);
		// if(password_verify('root1', $passwordHash)){
		// 	return "zhengque";
		// }
		// echo md5('root');
		
	}

	public function validatetest(){
		//假设传过来的数据
		$data = ['username'=>'hellollo'];

		//定义数据验证规则
		$vali = ['username'=>'require|length:1,24'];

		$validate =new validate($vali);

		dump($validate->check($data));

	}

}

?>