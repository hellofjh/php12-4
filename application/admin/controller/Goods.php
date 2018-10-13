<?php
namespace app\admin\controller;
// use app\admin\model\Category;
use think\Db;

class Goods extends Common{

	// ajax请求获取属性
	public function showAttr()
	{
		$type_id = input('type_id');

		// 调用自定义方法根据type_id的值获取属性
		$data = model('Attribute')->getAttrByTypeId($type_id);
		// dump($data);
		if(!$data){
			return '没有数据';
		}
		$this->assign('data',$data);
		return $this->fetch();
	}


	//测试ftp链接
	// public function testMove()
	// {
	// 	// 需要转移图片的地址
	// 	$img_dir = 'uploads/20180926/9ce35a739abcb6dcf6eb8c6526c9935c.jpg';
	// 	require_once "../extend/ftp.php";
	// 	$obj = new \ftp('192.168.245.144',21,'ftpuser','root');
	// 	$obj->up_file($img_dir,$img_dir);
	// }

	public function goodsAdd(){

		if($this->request->isGet()){

			//获取所有分类信息
			$type = model('Type')->getAllInfo();
			$this->assign('type',$type);

			//获取到分类信息数据
			$category = new \app\admin\model\Category;
			// dump($category);
			$categorytree = $category->getCateTree();
			$this->assign('data',$categorytree);

			return $this->fetch();
		}

		$model = model('Goods');
		$model_data = $model->addGoods();

		if($model_data === false){
			$this->error($model->getError());
		}

		$this->success('success','goodsList');

	}

	//显示商品列表
	public function goodsList(){

		if($this->request->isGet()){
			$obj = db('goods');
			$data = $obj->where('is_del',0)->alias('a')->field('a.*,b.cname')->join('category b','a.cate_id=b.id','right')->paginate(3);
			// dump($data);exit;
			$this->assign('data',$data);
			return $this->fetch();
		}
	}

	public function goTrash(){
		$id = input('id');
		$data = db('goods')->where('id',$id)->update(['is_del'=>1]);
		// dump($data);exit;
		$this->success('商品编号$id已经删除放置回收站','goodsList');

	}

	public function goodsTrash(){
		if($this->request->isGet()){
			$data = db('goods')->where('is_del',1)->paginate(3);
			$this->assign('data',$data);
			return $this->fetch();
		}
	}

	public function reduction(){
		$id = input('id');
		$data = db('goods')->where('id',$id)->update(['is_del'=>0]);
		// dump($data);exit;
		$this->success('商品编号$id已经还原','goodstrash');
	}

	public function remove(){
		$id = input('id');
		$data = db('goods')->where('id',$id)->delete();
		// dump($data);exit;
		$this->success('商品编号$id已经彻底删除','goodstrash');
	}

	public function goodsEdit(){

		$id = input('id');

		if($this->request->isGet()){
			$data = db('goods')->where('id',$id)->find();
			$this->assign('data',$data);

			// 获取所有分类
			$category = model('Category');
			$categorytree = $category->getCateTree();
			$this->assign('tree',$categorytree);

			//获取已有相册
			$pics = db('goods_img')->where('goods_id',$id)->select();
			$this->assign('pics',$pics);

			return $this->fetch();
		}

		$model = model('Goods');
		$result = $model->editGoods();
		if($result === FALSE){
			$this->error($model->getError());
		}
		$this->success('ok','goodsList');

	}

	public function delPic(){
		$img_id = input('img_id/d');
		Db::name('goods_img')->where('id',$img_id)->delete();
		return json(['status'=>1,'msg'=>'ok']);
	}

}