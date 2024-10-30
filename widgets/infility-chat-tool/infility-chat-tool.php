<?php
class infility_chat_tool{
    private $path = ABSPATH.'wp-content/uploads/chat-tool';

    public function __construct()
    {
        $this->checkTable();


        add_action( 'wp_enqueue_scripts', array( $this, 'ICT_enqueue_scripts' ) );
        add_action( 'admin_enqueue_scripts', array( $this, 'ICT_admin_enqueue_scripts' ) );

        add_action('wp_ajax_infility_chat_tool',array($this,'infility_chat_tool_ajax'));

//        add_shortcode('infility_chat_tool',[$this,'show']);
        add_action('wp_footer',[$this,'show']);
    }

    function ICT_enqueue_scripts(){
        wp_enqueue_style('ICT_css',plugins_url('css/infility_chat_tool.css',__FILE__));
        wp_enqueue_script('jquery');
        wp_localize_script('ICT_js','ajax_object',array('ajax_url'=>    admin_url('admin-ajax.php')));
        wp_enqueue_script('ICT_js',plugins_url('js/infility_chat_tool.js',__FILE__),array('jquery'),false,true);
    }

    function ICT_admin_enqueue_scripts(){
        wp_enqueue_script('dragsort_js',plugins_url('js/dragsort-0.5.1.min.js',__FILE__),array('jquery'),false,true);

        wp_localize_script('ICT_js_admin','ajax_object',array('ajax_url'=>    admin_url('admin-ajax.php')));
        wp_enqueue_script('ICT_js_admin',plugins_url('js/infility_chat_tool_admin.js',__FILE__),array('jquery'),INFILITY_GLOBAL_VERSION,true);
        wp_enqueue_style('ICT_css_admin',plugins_url('css/infility_chat_tool_admin.css',__FILE__),false,INFILITY_GLOBAL_VERSION);
    }

