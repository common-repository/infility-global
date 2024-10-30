<?php
class contact_form_plugins_class{
	var $file_name;

	public function __construct(){

		$optionAry = get_option('infility_global_configure');

		if ($optionAry['plugins']['CFP']!=1) return false;
		$this->file_name = dirname(__FILE__).'/js/CFP_form.js';

		add_action('init', array($this,'tracking_info_set_session_values'), 10);
		
		// add_action('admin_menu',array($this,'CFP_create_menu')); //整合到上一级 不需要在左侧加导航
		// add_action('wp_footer',array($this,'CFP_ga_code'));
		add_action( 'wp_footer',  array($this,'prefix_elementor_contact7_ini') );
		

		add_action( 'wp_enqueue_scripts', array( $this, 'CFP_enqueue_scripts' ) );
		// add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
      
		if (!is_file($this->file_name)) {
			$this->CFP_ga_code();
		}

		add_filter('wpcf7_form_response_output', array($this,'wpcf7_form_tracking_info'), 10, 3);
	}

	function CFP_create_menu(){
		add_submenu_page(
			'infility_global_plugins',
			__('CF7 Setting','infility-global'),
			__('CF7 Setting','infility-global'),
			'manage_options',
			'contact_form_plugins',
			array($this,'CFP_setting_page'),
		);


		add_submenu_page(
			'infility_global_plugins',
			__('CF7 Guide','infility-global'),
			__('CF7 Guide','infility-global'),
			'manage_options',
			'contact_form_plugins_guide',
			array($this,'CFP_guide_page'),
		);
	}

	function CFP_enqueue_scripts(){
		
		wp_enqueue_script('jquery');
		wp_enqueue_script('CFP_js',plugins_url('js/contact_form_plugins.js',__FILE__), ['jquery'],INFILITY_GLOBAL_VERSION,true);
		wp_enqueue_style('CFP_css',plugins_url('css/contact_form_plugins.css',__FILE__),false,INFILITY_GLOBAL_VERSION);


		wp_enqueue_script('CFP_form_js',plugins_url('js/CFP_form.js',__FILE__),['jquery'],INFILITY_GLOBAL_VERSION,true);
	}

