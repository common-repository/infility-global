<?php

class infility_global_keyword_pages_ajax {
	public function __construct()
	{
		//
	}

	public function openai_text () {
		$keyword = $_POST['keyword'];
		$type = $_POST['type'];
		if ( ! $keyword ) {
			wp_send_json_error( 'keyword error');
		}
		if ( $type === 'whatis' ) {
			$content = 'please ignore all the former chat, please explain what is [v[keyword]] in 80 english words(within 300 characters), and the phrase "[v[keyword]]" should appear once in the script. be professional and informative';
		} else if ( $type === 'faq' ) {
			$content = 'I need you to write 3 FAQ for [v[keyword]] in JSON language. Each answer will be within 100 words. Please use this format: [ { "question": "", "answer": "" }, { "question": "", "answer": "" } ]';
		} else {
			wp_send_json_error( 'type error');
		}
		$content = str_replace( '[v[keyword]]', $keyword, $content );
		$cache_key = md5( $content );
		$cache = $this->get_cache( $cache_key ); // string, 含 success, data
		if ( $cache ) {
			wp_send_json_success( json_decode( $cache, true )['data'] );
		}
		$response = '';
		try {
			$response = infility::get_openai_chat_text( $content ); // wp error, or body string (including success, data)
		} catch (Exception $e) {
			wp_send_json_error( $e->getMessage() );
		}
		if ( is_wp_error( $response ) ) {
			wp_send_json_error( $response->get_error_message() );
		} else {
			$ret = json_decode( $response, true );
			if ( $ret['success'] === true ) {
				if ( ! empty( $ret['data'] ) ) {
					$this->set_cache( $cache_key, $response ); // 含 success, data
					wp_send_json_success( $ret['data'] );
				} else {
					wp_send_json_error( 'text is empty' );
				}
			} else {
				wp_send_json_error( $ret['data'] );
			}
		}
	}

	private function get_cache ( $key ) {
		$dir = wp_upload_dir()['basedir'] . '/infility-global-openai-cache/';
		if ( ! is_dir( $dir ) ) {
			wp_mkdir_p( $dir );
		}
		$file = $dir . $key . '.json';
		if ( is_file( $file ) ) {
			$cache = file_get_contents( $file );
		} else {
			$cache = false;
		}
		return $cache;
	}
	private function set_cache ( $key, $value ) {
		$dir = wp_upload_dir()['basedir'] . '/infility-global-openai-cache/';
		if ( ! is_dir( $dir ) ) {
			wp_mkdir_p( $dir );
		}
		$file = $dir . $key . '.json';
		file_put_contents( $file, $value );
	}

	public function get_keyword_list() {
		$keywords = infility_global_keyword_pages_common::read_keywords_object();
		wp_send_json_success( $keywords['list'] );
	}