    function checkTable(){
        global $wpdb;
        $tableName = $wpdb->prefix.'chat_tool';
        if ($wpdb->get_var("SHOW TABLES LIKE '{$tableName}'") != $tableName) {
            $sql = " CREATE TABLE `{$tableName}` (
                      `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'id',
                      `service` varchar(50) NOT NULL COMMENT '服务商',
                      `username` varchar(100) NOT NULL COMMENT '账号',
                      `image` varchar(255) NOT NULL COMMENT '图片',
                      `background_color` varchar(50) NOT NULL COMMENT '背景颜色',
                      `sort` int(3) NOT NULL DEFAULT '0' COMMENT '排序',
                      `add_time` int(11) NOT NULL COMMENT '添加时间',
                      PRIMARY KEY (`id`)
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8
                   ";
            $wpdb->query($sql);
        }
    }

    function chat_tool_setting_page(){
        global $wpdb;
        // wp_enqueue_script('301_admin_js',plugins_url('js/301_jump_admin.js',__FILE__),'',false,true);

        $wpdb->show_errors();
        $table = $wpdb->prefix.'chat_tool';
        $do = sanitize_text_field($_GET['do']?$_GET['do']:'index');
        $current_url = (home_url(remove_query_arg(array('do'))));
        $img_url = esc_url( home_url( '/wp-content/uploads/chat-tool' ) );

        $RId = (int)$_GET['RId'];
        if($RId || !empty($_POST)){
            $where = "id='{$RId}'";
            $row = $wpdb->get_row(" SELECT * FROM {$table} WHERE {$where} ORDER BY sort ASC",ARRAY_A);

            if (!empty($_POST) && check_admin_referer('redirect_nonce')) {
                self::save_redirect_action();

                $tips = $RId?__('Updated Success','infility-global'):__('Added Success','infility-global');
                echo '<div id="message" class="updated"><p><strong>'.$tips.'</strong></p></div>';
                $do = 'index';
            }
        }else{
            $row = db::get_all($table,'service!="default"','*','sort asc');
            if(!$default_row = db::get_one($table,'service="default"','*')){
                $data = [
                    'service'           =>  'default',
                    'username'          =>  'default',
                    'image'             =>  '/wp-content/plugins/infility-global/widgets/infility-chat-tool/image/icon_chat_menu_btn.png',
                    'background_color'  =>  '#07bb8a',
                    'add_time'          =>  time(),
                ];

                $wpdb->insert($table,$data);
                $default_row = db::get_one($table,'service="default"','*');
            }
            if (!stristr($default_row['image'], 'icon_chat_menu_btn')) {
                $default_row['image'] = $img_url.'/'.$default_row['image'];
            }

            $lang_pack = array(
                'manual'    =>  __('Manual','infility-global'),
                'excel'     =>  __('Excel','infility-global'),
            );
        }

        $page_ary = array(
            'index' =>  '全部',
        );

        $MainDomain = get_option('MainDomain');
        ?>
        <div class="wrap <?php echo esc_html($do=='index'?'':'w_750');?>">
            <h1 class="wp-heading-inline"><?php echo __('Chat Tool List','infility-global');?></h1>
            <?php if($do=='index'){ ?>
                <a href="<?php echo esc_url($current_url)?>&do=edit" class="page-title-action"><?php echo __('Add','infility-global');?></a>
            <?php } ?>
            <?php if($do=='index'){ ?>
                <div class="tablenav top"></div>
                <table class="widefat striped" id="chatList">
                    <thead>
                    <tr valign="top">
                        <td nowrap="nowrap"></td>
                        <td>服务商</td>
                        <td>账号</td>
                        <td>背景颜色</td>
                        <td width='30%'>图片</td>
                        <td>操作</td>
                    </tr>
                    <tr valign="top">
                        <td class="i" style="font-size: 20px;"></td>
                        <td>默认图标</td>
                        <td>-</td>
                        <td><input type="text" name="background_color[<?=$default_row['id']?>]" size='50' value='<?=$default_row['background_color']?>'></td>
                        <td>
                            <a class="addBtn"><input type="file" size='45' value='<?=$default_row['image']?>' notnull></a>
                            <div class="imgBox">
                                <div style="width: 50px;height: 50px;border-radius: 500px;background:<?=$default_row['background_color']?> url(<?=$default_row['image']?>) no-repeat center center;background-size:20px; "></div>
                            </div>
                        </td>
                        <td class="control">
                            <a href="javascript://" class='save'><?php echo __('Save','infility-global');?></a>
                            <input type="hidden" name="RId[]" value="<?=$default_row['id']?>">
                        </td>
                    </tr>
                    </thead>
                    <tbody id="chatList_tbody">
                    <?php if($row){ ?>
                        <?php foreach ($row as $k => $v) {?>
                            <tr valign="top">
                                <td class="i" style="font-size: 20px;">
                                    <svg viewBox="64 64 896 896" focusable="false" data-icon="drag" width="1em" height="1em" fill="currentColor" aria-hidden="true"><path d="M909.3 506.3L781.7 405.6a7.23 7.23 0 00-11.7 5.7V476H548V254h64.8c6 0 9.4-7 5.7-11.7L517.7 114.7a7.14 7.14 0 00-11.3 0L405.6 242.3a7.23 7.23 0 005.7 11.7H476v222H254v-64.8c0-6-7-9.4-11.7-5.7L114.7 506.3a7.14 7.14 0 000 11.3l127.5 100.8c4.7 3.7 11.7.4 11.7-5.7V548h222v222h-64.8c-6 0-9.4 7-5.7 11.7l100.8 127.5c2.9 3.7 8.5 3.7 11.3 0l100.8-127.5c3.7-4.7.4-11.7-5.7-11.7H548V548h222v64.8c0 6 7 9.4 11.7 5.7l127.5-100.8a7.3 7.3 0 00.1-11.4z"></path></svg>
                                </td>
                                <td><?php if($v['service']=='email'){echo '邮箱';}else if($v['service']=='mobile'){echo '手机';}else{echo wp_kses_post($v['service']);}?></td>
                                <td><input type="text" name="username[<?php echo wp_kses_post($v['id'])?>]" size='50' value='<?php echo wp_kses_post($v['username'])?>'></td>
                                <td><input type="text" name="background_color[<?php echo wp_kses_post($v['id'])?>]" size='50' value='<?php echo wp_kses_post($v['background_color'])?>'></td>
                                <td>
                                    <a class="addBtn"><input type="file" size='45' value='<?php echo wp_kses_post($row['image'])?>' notnull></a>
                                    <div class="imgBox">
                                        <div style="width: 50px;height: 50px;border-radius: 500px;background:<?php echo $v['background_color']?> url(<?php echo $img_url.'/'.$v['image']?>) no-repeat center center;background-size:20px; "></div>
                                    </div>
                                </td>
                                <td class="control">
                                    <a href="javascript://" class='save'><?php echo __('Save','infility-global');?></a>
                                    <a href="javascript://" class='del'>删除</a>
                                    <input type="hidden" name="RId[]" value="<?php echo wp_kses_post($v['id'])?>">
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
                    </tbody>
                </table>
            <?php }else if($do=='edit'){ ?>
                <form method="post" id='save_chat_tool' enctype="multipart/form-data">
                    <table class="widefat striped">
                        <tr valign="top">
                            <td width="30%"></td>
                            <td width='70%'></td>
                        </tr>
                        <?php if($RId){ ?>
                            <tr valign="top">
                                <td><label>服务商:</label></td>
                                <td>
                                    <select name="service" value="<?php echo wp_kses_post($row['service'])?>">
                                        <option value="">请选择</option>
                                        <option value="email">邮箱</option>
                                        <option value="mobile">手机</option>
                                        <option value="whatsapp">whatsapp</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><label>账号:</label></td>
                                <td><input type="text" name="username" size='45' value='<?php echo wp_kses_post($row['username'])?>' notnull></td>
                            </tr>
                            <tr valign="top">
                                <td><label>背景颜色:</label></td>
                                <td><input type="text" name="background_color" size='45' value='<?php echo wp_kses_post($row['background_color'])?>' notnull></td>
                            </tr>
                            <tr valign="top">
                                <td><label>图片:</label></td>
                                <td><input type="file" name="image" size='45' value='<?php echo wp_kses_post($row['image'])?>' notnull></td>
                            </tr>
                            <tr valign="top">
                                <td><label>排序:</label></td>
                                <td><input type="text" name="sort" size='45' value='<?php echo wp_kses_post($row['sort'])?>' notnull></td>
                            </tr>
                        <?php }else{ ?>
                            <tr valign="top">
                                <td><label>服务商:</label></td>
                                <td>
                                    <select name="service" value="<?php echo wp_kses_post($row['service'])?>">
                                        <option value="">请选择</option>
                                        <option value="email">邮箱</option>
                                        <option value="mobile">手机</option>
                                        <option value="whatsapp">whatsapp</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><label>账号:</label></td>
                                <td><input type="text" name="username" size='45' value='<?php echo wp_kses_post($row['username'])?>' notnull></td>
                            </tr>
                            <tr valign="top">
                                <td><label>背景颜色:</label></td>
                                <td><input type="text" name="background_color" size='45' value='<?php echo wp_kses_post($row['background_color'])?>' notnull></td>
                            </tr>
                            <tr valign="top">
                                <td><label>图片:</label></td>
                                <td>
                                    <a class="addBtn"><input type="file" size='45' value='<?php echo wp_kses_post($row['image'])?>' notnull></a>
                                    <div class="imgBox"></div>
                                </td>
                            </tr>
                            <tr valign="top">
                                <td><label>排序:</label></td>
                                <td><input type="text" name="sort" size='45' value='0' notnull></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td colspan="2">
                                <input type="submit" name='Save' value="<?php echo __('Save','infility-global');?>" class='button button-primary' />
                                <input type="hidden" name="id" value="<?php echo wp_kses_post($RId)?>">
                                <input type="hidden" name="jumpUrl" value="<?php echo esc_url(home_url(remove_query_arg(array('do'))))?>">
                                <?php wp_nonce_field('redirect_nonce'); ?>
                            </td>
                        </tr>
                    </table>
                </form>
            <?php } ?>
        </div>
        <?php
    }

    function infility_chat_tool_ajax(){
        @extract($_POST, EXTR_PREFIX_ALL, 'p');
        $do_action = sanitize_text_field($p_do_action);
        if ($do_action == 'save') {
            $this->save();
        }elseif($do_action == 'del'){
            $this->del();
        }
    }

    public function save(){
        @extract($_POST, EXTR_PREFIX_ALL, 'p');

        global $wpdb;
        $tableName = $wpdb->prefix.'chat_tool';

        if($p_RId){
            $id = sanitize_text_field($p_RId);
            $row = db::get_one($table,"id='$id'",'*');

            $data = [];
            if(isset($p_username)){
                $data['username'] = sanitize_text_field($p_username);
            }
            if(isset($p_background_color)){
                $data['background_color'] = sanitize_text_field($p_background_color);
            }
            if(isset($p_image)){
                $file_name = $this->uploadImage(sanitize_text_field($p_image),$row['service']);
                if(!$file_name){
                    str::e_json('image must be jpg,jpeg or png',1);
                }
                $data['image'] = $file_name;
            }

            if(empty($data)){
                str::e_json('error',1);
            }

            $wpdb->update($tableName,$data,['id'=>$id]);

        }else if($p_u_sort){
            $sort = sanitize_text_field($p_u_sort);
            $sort = explode(',',$sort);
            foreach($sort as $k=>$v){
                $arr = explode('|',$v);
                $wpdb->update($tableName,['sort'=>$arr[1]],['id'=>$arr[0]]);
            }
        }else{
            if(empty($service = sanitize_text_field($p_service))){
                $error = 'service must not empty';
            }
            if(empty($username = sanitize_text_field($p_username))){
                $error = 'username must not empty';
            }
            if(empty($image = sanitize_text_field($p_image))){
                $error = 'image must not empty';
            }
            if(empty($background_color = sanitize_text_field($p_background_color))){
                $error = 'background_color must not empty';
            }
            $sort = sanitize_text_field($p_sort);
            if(!is_int($sort) && $sort!=0){
                $error = 'sort must be number';
            }

            $file_name = $this->uploadImage($p_image,$p_service);
            if(!$file_name){
                $error = 'image must be jpg,jpeg or png';
            }

            if($error){
                str::e_json($error,0);
            }

            $data = [
                'service'   => $service,
                'username'   => $username,
                'image'   => $file_name,
                'background_color'   => $background_color,
                'sort' => $sort,
                'add_time' => time(),
            ];

            $wpdb->insert($tableName,$data);
        }

        str::e_json('ok',1);
    }

    public function del(){
        @extract($_POST, EXTR_PREFIX_ALL, 'p');

        global $wpdb;
        $tableName = $wpdb->prefix.'chat_tool';

        $id = sanitize_text_field($p_RId);

        if(empty($id)){
            str::e_json('error',0);
        }

        $wpdb->delete($tableName,['id'=>$id]);

        str::e_json('ok',1);
    }

    private function uploadImage($p_image,$p_service=''){
        $file_type = '';
        if(strstr($p_image,'data:image/png;')){
            $p_image = str_replace("data:image/png;base64,","",$p_image);
            $file_type = 'png';
        }else if(strstr($p_image,'data:image/jpg;')){
            $p_image = str_replace("data:image/jpg;base64,","",$p_image);
            $file_type = 'jpg';
        }
        else if(strstr($p_image,'data:image/jpeg;')){
            $p_image = str_replace("data:image/jpeg;base64,","",$p_image);
            $file_type = 'jpeg';
        }else{
            return false;
        }

        $path = $this->path;
        $file_name = $p_service.'_'.time().'_'.rand(0,9).'.'.$file_type;
        if(!is_dir($path)){
            mkdir($path,777);
            chmod($path,0777);
        }

        file_put_contents($path.'/'.$file_name,base64_decode($p_image));

        return $file_name;
    }

    public function show(){ 
        $post_num = did_action('wp_footer');
        if(!is_admin() && $post_num==1){
            global $wpdb;
            $img_url = esc_url( home_url( '/wp-content/uploads/chat-tool' ) );
            $tableName = $wpdb->prefix.'chat_tool';
            $sql = "SELECT * FROM $tableName ORDER BY sort ASC";
            $data = $wpdb->get_results($sql,ARRAY_A);

            $logo_icon = plugins_url('image/',__FILE__).'icon_chat_menu_btn.png';
            $logo_bg = '#07bb8a';
            $top_icon = plugins_url('image/',__FILE__).'icon_chat_menu.png';

            $html = '<div id="infility_tool" state="close">';
            $subHtml = '';
            foreach($data as $k=>$v){
                $img = $img_url.'/'.$v['image'];
                if($v['service']=='email'){
                    $href = 'mailto:'.$v['username'];
                }elseif($v['service']=='mobile'){
                    $href = 'tel:'.$v['username'];
                }elseif($v['service']=='whatsapp'){
                    if(strstr($v['username'],'+')){
                        $whatsapp_name = $v['username'];
                    }else{
                        $whatsapp_name = '+86'.$v['username'];
                    }
                    $href = 'https://api.whatsapp.com/send?phone='.$whatsapp_name.'&text=Hello';
                }elseif($v['service']=='default'){
                    if (!stristr($v['image'], 'icon_chat_menu_btn')) {
                        $v['image'] = $img;
                    }
                    $default_row = $v;
                    continue;
                }
                $subHtml .= '<a class="chat" service="'.$v['service'].'" account="'.$v['username'].'" href="'.$href.'" target="_blank" style="background: '.$v['background_color'].' url('.$img.') no-repeat center center;background-size:20px;display:none"></a>';
            }

            $html .= '<a class="logo" href="javascript:;" style="background:'.($default_row['background_color'] ?? $logo_bg).' url('.($default_row['image']??$logo_icon).') no-repeat center / 24px;"></a>';
            $html .= $subHtml;
            $html .= '<a class="return_top" href="javascript:;" style="background:#b0b0b0 url('.$top_icon.') no-repeat;background-position: 0 -50px;"></a>';
            $html .= '</div>';

            echo $html;
        }
    }
}
new infility_chat_tool();