	function prefix_elementor_contact7_ini() {
    ?>
	    <script type='text/javascript'>
	        /** Document ready. We are waiting for the full page load. */
	        jQuery( document ).ready( function() {
	            
	            /** Click on link or button that opens the popup. It contain "#elementor-action" in href. */
	            jQuery( document ).on( 'click', "a[href*='#elementor-action']", function () {
	            
	                /** Let's give the elementor some time to animate popup. */
	                setTimeout( function() { 
	                    
	                    /** Find all Contact 7 forms inside elementor popup. */
	                    jQuery( '.elementor-popup-modal form.wpcf7-form:not(.elementor)' ).each( function ( index ) {
	                        
	                        wpcf7.init( jQuery( this )[0] ); // Extra initialisation for contact 7 form.
	                        jQuery( this ).addClass( 'elementor' ); // Mark our form with class '.elementor' so as not to do the same thing.
	                        
	                    } );
	                    
	                }, 800 ); // END Timeout.
	            
	            } ); // END link click.
	            
	        } ); // END Document ready.
	    </script>
   <?php
	}
	function CFP_setting_page(){
		global $wpdb;
		wp_enqueue_script('CFP_admin_js',plugins_url('js/contact_form_plugins_admin.js',__FILE__),'',false,true);
		
		$wpdb->show_errors();
		$table = $wpdb->prefix.'postmeta';

		if (!empty($_POST) && check_admin_referer('CFP7_nonce')) {
			@extract($_POST, EXTR_PREFIX_ALL, 'p');


			if(!$post_id = (int)$p_post_id){
				echo ('<div id="message" class="error"><p><strong>'.__('Form not selected','infility-global').'</strong></p></div>');
			}else{
				$data = array(
					'CFP7_link'		=>	sanitize_text_field($p_CFP7_link),
					'CFP7_code'		=>	sanitize_text_field($p_CFP7_code),
				);

				foreach ($data as $k => $v) {

					$where = "post_id='{$post_id}' and meta_key='{$k}'";
					if ($meta_id = $wpdb->get_var("SELECT meta_id FROM {$table} where {$where}")) {
						$wpdb->update($table,array('meta_value'=>$v),['meta_id'=>$meta_id]);					
					}else{
						$tmpData = array(
							'post_id'	=>	$post_id,
							'meta_key'	=>	$k,
							'meta_value'	=>	$v,
						);
						$wpdb->insert( $table, $tmpData, array( '%d', '%s', '%s' ));
					}
				}

				if (is_file($this->file_name)) {
					unlink($this->file_name);
				}

				echo ('<div id="message" class="updated"><p><strong>'.__('Settings saved success!','infility-global').'</strong></p></div>');
			}
		}


		$args = array('post_type' => 'wpcf7_contact_form');
		$cfp_query = new WP_Query($args);

		$post_id = (int)$_GET['post_id']?(int)$_GET['post_id']:0;

		$current_url = (home_url(remove_query_arg(array('post_id'))));
		$guide_url = esc_url(home_url(remove_query_arg(array('set_type'))));
		
?>
		<div class="wrap">
			<h2><?php echo __('CF7 - GA Setting','infility-global');?></h2>
			<?php /* ?>
			<div id="elementor-template-library-tabs-wrapper" class="nav-tab-wrapper">
				<a class="nav-tab nav-tab-active" href="javascript://">设置</a>				
				<a class="nav-tab" href="<?php echo $guide_url?>&set_type=CFP|CFP_guide_page">教程</a>				
			</div>*/?>
			<form action="" method="post" id="CFP_plugins_setting">			
				<table class="form-table">
					<tr valign="top">
						<th><label for="post_id"><?php echo __('Select Form','infility-global');?></label></th>
						<td>
							<select name="post_id" notnull id="">
								<?php if ($cfp_query->have_posts()){ ?>
									<?php while ($cfp_query->have_posts()){
										$cfp_query->the_post();
										if (!$post_id) {
											$post_id = get_the_ID();
										}

										$url = $current_url.'&post_id='.get_the_ID();
									 ?>
										<option value="<? the_ID(); ?>" url='<?php echo esc_url($url)?>' <? selected(get_the_ID(),(int)$_GET['post_id']) ?>><?php the_title(); ?></option>
									<?php } ?>
								<?php } ?>
							</select>
						</td>
					</tr>
					<?php 
						$where = "post_id='{$post_id}'";
						$CFP7_link = $wpdb->get_var("SELECT meta_value FROM {$table} where {$where} and meta_key='CFP7_link'");
						$CFP7_code = $wpdb->get_var("SELECT meta_value FROM {$table} where {$where} and meta_key='CFP7_code'");
					 ?>
					<tr valign="top">
						<th><label for="CFP7_link"><?php echo __('Redirect link','infility-global');?></label></th>
						<td><input type="text" id="CFP7_link" name="CFP7_link" size='50' value='<?php echo wp_kses_post($CFP7_link)?>'></td>
					</tr>
					<?php /* ?>
					<tr valign="top">
						<th><label for="CFP7_code">提交后执行代码</label></th>
						<td>
							<textarea name="CFP7_code" id="" cols="52" rows="10"><?php echo stripslashes($CFP7_code)?></textarea>
						</td>
					</tr>*/?>
					<tr valign="top">
						<td>
							<input type="submit" name='Save' value="<?php echo __('Save','infility-global');?>" class='button button-primary' />							
							<input type="hidden" value="<?php echo wp_kses_post($post_id)?>" name='post_id' />
							<? wp_nonce_field('CFP7_nonce'); ?>
						</td>
					</tr>
				</table>
			</form>
		</div>
<?php 
	}

