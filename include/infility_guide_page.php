<div class="wrap">
	<h2>
		<?php echo wp_kses_post($name);?> - 教程
		<a href="<?php echo esc_url($mainUrl)?>" class='return'>返回</a>
	</h2>
	<table class="widefat striped">
		<tr valign="top">
			<th nowrap="nowrap">步骤</th>
			<td width="40%">详解</td>
			<td width='40%'>代码</td>
		</tr>
		<?php if($type=='CFP'){ ?>
			<tr valign="top">
				<th nowrap="nowrap">
					第一步<br />
					创建表单
				</th>
				<td class='brief'>
					<img src="<?php echo plugins_url("../images/guide/{$type}_step_1.png",__FILE__);?>" alt=""><br />
					解析:<br />
					1.输入框组: 即为一个label文字 + 一个输入框的组合<br />
					2.输入框name值 作为输入框的代号, 通常用<b>一个</b>或<b>多个</b>英文单词组合  用_或-分隔  例如first_name 或 last-name<br />
					3.表单里面显示在输入框上面或前面的文字,版面是什么就填写什么<br />
					4.在 <?php echo htmlspecialchars('<label>')?> 里面的label后 空格 + <b>w="25"</b>  数字即宽度,不用写% <br />
					5.宽度,不填即100%,可设置10,20,30,40,50,60,70,80,90 和 25(一列4个),33(一列3个)
				</td>
				<td class='code'>
					<textarea><label w="50"> 您的名字 [text* your-name] </label>

<label w="50"> 您的电邮 [email* your-email] </label>

<label> 主题 [text* your-subject] </label>

<label> 您的消息 (可选) [textarea your-message] </label>

[submit "提交"]
					</textarea>
				</td>
			</tr>
		<?php }else if($type=='ETab'){ ?>
			<tr valign="top">
				<th nowrap="nowrap">
					Tab组件
					Elementor里面搜索<br />
					Tab,infility
				</th>
				<td class='brief'>
					<img src="<?php echo plugins_url("../images/guide/{$type}_step_1.png",__FILE__);?>" alt=""><br />
					选中此组件并开始使用,功能和原tab插件基本一样,只是增加了部分控制样式的位置
				</td>
				<td class='code'>N/A</td>
			</tr>
			<tr valign="top">
				<th nowrap="nowrap">
					面包屑组件
					Elementor里面搜索<br />
					breadcrumbs,infility
				</th>
				<td class='brief'>
					<img src="<?php echo plugins_url("../images/guide/elementor_breadcrumbs_1.png",__FILE__);?>" alt=""><br />
					左侧<b>Infility Breadcrumbs</b>是本插件,右边是PP的面包屑<br /><br /><br /><br />

					<table>
						<tr>
							<td>
								<img src="<?php echo plugins_url("../images/guide/elementor_breadcrumbs_3.png",__FILE__);?>" alt=""><br />
							</td>
							<td>
								<b>2.此区域是控制面包屑的内容<br /></b>
									1).<b>Alignment</b>:  对齐方向: 左对齐 居中 右对齐<br /><br />
									2).<b>HTML Tag</b>:  标签选择,选择面包屑用什么标签生成,如无特殊要求默认即可<br /><br />
									3).<b>页面类型</b>:  选择使用此面包屑的页面是什么类型,会根据选的类型,自动生成面包屑<br />共4种:<br />
									<b>Post</b>:一般文章页面,上级是分类的,如:产品,文章<br />
									<b>Page</b>:页面,上级是另一个页面,如about us , contact us<br />
									<b>Category</b>:分类页,上级是分类,如产品分类页<br />
									<b>Tag</b>:标签页,上一级是标签<br />
									<br />
									<br />
									<br />
							</td>
						</tr>
						<tr>
							<td>
								<img src="<?php echo plugins_url("../images/guide/elementor_breadcrumbs_5.png",__FILE__);?>" alt=""><br />
							</td>
							<td>
								<b>4.此区域是控制面包屑的样式<br /></b>
									1).<b>排版</b>: 控制全部文字的样式<br /><br />
									2).<b>Text Color</b>:  控制文字的颜色(除链接外)<br /><br />
									3).<b>Link Color</b>:  控制链接的颜色<br />
									(上方<b>NORMAL</b>表示鼠标没经过时颜色,<b>HOVER</b>表示鼠标经过时颜色,只对链接生效)
									<br />
							</td>
						</tr>
					</table>	
				</td>
				<td class='brief'>
					使用方法:<br />
					<table>
						<tr>
							<td>
								<img src="<?php echo plugins_url("../images/guide/elementor_breadcrumbs_2.png",__FILE__);?>" alt=""><br />
							</td>
							<td>
								<b>1</b>.此区域是添加<b>固定面包屑</b>的,比如:Home,Product,<br/><b>默认有一个Home</b>,后面自动生成的面包屑,都会在固定面包屑后面生成<br />
							</td>
						</tr>
						<tr>
							<td>
								<img src="<?php echo plugins_url("../images/guide/elementor_breadcrumbs_4.png",__FILE__);?>" alt=""><br />
							</td>
							<td>
								<b>3.显示分类<br /></b>
									1).<b>显示</b>: 自动生成此页面的上级面包屑<br />(只有Post,Page,Category能显示分类)<br />
										<b>分类别名</b>:通过CPT UI插件生成的分类,需要填上创建分类时候的别名(slug),如果是默认的文章分类,留空即可<br />
										<b>上级显示数量</b>:固定面包屑与最后一级面包屑(自己)之间,自动生成的上级面包屑显示数量<br />
									<br />
									2).<b>不显示</b>: 即只有固定面包屑+最后一级面包屑(自己)<br /><br />
									<br />
							</td>
						</tr>
					</table>						
				</td>
			</tr>
		<?php }else if($type=='301jump'){ ?>
			<tr valign="top">
				<th nowrap="nowrap">
					链接重定向插件
				</th>
				<td class='brief'>
					功能描述:<br />
					1.可增加网站重定向链接.<br />
					2.根据文档提供的链接,检测是否为死链,然后添加到301重定向队列(<b>文档上传开发未完成,后期补上</b>)<br />
					<br />
					使用步骤<br />
					1.前往<a href="/wp-admin/admin.php?page=infility_global_plugins&set_type=301jump%7Credirect_setting_page">设置</a>,填写要重定向的主域名(<b>图1</b>)<br />
					2.新增重定向的旧链接(域名可填可不填),和要重定向的新链接(首页就填/)<br />
					3.新增时,旧链接可以填多个,<b>一行一个</b>(<b>图2</b>)<br />
				</td>
				<td class='brief'>
					图1:<br /><img src="<?php echo plugins_url("../images/guide/301jump_1.png",__FILE__);?>" alt=""><br />
					图2:<br /><img src="<?php echo plugins_url("../images/guide/301jump_2.png",__FILE__);?>" alt=""><br />
				</td>
			</tr>
		<?php }else if($type=='301jump'){ ?>
			<tr valign="top">
				<th nowrap="nowrap">
					链接重定向插件
				</th>
				<td class='brief'>
					功能描述:<br />
					1.可增加网站重定向链接.<br />
					2.根据文档提供的链接,检测是否为死链,然后添加到301重定向队列(<b>文档上传开发未完成,后期补上</b>)<br />
					<br />
					使用步骤<br />
					1.前往<a href="/wp-admin/admin.php?page=infility_global_plugins&set_type=301jump%7Credirect_setting_page">设置</a>,填写要重定向的主域名(<b>图1</b>)<br />
					2.新增重定向的旧链接(域名可填可不填),和要重定向的新链接(首页就填/)<br />
					3.新增时,旧链接可以填多个,<b>一行一个</b>(<b>图2</b>)<br />
				</td>
				<td class='brief'>
					图1:<br /><img src="<?php echo plugins_url("../images/guide/301jump_1.png",__FILE__);?>" alt=""><br />
					图2:<br /><img src="<?php echo plugins_url("../images/guide/301jump_2.png",__FILE__);?>" alt=""><br />
				</td>
			</tr>
		<?php }else if($type=='PowerBy'){ ?>
			<tr valign="top">
				<th nowrap="nowrap">
					Infility Power By
				</th>
				<td class='brief'>
					功能描述:<br />
					[infility_power_by] 短码自动生成PowerBy 连接到Infility官网
					<br />
					使用步骤<br />
					1.在页脚处Copyright 或指定位置 加上短码[infility_power_by] 自动生成PowerBy<br />
					2.PowerBy的内容和设置在OA上调整<br />
				</td>
				<td class='brief'>
					图1:<br /><img src="<?php echo plugins_url("../images/guide/301jump_1.png",__FILE__);?>" alt=""><br />
					图2:<br /><img src="<?php echo plugins_url("../images/guide/301jump_2.png",__FILE__);?>" alt=""><br />
				</td>
			</tr>
        <?php }else if($type=='ChatTool') {?>
        <tr valign="top">
            <th nowrap="nowrap">
                Infility Chat Tool
            </th>
            <td class='brief'>
                功能描述:<br />
                此功能在前台自动生成Chat Tool 右下聊天工具
                <br />
                使用步骤<br />
                1.打开此功能 自动生成Chat Tool<br />
                2.Chat Tool的内容和设置在OA上调整<br />
            </td>
            <td class='brief'>
                图1:<br /><img src="<?php echo plugins_url("../images/guide/chat_tool_1.png",__FILE__);?>" alt=""><br />
                图2:<br /><img src="<?php echo plugins_url("../images/guide/chat_tool_2.png",__FILE__);?>" alt=""><br />
            </td>
        </tr>
        <?php }else if($type=='TranslateTool') { ?>
            <tr valign="top">
                <th nowrap="nowrap">
                    Infility Chat Tool
                </th>
                <td class='brief'>
                    功能描述:<br />
                    此功能在前台自动生成Translate Tool 语言选择
                    <br />
                    使用步骤<br />
                    1.一键安装语言插件。<br />
                    2.一键启动语言插件。<br />
                    3.选择显示位置，不设置的时候，默认左下角<br />
                    4.如果安装插件失败，请尝试3.1和3.2<br />
                    5.图2配置子目录<br />
                    6.菜单Transposh->Languages配置所需要的语言，一般配置 阿拉伯语、俄语、西班牙语、葡萄牙语、法语、德语、英语、意大利语，如图3所示<br />
                    7.打开此功能 自动生成Translate tool，效果看图1<br />
                    <br />
                    4.1.到<a href="https://transposh.org/download/" target="_blank">https://transposh.org/download/</a>安装并启用"Transposh Translation Filter"插件<br />
                    4.2.安装并启用"Language Switcher for Transposh"插件<br />
                </td>
                <td class='brief'>
                    图1:<br /><img src="<?php echo plugins_url("../images/guide/translate_tool_1.png",__FILE__);?>" alt=""><br />
                    图2:<br /><img src="<?php echo plugins_url("../images/guide/translate_tool_2.png",__FILE__);?>" alt=""><br />
                    图3:<br /><img src="<?php echo plugins_url("../images/guide/translate_tool_3.png",__FILE__);?>" alt=""><br />
                </td>
            </tr>
        <?php }?>
	</table>
</div>

<style>
	.return{font-size: 12px;text-decoration: underline;margin-left: 15px;}
	.widefat.striped .brief{line-height: 26px;}
	.widefat.striped .brief b{font-weight: bold;color: #000}
	.widefat.striped .code textarea{width: 100%;height: 300px;resize:none;}
	.striped>tbody>.white{background: white;}
</style>
