<?php
class infility_redirect_class{

	public function __construct(){
		global $wpdb;

		$optionAry = get_option('infility_global_configure');

		if ($optionAry['plugins']['301jump']!=1) return false;

		// add_action('admin_menu',array($this,'CFP_create_menu')); //整合到上一级 不需要在左侧加导航
		// add_action('wp_footer',array($this,'CFP_ga_code'));
		



		// add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'IR_admin_enqueue_scripts' ) );

		add_action('plugins_loaded',array($this,'infility_redirect_url'));	
		add_action('wp_ajax_infility_redirect',array($this,'infility_redirect_ajax'));	

		$tableName = $wpdb->prefix.'redirect_record';
		if ($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") != $tableName) {
			$sql = " CREATE TABLE IF NOT EXISTS `{$tableName}`(
				RId int(11) NOT NULL auto_increment,
				old_link varchar(255) DEFAULT '',
				redirect_link varchar(255) DEFAULT '',
				host varchar(255) DEFAULT '',
				path varchar(255) DEFAULT '',
				type varchar(255) DEFAULT '',
				PRIMARY KEY (`RId`)
				) DEFAULT CHARSET=utf8 AUTO_INCREMENT=0;
			";
			$wpdb->query($sql);
		}

	}


	function IR_admin_enqueue_scripts(){
		wp_enqueue_script('jquery');
		wp_enqueue_style('IR_css',plugins_url('css/infility_redirect.css',__FILE__),false,INFILITY_GLOBAL_VERSION);
		wp_enqueue_script('IR_js',plugins_url('js/infility_redirect.js',__FILE__),array('jquery'),INFILITY_GLOBAL_VERSION,true);
		wp_localize_script('IR_js','ajax_object',array('ajax_url'=>	admin_url('admin-ajax.php')));	
	}

	function infility_redirect_url(){
		global $wpdb,$table_prefix;
		$MainDomain = get_option('MainDomain');
		$DomainAry = parse_url(trim($MainDomain));
		$Domain = $DomainAry['host'] ?? '';
		if (!$Domain) {
			return false;
		}
		$IsRedirect = false;

		if($Domain){
			if ($_SERVER['HTTP_HOST']!=$Domain) {
				$IsRedirect = true;
			}
			
			$table = $table_prefix.'redirect_record';
			$wherePath = $this->request_uri(0);
			if($row = db::get_one($table,"path='{$wherePath}' or old_link='{$wherePath}'",'*','RId desc')){
				$IsRedirect = true;
			}
			// 	str::dump("path='{$wherePath}' or old_link='{$wherePath}'");
			// 	str::dump(parse_url('https://www.somtaoptical.com/ar/?p=1168&abc=123'));

			// exit;

			if ($IsRedirect) {
				$path = '/';
				if ($row) {
					$urlData = parse_url($row['redirect_link']);
					$path = $urlData['path'];
				}else{
					$path = $this->request_uri(1);
					// if ($this->http_status($Domain.$path)!='200') {
					// 	$path = false;
					// }
				}
				!$path && $path = '/';

				$url = '//'.$Domain.$path;
				$this->infility_global_redirect($url);
			}
		}
	}

	function infility_global_redirect($url){
		$oldPath = $this->request_uri(1);
		$pathAry = parse_url($url);
		$newPath = $pathAry['path'];
		if ($oldPath==$newPath) {
			return false;
		}
		if(wp_redirect($url,301, 'Infility Global - Redirect')){
			exit;
		}
		
	}

	function request_uri($isParam=1){
	    if (isset($_SERVER['REQUEST_URI']))
	    {
	        $uri = $_SERVER['REQUEST_URI'];
	    }
	    else
	    {
	        if (isset($_SERVER['argv']))
	        {
	            $uri = $_SERVER['PHP_SELF'] . ($isParam==1 ? ('?'.$_SERVER['argv'][0]) : '');
	        }
	        else
	        {
	            $uri = $_SERVER['PHP_SELF'] . ($isParam==1 ? ('?'.$_SERVER['QUERY_STRING']) : '');
	        }
	    }
	    return $uri;
	}

	function http_status($url){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, 1);
		curl_setopt($ch, CURLOPT_NOBODY, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 5);
		curl_exec($ch);
		$status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
		curl_close($ch);
		return $status;  
	}

	function infility_redirect_ajax(){
		global $wpdb;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$do_action = sanitize_text_field($p_do_action);
		if ($do_action == 'save_redirect_action' || $do_action == 'save_redirect_form') {
			self::save_redirect_action(1);
		}else if ($do_action == 'del_redirect_action') {
			self::del_redirect_action();
		}else if ($do_action == 'upload_infility_redirect') {
			self::upload_redirect_action();
		}else if ($do_action == 'infility_redirect_set') {
			self::set_redirect_action();
		}

	}


	function save_redirect_action($return=0){
		global $wpdb;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$RId = (int)$p_RId;
		$table = $wpdb->prefix.'redirect_record';

		$data = array(
			'redirect_link'	=>	sanitize_text_field($p_redirect_link),
		);			
		if ($RId) {
			$data['old_link'] =	sanitize_text_field($p_old_link);
			$tmpData = $data;
			
			$pathAry = parse_url($p_old_link);
			$tmpData['host'] = $pathAry['host'];
			$tmpData['path'] = $pathAry['path'] . ($pathAry['query'] ? ('?'.$pathAry['query']) : '');
			$wpdb->update($table,$tmpData,['RId'=>$RId]);					
		}else{
			$oldlinkAry = explode("\r\n", $p_old_link);
			$data['type'] = 'manual';
			foreach ($oldlinkAry as $k => $v) {
				if (!$v) continue;
				$tmpData = $data;
				$tmpData['old_link'] = $v;
				$pathAry = parse_url($v);
				$tmpData['host'] = $pathAry['host'];
				$tmpData['path'] = $pathAry['path'] . ($pathAry['query'] ? ('?'.$pathAry['query']) : '');
				$wpdb->insert( $table, $tmpData);
			}
		}		
		if ($return == 1 ) {
			str::e_json('',1);
		}
	}


	function del_redirect_action($return=0){
		global $wpdb;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$RId = (int)$p_RId;
		$table = $wpdb->prefix.'redirect_record';
		
		if ($RId) {
			$wpdb->delete($table,['RId'=>$RId]);			
			str::e_json('',1);
		}else{
			str::e_json(__('Error','infility-global'),-1);			
		}
	}


	function set_redirect_action(){
		global $wpdb;
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$MainDomain = $p_MainDomain;
		update_option('MainDomain',$MainDomain);
		
		str::e_json('',1);
	}


	function redirect_setting_page(){
		global $wpdb;
		// wp_enqueue_script('301_admin_js',plugins_url('js/301_jump_admin.js',__FILE__),'',false,true);
		
		$wpdb->show_errors();
		$table = $wpdb->prefix.'redirect_record';
		$do = sanitize_text_field($_GET['do']?$_GET['do']:'index');
		$current_url = (home_url(remove_query_arg(array('do'))));

		$RId = (int)$_GET['RId'];
		if($RId || !empty($_POST)){
			$where = "RId='{$RId}'";
			$row = $wpdb->get_row(" SELECT * FROM {$table} WHERE {$where}",ARRAY_A);

			if (!empty($_POST) && check_admin_referer('redirect_nonce')) {
				self::save_redirect_action();

				$tips = $RId?__('Updated Success','infility-global'):__('Added Success','infility-global');
				echo '<div id="message" class="updated"><p><strong>'.$tips.'</strong></p></div>';
				$do = 'index';
			}
		}else{
			$paged = (int)$_GET['paged'];
			$no_page_url=infility::get_parameter_string(infility::parameter_string('paged'));

			$where = '1';
			$keyword = sanitize_text_field($_GET['s']);
			$keyword && $where .= " and (old_link like '%{$keyword}%' or redirect_link like '%{$keyword}%')";
			$row = db::get_limit_page($table,$where,'*','RId desc',$paged,50);
			$lang_pack = array(
				'manual'	=>	__('Manual','infility-global'),
				'excel'		=>	__('Excel','infility-global'),
			);
		}	

		$page_ary = array(
			'index'		=>	'全部',
			// 'upload'	=>	'excel上传',
			'set'		=>	'设置',
		);

		$MainDomain = get_option('MainDomain');
?>
		<div class="wrap <?php echo esc_html($do=='index'?'':'w_750');?>">
			<h1 class="wp-heading-inline"><?php echo __('Redirect List','infility-global');?></h1>
			<?php if($do=='index'){ ?>
				<a href="<?php echo esc_url($current_url)?>&do=edit" class="page-title-action"><?php echo __('Add','infility-global');?></a>
			<?php } ?>			
			<div id="elementor-template-library-tabs-wrapper" class="nav-tab-wrapper">
				<?php foreach ($page_ary as $k => $v) {?>
					<a class="nav-tab <?=$do==$k?'nav-tab-active':'';?>" href="<?php echo esc_url($current_url)?>&do=<?=$k?>"><?=$v?></a>
				<?php } ?>
			</div>		
			<?php if($do=='index'){ ?>
				<div class="tablenav top" style="height:auto">
					<?php /* ?><div class="alignleft actions bulkactions">
						<label for="bulk-action-selector-top" class="screen-reader-text">选择批量操作</label>
						<select name="action" id="bulk-action-selector-top">
							<option value="-1">批量操作</option>
							<option value="delete">删除</option>
						</select>
						<input type="submit" id="doaction" class="button action" value="应用">
					</div>*/?>
					<div class="domain_str">
						主域名:
						<?php if($MainDomain){?>
							<?=$MainDomain?>
						<?php }else{echo '空';} ?>&nbsp;&nbsp;&nbsp;&nbsp;
						<a href="<?php echo esc_url($current_url)?>&do=set"><?=$MainDomain?'修改':'设置';?></a>
					</div>
					<form id="posts-filter" method="get">
						<p class="search-box">
							<label class="screen-reader-text" for="post-search-input">搜索重定向链接:</label>
							<input type="search" id="post-search-input" name="s" value="<?=$keyword?>">
							<input type="submit" id="search-submit" class="button" value="搜索重定向链接">
						</p>
						<input type="hidden" name="page" value="<?=$_GET['page']?>">
						<input type="hidden" name="set_type" value="<?=$_GET['set_type']?>">
						<div class="tablenav-pages one-page">
							<span class="displaying-num"><?php echo $row[1];?>个项目</span>
						</div>			
						<br class="clear">
						<?=infility::turn_page_html($row[1], $row[2], $row[3], $no_page_url);?>
					</form>				
				</div>
				<table class="widefat striped" id="redirectList"> 
					<tr valign="top">
						<td nowrap="nowrap">序号</td>
						<td width="40%">旧链接</td>
						<td width='40%'>重定向</td>
						<td >类型</td>
						<td width='118'>操作</td>
					</tr>
					<?php if($row[0]){ ?>
						<?php foreach ($row[0] as $k => $v) {?>
							<tr valign="top">
								<td><?php echo wp_kses_post($k+1)?></td>
								<td><input type="text" name="old_link[<?php echo wp_kses_post($v['RId'])?>]" size='50' value='<?php echo wp_kses_post($v['old_link'])?>'></td>
								<td><input type="text" name="redirect_link[<?php echo wp_kses_post($v['RId'])?>]" size='50' value='<?php echo wp_kses_post($v['redirect_link'])?>'></td>
								<td><?php echo esc_html($lang_pack[$v['type']])?></td>
								<td>
									<a href="javascript://" class='save'><?php echo __('Save','infility-global');?></a>
									<a href="javascript://" class='del'><?php echo __('Delete','infility-global');?></a>
									<input type="hidden" name="RId[]" value="<?php echo wp_kses_post($v['RId'])?>">
								</td>
							</tr>
						<?php } ?>
					<?php } ?>
					<?php /* ?><tr valign="top">
						<td colspan="4">
							<input type="submit" name='Save' value="<?php echo __('Save','infility-global');?>" class='button button-primary' />
							<?php wp_nonce_field('redirect_nonce'); ?>
						</td>
					</tr>*/?>
				</table>
			<?php }else if($do=='edit'){ ?>
				<form method="post" id='save_redirect'>
					<table class="widefat striped"> 
						<tr valign="top">
							<td width="50%">旧链接</td>
							<td width='50%'>重定向</td>
						</tr>
						<?php if($RId){ ?>
							<tr valign="top">
								<td><input type="text" name="old_link" size='45' value='<?php echo wp_kses_post($row['old_link'])?>' notnull></td>
								<td><input type="text" name="redirect_link" size='45' value='<?php echo wp_kses_post($row['redirect_link'])?>' notnull></td>
							</tr>
						<?php }else{ ?>
							<tr valign="top">
								<td colspan="2">
									<textarea name="old_link" id="" class='add_textarea'></textarea>
								</td>
							</tr>
							<tr valign="top">
								<td colspan="2"><input type="text" name="redirect_link" size='45' value='<?php echo wp_kses_post($row['redirect_link'])?>' notnull></td>
							</tr>
						<?php } ?>
						<tr>
							<td colspan="2">
								<input type="submit" name='Save' value="<?php echo __('Save','infility-global');?>" class='button button-primary' />
								<input type="hidden" name="RId" value="<?php echo wp_kses_post($RId)?>">
								<input type="hidden" name="jumpUrl" value="<?php echo esc_url(home_url(remove_query_arg(array('do'))))?>">
								<?php wp_nonce_field('redirect_nonce'); ?>
							</td>
						</tr>
					</table>
				</form>
			<?php }else if($do=='upload'){ ?>
				<form method="post" id='upload_redirect' enctype="multipart/form-data">
					<table class="widefat striped"> 
						<tr valign="top">
							<td width="100%"><?php echo __('Excel Upload','infility-global');?></td>
						</tr>
						<tr valign="top">
							<td><input type="file" name="File"></td>
						</tr>
						<tr valign="top">
							<td width="100%"><?php echo __('Dead link detection','infility-global');?></td>
						</tr>
						<tr valign="top">
							<td><input type="checkbox" name="IsCheckDeadLink"></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" name='Save' value="<?php echo __('Save','infility-global');?>" class='button button-primary' />
								<input type="hidden" name="jumpUrl" value="<?php echo home_url(remove_query_arg(array('do')))?>">
								<input type="hidden" name="action" value="infility_redirect">
								<input type="hidden" name="do_action" value="upload_infility_redirect">
								<?php wp_nonce_field('redirect_nonce'); ?>
							</td>
						</tr>
					</table>
				</form>
			<?php }else if($do=='set'){ ?>
				<form method="post" id='set_redirect'>
					<table class="widefat striped"> 
						<tr valign="top">
							<td width="100%">主域名:</td>
						</tr>
						<tr valign="top">
							<td><input type="text" name="MainDomain" notnull size='70' value="<?=$MainDomain;?>"></td>
						</tr>
						<tr>
							<td colspan="2">
								<input type="submit" name='Save' value="<?php echo __('Save','infility-global');?>" class='button button-primary' />
								<input type="hidden" name="jumpUrl" value="<?php echo home_url(remove_query_arg(array('do')))?>">
								<?php wp_nonce_field('redirect_nonce'); ?>
							</td>
						</tr>
					</table>
				</form>
			<?php } ?>
		</div>
<?php 
	}
}
new infility_redirect_class();
