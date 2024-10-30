<?php 

class action{
	public static function check_power_by_html($data=''){
		$poweyByData = get_option('infility_power_by');
		if (is_array($data)) {
			$data = array(
	    		'PowerBy'	=>	($data['PBText']),
	    		'IsHide'	=>	$data['PBIsHide'],
	    		'IsDel'		=>	$data['PBIsDel'],
	    	);
		}else{
		    if (!$poweyByData) {
		    	$data = array(
		    		'PowerBy'	=>	'POWER BY <a href="https://infility.cn" target="_blank">infility</a>',
		    		'IsHide'	=>	0,
		    		'IsDel'		=>	0,
		    	);
		    }
	    }
		is_array($data) && update_option('infility_power_by',$data);
	}

	public static function get_form_post(){
		global $wpdb;
		
		$data = db::get_all('wp_posts',"post_type='wpcf7_contact_form'");

		foreach ($data as $k => $v) {
			$id = $v['ID'];

			$where = "form_post_id = '{$id}'";
			$data[$k]['inquiry_count'] = db::get_row_count('wp_db7_forms',$where);
		}

		$result = [
			'data' => $data,
		];

		str::e_json($result,1);
	}

	public static function infility_get_data($postData){
		global $wpdb;

		$parameterData = [
			'table'	=>	'',
			'where' =>	1,
			'field' =>	'*',
			'order'	=>	'1',
			'page'	=>	'0',
			'pageLimit'=>	'20',
		];

		foreach ($parameterData as $k => $v) {
			$value = stripslashes($postData[$k]?$postData[$k]:$v);
			$postData[$k] = $value;
			$$k = $value;
		}
		
		if (!$table) str::e_json('table不能为空',-1);
		
		$data = db::get_limit_page($table,$where,$field,$order,$page,$pageLimit);

		if ($table=='wp_db7_forms') {
			foreach ($data[0] as $k => $v) {
				$data[0][$k]['form_value'] = unserialize($v['form_value']);
			}
		}
		
		$result = [
			'data' => $data,
		];

		str::e_json($result,1);
	}

	public static function plugin_swtich(){
		global $wpdb;

		$optionAry = get_option(INFILITY_GLOBAL_OPTION_KEY);
		$key = $_POST['key'] ?? '';
		$Checked = $_POST['isChecked'] ?? 0;
		if (isset($optionAry['plugins'][$key])) {
			$optionAry['plugins'][$key] = $Checked;
		}else{
			str::e_json('ERROR',-1);			
		}

		update_option(INFILITY_GLOBAL_OPTION_KEY,$optionAry);		
		str::e_json($Checked?'开启成功':'关闭成功',1);
	}
}

 ?>