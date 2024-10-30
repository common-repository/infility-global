<?php

class SitemapForMultiLanguages {

	private array $languages;

	public function __construct() {
		// all plugins are loaded
		add_action( 'plugins_loaded', [ $this, 'init' ], 10, 0 );
	}

	public function init() {
		if ( ! defined( 'TRANSPOSH_OPTIONS' ) ) {
			// define('TRANSPOSH_OPTIONS', 'transposh_options');

			// 未启用插件
			return;
		}
		if ( ! function_exists( 'YoastSEO' ) ) {
			return; // Yoast SEO 插件未启用
		}

		$option = get_option( TRANSPOSH_OPTIONS );
		if ( ! $option
			|| ! is_array( $option )
			|| ! isset( $option['default_language'] )
			|| ! isset( $option['viewable_languages'] )
		) {
			// 未配置
			return;
		}

		$this->languages = [];
		$languages = explode( ',', $option['viewable_languages'] );
		foreach ($languages as $lang) {
			if ( $lang === $option['default_language'] ) {
				continue;
			}

			$this->languages[] = $lang;
		}

		// array
		//   default_language
		//   viewable_languages
		//   sorted_languages

		add_filter('wpseo_sitemap_url', [ $this, 'wpseo_sitemap_url' ], 10, 2);
	}

	public function wpseo_sitemap_url ( $output, $url ) {
		$new_output = '';

		try {
			$date = null;

			if ( ! empty( $url['mod'] ) ) {
				// Create a DateTime object date in the correct timezone.
				$date = YoastSEO()->helpers->date->format( $url['mod'] );
			}

			$parsed_url = parse_url( $url['loc'] );
			// $parsed_url = parse_url( 'https://www.baidu.com:8080/qw/ert?a=b&c=d' );

			foreach ($this->languages as $lang) {
				$the_url = $parsed_url['scheme'] . '://' . $parsed_url['host'];
				if ( isset( $parsed_url['port'] ) ) {
					$the_url .= ':' . $parsed_url['port'];
				}
				$the_url .= '/'. $lang . $parsed_url['path'];
				if ( isset( $parsed_url['query'] ) ) {
					$the_url .= '?' . $parsed_url['query'];
				}

				$new_output .= "\t<url>\n";
				$new_output .= "\t\t<loc>" . $this->encode_and_escape( $the_url ) . "</loc>\n";
				$new_output .= empty( $date ) ? '' : "\t\t<lastmod>" . htmlspecialchars( $date, ENT_COMPAT, 'UTF-8', false ) . "</lastmod>\n";
				$new_output .= "\t</url>\n";
			}
		} catch ( Exception $e ) {
			error_log( sprintf(
				"[Infility Global - Sitemap For Multi Languages - wpseo_sitemap_url] %s : %s",
				$e->getMessage(),
				$new_output,
			) );
			error_log( $e->getTraceAsString() );
			$new_output = '';
		}

		return $output . $new_output;
	}

	// ================================ 以下方法复制自 ================================
	// wp-content\plugins\wordpress-seo\inc\sitemaps\class-sitemaps-renderer.php
	// ================================ ================================

	/**
	 * Ensure the URL is encoded per RFC3986 and correctly escaped for use in an XML sitemap.
	 *
	 * This method works around a two quirks in esc_url():
	 * 1. `esc_url()` leaves schema-relative URLs alone, while according to the sitemap specs,
	 *    the URL must always begin with a protocol.
	 * 2. `esc_url()` escapes ampersands as `&#038;` instead of the more common `&amp;`.
	 *    According to the specs, `&amp;` should be used, and even though this shouldn't
	 *    really make a difference in practice, to quote Jono: "I'd be nervous about &#038;
	 *    given how many weird and wonderful things eat sitemaps", so better safe than sorry.
	 *
	 * @link https://www.sitemaps.org/protocol.html#xmlTagDefinitions
	 * @link https://www.sitemaps.org/protocol.html#escaping
	 * @link https://developer.wordpress.org/reference/functions/esc_url/
	 *
	 * @param string $url URL to encode and escape.
	 *
	 * @return string
	 */
	protected function encode_and_escape( $url ) {
		$url = $this->encode_url_rfc3986( $url );
		$url = esc_url( $url );
		$url = str_replace( '&#038;', '&amp;', $url );
		$url = str_replace( '&#039;', '&apos;', $url );

		if ( strpos( $url, '//' ) === 0 ) {
			// Schema-relative URL for which esc_url() does not add a scheme.
			$url = 'http:' . $url;
		}

		return $url;
	}

	/**
	 * Apply some best effort conversion to comply with RFC3986.
	 *
	 * @param string $url URL to encode.
	 *
	 * @return string
	 */
	protected function encode_url_rfc3986( $url ) {

		if ( filter_var( $url, FILTER_VALIDATE_URL ) ) {
			return $url;
		}

		$path = wp_parse_url( $url, PHP_URL_PATH );

		if ( ! empty( $path ) && $path !== '/' ) {
			$encoded_path = explode( '/', $path );

			// First decode the path, to prevent double encoding.
			$encoded_path = array_map( 'rawurldecode', $encoded_path );

			$encoded_path = array_map( 'rawurlencode', $encoded_path );
			$encoded_path = implode( '/', $encoded_path );

			$url = str_replace( $path, $encoded_path, $url );
		}

		$query = wp_parse_url( $url, PHP_URL_QUERY );

		if ( ! empty( $query ) ) {

			parse_str( $query, $parsed_query );

			$parsed_query = http_build_query( $parsed_query, '', '&amp;', PHP_QUERY_RFC3986 );

			$url = str_replace( $query, $parsed_query, $url );
		}

		return $url;
	}
}

new SitemapForMultiLanguages();
