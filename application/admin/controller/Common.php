<?php  

namespace app\admin\controller;
use think\Controller;

class Common extends Controller{
	public $request;//保存request对象
	public $is_check_login = true;//属性保存是否需要校验登陆
	public function __construct(){
		//执行父类的构造方法
		parent::__construct();
		//将request对象保存到属性中
		$this->request = request();
		//判断用户是否登陆
		if($this->is_check_login){
			if(!cookie('admin_id')){
				$this->error('没有登陆','admin/login/login');
			}
		}
	}

}

?>