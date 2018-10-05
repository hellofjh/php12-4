<?php
namespace app\admin\controller;
// use app\admin\model\Category;

class Goods extends Common{
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
		$this->success('商品编号$id已经还原','goodsList');
	}

	public function remove(){
		$id = input('id');
		$data = db('goods')->where('id',$id)->delete();
		// dump($data);exit;
		$this->success('商品编号$id已经彻底删除','goodsList');
	}

}