	public function save_keyword_list() {
		// 定义
		$keywords = infility_global_keyword_pages_common::read_keywords_object();

		// 处理数据
		if ( $_POST['save'] === 'add' ) {
			// 新增
			$parent = $_POST['data']['parent'];
			$keyword = $_POST['data']['keyword'];
			$slug = $_POST['data']['slug'];
			$description = $_POST['data']['description'];
			$description2 = $_POST['data']['description2'];
			$faq = $_POST['data']['faq'];
			$order = $_POST['data']['order'];
			// 验证数据
			if ( ! $keyword ) {
				wp_send_json_error( 'keyword 不能为空' );
			}
			if ( ! $slug ) {
				wp_send_json_error( 'slug 不能为空' );
			}
			if ( ! $description ) {
				wp_send_json_error( 'description 不能为空' );
			}
			if ( ! $description2 ) {
				wp_send_json_error( 'description2 不能为空' );
			}
			if ( ! $parent ) {
				$parent = 0;
			}
			if ( ! $order ) {
				$order = 0;
			}
			$parent = intval( $parent );
			$order = intval( $order );
			// 检查是否已存在相同 keyword
			$index = array_search( $keyword, array_column( $keywords['list'], 'keyword' ) );
			if ( $index !== false ) {
				wp_send_json_error( '已存在相同的keyword' );
			}
			$keywords['list'][] = [
				'id' => $keywords['max_id'] + 1,
				'parent' => $parent,
				'keyword' => $keyword,
				'slug' => $slug,
				'description' => $description,
				'description2' => $description2,
				'faq' => $faq,
				'order' => $order,
				'created_at' => time(),
				'created_dt' => date( 'Y-m-d H:i:s' ),
				'updated_at' => time(),
				'updated_dt' => date( 'Y-m-d H:i:s' ),
				'updated_date' => date( 'Y-m-d\TH:i:s+00:00', time() ),
			];
			$keywords['max_id'] = $keywords['max_id'] + 1;
		} else if ( $_POST['save'] === 'one' ) {
			// 保存1个
			$id = $_POST['data']['id'];
			$parent = $_POST['data']['parent'];
			$keyword = $_POST['data']['keyword'];
			$slug = $_POST['data']['slug'];
			$description = $_POST['data']['description'];
			$description2 = $_POST['data']['description2'];
			$order = $_POST['data']['order'];
			$faq = $_POST['data']['faq'];
			// 验证数据
			if ( ! $id ) {
				wp_send_json_error( 'id 不能为空' );
			}
			if ( ! $keyword ) {
				wp_send_json_error( 'keyword 不能为空' );
			}
			if ( ! $slug ) {
				wp_send_json_error( 'slug 不能为空' );
			}
			if ( ! $description ) {
				wp_send_json_error( 'description 不能为空' );
			}
			if ( ! $description2 ) {
				wp_send_json_error( 'description2 不能为空' );
			}
			if ( ! $parent ) {
				$parent = 0;
			}
			if ( ! $order ) {
				$order = 0;
			}
			$id = intval( $id );
			$parent = intval( $parent );
			$order = intval( $order );
			// 检查是否存在该ID的记录
			// $index = array_search( $id, array_column( $keywords['list'], 'id' ) );
			$found_item = null;
			$index = 0;
			foreach ($keywords['list'] as $index => $keyword_item) {
				if ( $keyword_item['id'] === $id ) {
					$found_item = $keyword_item;
					break;
				}
			}
			if ( ! $found_item ) {
				wp_send_json_error( 'id 不存在' );
			}
			// 检查是否已存在相同 keyword （不同的 ID）
			foreach ($keywords['list'] as $keyword_item) {
				if ( $keyword_item['keyword'] === $keyword && $keyword_item['id'] !== $id ) {
					// 返回错误
					wp_send_json_error( 'keyword 已存在' );
				}
			}
			// 更新
			$keywords['list'][$index]['parent'] = $parent;
			$keywords['list'][$index]['keyword'] = $keyword;
			$keywords['list'][$index]['slug'] = $slug;
			$keywords['list'][$index]['description'] = $description;
			$keywords['list'][$index]['description2'] = $description2;
			$keywords['list'][$index]['faq'] = $faq;
			$keywords['list'][$index]['order'] = $order;
			$keywords['list'][$index]['updated_at'] = time();
			$keywords['list'][$index]['updated_dt'] = date( 'Y-m-d H:i:s' );
			$keywords['list'][$index]['updated_date'] = date( 'Y-m-d\TH:i:s+00:00', time() );
		} else if ( $_POST['save'] === 'del' ) {
			$id = $_POST['data']['id'];
			// 验证数据
			if ( ! $id ) {
				wp_send_json_error( 'id 不能为空' );
			}
			$id = intval( $id );
			// 检查是否存在该ID的记录
			$found_item = null;
			$index = 0;
			foreach ($keywords['list'] as $index => $keyword_item) {
				if ( $keyword_item['id'] === $id ) {
					$found_item = $keyword_item;
					break;
				}
			}
			if ( ! $found_item ) {
				wp_send_json_error( 'id 不存在' );
			}
			// 删除
			array_splice( $keywords['list'], $index, 1 );
		} else if ( $_POST['save'] === 'all' ) {
			// 保存全部
			// $keywords = $_POST['keywords'];
		} else {
			wp_send_json_error( '未知的 save 参数' );
		}

		// 保存数据
		// $code = var_export( $keywords, true );
		// $code = '<?php return ' . $code . ';';
		// file_put_contents( $file, $code );
		infility_global_keyword_pages_common::write_keywords_object( $keywords );

		// 返回
		wp_send_json_success( $keywords );
	}

