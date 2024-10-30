<?php
class ary{
	public static function ary_row_together_by_field($data, $field){	//数组把第二维指定的下标相同的排在一起
		$new_data=$moved_key=array();
		foreach($data as $k=>$v){
			if(in_array($k, $moved_key)){continue;}
			$new_data[]=$v;
			for($i=$k+1; $i<count($data); $i++){
				if($data[$i][$field]==$v[$field]){
					$new_data[]=$data[$i];
					$moved_key[]=$i;
				}
			}
		}
		return $new_data;
	}
	
	public static function ary_unset($data, $key){	//删除数组的指定下标
		$keys=!is_array($key)?explode(',', $key):$key;
		foreach($data as $k=>$v){
			if(in_array((string)$k, $keys)){
				unset($data[$k]);
			}elseif(is_array($v)){
				$data[$k]=ary::ary_unset($v, $key);
			}
		}
		return $data;
	}
	
	public static function ary_filter($data, $key, $value=''){	//返回数组指定下标包含指定值的新数组
		if($value==''){return $data;};
		!is_array($key) && $key=explode('|', $key);
		!is_array($value) && $value=explode('|', $value);
		foreach($data as $k=>$v){
			$unset=false;
			foreach($key as $k1=>$v1){
				if(is_array($v[$v1])){
					$data[$k]=ary::ary_filter($v[$v1], $key, $value);
				}elseif(!in_array($v[$v1], explode(',', $value[$k1]))){
					$unset=true;
					break;
				}
			}
			if($unset){unset($data[$k]);}
		}
		return $data;
	}
	
	public static function ary_filter_empty($data){	//删除数组中的空值
		if(!is_array($data)){return $data;}
		foreach($data as $k=>$v){
			is_array($v) && $data[$k]=ary::ary_filter_empty($v);
		}
		return array_filter($data, function($v){
			return !is_array($v)?(($v!='' || $v===0)?true:false):(count($v)?true:false);
		});
	}
	
	public static function ary_format($data, $return=0, $unset='', $explode_char=',', $implode_char=','){	//$return，0：字符串，1：数组，2：in查询语句，3：or查询语句，4：返回第一个值
		!is_array($data) && $data=explode($explode_char, $data);
		foreach($data as $k=>$v){
			$data[$k]=trim($v);
		}
		$data=array_filter($data, function($v){
			return !is_array($v)?(($v!='' || $v===0)?true:false):(count($v)?true:false);
		});
		if($unset){
			$unset=ary::ary_format($unset, 1, '', $explode_char, $implode_char);
			foreach($data as $k=>$v){
				if(in_array($v, $unset)){
					unset($data[$k]);
				}
			}
		}
		if($return==0){	
			return $data?($implode_char.implode($implode_char, $data).$implode_char):'';
		}elseif($return==1){
			return $data;
		}elseif($return==2 || $return==3){
			if(!$data){return '"0"';}
			if($return==2){
				$is_numeric=true;
				foreach($data as $v){
					if(!is_numeric($v)){
						$is_numeric=false;
						break;
					}
				}
				return ($is_numeric?'':"'").implode($is_numeric?',':"','", $data).($is_numeric?'':"'");
			}else{
				return implode(' or ', $data);
			}
		}elseif($return==4){
			return array_shift($data);
		}
	}
	
	public static function obj_to_ary($data){	//obj对象转数组
		is_object($data) && $data=(array)$data;
		if(!is_array($data)){return $data;}
		foreach($data as $k=>$v){
			$data[$k]=ary::obj_to_ary($v);
		}
		return $data;
	}

    public static function array_column($data, $field){  // 兼容5.5之前的版本PHP内置的array_column
        foreach ((array)$data as $key => $value) {
            $data[] = $value[$field];
        }
        return $data;
    }
}
?>