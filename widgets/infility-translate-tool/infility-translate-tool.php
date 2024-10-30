<?php
class infility_translate_tool{
    public function __construct()
    {

        add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );    
        add_action('wp_ajax_install_translation',array($this,'install_translation'));
        add_action('wp_ajax_open_translation',array($this,'open_translation'));
        add_action('wp_ajax_translate_position',array($this,'translate_position'));

        add_action('init',[$this,'lang_301']);
        add_action('wp_head',[$this,'show_head']);
        add_action('wp_footer',[$this,'show']);
    }

    public function enqueue_scripts(){
        wp_enqueue_style('ITT_css',plugins_url('css/infility_translate_tool.css',__FILE__));
        wp_enqueue_script('jquery');
        wp_enqueue_script('ITT_js',plugins_url('js/infility_translate_tool.js',__FILE__),array('jquery'),false,true);
        wp_localize_script('ITT_js','ajax_object',array('ajax_url'=>admin_url('admin-ajax.php')));
    }

    public function lang_301(){
        if(!empty($_GET['lang'])){
            $this->header_lang_301($_GET['lang']);
        }
        if(!empty($_GET['language'])){
            $this->header_lang_301($_GET['language']);
        }
    }

    public function header_lang_301($lang){
        if($_SERVER['PHP_SELF']=='/index.php'){
            $url = '/'.$lang.'/';
        }else{
            $url = '/'.$lang.$_SERVER['PHP_SELF'];
        }

        if(wp_redirect($url,301, 'Infility Global - translate lang 301')){
            exit;
        }
    }

    public function show_head(){
        if(!is_admin()){
            global $my_transposh_plugin;
            $curr_lang = $my_transposh_plugin->tgl;
            if(empty($curr_lang)){$curr_lang = 'en';}
            $hots = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['HTTP_HOST'];
            $whole_url = $hots.'/'.$curr_lang.'/';

            echo '<link rel="alternate" hreflang="x-default" href="'.$hots.'/" />
            <link rel="alternate" hreflang="'.$curr_lang.'" href="'.$whole_url.'"/>';
        }
    }

    public function translate_tool_setting_page(){

        $position = get_option('infility_translation_position');
?>
        <div id="translate_tool_setting" class="wrap" >
            <div class="wrap-div">
                <button class="install_plugins">一键安装语言翻译插件</button>
                <div class="result1"></div>
                <div class="result2"></div>
            </div>
            <div class="wrap-div">
                <button class="open_plugins">一键启用语言翻译插件</button>
                <div class="open_result"></div>
            </div>
            <div class="position_choose wrap-div">
                <div class="position">显示位置：</div>
                <div class="position">
                    <label>不显示</label>
                    <input type="radio" name="position" value="none" <?php if($position=='none' || empty($position)){?> checked <?php } ?> >
                </div>
                <div class="position">
                    <label>左下角</label>
                    <input type="radio" name="position" value="left_bottom" <?php if($position=='left_bottom'){?> checked <?php } ?> >
                </div>
                <div class="position">
                    <label>右下角</label>
                    <input type="radio" name="position" value="right_bottom" <?php if($position=='right_bottom'){?> checked <?php } ?> >
                </div>
                <div class="position">
                    <label>左上角</label>
                    <input type="radio" name="position" value="left_top" <?php if($position=='left_top'){?> checked <?php } ?> >
                </div>
                <div class="position">
                    <label>右上角</label>
                    <input type="radio" name="position" value="right_top" <?php if($position=='right_top'){?> checked <?php } ?> >
                </div>
                <div>
                    <button class="choose_position">确定位置</button>
                </div>
                <div class="position_result"></div>
            </div>
        </div>
<?php
    }

    public function install_translation(){
        if(!current_user_can('install_plugins')){
            str::e_json('not allow!',0);
        }

        if($_POST['slug']){
            //安装Language Switcher for Transposh
            if(!in_array($_POST['slug'],['language-switcher-for-transposh'])){
                wp_send_json_error(['msg'=>'没权限安装该插件']);
            }

            $check_path = ABSPATH.'wp-content/plugins/language-switcher-for-transposh/cfx-language-switcher-for-transposh.php';
            if(!file_exists($check_path)){
                $this->install_plugin_api($_POST['slug']);
            }

            wp_send_json_success(['pluginName'=>'Language Switcher for Transposh']);
        }else if($_POST['upload']){
            $transposh_path = ABSPATH.'wp-content/plugins/transposh-translation-filter-for-wordpress/transposh.php';

            //安装Transposh Translation Filter
            if(!file_exists($transposh_path)){
                $zip = ABSPATH.'wp-content/plugins/infility-global/widgets/infility-translate-tool/file/transposh.latest.zip';
                $this->install_plugin_zip($zip);
            }
        }
    }

    public function open_translation(){
        $switcher_path = ABSPATH.'wp-content/plugins/language-switcher-for-transposh/cfx-language-switcher-for-transposh.php';

        if(!is_plugin_active('language-switcher-for-transposh/cfx-language-switcher-for-transposh.php')){
            activate_plugin($switcher_path);
        }

        $transposh_path = ABSPATH.'wp-content/plugins/transposh-translation-filter-for-wordpress/transposh.php';
        if(!is_plugin_active('transposh-translation-filter-for-wordpress/transposh.php')){//启用Transposh Translation Filter
            activate_plugin($transposh_path);
        }
        echo '<div>Transposh Translation Filter 安装启用成功</div>';
        exit;
    }

    public function translate_position(){
        if(empty($_POST['position'])){
            str::e_json('not allow!',0);
        }

        $position = $_POST['position'];
        update_option('infility_translation_position',$position);

        str::e_json('修改成功',1);
    }

    public function install_plugin_zip($zip_file){
        // 确保文件存在
        if (file_exists($zip_file)) {
            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
            require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

            $upload_dir = wp_upload_dir();
            $filename = basename($zip_file);
            $package = $upload_dir['path'].'/'.$filename;
            $url = $upload_dir['url'].'/'.$filename;
            $copy_res = copy($zip_file,$package);
            if(!$copy_res){echo "上传文件出错。";exit;}

            // Construct the attachment array.
            $attachment = array(
                'post_title'     => $filename,
                'post_content'   => $url,
                'post_mime_type' => '',
                'guid'           => $url,
                'context'        => 'upgrader',
                'post_status'    => 'private',
            );

            $id = wp_insert_attachment( $attachment, $package );

            /* translators: %s: File name. */
            $title = sprintf( __( 'Installing plugin from uploaded file: %s' ), esc_html( basename( $filename ) ) );
            $nonce = 'plugin-upload';
            $url   = add_query_arg( array( 'package' => $id ), 'update.php?action=upload-plugin' );
            $type  = 'upload'; // Install plugin type, From Web or an Upload.

            $overwrite = isset( $_GET['overwrite'] ) ? sanitize_text_field( $_GET['overwrite'] ) : '';
            $overwrite = in_array( $overwrite, array( 'update-plugin', 'downgrade-plugin' ), true ) ? $overwrite : '';

            $upgrader = new Plugin_Upgrader( new Plugin_Installer_Skin( compact( 'type', 'title', 'nonce', 'url', 'overwrite' ) ) );
            $result   = $upgrader->install( $package, array( 'overwrite_package' => $overwrite ) );

            if ( !$result || is_wp_error( $result ) ) {
                echo $result->get_error_message();
            }
        } else {
            echo "ZIP文件不存在。";
        }
    }

    public function install_plugin_api($slug){
        if ( empty( $slug ) ) {
            wp_send_json_error(
                array(
                    'slug'         => '',
                    'errorCode'    => 'no_plugin_specified',
                    'errorMessage' => __( 'No plugin specified.' ),
                )
            );
        }

        $status = array(
            'install' => 'plugin',
            'slug'    => sanitize_key( wp_unslash( $slug ) ),
        );

        if ( ! current_user_can( 'install_plugins' ) ) {
            $status['errorMessage'] = __( 'Sorry, you are not allowed to install plugins on this site.' );
            wp_send_json_error( $status );
        }

        require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
        require_once ABSPATH . 'wp-admin/includes/plugin-install.php';

        $api = plugins_api(
            'plugin_information',
            array(
                'slug'   => sanitize_key( wp_unslash( $slug ) ),
                'fields' => array(
                    'sections' => false,
                ),
            )
        );

        if ( is_wp_error( $api ) ) {
            $status['errorMessage'] = $api->get_error_message();
            wp_send_json_error( $status );
        }

        $status['pluginName'] = $api->name;

        $skin     = new WP_Ajax_Upgrader_Skin();
        $upgrader = new Plugin_Upgrader( $skin );
        $result   = $upgrader->install( $api->download_link );

        if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
            $status['debug'] = $skin->get_upgrade_messages();
        }

        if ( is_wp_error( $result ) ) {
            $status['errorCode']    = $result->get_error_code();
            $status['errorMessage'] = $result->get_error_message();
            wp_send_json_error( $status );
        } elseif ( is_wp_error( $skin->result ) ) {
            $status['errorCode']    = $skin->result->get_error_code();
            $status['errorMessage'] = $skin->result->get_error_message();
            wp_send_json_error( $status );
        } elseif ( $skin->get_errors()->has_errors() ) {
            $status['errorMessage'] = $skin->get_error_messages();
            wp_send_json_error( $status );
        } elseif ( is_null( $result ) ) {
            global $wp_filesystem;

            $status['errorCode']    = 'unable_to_connect_to_filesystem';
            $status['errorMessage'] = __( 'Unable to connect to the filesystem. Please confirm your credentials.' );

            // Pass through the error from WP_Filesystem if one was raised.
            if ( $wp_filesystem instanceof WP_Filesystem_Base && is_wp_error( $wp_filesystem->errors ) && $wp_filesystem->errors->has_errors() ) {
                $status['errorMessage'] = esc_html( $wp_filesystem->errors->get_error_message() );
            }

            wp_send_json_error( $status );
        }

        $install_status = install_plugin_install_status( $api );
        $pagenow        = isset( $_POST['pagenow'] ) ? sanitize_key( $_POST['pagenow'] ) : '';

        // If installation request is coming from import page, do not return network activation link.
        $plugins_url = ( 'import' === $pagenow ) ? admin_url( 'plugins.php' ) : network_admin_url( 'plugins.php' );

        if ( current_user_can( 'activate_plugin', $install_status['file'] ) && is_plugin_inactive( $install_status['file'] ) ) {
            $status['activateUrl'] = add_query_arg(
                array(
                    '_wpnonce' => wp_create_nonce( 'activate-plugin_' . $install_status['file'] ),
                    'action'   => 'activate',
                    'plugin'   => $install_status['file'],
                ),
                $plugins_url
            );
        }

        if ( is_multisite() && current_user_can( 'manage_network_plugins' ) && 'import' !== $pagenow ) {
            $status['activateUrl'] = add_query_arg( array( 'networkwide' => 1 ), $status['activateUrl'] );
        }

        return $status;
