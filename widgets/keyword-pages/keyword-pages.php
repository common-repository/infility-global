<?php

class keyword_pages {
	public function __construct()
	{
		require_once('includes/common.php');

		add_action( 'wp_enqueue_scripts', [ $this, 'front_end_scripts'] );
		add_action( 'admin_enqueue_scripts', [ $this, 'admin_scripts'] );
		add_action( 'plugins_loaded', [ $this, 'render_sitemap_xml'] );

		add_filter( 'template_include', [ $this, 'use_custom_template' ] );

		add_action( 'wp_ajax_infility_global_keyword_pages_ajax', [ $this, 'infility_global_keyword_pages_ajax' ] );
		add_action( 'wp_ajax_nopriv_infility_global_keyword_pages_ajax', [ $this, 'infility_global_keyword_pages_ajax' ] );

		add_shortcode( 'infility_global_keywords', [ $this, 'shortcode_infility_global_keywords' ] );
	}

	public function keyword_pages_setting_page () {
		// 公共代码写在前面。 panel 代码写在 panel 里面。
		?>
		<div class="wrap infility-global-keyword-pages">
			<h1>Keyword Pages</h1>
			<div>
				<p class="description">根据关键词自动生成页面</p>
			</div>
			<!-- <form method="post" action="options.php"> -->
				<?php
				// settings_fields( 'keyword_pages' );
				// do_settings_sections( 'keyword_pages' );
				// submit_button();
				?>
			<!-- </form> -->
			<div class="tabs">
				<div class="tab-titles">
					<div class="tab">关键词管理</div>
					<div class="tab">关键词导入</div>
					<div class="tab">Why choose us</div>
					<div class="tab">设置</div>
				</div>
				<div class="tab-containers">
					<div class="panel panel-list">
						<div class="btn-wrap">
							<button class="button button-primary btn-add-keyword">添加 keyword</button>
							<!-- <button class="button button-primary btn-import">批量上传 keyword</button> -->
						</div>
						<!-- <table class="wp-list-table widefat fixed striped table-view-list posts" cellspacing="0"> -->
						<table class="table widefat striped" cellspacing="0">
							<thead>
								<tr>
									<th nowrap>主词</th>
									<th>关键词</th>
									<th>What is KEYWORD</th>
									<th>KEYWORD by <?php echo esc_html( get_bloginfo( 'name' ) ); ?></th>
									<th>FAQ</th>
									<th width="100">操作</th>
								</tr>
							</thead>
							<tbody class="tr-template">
								<tr>
									<td class="is_main_keyword" nowrap></td>
									<td nowrap>
										<div class="keyword"></div>
										<div class="slug"></div>
									</td>
									<td>
										<div class="description"></div>
									</td>
									<td>
										<div class="description2"></div>
									</td>
									<td class="faq">
										<div class="q1"></div>
										<div class="a1"></div>
										<div class="q2"></div>
										<div class="a2"></div>
										<div class="q3"></div>
										<div class="a3"></div>
									</td>
									<td>
										<button class="button button-small btn-edit">编辑</button>
										<button class="button button-link button-link-delete btn-delete">删除</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
					<div class="panel panel-import">
						<div class="panel-wrap">
							<div class="panel-cont">
								<div>
									<select name="" id="" class="ipt-parent"></select>
									<button class="button btn-refresh-main-list">刷新</button>
								</div>
								<div>
									<textarea name="" id="" cols="" rows="20" class="large-text"></textarea>
								</div>
								<div>
									<button class="button button-primary btn-import">Import</button>
								</div>
							</div>
							<div class="panel-cont div-log">
								<!-- <table class="table widefat striped"> -->
								<table>
									<!-- <thead>
										<tr>
											<th>时间</th>
											<th>事项</th>
											<th>值</th>
										</tr>
									</thead> -->
									<tbody></tbody>
								</table>
							</div>
						</div>
					</div>
					<div class="panel panel-whyus">
						<table class="table widefat striped">
							<thead>
								<tr>
									<th style="width: 28px;">序号</th>
									<th style="width:20%">图片</th>
									<th style="width:20%">ALT</th>
									<th style="width:20%">标题</th>
									<th style="width:20%">内容</th>
									<th>操作</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td class="index"></td>
									<td class="image">
										<img src="" alt="" style="width: 100px;">
										<button class="button button-primary btn-select-image">选择图片</button>
										<button class="button button-link button-link-delete btn-delete-image">删除图片</button>
									</td>
									<td class="alt"><input type="text" class="regular-text" /></td>
									<td class="title">
										<input type="text" class="regular-text" />
									</td>
									<td class="desc">
										<textarea name="" id="" rows="3" class="large-text"></textarea>
									</td>
									<td>
										<button class="button button-primary btn-save">保存</button>
										<button class="button button-link button-link-delete btn-delete">删除</button>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr class="tr-add">
									<td></td>
									<td>
										<img src="" alt="" style="width: 100px;" />
										<input type="hidden" class="ipt-image-url" />
										<button class="button btn-select-image-to-add">Select</button>
									</td>
									<td>
										<input type="text" class="regular-text ipt-image-alt" />
									</td>
									<td>
										<input type="text" class="regular-text ipt-title" />
									</td>
									<td>
										<textarea name="" id="" rows="3" class="large-text ipt-desc"></textarea>
									</td>
									<td>
										<button class="button button-primary btn-add">Add</button>
									</td>
								</tr>
							</tfoot>
						</table>
					</div>
					<div class="panel panel-settings">
						<?php // 代码按 panel 来编写，方便区分管理
						// 获取所有 post type （show_ui）
						// $post_types = get_post_types( array( 'show_ui' => true ), 'objects' ); // array( name => object( name label ) )

						// 获取所有 taxonomy
						// $taxonomies = get_taxonomies( array( 'show_in_menu' => true ), 'objects' ); // array( name => object( name label ) )
						?>
						<table class="form-table">
							<tbody>
								<tr>
									<th>产品</th>
									<td>
										<select name="" id="" class="ipt-post-type">
											<option value="">Please wait ...</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>产品分类</th>
									<td>
										<!-- get_object_taxonomies -->
										<select name="" id="" class="ipt-taxonomy">
											<option value="">Please wait ...</option>
										</select>
									</td>
								</tr>
								<tr>
									<th>Image for banner</th>
									<td>
										<input type="text" class="regular-text ipt-banner-image" />
										<button class="button btn-select-banner-image">Select</button>
									</td>
								</tr>
								<tr>
									<th>Image for "What is"</th>
									<td>
										<input type="text" class="regular-text ipt-whatis-image" />
										<button class="button btn-select-whatis-image">Select</button>
									</td>
								</tr>
								<tr>
									<th>Image alt for "What is"</th>
									<td>
										<input type="text" class="regular-text ipt-whatis-image-alt" />
									</td>
								</tr>
								<tr>
									<th>Image for "FAQ"</th>
									<td>
										<input type="text" class="regular-text ipt-faq-image" />
										<button class="button btn-select-faq-image">Select</button>
									</td>
								</tr>
								<tr>
									<th>Image alt for "FAQ"</th>
									<td>
										<input type="text" class="regular-text ipt-faq-image-alt" />
									</td>
								</tr>
								<tr>
									<th>Link to "contact us"</th>
									<td>
										<input type="text" class="regular-text ipt-link" />
									</td>
								</tr>
								<tr>
									<th>Theme color: </th>
									<td></td>
								</tr>
								<tr>
									<th></th>
									<td>
										<button class="button button-primary btn-save">Save</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>

			<div class="keyword-editor">
				<div class="keyword-editor-wrap">
					<div class="loading"></div>
					<div class="label">主词</div>
					<div>
						<select name="parent" id="" class="ipt-parent">
							<option value="0">（无）</option>
							<option value="0">a</option>
						</select>
					</div>
					<div class="label">关键词</div>
					<div><input type="text" class="regular-text ipt-keyword" /></div>
					<div class="label">slug: <span class="slug"></span></div>
					<div class="label">
						描述(what is <span class="keyword"></span>)&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="button button-small btn-generate-what-is">AI 生成</button>
						<span class="span-loading span-loading-1"></span>
					</div>
					<div><textarea class="large-text code ipt-description" name="" id="" cols="30" rows="5"></textarea></div>
					<div class="label">
						描述(<span class="keyword"></span> by <?php echo esc_html( get_bloginfo( 'name' ) ) ?>)
						&nbsp;&nbsp;&nbsp;&nbsp;
						<select name="" id="" class="ipt-template-select">
							<option value="-1">随机模板</option>
							<option value="0">模板1 ( Introducing top-notch ... )</option>
							<option value="1">模板2 ( Step into ... )</option>
							<option value="2">模板3 ( Discover ... )</option>
							<option value="3">模板4 ( Unleash possibilities ... )</option>
						</select>
						<button class="button button-small btn-generate-description-2">生成</button>
					</div>
					<div><textarea class="large-text code ipt-description2" name="" id="" cols="30" rows="5"></textarea></div>
					<div class="label">
						FAQ&nbsp;&nbsp;&nbsp;&nbsp;
						<button class="button button-small btn-ai-generate-faq">AI 生成</button>
						&nbsp;(自动覆盖，不再提示)
						&nbsp;<span class="span-loading span-loading-2"></span>
					</div>
					<div class="faq">
						<div class="q1"><input type="text" class="regular-text ipt-q1" placeholder="Question 1" /></div>
						<div class="a1"><textarea type="text" class="large-text code ipt-a1" placeholder="Answer 1" rows="3"></textarea></div>
						<div class="q2"><input type="text" class="regular-text ipt-q2" placeholder="Question 2" /></div>
						<div class="a2"><textarea type="text" class="large-text code ipt-a2" placeholder="Answer 2" rows="3"></textarea></div>
						<div class="q3"><input type="text" class="regular-text ipt-q3" placeholder="Question 3" /></div>
						<div class="a3"><textarea type="text" class="large-text code ipt-a3" placeholder="Answer 3" rows="3"></textarea></div>
					</div>
					<div class="label">排序（越大越靠前）</div>
					<div><input type="text" class="regular-text ipt-order" /></div>
					<div>
						<input type="hidden" name="id" class="ipt-id">
					</div>
					<div class="btn-wrap">
						<button class="button button-primary btn-save">保存</button>
						<button class="button btn-cancel">取消</button>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

	public function front_end_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_script( 'infility_global_keyword_pages_common_js', plugins_url('dist/js/common.min.js', __FILE__), array( 'jquery' ), INFILITY_GLOBAL_VERSION, /* in_footer */ true );
		wp_enqueue_script( 'infility_global_keyword_pages_main_js', plugins_url('dist/js/main.min.js', __FILE__), array( 'jquery', 'infility_global_keyword_pages_common_js' ), INFILITY_GLOBAL_VERSION, /* in_footer */ true );
		wp_enqueue_style( 'infility_global_keyword_pages_main_css', plugins_url('dist/css/main.min.css', __FILE__), /* string[] deps */ array(), INFILITY_GLOBAL_VERSION, /* string media */ 'all' );
	}

