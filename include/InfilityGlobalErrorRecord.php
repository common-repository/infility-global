<?php

defined( 'ABSPATH' ) || die;

class InfilityGlobalErrorRecord {
    public static function init() {
        $method = $_SERVER['REQUEST_METHOD'];
        $request_uri = $_SERVER['REQUEST_URI'];
        $uri = parse_url( $request_uri, PHP_URL_PATH );

        if ( $method === 'GET' ) {
            self::output_js_code();
            if ( $uri === '/cf7_records' ) {
                add_action( 'wp', [ self::class, 'show_cf7_records' ] );
                // self::show_cf7_records();
            } else if ( $uri === '/cf7_record' || $uri === '/js_error' ) {
                $location = home_url();
                $status = 301;
                status_header( $status );
                header( "X-Redirect-By: Wordpress - Infility Global - Error Record" );
                header( "Location: $location", true, $status );
                exit;
            }
        } else if ( $method === 'POST' ) {
            if ( $uri === '/cf7_record' ) {
                self::deleteOldFiles();
                self::save_cf7_record();
            } else if ( $uri === '/js_error' ) {
                self::deleteOldFiles();
                self::save_js_error();
            }
        }

    }

    public static function output_js_code() {
        if ( ! is_admin() ) {
            add_action( 'wp_head', function () {
                ?><script>
/* 源代码。（使用 gulp 打包）
;(function () {
	let init = function () {
		var form, i;
		var forms = document.getElementsByClassName('infility-form') // HTMLCollection
		for (i = 0; i < forms.length; i++) {
			form = forms[i]
			if (form.tagName === 'FORM') {
				initOneForm(forms[i])
			}
		}
		forms = document.getElementsByClassName('wpcf7-form') // HTMLCollection
		for (i = 0; i < forms.length; i++) {
			form = forms[i]
			if (form.tagName === 'FORM') {
				initOneForm(forms[i])
			}
		}
	}

	let ajax = function (method, url, data = '') {
		let xhr = new XMLHttpRequest()
		xhr.open(method, url)
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded')
		xhr.send(data)
	}

	let submitRecord = function (form) {
		let dataArr = []

		var no_set = 1;

		for (var i = 0; i < form.elements.length; i++) {
			var element = form.elements[i];
			var name = element.name;
			var type = element.type;
			var value = element.value;

			if (tag === 'BUTTON') continue;
			if (tag === 'INPUT' && type === 'submit') continue;

			if (!name) {
				name = 'name_no_set_'+no_set;
				no_set++;
			}

			if (type === 'file') {
				continue;
			}

			if (type === 'password') {
				value = '***';
			}

			value = encodeURIComponent(value);

			dataArr.push([name, value].join('='));
		}


		// console.log('POST', '/cf7_record', dataArr.join('&'))
		ajax('POST', '/cf7_record', dataArr.join('&'))
	}

	let initOneForm = function (form) {
		if (form.infility_cf7_record_init) return
		form.infility_cf7_record_init = true

		let inputSubmits = form.getElementsByTagName('input')
		for (let i = 0; i < inputSubmits.length; i++) {
			if (inputSubmits[i].type === 'submit') {
				inputSubmits[i].addEventListener('click', function (event) {
					submitRecord(form)
				})
			}
		}

		let buttonSubmits = form.getElementsByTagName('button')
		for (let i = 0; i < buttonSubmits.length; i++) {
			if (buttonSubmits[i].type === 'submit') {
				buttonSubmits[i].addEventListener('click', function (event) {
					submitRecord(form)
				})
			}
		}

		if ( inputSubmits.length === 0 && buttonSubmits.length === 0 ) {
			form.addEventListener('submit', function (event) {
				submitRecord(form)
			})
		}
	}

	window.addEventListener('load', function () {
		init()
	})
	document.addEventListener('DOMContentLoaded', function () {
		init()
	})
	init()
	setInterval(() => {
		init()
	}, 3 * 1000);
})();
*/
                    // cf7 log
(function () {
  var init = function init() {
    var form, i;
    var forms = document.getElementsByClassName('infility-form'); // HTMLCollection
    for (i = 0; i < forms.length; i++) {
      form = forms[i];
      if (form.tagName === 'FORM') {
        initOneForm(forms[i]);
      }
    }
    forms = document.getElementsByClassName('wpcf7-form'); // HTMLCollection
    for (i = 0; i < forms.length; i++) {
      form = forms[i];
      if (form.tagName === 'FORM') {
        initOneForm(forms[i]);
      }
    }
  };
  var ajax = function ajax(method, url) {
    var data = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : '';
    var xhr = new XMLHttpRequest();
    xhr.open(method, url);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.send(data);
  };
  var submitRecord = function submitRecord(form) {
    var dataArr = [];
    var no_set = 1;
    for (var i = 0; i < form.elements.length; i++) {
      var element = form.elements[i];
      var tag = element.tagName;
      var name = element.name;
      var type = element.type;
      var value = element.value;
      if (tag === 'BUTTON') continue;
      if (tag === 'INPUT' && type === 'submit') continue;
      if (!name) {
        name = 'name_no_set_' + no_set;
        no_set++;
      }
      if (type === 'file') {
        continue;
      }
      if (type === 'password') {
        value = '***';
      }
      value = encodeURIComponent(value);
      dataArr.push([name, value].join('='));
    }

    // console.log('POST', '/cf7_record', dataArr.join('&'))
    ajax('POST', '/cf7_record', dataArr.join('&'));
  };
  var initOneForm = function initOneForm(form) {
    if (form.infility_cf7_record_init) return;
    form.infility_cf7_record_init = true;
    var inputSubmits = form.getElementsByTagName('input');
    for (var i = 0; i < inputSubmits.length; i++) {
      if (inputSubmits[i].type === 'submit') {
        inputSubmits[i].addEventListener('click', function (event) {
          submitRecord(form);
        });
      }
    }
    var buttonSubmits = form.getElementsByTagName('button');
    for (var _i = 0; _i < buttonSubmits.length; _i++) {
      if (buttonSubmits[_i].type === 'submit') {
        buttonSubmits[_i].addEventListener('click', function (event) {
          submitRecord(form);
        });
      }
    }
    if (inputSubmits.length === 0 && buttonSubmits.length === 0) {
      form.addEventListener('submit', function (event) {
        submitRecord(form);
      });
    }
  };
  window.addEventListener('load', function () {
    init();
  });
  document.addEventListener('DOMContentLoaded', function () {
    init();
  });
  init();
  setInterval(function () {
    init();
  }, 3 * 1000);
})();
                </script><script>
                    // js error code
                    window.onerror = function (msg, url, lineNo, columnNo, error) {
                        var createXMLHttpRequest = function () {
                            var xmlHttp
                            if(window.XMLHttpRequest){
                                xmlHttp = new XMLHttpRequest();
                            }else if(window.ActiveXObject){
                                xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
                            }
                            return xmlHttp
                        };
                        var data = 'message=' + encodeURIComponent(msg)
                            + '&filename=' + encodeURIComponent(url)
                            + '&lineno=' + lineNo
                            + '&colno=' + columnNo
                            + '&stack=' + ((error && error.stack) ? encodeURIComponent(error.stack) : '');
                        var xhr = createXMLHttpRequest();
                        if (!xhr) { return; }
                        xhr.open('POST', '/js_error', true);
                        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                        xhr.send(data);
                    };
                </script><?php
            } );
        }
    }

