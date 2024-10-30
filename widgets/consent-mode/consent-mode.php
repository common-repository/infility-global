<?php

class ConsentMode {
	private string $dir = '';

	public function __construct() {
		$this->dir = __DIR__;
		if ( $_SERVER['HTTP_HOST'] === 'tools.infility.cn' ) {
		} else {
			add_action( 'wp_head', [ $this, 'consent_mode' ] );
		}
	}

	public function consent_mode() {
		echo '<style>';
		include_once( $this->dir . '/dist/consent-mode.min.css' );
		echo '</style>';
		echo '<script>';
		include_once( $this->dir . '/dist/consent-mode.min.js' );
		echo '</script>';
	}

	public function consent_mode_setting_page () {}
}

new ConsentMode();
