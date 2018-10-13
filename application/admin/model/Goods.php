<?php
namespace app\admin\model;
use think\Db;
use think\Model;

class Goods extends Model{
	//添加商品数据
	public function addGoods(){
		$data = input();

		//数据验证
		/*
		   'goods_name' => string '' (length=0)
  			'goods_sn' => string '' (length=0)
  			'cate_id' => string '0' (length=1)
  			'shop_price' => string '' (length=0)
  			'is_sale' => string '1' (length=1)
  			'market_price' => string '' (length=0)
  			'goods_body' => string '' (length=0)
		 */
		// if(!$data['goods_name']){
		// 	$this->error='商品名称为空';
		// 	return false;
		// }

		// if($data['cate_id']<=0){
		// 	$this->error='分类必须选择';
		// 	return false;
		// }

		// if($data['shop_price']<=0){
		// 	$this->error='价格格式错误';
		// 	return false;
		// }

		// if($data['market_price']<=$data['shop_price']){
		// 	$this->error='价格不能比市场售价高';
		// 	return false;
		// }

		// if(!$data['goods_name']){
		// 	$this->error='商品名称为空';
		// 	return false;
		// }
		// 数据进行验证
		$obj = validate('Goods');
		if($obj->check($data) === false){
			$this->error = $obj->getError();
			return false;
		}
		
		// 实现商品图片上传
		if($this->uploadGoodsThumb($data) ===FALSE){
			return FALSE;
		}

		if($this->checkGoodsSn($data) === false){
			$this->error = '货号已存在';
			return false;
		}

		//增加上架时间
		$data['addtime'] = time();
		//写入数据
		// new \app\admin\model\Goods;
		// Goods::allowField(true)->save($data);
		// 写入数据
		Goods::startTrans();//开启事物
		try{
			Goods::allowField(true)->save($data);
			$goods_id = Goods::getLastInsID();//获取写入数据的主键
			//实现商品相册上传
			$this->uploadPics($goods_id);
			model('GoodsAttr')->insertData($goods_id,input('attr_id/a'),input('attr/a'));
			Goods::commit();
		}catch(\Exception $e){
			Goods::rollback();
			$this->error = '数据写入错误';
			return FALSE;
		}
	}

	// 商品缩略图上传
	public function uploadGoodsThumb(&$data,$isMust=true)
	{
		// 1、使用request对象调用file方法获取File类对象
		$file = request()->file('goods_img');
		if(!$file){
			if($isMust){
				//必须上传图片
				$this->error = '商品缩略图必须上传';
				return FALSE;
			}else{
				// 非必须上传 由于没有图片终止后续代码
				return TRUE;
			}
		}
		// 2、调用move方法上传图片 使用validate方法限制格式
		$info = $file->validate(['ext'=>'jpg,png'])->move('uploads');
		if(!$info){
			// 上传的文件异常
			$this->error = $file->getError();
			return FALSE;
		}
		// 组装上传的文件地址
		// 将"\"符号转换为"/" 考虑linux下下将"\"不作为目录分隔符
		$data['goods_img'] = str_replace('\\','/', $info->getPathName());
		// 3、打开文件
		$img = \think\Image::open($data['goods_img']);
		//组装缩略图保存地址 缩略图保存地址与上传图片地址一致文件名称在上传文件名称前追加thumb_
		//getFileName上传文件成功后获取文件的名称
		$data['goods_thumb'] = 'uploads/'.date('Ymd').'/thumb_'.$info->getFileName();
		// 4、生成缩略图
		$img->thumb(100,100)->save($data['goods_thumb']);
		// 将商品图片转移到资源服务器下
		img_to_cdn($data['goods_img']);
		img_to_cdn($data['goods_thumb']);
	}

	// 相册上传
	public function uploadPics($goods_id)
	{
		// 1、获取上传数组格式的对象
		$files = request()->file('pics');
		$list = [];
		// 循环上传
		foreach ($files as $file) {
			$info = $file->validate(['ext'=>'jpg,png'])->move('uploads');
			if(!$info){
				return FALSE;
			}
			// 组装上传的文件地址
			// 将"\"符号转换为"/" 考虑linux下下将"\"不作为目录分隔符
			$goods_img = str_replace('\\','/', $info->getPathName());
			// 3、打开文件
			$img = \think\Image::open($goods_img);
			//组装缩略图保存地址 缩略图保存地址与上传图片地址一致文件名称在上传文件名称前追加thumb_
			//getFileName上传文件成功后获取文件的名称
			$goods_thumb = 'uploads/'.date('Ymd').'/thumb_'.$info->getFileName();
			// 4、生成缩略图
			$img->thumb(100,100)->save($goods_thumb);
			// 将商品图片转移到资源服务器下
			img_to_cdn($goods_img);
			img_to_cdn($goods_thumb);
			$list[]=[
				'goods_id'=>$goods_id,
				'goods_img'=>$goods_img,
				'goods_thumb'=>$goods_thumb
			];
		}
		if($list){
			Db::name('goods_img')->insertAll($list);
		}
	}

	//商品号的检测
	public function checkGoodsSn(&$data,$method='add'){
		if($data['goods_sn']){
			//检测唯一
			if(Goods::get(['goods_sn'=>$data['goods_sn']])){
				return false;
			}
		}else{
			//生成唯一
			$data['goods_sn'] = strtoupper('SHOP'.uniqid());
		}
	}

	public function editGoods(){
		$data = input();
		// 考虑取消勾选操作后 没有内容提交无法更新状态
		if(!isset($data['is_hot'])){
			$data['is_hot']=0;
		}
		if(!isset($data['is_new'])){
			$data['is_new']=0;
		}
		if(!isset($data['is_rec'])){
			$data['is_rec']=0;
		}
		// 检查数据合法性
		$obj = validate('Goods');
		if($obj->check($data) === FALSE){
			$this->error = $obj->getError();
			return FALSE;
		}
		// 检查货号
		if($this->checkGoodsSn($data,'edit') === FALSE){
			$this->error = '货号错误';
			return FALSE;
		}
		// 实现商品图片上传 编辑图片上传不是必须
		if($this->uploadGoodsThumb($data,FALSE) ===FALSE){
			return FALSE;
		}
		// 修改数据
		Goods::allowField(true)->isUpdate(true)->save($data,['id'=>$data['id']]);

		//实现商品的相册上传
		$this->uploadPics($data['id']);
	}

}