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
// if(!function_exists('get_cate_tree')){
// 	function get_cate_tree($data,$id=0,$lev=1){
// 		static $list = [];//保存结果
// 		foreach ($data as $key => $value) {
// 			if($value['parent_id']==$id){
// 				$value['lev'] = $lev;
// 				$list[] = $value;
// 				get_cate_tree($data,$value['id'],$lev+1);
// 			}
// 		}
// 		return $list;
// 	}
// }

if(!function_exists('get_cate_tree')){
	function get_cate_tree($data,$id=0,$lev=1,$isClear=false){
		static $list = [];//保存结果
		if($isClear){
			// 根据传递的参数确认是否需要重置已有的数据
			$list = [];
		}
		foreach ($data as $key => $value) {
			if($value['parent_id']==$id){
				$value['lev'] = $lev;
				$list[] = $value;
				get_cate_tree($data,$value['id'],$lev+1,false);
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


/**
 * 请求接口返回内容
 * @param  string $url [请求的URL地址]
 * @param  string $params [请求的参数]
 * @param  int $ipost [是否采用POST形式]
 * @return  string
 */
if(!function_exists('jhcurl_sms')){

		function jhcurl_sms($url,$params=false,$ispost=0){
		    $httpInfo = array();
		    $ch = curl_init();
		    curl_setopt( $ch, CURLOPT_HTTP_VERSION , CURL_HTTP_VERSION_1_1 );
		    curl_setopt( $ch, CURLOPT_USERAGENT , 'Mozilla/5.0 (Windows NT 5.1) AppleWebKit/537.22 (KHTML, like Gecko) Chrome/25.0.1364.172 Safari/537.22' );
		    curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT , 30 );
		    curl_setopt( $ch, CURLOPT_TIMEOUT , 30);
		    curl_setopt( $ch, CURLOPT_RETURNTRANSFER , true );
		    if( $ispost )
		    {
		        curl_setopt( $ch , CURLOPT_POST , true );
		        curl_setopt( $ch , CURLOPT_POSTFIELDS , $params );
		        curl_setopt( $ch , CURLOPT_URL , $url );
		    }
		    else
		    {
		        if($params){
		            curl_setopt( $ch , CURLOPT_URL , $url.'?'.$params );
		        }else{
		            curl_setopt( $ch , CURLOPT_URL , $url);
		        }
		    }
		    $response = curl_exec( $ch );
		    if ($response === FALSE) {
		        //echo "cURL Error: " . curl_error($ch);
		        return false;
		    }
		    $httpCode = curl_getinfo( $ch , CURLINFO_HTTP_CODE );
		    $httpInfo = array_merge( $httpInfo , curl_getinfo( $ch ) );
		    curl_close( $ch );
		    return $response;
		}

}





/*
    ***聚合数据（JUHE.CN）短信API服务接口PHP请求示例源码
    ***DATE:2015-05-25
*/
if(!function_exists('get_sms')){

	function get_sms($num,$code){
		header('content-type:text/html;charset=utf-8');  
		$sendUrl = 'http://v.juhe.cn/sms/send'; //短信接口的URL		  
		$smsConf = array(
		    'key'   => '33eb5cb18f8b584859c679fac66ba3a1', //您申请的APPKEY
		    'mobile'    => $num, //接受短信的用户手机号码
		    'tpl_id'    => '102638', //您申请的短信模板ID，根据实际情况修改
		    'tpl_value' =>'#code#='.$code.'&#company#=聚合数据' //您设置的模板变量，根据实际情况修改
		);
				 
		$content = jhcurl_sms($sendUrl,$smsConf,1); //请求发送短信
		return $content;
		// if($content){
		//     $result = json_decode($content,true);
		//     $error_code = $result['error_code'];
		//     if($error_code == 0){
		//         //状态为0，说明短信发送成功
		//         echo "短信发送成功,短信ID：".$result['result']['sid'];
		//     }else{
		//         //状态非0，说明失败
		//         $msg = $result['reason'];
		//         echo "短信发送失败(".$error_code.")：".$msg;
		//     }
		// }else{
		//     //返回内容异常，以下可根据业务逻辑自行修改
		//     echo "请求发送短信失败";
		// }
	}

}


/*
*
* 作用：双重MD5加密
* @param:$pwd string 明文
* @param:$salt string 盐
* @return string 
* 
*/
if(!function_exists('md6')){
	function md6($pwd,$salt='123456'){
		return md5(md5($pwd).$salt);
	}
}