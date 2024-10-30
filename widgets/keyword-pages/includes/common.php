<?php

class infility_global_keyword_pages_common {

	public static function get_file () {
		$file = wp_upload_dir()['basedir'] . '/infility-global-keywords.php';
		return $file;
	}

	public static function read_keywords_object () {
		$file = self::get_file();
		if ( is_file( $file ) ) {
			$keywords = include $file;
		} else {
			$keywords = array(
				'data_version' => 1,
				'max_id' => 0,
				'settings' => array( 'post_type' => '', 'taxonomy' => '' ),
				'whyus' => array(),
				'list' => array(),
			);
		}
		return $keywords;
	}

	public static function write_keywords_object ( $keywords ) {
		$file = self::get_file();
		$code = var_export( $keywords, true );
		$code = '<?php return ' . $code . ';';
		file_put_contents( $file, $code );
		return $keywords;
	}
}
