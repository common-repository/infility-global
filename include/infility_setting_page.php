<div class="wrap">
	<h2><?php echo __('Infility Public Plugin Settings','infility-global')?></h2>
	<form action="" method="post" id="CFP_plugins_setting">
		<table class="widefat striped" style="margin-top:10px;">
			<tr valign="top">
				<th nowrap="nowrap" width="5%">序号</th>
				<th nowrap="nowrap" width="35%">插件</th>
				<th nowrap="nowrap" width="5%">教程</th>
				<td width="40%">简述</td>
				<td width="75">操作</td>
			</tr>
			<?php foreach ($optionAry['plugins'] as $k => $v) {
				$guide_url = home_url(remove_query_arg(array('set_type','GuidePage'))) . '&GuidePage='.$k;
				?>
				<tr valign="top">
					<td><?php echo wp_kses_post(++$i);?></td>
					<td><?php echo wp_kses_post($this->infility_global_get_plugins_config($k,$v?'href':'title'))?></td>
					<td><a href="<?php echo esc_url($guide_url)?>">教程</a></td>
					<td><?php echo wp_kses_post($this->infility_global_get_plugins_config($k,'brief'))?></td>
					<td>
						<?php if ($this->infility_global_get_plugins_config($k,'swtich')!=0) { ?>
							<input type="checkbox" name="<?php echo wp_kses_post($k)?>_swtich" class='plugin_swtich' key='<?=$k?>' value="1" <?php checked(1,$v)?>>开关
						<?php } ?>
					</td>
				</tr>
			<?php } ?>
			<?php /* ?><tr valign="top">
				<td></td>
				<td></td>
				<td></td>
				<td></td>
				<td>
					<input type="submit" name='Save' value="<?php echo __('Save','infility-global')?>" class='button button-primary' />
					<?php wp_nonce_field('IGP_nonce'); ?>
				</td>
			</tr>*/?>
		</table>
	</form>
</div>
