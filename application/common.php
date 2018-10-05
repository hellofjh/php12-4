<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/*
*
* 作用：分类的格式化操作
* @param:$data array 格式化数据
* @param:$id int 指定查找的分类id
* @param:$lev int 指定层次数字
* @return array 
* 
*/
if(!function_exists('get_cate_tree')){
	function get_cate_tree($data,$id=0,$lev=1){
		static $list = [];//保存结果
		foreach ($data as $key => $value) {
			if($value['parent_id']==$id){
				$value['lev'] = $lev;
				$list[] = $value;
				get_cate_tree($data,$value['id'],$lev+1);
			}
		}
		return $list;
	}
}

/*
*
* 作用：图片转移到资源服务器
* @param:$local_dir string 本地资源地址
* @param:$cdn_dir string 服务器地址
* @return  
* 
*/
if(!function_exists('img_to_cdn')){
	function img_to_cdn($local_dir,$cdn_dir=''){
		// 上传到服务器的地址 没有传递使用本地的地址
		$cdn_dir= $cdn_dir?$cdn_dir:$local_dir;
		require_once "../extend/ftp.php";
		// 从配置信息中读取资源服务信息
		$config = config('cdn_config');
		$obj = new \ftp($config['host'],$config['port'],$config['user'],$config['pwd']);
		return $obj->up_file($local_dir,$cdn_dir);
	}
}