	public function admin_scripts() {
		wp_enqueue_script( 'jquery' );
		wp_enqueue_media();
		wp_enqueue_script( 'infility_global_keyword_pages_common_js', plugins_url('dist/js/common.min.js', __FILE__), array( 'jquery' ), INFILITY_GLOBAL_VERSION, /* in_footer */ true );
		wp_enqueue_script( 'infility_global_keyword_pages_admin_js', plugins_url('dist/js/admin.min.js', __FILE__), array( 'jquery', 'infility_global_keyword_pages_common_js' ), INFILITY_GLOBAL_VERSION, /* in_footer */ true );
		wp_enqueue_style( 'infility_global_keyword_pages_admin_css', plugins_url('dist/css/admin.min.css', __FILE__), /* string[] deps */ array(), INFILITY_GLOBAL_VERSION, /* string media */ 'all' );
	}

	public function use_custom_template( $template ) {
		global $wp_query;
		// 如果是以 /kwp/ 开头的页面，就使用 plugin 的 template
		if ( $_SERVER['REQUEST_URI'] === '/kwp' ) {
			header( 'HTTP/1.1 302 Found' );
			header( 'Location: /kwp/' );
			exit;
			// header( 'HTTP/1.1 301 Moved Permanently' );
			// header( 'Location: /kwp/' );
		} else if ( $_SERVER['REQUEST_URI'] === '/kwp/' ) {
			// 列出所有 keyword
			// header( 'HTTP/1.1 200 OK' );
			// $wp_query->is_404 = false;
			// $template = plugin_dir_path( __FILE__ ) . 'templates/keywords.php';
			// 暂时设置跳转到首页
			header( 'HTTP/1.1 302 Found' );
			header( 'Location: /' );
			exit;
		} else if ( strpos( $_SERVER['REQUEST_URI'], '/kwp/' ) === 0 ) {

			// $wp_query->my_variable = 'Hello Template File';
			// set_query_var('my_variable ', 'Hello Template File' );
			// $wp_query->set( 'my_variable', 'Hello Template File' );

			$uri = explode( '?', $_SERVER['REQUEST_URI'] )[0];
			$uri = explode( '/', $uri );
			$keyword_slug = $uri[2];

			$object = infility_global_keyword_pages_common::read_keywords_object();

			// 检查 keyword 是否存在
			$keyword = false;
			foreach ($object['list'] as $key => $value) {
				if ( $value['slug'] === $keyword_slug ) {
					$keyword = $value;
					break;
				}
			}
			if ( ! $keyword ) {
				// 关键词不存在，302 到 /kwp/
				header( 'HTTP/1.1 302 Found' );
				header( 'Location: /kwp/' );
				exit;
			}

			$settings = $object['settings'];
			$whyus = $object['whyus'];
			if ( ! isset( $keyword['whyus'] ) ) {
				$keyword['whyus'] = [];
			}
			if ( count( $keyword['whyus'] ) < 1 ) {
				$keyword['whyus'] = $whyus;
			}

			header( 'HTTP/1.1 200 OK' );
			$wp_query->is_404 = false;
			$wp_query->set( 'keyword', $keyword );
			$wp_query->set( 'settings', $settings );

			add_filter( 'pre_get_document_title', function( $title ) use ( $keyword ) {
				return $keyword['keyword'] . ' | ' . get_bloginfo( 'name' );
			}, 20, 1 );

			// wpseo_opengraph_title
			add_filter( 'wpseo_opengraph_title', function( $title ) use ( $keyword ) {
				return $keyword['keyword'] . ' | ' . get_bloginfo( 'name' );
			}, 20, 1 );

			add_action( 'wp_head', function() use ( $keyword ) {
				?>
				<meta content="We supply quality <?php echo esc_attr( $keyword['keyword'] ); ?>, click on to find out more about <?php echo esc_attr( $keyword['keyword'] ); ?>. Get a free quote today." name="description">
    			<meta content="<?php echo esc_attr( $keyword['keyword'] ); ?>" name="keywords">
				<script type="application/ld+json">
					{
						"@context": "https://schema.org",
						"@type": "Organization",
						"url": "<?php echo home_url( $_SERVER['REQUEST_URI'] ); ?>",
						"logo": "https://kjbath.com/wp-content/uploads/2023/01/kangjian_logo.webp"
					}
				</script>
				<?php
			});

			add_filter( 'body_class', function ( $classes, $css_class ) {
				$classes[] = 'infility-kwp';
				return $classes;
			}, 10, 2 );

			$template = plugin_dir_path( __FILE__ ) . 'templates/keyword-page.php';
		}
		return $template;
	}