    public static function save_js_error () {
        $user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
        $origin = isset( $_SERVER['HTTP_ORIGIN'] ) ? $_SERVER['HTTP_ORIGIN'] : '';
        $referer = isset( $_SERVER['HTTP_REFERER'] ) ? $_SERVER['HTTP_REFERER'] : ''; // Referer

        // CORS headers
        header( 'Access-Control-Allow-Origin: ' . $origin );
        header( 'Access-Control-Allow-Headers: Content-Type' );
        header( 'Access-Control-Allow-Methods: POST' );

        if ( $origin ) $host = parse_url( $origin, PHP_URL_HOST ); // 没有端口号
        else $host = 'origin_not_set';

        $log_path = ABSPATH . 'wp-content/uploads/js_error';
        if ( ! is_dir( $log_path ) ) {
            mkdir( $log_path );
        }
        $log_path = $log_path . '/' . $host;
        if ( ! is_dir( $log_path ) ) {
            mkdir( $log_path );
        }
        $log_file = $log_path . '/' . date( 'Ymd-His' ) . '-' . rand(1000, 9999) . '.log';
        file_put_contents( $log_file, json_encode( [
            'message' => isset( $_POST['message'] ) ? $_POST['message'] : '',
            'filename' => isset( $_POST['filename'] ) ? $_POST['filename'] : '',
            'lineno' => isset( $_POST['lineno'] ) ? $_POST['lineno'] : '',
            'colno' => isset( $_POST['colno'] ) ? $_POST['colno'] : '',
            'stack' => isset( $_POST['stack'] ) ? $_POST['stack'] : '',
            'host' => $host,
            'origin' => $origin,
            'referer' => $referer,
            'user_agent' => $user_agent,
        ], JSON_PRETTY_PRINT ) );

        die;
    }

