<?php
class infility_collect_data{
    public function __construct()
    {
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
    }

    public function enqueue_scripts(){
        wp_enqueue_script('infility_analytics','https://analytics.infility.cn/js/analytics.js',[],INFILITY_GLOBAL_VERSION,['in_footer'=>true]);
    }
}
new infility_collect_data();