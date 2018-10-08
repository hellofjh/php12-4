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
	}

}