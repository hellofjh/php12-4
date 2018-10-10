<?php 
namespace app\admin\controller;
use think\Controller;

class category extends Common{
//-------------------------显示分类列表--------------------------------------
	public function index(){
		//判断get访问显示分类添加模板
		if($this->request->isGet()){
			$category = model('Category')->getCateTree();
			$this->assign('category',$category);
			return $this->fetch();
		}
	}
//--------------------------------------------------------------------------



//-------------------显示类别/修改类别--------------------------------------
	public function edit(){
		$id = input('id',0,'intval');
		
		$model = model('Category');

		// 修改类别页面回显数据
		if($this->request->isGet()){
			//假设模板方法，获取指定id数据
			$data = $model->get($id);
			$this->assign('data',$data);
			//假设模板方法，获取指定id数据
			$category = $model->getCateTree();
			$this->assign('category',$category);
			//输出视图
			return $this->fetch();
		}

		// 修改类别页面
		// 假设model有这方法
		$result = $model->editCategory();
		if($result === false){
			return $this->error($model->getError());
		}
		return $this->success('修改成功','list');

	}
//--------------------------------------------------------------------------



//-------------------------显示类别删除------------------------------------
	public function del(){
		// $obj = db('category');
		// $obj->where('id',input('id'))->delete();
		// 实例化对象
		$model = new \app\admin\model\Category;
		//input获取id值，默认为0，过滤函数intval
		$id = input('id',0,'intval');
		//假设有model对象
		$return = $model->del($id);
		if($return === false){
			// 使用getError方法来获取模型错误信息
			$this->error($model->getError());
		}

		$this->success('删除成功');

	}
//---------------------------------------------------------------------------	



//------------------------显示分类添加分类模板-------------------------------
	public function add(){
		//获取数据表query对象
		$queryTable = db('category');
		// 调用category模型
		$model = model('Category');
		//判断get访问显示分类添加模板
		if($this->request->isGet()){
			// $data = $queryTable->select();
			// $data = get_cate_tree($data);
			$category = $model->getCateTree();
			$this->assign('category',$category);
			return $this->fetch();
		}
		//数据的获取可以直接使用input请求
		// $data = $_POST;
		// dump($data);
		// exit;
		// dump(input('cname'));
		// query方式插入数据
		$result = $queryTable->insert(input());

		if(!$result){
			$this->error('error','admin/category/add');
		}
		$this->success('ok','admin/category/add');
	}
//------------------------------------------------------------------------

}


?>