	function CFP_ga_code(){
		global $wpdb;

		// $args = array('post_type' => 'wpcf7_contact_form');
		// $cfp_query = new WP_Query($args);
?>	
		<?php if ($cf7_row = db::get_all('wp_posts',"post_type='wpcf7_contact_form'")){ 
				ob_start();
			?>
			<?php foreach($cf7_row as $k => $v){
				$post_id = $v['ID'];

				$table = $wpdb->prefix.'postmeta';
				$where = "post_id='{$post_id}'";
				$CFP7_link = $wpdb->get_var("SELECT meta_value FROM {$table} where {$where} and meta_key='CFP7_link'");
				$CFP7_code = $wpdb->get_var("SELECT meta_value FROM {$table} where {$where} and meta_key='CFP7_code'");
				if ($CFP7_link || $CFP7_code) {
			 ?>
					if ( '<?=$post_id;?>' == event.detail.contactFormId ) {
						<?php //echo ($CFP7_code);?>

						<?php if($CFP7_link){ ?>
							window.location.href='<?php echo ($CFP7_link);?>';
						<?php } ?>
					}
				<?php } ?>
			<?php } ?>
			<?php 
				$js_code = ob_get_contents();
				ob_end_clean();
			 ?>
			<?php if($js_code){ 
				ob_start();
				?>
					(function($) {
						document.addEventListener( 'wpcf7mailsent', function( event ) {
							<?php echo ($js_code);?>
						}, false );
					})( jQuery );
			<?php 
				$js_html = ob_get_contents();
				ob_end_clean();

				$file_name = $this->file_name;
				file_put_contents($file_name,$js_html);
			} ?>
		<?php } ?>
<?php 
	}

	function wpcf7_form_tracking_info($output, $class, $content){
		$trackingInfo = $this->tracking_info_result();
		$html = '<textarea name="page_source" class="hide_field no_translate">'.$trackingInfo.'</textarea>';
		$output.= $html;

		return $output;
	}
	