    public static function save_cf7_record () {
        $origin = isset( $_SERVER['HTTP_ORIGIN'] ) ? $_SERVER['HTTP_ORIGIN'] : '';

        // CORS headers
        header( 'Access-Control-Allow-Origin: ' . $origin );
        header( 'Access-Control-Allow-Headers: Content-Type' );
        header( 'Access-Control-Allow-Methods: POST' );

        if ( $origin ) $host = parse_url( $origin, PHP_URL_HOST ); // 没有端口号
        else $host = 'origin_not_set';

        $log_path = ABSPATH . 'wp-content/uploads/cf7_record';
        if ( ! is_dir( $log_path ) ) {
            mkdir( $log_path );
        }
        $log_path = $log_path . '/' . $host;
        if ( ! is_dir( $log_path ) ) {
            mkdir( $log_path );
        }
        $log_file = $log_path . '/' . date( 'Ymd-His' ) . '-' . rand(1000, 9999) . '.log';
        file_put_contents( $log_file, json_encode( $_POST, JSON_PRETTY_PRINT ) );

        die;
    }

    public static function show_cf7_records () {
        if ( ! is_user_logged_in() ) return;
        $type = isset( $_GET['type'] ) ? $_GET['type'] : '';
        $domain = isset( $_GET['domain'] ) ? $_GET['domain'] : '';
        $date = isset( $_GET['date'] ) ? $_GET['date'] : '';
        $base_dir = ABSPATH . 'wp-content/uploads';
        $js_dir = $base_dir . '/js_error';
        $cf7_dir = $base_dir . '/cf7_record';
        ?><!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Infility Tools Error Records</title>
            <style>
                table {
                    border-collapse: collapse;
                }
                table, th, td {
                    border: 1px solid black;
                }
                th, td {
                    padding: 5px;
                    text-align: left;
                }
            </style>
        </head>
        <body><?php
        if ( $type === 'js' ) {
            $target_dir = $js_dir . '/' . $domain;
            $names = scandir( $target_dir );
            $names = array_diff( $names, [ '.', '..' ] );
            if ( $date ) {
                $names = array_filter( $names, function ( $name ) use ( $date ) {
                    return strpos( $name, $date ) !== false;
                });
            }
            ?>
            <table>
                <tr>
                    <th>Log</th>
                    <th>Message</th>
                    <th>File Name</th>
                    <th>Line</th>
                </tr>
                <?php
                foreach ($names as $name) {
                    $file = $target_dir . '/' . $name;
                    $obj = json_decode( file_get_contents( $file ), true );
                    echo '<tr>'
                        . '<td nowrap><a href="/wp-content/uploads/js_error/' . $domain . '/' . $name . '" target="_blank">' . $name . '</a></td>'
                        . '<td nowrap>' . $obj['message'] . '</td>'
                        . '<td nowrap>' . $obj['filename'] . '</td>'
                        . '<td nowrap>' . $obj['lineno'] . '</td>'
                        . '</tr>';
                }
                ?>
            </table>
            <?php
        } else if ( $type === 'cf7' ) {
            $target_dir = $cf7_dir . '/' . $domain;
            $names = scandir( $target_dir );
            $names = array_diff( $names, [ '.', '..' ] );
            if ( $date ) {
                $names = array_filter( $names, function ( $name ) use ( $date ) {
                    return strpos( $name, $date ) !== false;
                });
            }
            ?>
            <table>
                <tr>
                    <th>日志文件</th>
                    <th>your-name</th>
                    <th>your-email</th>
                    <th>your-phone</th>
                    <th>your-message</th>
                    <th>所有数据</th>
                </tr>
                <?php
                foreach ($names as $name) {
                    $file = $target_dir . '/' . $name;
                    $file_content = file_get_contents( $file );
                    $obj = json_decode( $file_content, true );
                    echo '<tr>'
                        . '<td nowrap><a href="/wp-content/uploads/cf7_record/' . $domain . '/' . $name . '" target="_blank">' . $name . '</a></td>'
                        . '<td nowrap>' . ( isset( $obj['your-name'] ) ? $obj['your-name'] : ( isset( $obj['name'] ) ? $obj['name'] : '' )) . '</td>'
                        . '<td nowrap>' . ( isset( $obj['your-email'] ) ? $obj['your-email'] : ( isset( $obj['email'] ) ? $obj['email'] : '' )) . '</td>'
                        . '<td nowrap>' . ( isset( $obj['your-phone'] ) ? $obj['your-phone'] : ( isset( $obj['phone'] ) ? $obj['phone'] : '' )) . '</td>'
                        . '<td nowrap>' . ( isset( $obj['your-message'] ) ? $obj['your-message'] : ( isset( $obj['message'] ) ? $obj['message'] : '' )) . '</td>'
                        . '<td style="word-break: break-all; word-wrap: break-word;">' . $file_content . '</td>'
                        . '</tr>';
                }
                ?>
            </table>
            <?php
        } else {
            // get all names under the directory
            $js_names = scandir( $js_dir );
            $js_names = array_diff( $js_names, [ '.', '..' ] );
            $js_names = array_values( $js_names );

            echo '<div>JS</div>';
            foreach ($js_names as $i => $name) {
                echo '<a href="/cf7_records?type=js&domain=' . $name . '&date=' . date('Ymd') . '" target="_blank">' . $name . '</a> &nbsp; '
                    . '<a href="/cf7_records?type=js&domain=' . $name . '&date=' . date('Ymd', strtotime( '-1 day' )) . '" target="_blank">' . date('Ymd', strtotime( '-1 day' )) . '</a>'
                    . '<br/>';
            }

            $cf7_names = scandir( $cf7_dir );
            $cf7_names = array_diff( $cf7_names, [ '.', '..' ] );
            $cf7_names = array_values( $cf7_names );

            echo '<div>CF7</div>';
            foreach ($cf7_names as $i => $name) {
                echo '<a href="/cf7_records?type=cf7&domain=' . $name . '&date=' . date('Ymd') . '" target="_blank">' . $name . '</a> &nbsp; '
                    . '<a href="/cf7_records?type=cf7&domain=' . $name . '&date=' . date('Ymd', strtotime( '-1 day' )) . '" target="_blank">' . date('Ymd', strtotime( '-1 day' )) . '</a>'
                    . '<br/>';
            }
        }
        echo '</body></html>';
        die;
    }

    public static function deleteOldFiles () {
        $option_key = 'infility_global_delete_old_files';
        $today = date( 'Ymd' );
        $option = get_option( $option_key );
        if ( $option === $today ) {
            return;
        }
        update_option( $option_key, $today );

        $scan_directory = function ( string $dir_path, int $days ) {
            $domains = scandir( $dir_path );
            $domains = array_diff( $domains, [ '.', '..' ] );
            foreach ($domains as $domain) {
                if ( is_dir( $dir_path . '/' . $domain ) ) {
                    $names = scandir( $dir_path . '/' . $domain );
                    $names = array_diff( $names, [ '.', '..' ] );
                    foreach ($names as $name) {
                        if ( time() - filemtime( $dir_path . '/' . $domain . '/' . $name ) > 86400 * $days ) {
                            unlink( $dir_path . '/' . $domain . '/' . $name );
                        }
                    }
                }
            }
        };

        $scan_directory( ABSPATH . 'wp-content/uploads/js_error', 14 );
        $scan_directory( ABSPATH . 'wp-content/uploads/cf7_record', 30 );
    }
}
InfilityGlobalErrorRecord::init();