	public function get_settings () {
		$keywords = infility_global_keyword_pages_common::read_keywords_object();
		$settings = $keywords['settings'];

		$post_types = get_post_types( array( 'public' => true ), 'objects' );
		$settings['post_types'] = [];
		foreach ( $post_types as $post_type ) {
			$taxonomies = get_object_taxonomies( $post_type->name, 'objects' );
			$taxonomy_list = [];
			foreach ( $taxonomies as $taxonomy ) {
				$taxonomy_list[] = [
					'value' => $taxonomy->name,
					'label' => $taxonomy->label,
				];
			}
			$settings['post_types'][] = [
				'value' => $post_type->name,
				'label' => $post_type->label,
				'taxonomies' => $taxonomy_list,
			];
		}

		wp_send_json_success($settings);
	}

	public function get_whyus_list () {
		$keywords = infility_global_keyword_pages_common::read_keywords_object();
		$whyus = $keywords['whyus'];
		wp_send_json_success($whyus);
	}

	public function save_whyus () {
		// 定义
		$keywords = infility_global_keyword_pages_common::read_keywords_object();

		// 处理数据
		if ( isset( $_POST['data'] ) ) {
			$whyus = $_POST['data'];
			$keywords['whyus'] = $whyus;
		}

		// 保存数据
		infility_global_keyword_pages_common::write_keywords_object( $keywords );

		// 返回
		wp_send_json_success( $keywords['whyus'] );
	}

	public function save_settings () {
		// 定义
		$keywords = infility_global_keyword_pages_common::read_keywords_object();

		// 处理数据
		if ( isset( $_POST['data'] ) ) {
			// post type
			$post_type = $_POST['data']['post_type'];
			if ( ! $post_type ) {
				wp_send_json_error( '请选择 post_type');
			}
			$keywords['settings']['post_type'] = $post_type;

			// taxonomy
			$taxonomy = $_POST['data']['taxonomy'];
			if ( ! $taxonomy ) {
				wp_send_json_error( '请选择 taxonomy');
			}
			$keywords['settings']['taxonomy'] = $taxonomy;

			// banner_image
			$banner_image = $_POST['data']['banner_image'];
			$keywords['settings']['banner_image'] = $banner_image;

			// whatis_image
			$whatis_image = $_POST['data']['whatis_image'];
			$keywords['settings']['whatis_image'] = $whatis_image;

			// whatis_image_alt
			$whatis_image_alt = $_POST['data']['whatis_image_alt'];
			$keywords['settings']['whatis_image_alt'] = $whatis_image_alt;

			// faq_image
			$faq_image = $_POST['data']['faq_image'];
			$keywords['settings']['faq_image'] = $faq_image;

			// faq_image_alt
			$faq_image_alt = $_POST['data']['faq_image_alt'];
			$keywords['settings']['faq_image_alt'] = $faq_image_alt;

			// link
			$link = $_POST['data']['link'];
			$keywords['settings']['link'] = $link;
		}

		// 保存数据
		infility_global_keyword_pages_common::write_keywords_object( $keywords );

		// 返回
		wp_send_json_success( $keywords );
	}

	public function keyword_exists () {
		if ( ! isset( $_POST['keyword'] ) ) {
			wp_send_json_error( 'keyword error');
		}
		$keyword = $_POST['keyword'];
		if ( ! $keyword ) {
			wp_send_json_error( 'keyword error');
		}
		$keywords = infility_global_keyword_pages_common::read_keywords_object();
		$exists = false;
		foreach ($keywords['list'] as $keyword_item) {
			if ( $keyword_item['keyword'] === $keyword ) {
				$exists = true;
				break;
			}
		}
		wp_send_json_success( $exists );
	}
}