	function tracking_info_set_session_values() {
		if (!session_id() && !headers_sent()) {
			session_start( [
				'read_and_close' => true,
			] );
		}
		if (!isset($_SESSION['OriginalRef'])) {
			if(isset($_SERVER['HTTP_REFERER'])) {
				$_SESSION['OriginalRef'] = $_SERVER["HTTP_REFERER"];
			} else {
				$_SESSION['OriginalRef'] = __('not set','infility-global');
			}
		}
		if( $_SESSION['OriginalRef'] == 'not set' ) {
			$_SESSION['OriginalRef'] = __('not set','infility-global');
		}
		if (!isset($_SESSION['LandingPage'])) {
			$cf7ltisSecure = false;
			if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on') {
				$cf7ltisSecure = true;
			}
			elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
				$cf7ltisSecure = true;
			}
			$CF7LT_REQUEST_PROTOCOL = $cf7ltisSecure ? 'https://' : 'http://';
			$_SESSION['LandingPage'] = $CF7LT_REQUEST_PROTOCOL . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"]; 
		}

		// NEW FEATURE BEING TESTED: PagePath 01/02
		// if (!isset($_SESSION['PagePath'])) {
			// $_SESSION['PagePath'] = $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		// } else {
			// if ( strpos($_SERVER["REQUEST_URI"], 'contact-form-7') === false )
				// $_SESSION['PagePath'] .= ', ' . $_SERVER["SERVER_NAME"] . $_SERVER["REQUEST_URI"];
		// }
	}

	function tracking_info_result() {
		global $wpdb;

		$lineBreak = "\n";
		
		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? "https" : "http";
		$host     = $_SERVER['HTTP_HOST'];
		$uri      = $_SERVER['REQUEST_URI'];

		$current_url = $protocol . "://" . $host . $uri;

		$trackingInfo = '';
		$trackingInfo .= $lineBreak . __('-- Tracking Info --','infility-global') . $lineBreak;
		if (isset ($_SESSION['OriginalRef']) )
			$trackingInfo .= __('The user came to your website from:','infility-global') . ' ' . $_SESSION['OriginalRef'] . $lineBreak;
		if (isset ($_SESSION['LandingPage']) )
			$trackingInfo .= __('Landing page on your website:','infility-global') . ' ' . $_SESSION['LandingPage'] . $lineBreak;
		$trackingInfo .= __('The user filled the form on:','infility-global') . ' ' . ($current_url) . $lineBreak;
		
		$trackingInfoNoIp = $trackingInfo;
		if ( isset ($_SERVER["REMOTE_ADDR"]) )
			$trackingInfo .= __('IP:','infility-global') . ' ' . $_SERVER["REMOTE_ADDR"] . $lineBreak;
		if ( is_plugin_active( 'geoip-detect/geoip-detect.php' ) ) {
			$trackingCountry = geoip_detect_get_info_from_current_ip();
			$trackingInfo .= __('Country:','infility-global') . ' ' . $trackingCountry->country_name . ' (' . $trackingCountry->country_code . ' - ' . $trackingCountry->continent_code . ')';
			$trackingInfoNoIp .= __('Country:','infility-global') . ' ' . $trackingCountry->country_name . ' (' . $trackingCountry->country_code . ' - ' . $trackingCountry->continent_code . ')';
			if (!empty($trackingCountry->region_name)) {
				$trackingInfo .= ' - ' . __('Region:','infility-global') . ' ' . $trackingCountry->region_name . '(' . $trackingCountry->region . ')';
				$trackingInfoNoIp .= ' - ' . __('Region:','infility-global') . ' ' . $trackingCountry->region_name . '(' . $trackingCountry->region . ')';
			}
			if (!empty($trackingCountry->city)) {			
				$trackingInfo .= ' - ' . __('Postal Code + City:','infility-global') . ' ' . $trackingCountry->postal_code . ' ' . $trackingCountry->city;
				$trackingInfoNoIp .= ' - ' . __('Postal Code + City:','infility-global') . ' ' . $trackingCountry->postal_code . ' ' . $trackingCountry->city;
			}
			$trackingInfo .= $lineBreak;
			$trackingInfoNoIp .= $lineBreak;
		}
		if ( isset ($_SERVER["HTTP_X_FORWARDED_FOR"]) ) {
			$trackingInfo .= __('Proxy Server IP:','infility-global') . ' ' . $_SERVER["HTTP_X_FORWARDED_FOR"] . $lineBreak;
			if (  is_plugin_active( 'geoip-detect/geoip-detect.php' ) ) {
				$trackingcountryproxy = geoip_detect_get_info_from_ip($_SERVER["HTTP_X_FORWARDED_FOR"]);
				$trackingInfo .= __('Country:','infility-global') . ' ' . $trackingcountryproxy->country_name . ' (' . $trackingcountryproxy->country_code . ' - ' . $trackingcountryproxy->continent_code . ')';
				$trackingInfoNoIp .= __('Country:','infility-global') . ' ' . $trackingcountryproxy->country_name . ' (' . $trackingcountryproxy->country_code . ' - ' . $trackingcountryproxy->continent_code . ')';
				if (!empty($trackingcountryproxy->region_name)) {
					$trackingInfo .= ' - ' . __('Region:','infility-global') . ' ' . $trackingcountryproxy->region_name . '(' . $trackingcountryproxy->region . ')';
					$trackingInfoNoIp .= ' - ' . __('Region:','infility-global') . ' ' . $trackingcountryproxy->region_name . '(' . $trackingcountryproxy->region . ')';
				}
				if (!empty($trackingcountryproxy->city)) {			
					$trackingInfo .= ' - ' . __('Postal Code + City:','infility-global') . ' ' . $trackingcountryproxy->postal_code . ' ' . $trackingcountryproxy->city;
					$trackingInfoNoIp .= ' - ' . __('Postal Code + City:','infility-global') . ' ' . $trackingcountryproxy->postal_code . ' ' . $trackingcountryproxy->city;
				}
				$trackingInfo .= $lineBreak;
				$trackingInfoNoIp .= $lineBreak;
			}
		}
		if ( isset ($_SERVER["HTTP_USER_AGENT"]) )
		{
			$trackingInfo .= __('Browser is:','infility-global') . ' ' . $_SERVER["HTTP_USER_AGENT"] . $lineBreak;
			$trackingInfoNoIp .= __('Browser is:','infility-global') . ' ' . $_SERVER["HTTP_USER_AGENT"] . $lineBreak;
		}

		// NEW FEATURE BEING TESTED: PagePath 02/02	
		// $trackingInfo .=  __('Page path:','infility-global') . ' ' . $_SESSION['PagePath'];
		
		// $array['body'] = str_replace('[tracking-info]', $trackingInfo, $array['body']);
		// $array['body'] = str_replace('[tracking-info-noip]', $trackingInfoNoIp, $array['body']);
		return $trackingInfo;
	}
}
new contact_form_plugins_class();