//        wp_send_json_success( $status );
    }

    public function show(){
        $post_num = did_action('wp_footer');
        if(!is_admin() && $post_num==1){
            $position = get_option('infility_translation_position');

            if($position=='none' || empty($position)){
                return '';
            }else if($position=='left_bottom'){
                $style = 'left:20px;bottom: 20px;';
                $menu_style = 'bottom:36px;';
                $menu_phone = 'bottom:38px;';
            }else if($position=='right_bottom'){
                $style = 'right:20px;bottom: 20px;';
                $menu_style = 'bottom:36px;';
                $menu_phone = 'bottom:38px;';
            }else if($position=='left_top'){
                $style = 'left:20px;top: 20px;';
                $menu_style = 'top:36px;';
                $menu_phone = 'top:38px;';
            }else if($position=='right_top'){
                $style = 'right:20px;top: 20px;';
                $menu_style = 'top:36px;';
                $menu_phone = 'top:38px;';
            }else{
                $style = 'left:20px;bottom: 20px;';
                $menu_style = 'bottom:36px;';
                $menu_phone = 'bottom:38px;';
            }

            if(is_plugin_active('language-switcher-for-transposh/cfx-language-switcher-for-transposh.php') && is_plugin_active('transposh-translation-filter-for-wordpress/transposh.php')){
                echo
                    '
                <style>
                    #translate_tool{position: fixed;z-index: 10000;'.$style.'}
                    #translate_tool .gp-icon.icon-arrow::before{content: none;}
                    #translate_tool .stylable-list{padding:10px;background:#FFFFFF;box-shadow: rgba(0, 0, 0, 0.15) 0 5px 15px;border-radius: 2px;}
                    
                    #translate_tool #sh_sc_flags_names_submenu{max-height: 200px;overflow: auto;box-shadow: rgba(0, 0, 0, 0.15) 0 5px 15px !important;'.$menu_style.'}
                    #translate_tool #sh_sc_flags_names_submenu::-webkit-scrollbar{width: 5px;height: 5px;background-color: #F5F5F5;}
                    #translate_tool #sh_sc_flags_names_submenu::-webkit-scrollbar-track{border-radius: 5px;background-color: transparent;}
                    #translate_tool #sh_sc_flags_names_submenu::-webkit-scrollbar-thumb{border-radius: 5px;background-color: #ccc;}
                    #translate_tool #sh_sc_flags_names_submenu li{padding-left:10px !important;}
                    
                    #translate_tool .translate_mobile{display:none;}
                    #translate_tool #sh_sc_flags_submenu{max-height: 200px;overflow: auto;'.$menu_phone.'}
                    #translate_tool #sh_sc_flags_submenu::-webkit-scrollbar{width: 5px;height: 5px;background-color: #F5F5F5;}
                    #translate_tool #sh_sc_flags_submenu::-webkit-scrollbar-track{border-radius: 5px;background-color: transparent;}
                    #translate_tool #sh_sc_flags_submenu::-webkit-scrollbar-thumb{border-radius: 5px;background-color: #ccc;}
                    #translate_tool #sh_sc_flags_submenu li{margin:0 18px 0 10px !important;}
                
                    /*手机*/
                    @media screen and (max-width: 600px){
                        #translate_tool .translate_pc{display:none;}
                        #translate_tool .translate_mobile{display:block;}
                    }
                </style>
                <div id="translate_tool">
                    <div class="translate_pc">'.do_shortcode('[lsft_custom_dropdown_flags_names]').'</div>
                    <div class="translate_mobile">'.do_shortcode('[lsft_custom_dropdown_flags]').'</div>
                </div>';
            }
        }
    }
}
new infility_translate_tool();