	public function render_sitemap_xml() {
		if ( $_SERVER['REQUEST_URI'] === '/keyword_sitemap.xml' ) {
			header( 'HTTP/1.1 200 OK' );
			header( 'Content-Type: text/xml' );

			$keywords = infility_global_keyword_pages_common::read_keywords_object()['list'];
			$xml = '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
			$xml .= '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
			foreach ( $keywords as $keyword_item ) {
				$xml .= "\t<url>";
				$xml .= '<loc>' . home_url( '/kwp/' . $keyword_item['slug'] . '/' ) . '</loc>';
				// $xml .= '<lastmod>' . $keyword_item['updated_date'] . '</lastmod>';
				// $xml .= '<changefreq>daily</changefreq>';
				// $xml .= '<priority>0.8</priority>';
				$xml .= '</url>' . "\n";
			}
			$xml .= '</urlset>';
			echo $xml;
			exit;
		}
	}

	public function infility_global_keyword_pages_ajax () {
		$do_action = isset( $_POST['do_action'] ) ? $_POST['do_action'] : '';
		if ( ! $do_action ) {
			wp_send_json_error( '' );
		}
		if ( ! class_exists( 'infility_global_keyword_pages_ajax' ) ) {
			include_once( 'includes/ajax.php' );
		}
		$ajax = new infility_global_keyword_pages_ajax();
		if ( ! method_exists( $ajax, $do_action ) ) {
			wp_send_json_error( 'Undefined action' );
		}
		$ajax->$do_action();
	}

