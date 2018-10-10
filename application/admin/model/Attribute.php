<?php
namespace app\admin\model;
use think\Model;
use think\Db;

/**
* 
*/
class Attribute extends Model
{
	
	public function listData(){
		//方法一：使用连表查询
		//return Attribute::alias('a')->field('a.*,b.type_name')->join('tp_type b','a.type_id=b.id','left')->paginate(1);
		
		// 方式五 使用缓存实现
		// 1、获取所有的类型
		$type_info = model('Type')->getAllInfo();
		// 2、获取当前页对应的数据
		$attribute = $this->paginate(10);
		$list =[];//保存完整属性信息
		foreach ($attribute as $key => $value) {
			$value = $value->toArray();
			$type_id = $value['type_id'];//获取属性对应的type_id
			$value['type_name']=$type_info[$type_id]['type_name'];
			$list[]=$value;
		}
		// data为数据 page为分页导航菜单
		return ['list'=>$list,'page'=>$attribute->render()];
		
	}

	public function edit()
	{
		$data = request()->param();
		if($data['attr_input_type']==1){
			// input 文本框输入
			unset($data['attr_values']);
		}else{
			if(!$data['attr_values']){
				$this->error = 'select选择默认值必须填写';
				return FALSE;
			}
		}
		return $this->update($data);
	}

	// 根据类型ID获取属性
	public function getAttrByTypeId($type_id)
	{
		$attribute = $this->all(['type_id'=>$type_id]);
		$list = [];//保存数据
		foreach ($attribute as $key => $value) {
			$value = $value->toArray();
			if($value['attr_input_type']==2){
				// 为select选择 需要将attr_values中的数据转换为数组格式(模板需要)
				$value['attr_values'] = explode(',',$value['attr_values']);
			}
			$list[]=$value;
		}
		return $list;
	}

}