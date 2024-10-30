<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Infility_Global_Infility_Form_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'infility_form';
	}

	public function get_title() {
		return 'Infility Form';
	}

	public function get_icon() {
		return 'eicon-code';
	}

	public function get_categories() {
		return [ 'infility-category' ];
	}

	public function get_keywords() {
		return [ 'infility', 'form', 'global' ];
	}

	protected function register_controls() {
		$this->add_section_content_form();
	}

	protected function render() {
		$settings = $this->get_settings_for_display();

		echo $this->get_form_html( intval( $settings['form_id'] ) );
	}

	private function add_section_content_form () {
		$this->start_controls_section(
			'section_content_form',
			[
				'label' => 'Form',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT, // TAB_STYLE
			]
		);

		$this->add_control(
			'form_id',
			[
				'label' => 'Form ID',
				'type' => \Elementor\Controls_Manager::NUMBER,
				// 'min' => 1,
				// 'max' => 100,
				// 'step' => 1,
				// 'default' => 10,
			]
		);

		$this->end_controls_section(); // section_content_form
	}

	private function get_form_html ( int $form_id ) : string {
		// $upload_dir = wp_upload_dir()['baseurl'];
		$upload_dir = wp_upload_dir()['basedir'];
		$cache_dir = $upload_dir . '/infility_form_cache';
		$mode = InfilityForm::get_option( 'cache_mode' );
		$server = InfilityForm::get_option( 'server' );
		if ( $mode === 'cache' && ! is_dir( $cache_dir ) ) {
			if ( ! mkdir( $cache_dir, 0755, true ) ) {
				error_log( '创建缓存目录失败' );
				$mode = 'direct';
			}
		}
		if ( $mode === 'cache' ) {
			$today = date( 'Ymd' );
			$cache_file = $cache_dir . '/' . $today . '-' . $form_id . '.html';
			if ( file_exists( $cache_file ) ) {
				return file_get_contents( $cache_file );
			}
		}
		$url = "{$server}/form/{$form_id}"; // preview 是为了避免输出 html 和 body 标签。
		$response = wp_remote_get( $url );
		if ( is_wp_error( $response ) ) {
			error_log( sprintf( '获取表单失败1: %s %s', $form_id, $url, $response->get_error_message() ) );
			sleep( 1 );
			$response = wp_remote_get( "{$server}/form/{$form_id}" );
			if ( is_wp_error( $response ) ) {
				error_log( sprintf( '获取表单失败2: %s %s', $form_id, $url, $response->get_error_message() ) );
				sleep( 1 );
				$response = wp_remote_get( "{$server}/form/{$form_id}" );
				if ( is_wp_error( $response ) ) {
					error_log( sprintf( '获取表单失败3: %s %s', $form_id, $url, $response->get_error_message() ) );
					return 'An error occurred. Please try again later.';
				}
			}
		}
		$html = wp_remote_retrieve_body( $response );
		if ( $mode === 'cache' ) {
			file_put_contents( $cache_file, $html );
		}
		return $html;
	}

}
