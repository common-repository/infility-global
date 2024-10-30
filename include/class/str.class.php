<?php 

class str{
	public static function create_login_href($href,$email){
		$time = time();
		$api_key = str::api_key($time);

		$parameterAry = array(
			'email'				=>	$email,
			'time'				=>	$time,
			'INFILITY_APIKEY'	=>	$api_key
		);

		$parameter = str::json_data($parameterAry,'encode');
		$parameter = 'i='.base64_encode($parameter).'&LOGIN_TYPE=infility_oa';
		
		return $href.'?'.$parameter;
	}

	public static function api_key($time){
		$api_key = base64_encode(md5('infility'.$time.'api_key'));

		return $api_key;
	}

	public static function create_curl_url($domain){
		$time = time();
		$api_key = str::api_key($time);

		$parameterAry = array(
			'time'				=>	$time,
			'INFILITY_APIKEY'	=>	$api_key
		);

		$parameter = str::json_data($parameterAry,'encode');
		$parameter = 'i='.base64_encode($parameter).'&ACTION_TYPE=infility_oa';
		
		return $domain.'?'.$parameter;
	}

	public static function curl($url,$data){
		$curl = curl_init();

		curl_setopt_array($curl, array(
		  CURLOPT_URL => $url,
		  CURLOPT_RETURNTRANSFER => true,
		  CURLOPT_ENCODING => '',
		  CURLOPT_MAXREDIRS => 10,
		  CURLOPT_TIMEOUT => 0,
		  CURLOPT_FOLLOWLOCATION => true,
		  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		  CURLOPT_CUSTOMREQUEST => 'POST',
		  CURLOPT_POSTFIELDS => $data,
		));

		$response = curl_exec($curl);

		curl_close($curl);
		return $response;
	}



	public static function e_json($msg='', $ret=0, $exit=1){
		is_bool($ret) && $ret=$ret?1:0;
		echo self::json_data(array(
				'msg'	=>	$msg,
				'ret'	=>	$ret
			)
		);
		$exit && exit;
	}	
	
	public static function dump($str, $type=''){//原样输出
		echo '<pre>';
		if ($type){
			var_dump($str);
		}else{
			print_r($str);
		}
		echo '</pre>';
	}
	
	public static function json_data($data, $action='encode'){	//json数据编码
		if($action=='encode'){
			if(version_compare(PHP_VERSION, '5.4.0', '>=')){
				return json_encode($data, JSON_UNESCAPED_UNICODE);
			}else{
            	return json_encode($data);
			}
		}else{
			return (array)json_decode($data, true);
		}
	}

	public static function recursiveStripSlashes(&$array) {
	    foreach ($array as $key => &$value) {
	        if (is_array($value)) {
	            self::recursiveStripSlashes($value); // 递归处理数组元素
	        } else {
	            $value = stripslashes($value); // 反转义字符串
	            $value = str_replace('\\', '', $value); // 反转义字符串
	        }
	    }

	    return $array;
	}
}

 ?>