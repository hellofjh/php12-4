<?php 
namespace app\admin\model;
use think\Model;
/**
* 权限模型
*/
class Rule extends Model
{
	// 获取权限信息层次关系
	public function getRules()
	{
		$data = $this->all();
		$return = get_cate_tree($data);
		return $return;
	}
}