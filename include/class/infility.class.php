<?php

class infility{
	public static function parameter_string($exclude=''){
		!is_array($exclude) && $exclude=explode(',', str_replace(' ','',$exclude));
		if($_SERVER['QUERY_STRING']){
			$q=@explode('&', $_SERVER['QUERY_STRING']);
			$return='';
			foreach ($q as $k => $v) {
				$tmpData=@explode('=', $v);
				if(in_array($tmpData[0], $exclude)){continue;}
				$return.=$tmpData[0].'='.$tmpData[1].'&';
			}
			$return=substr($return, 0, -1);
			$return=='=' && $return='';
			return $return;
		}else{
			return '';
		}
	}

	public static function get_parameter_string($str){
		$para_ary=@explode('&', trim($str, '?'));
		$parameter_string='';
		foreach($para_ary as $k=>$v){
			$v=trim($v);
			if($v=='' || $v=='='){continue;}
			$parameter_string.="&{$v}";
		}
		return $parameter_string;
	}

	public static function turn_page_html($row_count, $page, $total_pages, $parameter_string){
		if(!$row_count){return;}
		$page<1 && $page = 1;
		ob_start();
		?>
		<div class="pagination-links">
			<?php if($page<=1){ ?>
				<span class="tablenav-pages-navspan button disabled" aria-hidden="true">«</span>
				<span class="tablenav-pages-navspan button disabled" aria-hidden="true">‹</span>
			<?php }else{
				$prePage = $page-1;
				?>
				<a class="first-page button" href="?<?=$parameter_string?>&paged=1">
					<span class="screen-reader-text">首页</span>
					<span aria-hidden="true">«</span>
				</a>
				<a class="prev-page button" href="?<?=$parameter_string?>&paged=<?=$prePage?>">
					<span class="screen-reader-text">上一页</span>
					<span aria-hidden="true">‹</span>
				</a>
			<?php } ?>
			<span class="paging-input">
				第<label for="current-page-selector" class="screen-reader-text">当前页</label>
				<input class="current-page" id="current-page-selector" type="text" name="paged" value="<?=$page?>" size="1" aria-describedby="table-paging">
				<span class="tablenav-paging-text">
					页，共<span class="total-pages"><?=$total_pages?></span>
					页
				</span>
			</span>
			<?php if($page==$total_pages){ ?>
				<span class="tablenav-pages-navspan button disabled" aria-hidden="true">›</span>
				<span class="tablenav-pages-navspan button disabled" aria-hidden="true">»</span>
			<?php }else{
				$nextPage = $page+1;
				$nextPage>$total_pages && $nextPage = $total_pages;
			 ?>
				<a class="next-page button" href="?<?=$parameter_string?>&paged=<?=$nextPage?>">
					<span class="screen-reader-text">下一页</span>
					<span aria-hidden="true">›</span>
				</a>
				<a class="last-page button" href="?<?=$parameter_string?>&paged=<?=$total_pages;?>">
					<span class="screen-reader-text">尾页</span>
					<span aria-hidden="true">»</span>
				</a>
			<?php } ?>
		</div>
<?php
		$html = ob_get_contents();
		ob_end_clean();
		return $html;
	}

	public static function get_openai_chat_text ( $content ) {
		$response = wp_remote_post( 'https://beta.wxkntest.com/wp-admin/admin-ajax.php', array(
			'body' => array(
				'action' => 'infility_page_builder_ajax',
				'do_action' => 'openai_text',
				'content' => $content,
			),
			'timeout' => 120,
		) );

		if ( is_wp_error( $response ) )
			return $response;

		return $response['body'];
	}
}
