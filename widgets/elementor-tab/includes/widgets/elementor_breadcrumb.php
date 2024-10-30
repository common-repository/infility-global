<?php
// namespace ElementorPro\Modules\ThemeElements\Widgets;

use Elementor\Controls_Manager;
use Elementor\Core\Kits\Documents\Tabs\Global_Typography; 
use Elementor\Group_Control_Typography;
use Elementor\Utils;
// use WPSEO_Breadcrumbs;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class elementor_breadcrumb extends \Elementor\Widget_Base {

	public function get_name() {
		return 'inf_breadcrumbs';
	}

	public function get_title() {
		return esc_html__( 'Infility Breadcrumbs', 'elementor-pro' );
	} 

	public function get_icon() {
		return 'ppicon-breadcrumbs';
	}

	public function get_categories() {
		return [ 'infility-category' ];
	}

	public function get_script_depends() {
		return [ 'breadcrumbs' ];
	}

	public function get_keywords() {
		return [ 'yoast', 'seo', 'breadcrumbs', 'internal links','Infility' ];
	}

	protected function register_controls() {
		$this->start_controls_section(
			'section_breadcrumbs_content',
			[
				'label' => esc_html__( 'Infility Breadcrumbs', 'elementor-pro' ),
			]
		);		

		/* Start repeater */

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'tabs_at' );


		$repeater->add_control(
			'text',
			[
				'label' => '文字',
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '内容',
				'default' => '内容',
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'url',
			[
				'label' => '链接',
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => '链接',
				'default' => '/',
				'label_block' => true,
				'dynamic' => [
					'active' => true,
				],
			]
		);
		$repeater->end_controls_tabs();

		/* End repeater */

		$this->add_control(
			'list_items',
			[
				'label' => __( 'List Items', 'infility-global' ),
				'type' => \Elementor\Controls_Manager::REPEATER,
				'fields' => $repeater->get_controls(),           /* Use our repeater */
				'default' => [
					array(
						'tab_title' => __( 'Home', 'infility-global' ),
						'text'		=> __( 'Home', 'infility-global' ),
						'url'		=> '/',
					),
				],
				'title_field' => '{{{ text }}}',
			]
		);	

		$this->add_responsive_control(
			'align',
			[
				'label' => esc_html__( 'Alignment', 'elementor-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'options' => [
					'left' => [
						'title' => esc_html__( 'Left', 'elementor-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => esc_html__( 'Center', 'elementor-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => esc_html__( 'Right', 'elementor-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'elementor%s-align-',
			]
		);

		$this->add_control(
			'html_tag',
			[
				'label' => esc_html__( 'HTML Tag', 'elementor-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => esc_html__( 'Default', 'elementor-pro' ),
					'p' => 'p',
					'div' => 'div',
					'nav' => 'nav',
					'span' => 'span',
				],
				'default' => '',
			]
		);

		$this->add_control(
			'page_type',
			[
				'label' => esc_html__( '页面类型', 'infility-global' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'post' => esc_html__( 'Post', 'infility-global' ),
					'page' => esc_html__( 'Page', 'infility-global' ),
					'category' => esc_html__( 'Category', 'infility-global' ),
					'tag' => esc_html__( 'Tag', 'infility-global' ),
				],
				'default' => 'post',
			]
		);

		$this->add_control(
			'is_category',
			[
				'label' => esc_html__( '显示分类', 'infility-global' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'0' => esc_html__( '不显示', 'infility-global' ),
					'1' => esc_html__( '显示', 'infility-global' ),
				],
				'default' => '0',
				'condition' => array(
					'page_type' => array('post','page','category'),
				),
			]
		);

		$this->add_control(
			'category_slug',
			[
				'label' => esc_html__( '分类别名', 'infility-global' ),
				'type' => Controls_Manager::TEXT,
				'default' => '',
				'condition' => array(
					'is_category' => '1',
				),
			]
		);

		$this->add_control(
			'dept_count',
			[
				'label' => esc_html__( '中间显示数量', 'infility-global' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'1' => 1,
					'2' => 2,
					'3' => 3,
					'4' => 4,
					'5' => 5,
					'6' => 6,
					'7' => 7,
					'8' => 8,
					'9' => 9,
				],
				'default' => '1',
				'condition' => array(
					'is_category' => '1',
					'page_type' => array('post','page','category'),
				),
			]
		);

		// $this->add_control(
		// 	'html_description',
		// 	[
		// 		'raw' => esc_html__( 'Additional settings are available in the Yoast SEO', 'elementor-pro' ) . ' ' . sprintf( '<a href="%s" target="_blank">%s</a>', admin_url( 'admin.php?page=wpseo_titles#top#breadcrumbs' ), esc_html__( 'Breadcrumbs Panel', 'elementor-pro' ) ),
		// 		'type' => Controls_Manager::RAW_HTML,
		// 		'content_classes' => 'elementor-descriptor',
		// 	]
		// );

		$this->end_controls_section();

		$this->start_controls_section(
			'section_style',
			[
				'label' => esc_html__( 'Breadcrumbs', 'elementor-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'typography',
				'selector' => '{{WRAPPER}} #infility_position',
				'global' => [
					'default' => Global_Typography::TYPOGRAPHY_SECONDARY,
				],
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #infility_position>*' => 'color: {{VALUE}};',
				],
			]
		);

		$this->start_controls_tabs( 'tabs_breadcrumbs_style' );

		$this->start_controls_tab(
			'tab_color_normal',
			[
				'label' => esc_html__( 'Normal', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'link_color',
			[
				'label' => esc_html__( 'Link Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '',
				'selectors' => [
					'{{WRAPPER}} #infility_position>*>a' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_tab();

		$this->start_controls_tab(
			'tab_color_hover',
			[
				'label' => esc_html__( 'Hover', 'elementor-pro' ),
			]
		);

		$this->add_control(
			'link_hover_color',
			[
				'label' => esc_html__( 'Color', 'elementor-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} #infility_position>*>a:hover' => 'color: {{VALUE}};',
				],
			]
		);

		$this->end_controls_section();
	}

	private function get_html_tag() {
		$html_tag = $this->get_settings( 'html_tag' );

		if ( empty( $html_tag ) ) {
			$html_tag = 'p';
		}

		return Utils::validate_html_tag( $html_tag );
	}

	protected function render() {
		$html_tag = $this->get_html_tag();
		$settings = $this->get_settings();
		
		$page_type = $settings['page_type'];
		$is_category = $settings['is_category'];
		$dept_count = $settings['dept_count'];

		$obj = get_queried_object();
		$objName = $obj->name;

		if ($page_type=='page' || $page_type=='post') {
			$objName = $obj->post_title;
		}else if($page_type=='category'){
			$objName = $obj->cat_name;
		}		
		if(is_search()){
			$objName = 'Search Results';
		}
		!$objName && $objName = $obj->name;

		if (($_GET['DEBUG'] ?? '')=='CJJ') {
			str::dump($obj);
		}

		$data = array();
		foreach ($settings['list_items'] as $k => $v) {
			$data[] = array(
				'name'	=>	$v['text'],
				'url'	=>	$v['url'],
			);
		}

		if ($is_category) {
			$parantData = array();
			if ($page_type=='page') {
				if ($obj->post_parent) {
					$parent_row = get_post($obj->post_parent);
					unset($parent_row->post_content);
					$parantData[$obj->post_parent] = array(
						'name'	=>	$parent_row->post_title,
						'url'	=>	get_permalink($parent_row->ID),
					);
					if ($parent_row->post_parent>0 && count($parantData)<$dept_count) {
						while ($parent_row->post_parent>0) {
							$parent_row = get_post($parent_row->post_parent);
							unset($parent_row->post_content);
							$parantData[$parent_row->post_parent] = array(
								'name'	=>	$parent_row->post_title,
								'url'	=>	get_permalink($parent_row->ID),
							);
						}
					}
				}
			}else if($page_type=='post'){			
				if ($settings['category_slug']) {
					$category_list = get_the_terms($obj->ID,$settings['category_slug']);
					if(!isset($category_list->errors)){
						if ($category_one = $category_list[0]) {
							$parantData[$category_one->term_id] = array(
								'name'	=>	$category_one->name,
								'url'	=>	get_term_link($category_one->term_id,$settings['category_slug']),
							);			
							if ($category_one->parent>0) {
								while ($category_one->parent>0 && count($parantData)<$dept_count) {
									$category_one = get_term($category_one->parent,$settings['category_slug']);
									if ($category_one->errors) break;
									$parantData[$category_one->term_id] = array(
										'name'	=>	$category_one->name,
										'url'	=>	get_term_link($category_one->term_id,$settings['category_slug']),
									);
								}
							}			
						}
					}
				}else{
					$category_list = get_the_category($obj->ID);
					if(!$category_list->errors){
						if ($category_one = $category_list[0]) {
							$parantData[$category_one->term_id] = array(
								'name'	=>	$category_one->cat_name,
								'url'	=>	get_category_link($category_one->term_id),
							);
							if ($category_one->category_parent>0 && count($parantData)<$dept_count) {
								while ($category_one->category_parent>0) {
									$category_one = get_category($category_one->category_parent);
									if ($category_one->errors) break;
									$parantData[$category_one->term_id] = array(
										'name'	=>	$category_one->cat_name,
										'url'	=>	get_category_link($category_one->term_id),
									);
								}
							}			
						}
					}
				}
			}else if($page_type=='category'){
				if ($settings['category_slug']) {
					if ($obj->parent>0) {
						$category_one = $obj;
						while ($category_one->parent>0 && count($parantData)<$dept_count) {
							$category_one = get_term($category_one->parent,$settings['category_slug']);
							if ($category_one->errors) break;
							$parantData[$category_one->term_id] = array(
								'name'	=>	$category_one->name,
								'url'	=>	get_term_link($category_one->term_id,$settings['category_slug']),
							);
						}
					}	
				}else{
					$category_one = get_category($obj->term_id);
					if ($category_one->category_parent>0) {
						while ($category_one->category_parent>0 && count($parantData)<$dept_count) {
							$category_one = get_category($category_one->category_parent);
							if ($category_one->errors) break;
							$parantData[$category_one->term_id] = array(
								'name'	=>	$category_one->cat_name,
								'url'	=>	get_category_link($category_one->term_id),
							);
						}
					}
				}
			}

			if ($parantData) {
				$parantData = array_reverse($parantData);
			}

			$i = 0;
			foreach ($parantData as $k => $v) {
				if ($i>=$dept_count)  continue;
				$data[] = $v;
				$i++;
			}
		}		

		$data['this'] = array(
			'name'	=>	$objName,
		);
		if (($_GET['DEBUG'] ?? '')=='CJJ') {
			str::dump($data);
			// str::dump($settings);
		}
?>
		<div id="infility_position" class='<?=$settings['align']?>'>
			<?php foreach ($data as $k => $v) {?>
				<?php if($k!==0){ ?> <span>></span> <?php }?>
				<<?=$html_tag?> class='<?=$k?>'>
					<?php if(isset($v['url'])){ ?><a href="<?=$v['url']?>" ><?php } ?>
						<?=$v['name'];?>
					<?php if(isset($v['url'])){ ?></a><?php } ?>
				</<?=$html_tag?>>
			<?php } ?>
		</div>
<?php
	}

	public function get_group_name() {
		return 'theme-elements';
	}
}
