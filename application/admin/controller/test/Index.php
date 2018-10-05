<?php 
namespace app\admin\controller;
// use think\Controller;
use think\Config;
use think\Jump;
use think\View;
// use think\Db;


class index extends Common{

	public function index()
	{
		return "admin Index index";
	}

	// 使用config类实现配置项的处理
	public function getConfig()
	{
		// Config::set('database.hostname','192.168.1.1');
		// dump(Config::get('database.hostname'));
		// config('database.hostname','192.168.1.1');
		dump(config());
	}

	//url
	public function urltest()
	{
		echo url('read');
	}

	//跳转与重定向
	public function successJump()
	{
		$this->success('success','index/index/index');
	}
	public function errorJump()
	{
		$this->error('error','index/index/index');
	}
	public function redirectJump()
	{
		$this->redirect('index/index/index',['name'=>'hao']);
	}

	// VIEW调用
	public function testview(){
		return $this->fetch();
		// $view = new view();
		// return $view->fetch();
	}

	//view调度测试
	public function viewIndex(){
		//同名目录下调用testview文件
		// return $this->fetch('testview');
		//渲染view/goods目录，调用view下的goods目录(不是本目录)中的index文件
		// return $this->fetch('goods/index');
		// 跨模块渲染模板
		// return $this->fetch('index@index/index');
		// 完整地址方式渲染
		return $this->fetch('../application/index/view/index/index.html');
	}

	//db数据库操作
	public function getDb()
	{
		// 使用name获取到到对象 不带前缀的表名称
		// $obj = Db::name('user');
		// 使用table方法获取对象 需要传递完整表名称
		// $obj = Db::table('tp_user');
		// 使用助手函数获取对象
		$obj = db('user');
		// $data = [
		// 	'name' => 'fengjunhao',
		// 	'age' => '22'
		// ];
		// $a = $obj->insert($data);
		// $a = $obj->find(3);
		// $a = $obj->select([2,3,4,5]);
		// echo $obj->getLastSql();
		// echo $obj->getLastInsID();
		// $a = $obj->where('id',1)->update(['name'=>'update']);
		// $count = $obj->count('id');
		// $a = $obj->where('id',$count)->update(['name'=>'update']);
		// $a = $obj->delete(5);
		// echo $obj->getLastSql();
		dump($a);
	}

	//



}

?>