<?php
namespace app\admin\controller;
use think\Db;

/**
* 
*/
class Attribute extends Common
{
	
	public function add(){
		if($this->request->isGet()){
			$type = db('type')->select();
			$this->assign('type',$type);
			return $this->fetch();
		}

		$data = input();
		if($data['attr_input_type']==1){
			// input 文本框输入
			unset($data['attr_values']);
		}else{
			if(!$data['attr_values']){
				$this->error('select选择默认值必须填写');
			}
		}
		db('attribute')->insert($data);
		$this->success('ok','index');
	}

	public function index(){
		// $data = db('attribute')->alias('a')->field('a.*,b.type_name')->join('tp_type b','a.type_id=b.id','left')->paginate(1);
		// dump($data);exit();
		$data = model('attribute')->listData();
		$this->assign('data',$data);
		return $this->fetch();
	}

	public function del(){
		$id = input('id');
		db('Attribute')->where('id',$id)->delete();
		$this->success('ok','index');
	}

	public function edit(){
		$model = model('Attribute');
		if($this->request->isGet()){
			// $info = $model::get(input('id'));
			$info = db('Attribute')->where('id',input('id'))->find();
			$this->assign('info',$info);

			//获取说有类型
			$type = model('Type')->getAllInfo();
			$this->assign('type',$type);
			return $this->fetch();
		}

		$result = $model->edit();
		if(!$result){
			$this->error($model->getError());
		}
		$this->success('ok','index');
	}

}