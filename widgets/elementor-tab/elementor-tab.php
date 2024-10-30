<?php
/*↓
Plugin Name: Elementor Tab
Plugin URI: 
Description: Elementor 选项卡组件
Version: 1.0
Author:CJJ
Author URI: 
License: GPLv2
*/


class elementor_tab_class{
	public function __construct(){

		add_action('wp_enqueue_scripts',array($this,'ETab_load'));			

		
		//注册Elementor插件分类
		add_action( 'elementor/elements/categories_registered', array($this,'add_elementor_widget_categories') );

		//注册Elementor插件
		add_action( 'elementor/widgets/register', array($this,'ETab_elementor_register') );	
		add_action( 'elementor/widgets/register', array($this,'EBreadcrumb_elementor_register') );	
		// add_action( 'elementor/widgets/register', array($this,'EImgSilde_elementor_register') );	

		//AJAX的ACTION
		// add_action('wp_ajax_nopriv_get_tertiary_filter_option',array($this,'TF_get_tertiary_filter_option'));	
		// add_action('wp_ajax_get_tertiary_filter_option',array($this,'TF_get_tertiary_filter_option'));	
	}

	function add_elementor_widget_categories( $elements_manager ) {

		$elements_manager->add_category(
			'infility-category',
			[
				'title' => 'Infility',
				'icon' => 'fa fa-plug',
			]
		);
	}

	function ETab_elementor_register($widgets_manager) {
		//选项卡
		require_once( __DIR__ . '/includes/widgets/elementor_tab_html.php' );
		$widgets_manager->register( new \elementor_tab_html() );
	}

	function EBreadcrumb_elementor_register($widgets_manager) {
		//面包屑
		require_once( __DIR__ . '/includes/widgets/elementor_breadcrumb.php' );
		$widgets_manager->register( new \elementor_breadcrumb() );
	}


	function EImgSilde_elementor_register($widgets_manager) {
		//图片
		require_once( __DIR__ . '/includes/widgets/elementor_img_silde.php' );
		$widgets_manager->register( new \elementor_img_silde() );
	}

	function ETab_load(){
		wp_enqueue_script('jquery');
		wp_enqueue_script('ETab_js',plugins_url('js/elementor_tab.js',__FILE__),['jquery'],false,true);
		wp_enqueue_style('ETab_css',plugins_url('css/elementor_tab.css',__FILE__),false);


		wp_enqueue_style('EBreadcrumb_css',plugins_url('css/elementor_breadcrumb.css',__FILE__),false);
		wp_enqueue_style('EImgSilde_css',plugins_url('css/elementor_img_silde.css',__FILE__),false);
		wp_enqueue_script('EImgSilde_js',plugins_url('js/elementor_img_silde.js',__FILE__),false,false,true);

		// wp_localize_script('TF_js','ajax_object',array('ajax_url'=>	admin_url('admin-ajax.php')));	
	}
}
new elementor_tab_class();
