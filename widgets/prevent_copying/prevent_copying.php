<?php

class prevent_copying {
	public function __construct()
	{
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );		
	}

	function enqueue_scripts(){
		wp_enqueue_script('prevent_copying_js',plugins_url('js/prevent_copying.js',__FILE__),['jquery'],INFILITY_GLOBAL_VERSION,true);		
	}
}

new prevent_copying();
