<?php
namespace app\admin\model;
use think\Model;

class Category extends Model{
	//修改类别数据操作
	public function editCategory(){
		//接收控制器提交所有的数据
		$data = input();

		// 调用model下getCateTree方法
		// 判断是否能被修改
		// 修改的分类不能不能包含子分类
		// 修改的分类不能为自己的父分类
		
		//获取id下的子分类
		$son = $this->getCateTree($data['id']);
		//循环出所有的子分类
		foreach($son as $key => $val){
			if($data['parent_id'] == $val['id']){
				$this->error = '分类包含下级分类，不能修改';
				return false;
			}
		}

		//判断是否为自己的分类
		if($data['parent_id'] == $data['id']){
			$this->error = '不能设置为自己的分类';
			return false;
		}

		$this->isUpdate(true)->allowField(true)->save($data,['id'=>$data['id']]);

	}

	//获取所有分类信息
	public function getCateTree($id=0){
		//获取数据库分类信息
		$data = $this->all();
		//格式化数据
		// return $data;
		return get_cate_tree($data,$id);
	}

	//删除分类方法
	public function del($id){
		//模型类可以使用静态调用或者实例化调用两种方式
		$hasSon = Category::get(['parent_id'=>$id]);
		if($hasSon){
			// 设置属性记录错误信息
			$this->error = '含有子分类';
			return false;
		}
		//根据主键删除
		return Category::destroy($id);
	}
}

?>