	public function shortcode_infility_global_keywords () {
		$keywords_object = infility_global_keyword_pages_common::read_keywords_object();
		$keywords = $keywords_object['list'];
		ob_start();
		?>
		<div class="infility-kwp-keywords">
			<div class="infility-kwp-keywords-main">
				<?php foreach( $keywords as $k => $keyword ) {
					if ( $keyword['parent'] ) continue;
				?>
					<div class="infility-kwp-keywords-main-item" data-slug="<?php echo esc_attr( $keyword['slug'] ); ?>">
						<a href="/kwp/<?php echo esc_attr( $keyword['slug'] ); ?>/"><?php echo esc_html( $keyword['keyword'] ); ?></a>
					</div>
					<div class="infility-kwp-keywords-sub kw-sub-for-<?php echo esc_attr( $keyword['slug'] ); ?>">
						<?php foreach( $keywords as $k1 => $kw ) {
							if ( $kw['parent'] !== $keyword['id'] ) continue;
						?>
							<div class="infility-kwp-keywords-sub-item kw-slug-<?php echo esc_attr( $kw['slug'] ); ?>">
								<a href="/kwp/<?php echo esc_attr( $kw['slug'] ); ?>/"><?php echo esc_html( $kw['keyword'] ); ?></a>
							</div>
						<?php } ?>
					</div>
				<?php } ?>
			</div>
			<div class="infility-kwp-keywords-show"></div>
		</div>
		<?php
		return ob_get_clean();
	}

	// ################################ 以下 private function ################################
}

new keyword_pages();
