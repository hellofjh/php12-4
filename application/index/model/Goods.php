<?php 
namespace app\index\model;
use think\Model;
use think\Db;
/**
* 
*/
class Goods extends Model
{
	
	// 根据商品id获取信息
	public function getGoodsInfo($goods_id)
	{
		$data = [];
		// 获取商品基本信息
		$info = $this->where('id',$goods_id)->find();
		if(!$info || ($info['is_del']==1)){
			return FALSE;
		}
		$data['info'] = $info->toArray();//保存商品的基本信息
		// 获取商品相册
		$data['img'] = Db::name('goods_img')->where('goods_id',$goods_id)->select();
		return $data;
	}
}

?>