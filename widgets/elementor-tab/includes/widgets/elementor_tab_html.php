<?php
// use PowerpackElements\Modules\AdvancedTabs\Widgets\Advanced_Tabs;

use PowerpackElements\Base\Module_Base;
use PowerpackElements\Base\Powerpack_Widget;
use PowerpackElements\Classes\PP_Config;

use Elementor\Controls_Manager;
use Elementor\Utils;
use Elementor\Icons_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Image_Size;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography as Scheme_Typography;
use Elementor\Core\Schemes\Color as Scheme_Color;


class elementor_tab_html extends \Elementor\Widget_Base {

	public function get_name() {
		return 'elementor_tab_html';
	}

	public function get_title() {
		return __( 'Tab', 'infility-global' );
	}

	public function get_icon() {
		return 'eicon-tabs';
	}

	public function get_categories() {
		return [ 'infility-category' ];
	}

	public function get_keywords() {
		return [ 'Tab' ,'infility','tab'];
	}

	protected function register_controls() {
		$this->register_content_tabs_controls();
		$this->register_content_layout_controls();


		$this->register_style_tabs_controls();
		$this->register_style_title_controls();
		$this->register_style_content_controls();
	}

	protected function register_content_tabs_controls(){
		$this->start_controls_section(
			'content_section',
			[
				'label' => '选项卡设置',
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		/* Start repeater */

		$repeater = new \Elementor\Repeater();

		$repeater->start_controls_tabs( 'tabs_at' );

		$repeater->start_controls_tab(
			'tab_content',
			array(
				'label' => '内容',
			)
		);

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
			'content_type',
			array(
				'label'   => '类型',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'tab_content',
				'options' => array(
					'tab_content' => 'Content',
					'tab_photo'   => 'Image',
					'tab_video'   => 'Link (Video/Image)',
					'section'     => 'Saved Section',
					'widget'      => 'Saved Widget',
					'template'    => 'Saved Page Template',
				),
			)
		);

		$repeater->add_control(
			'content',
			array(
				'label'     => '内容',
				'type'      => \Elementor\Controls_Manager::WYSIWYG,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => __( 'I am tab content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'infility-global' ),
				'condition' => array(
					'content_type' => 'tab_content',
				),
			)
		);

		$repeater->add_control(
			'image',
			array(
				'label'     => '图片',
				'type'      => Controls_Manager::MEDIA,
				'dynamic'   => array(
					'active' => true,
				),
				'default'   => array(
					'url' => Utils::get_placeholder_image_src(),
				),
				'condition' => array(
					'content_type' => 'tab_photo',
				),
			)
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'image',
				'label'     => '图片大小',
				'default'   => 'large',
				'exclude'   => array( 'custom' ),
				'condition' => array(
					'content_type' => 'tab_photo',
				),
			)
		);

		$repeater->add_control(
			'link_video',
			array(
				'label'       => '链接',
				'description' => sprintf( __( 'Check list of supported embeds <a href="%1$s" target="_blank">here</a>.', 'infility-global' ), 'https://wordpress.org/support/article/embeds/' ),
				'type'        => Controls_Manager::TEXT,
				'dynamic'     => array(
					'active' => true,
				),
				'placeholder' => '输入视频链接',
				'label_block' => true,
				'condition'   => array(
					'content_type' => 'tab_video',
				),
			)
		);

		$repeater->add_control(
			'saved_widget',
			array(
				'label'       => '选择小部件',
				'type'        => 'pp-query',
				'label_block' => false,
				'multiple'    => false,
				'query_type'  => 'templates-widget',
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'content_type',
							'operator' => '==',
							'value'    => 'widget',
						),
					),
				),
			)
		);

		$repeater->add_control(
			'saved_section',
			array(
				'label'       => '选择章节',
				'type'        => 'pp-query',
				'label_block' => false,
				'multiple'    => false,
				'query_type'  => 'templates-section',
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'content_type',
							'operator' => '==',
							'value'    => 'section',
						),
					),
				),
			)
		);

		$repeater->add_control(
			'templates',
			array(
				'label'       => __( 'Choose Template', 'infility-global' ),
				'type'        => 'pp-query',
				'label_block' => false,
				'multiple'    => false,
				'query_type'  => 'templates-page',
				'conditions'  => array(
					'terms' => array(
						array(
							'name'     => 'content_type',
							'operator' => '==',
							'value'    => 'template',
						),
					),
				),
			)
		);

		$repeater->end_controls_tab();

		$repeater->start_controls_tab(
			'tab_icon',
			array(
				'label' => __( 'Icon', 'infility-global' ),
			)
		);

		$repeater->add_control(
			'pp_icon_type',
			[
				'label'             => __( 'Icon Type', 'infility-global' ),
				'type'              => Controls_Manager::CHOOSE,
				'label_block'       => false,
				'toggle'            => false,
				'default'           => 'icon',
				'options'           => [
					'none'  => [
						'title' => __( 'None', 'infility-global' ),
						'icon'  => 'eicon-ban',
					],
					'icon'  => [
						'title' => __( 'Icon', 'infility-global' ),
						'icon'  => 'eicon-star',
					],
					'image' => [
						'title' => __( 'Image', 'infility-global' ),
						'icon'  => 'eicon-image-bold',
					],
				],
			]
		);

		$repeater->add_control(
			'selected_icon',
			array(
				'label'            => __( 'Icon', 'infility-global' ),
				'type'             => Controls_Manager::ICONS,
				'label_block'      => true,
				'default'          => array(
					'value'   => 'fas fa-check',
					'library' => 'fa-solid',
				),
				'fa4compatibility' => 'icon',
				'condition'        => [
					'pp_icon_type' => 'icon',
				],
			)
		);

		$repeater->add_control(
			'icon_img',
			[
				'label'             => __( 'Image', 'infility-global' ),
				'label_block'       => true,
				'type'              => Controls_Manager::MEDIA,
				'default'           => [
					'url' => Utils::get_placeholder_image_src(),
				],
				'dynamic'           => [
					'active'  => true,
				],
				'condition'         => [
					'pp_icon_type' => 'image',
				],
			]
		);

		$repeater->add_group_control(
			Group_Control_Image_Size::get_type(),
			array(
				'name'      => 'icon_img',
				'label'     => __( 'Image Size', 'infility-global' ),
				'default'   => 'full',
				'condition' => array(
					'pp_icon_type' => 'image',
				),
			)
		);

		$repeater->end_controls_tab();

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
						'tab_title' => __( 'Tab #1', 'infility-global' ),
						'content'   => __( 'I am tab 1 content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'infility-global' ),
					),
					array(
						'tab_title' => __( 'Tab #2', 'infility-global' ),
						'content'   => __( 'I am tab 2 content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'infility-global' ),
					),
					array(
						'tab_title' => __( 'Tab #3', 'infility-global' ),
						'content'   => __( 'I am tab 3 content. Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.', 'infility-global' ),
					),
				],
				'title_field' => '{{{ text }}}',
			]
		);	


		$this->end_controls_section();
	}

	protected function register_content_layout_controls() {

		$this->start_controls_section(
			'section_general_layout',
			array(
				'label' => '布局',
			)
		);

		$this->add_control(
			'type',
			array(
				'label'   => '布局',
				'type'    => Controls_Manager::SELECT,
				'default' => 'at-horizontal',
				'options' => array(
					'at-horizontal' => '上下',
					'at-vertical'   => '左右',
				),
			)
		);


		$this->add_control(
			'scroll_top',
			array(
				'label'       => '屏幕跟随',
				'description' => '单击选项卡标题时滚动到选项卡容器的顶部。',
				'type'        => Controls_Manager::SELECT,
				'default'     => 'no',
				'options'     => array(
					'yes' => __( 'Yes', 'infility-global' ),
					'no'  => __( 'No', 'infility-global' ),
				),
				'condition'   => array(
					'type' => 'at-vertical',
				),
			)
		);


		$this->end_controls_section();
	}

	protected function register_style_tabs_controls() {
		/**
		 * Style Tab: Tabs
		 */
		$this->start_controls_section(
			'section_tabs_style',
			array(
				'label' => __( 'Tabs', 'infility-global' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_responsive_control(
			'title_align_horizontal',
			array(
				'label'     => '对齐方向',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => '左对齐',
						'icon'  => 'eicon-h-align-left',
					),
					'center'     => array(
						'title' => '居中',
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'   => array(
						'title' => '右对齐',
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'center',
				'condition' => array(
					'type' => 'at-horizontal',
				),
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_width',
			array(
				'label'      => '宽度',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 50,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
					'%' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 1,
					),
					'auto' => array(
						'min'  => 0,
						'max'  => 100,
						'step' => 0,
					),
				),
				'size_units' => array(  'px' , '%' ,'auto'),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .infility_tab.at-vertical .infility_tab_content' => 'width: calc(100% - {{SIZE}}{{UNIT}})',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin_right',
			array(
				'label'      => '右外间距',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 0,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'condition'  => array(
					'type'                   => 'at-horizontal',
					'title_align_horizontal' => 'flex-end',
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items:last-child' => 'margin-right: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin_left',
			array(
				'label'      => '左外间距',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 0,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'condition'  => array(
					'type'                   => 'at-horizontal',
					'title_align_horizontal' => 'flex-start',
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items:first-child' => 'margin-left: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin_bottom',
			array(
				'label'      => '下外间距',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 0,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'condition'  => array(
					'type'                   => 'at-horizontal',
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'title_align_vertical',
			array(
				'label'     => '对齐方向',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => '向上对齐',
						'icon'  => 'eicon-v-align-top',
					),
					'center'     => array(
						'title' => '居中',
						'icon'  => 'eicon-v-align-middle',
					),
					'flex-end'   => array(
						'title' => '向下对齐',
						'icon'  => 'eicon-v-align-bottom',
					),
				),
				'default'   => 'flex-start',
				'condition' => array(
					'type' => 'at-vertical',
				),
				'selectors' => array(
					'{{WRAPPER}}  .infility_tab.at-vertical' => 'justify-content: {{VALUE}};',
					'{{WRAPPER}}  .infility_tab.at-vertical .infility_tab_title' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'tabs_position_vertical',
			array(
				'label'                => '位置',
				'type'                 => Controls_Manager::CHOOSE,
				'options'              => array(
					'left'  => array(
						'title' => '左边',
						'icon'  => 'eicon-h-align-left',
					),
					'right' => array(
						'title' => '右边',
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'              => 'left',
				'selectors_dictionary' => array(
					'left'  => 'row',
					'right' => 'row-reverse',
				),
				'selectors'            => array(
					'{{WRAPPER}} .infility_tab.at-vertical' => 'flex-direction: {{VALUE}};',
				),
				'condition'            => array(
					'type' => 'at-vertical',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin_top',
			array(
				'label'      => '上外边距',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 0,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'condition'  => array(
					'type'                 => 'at-vertical',
					'title_align_vertical' => 'flex-start',
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab.at-vertical .infility_tab_title .title_items:first-child' => 'margin-top: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'title_margin_bottom',
			array(
				'label'      => '下外边距',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 0,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'condition'  => array(
					'type'                 => 'at-vertical',
					'title_align_vertical' => 'flex-end',
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab.at-vertical .infility_tab_title .title_items:last-child' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_responsive_control(
			'title_space',
			array(
				'label'      => '选项卡间距',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 0,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'separator'  => 'after',
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab.at-horizontal .infility_tab_title .title_items:not(:last-child)' => 'margin-right: {{SIZE}}{{UNIT}}',
					// '{{WRAPPER}} .at-horizontal-content .pp-advanced-tabs-title:not(:first-child)' => 'margin-top: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .infility_tab.at-vertical .infility_tab_title .title_items:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'(tablet){{WRAPPER}} .pp-tabs-responsive-tablet .pp-tabs-panel:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
					'(mobile){{WRAPPER}} .pp-tabs-responsive-mobile .pp-tabs-panel:not(:last-child)' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'tabs_container_background_color',
			[
				'label'                 => '背景颜色',
				'type'                  => Controls_Manager::COLOR,
				'default'               => '',
				'selectors'             => [
					'{{WRAPPER}} .infility_tab .infility_tab_title' => 'background-color: {{VALUE}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_border_radius',
			[
				'label'                 => '边框圆角',
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .infility_tab .infility_tab_title' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_padding',
			[
				'label'                 => '内边距',
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .infility_tab .infility_tab_title' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);

		$this->add_responsive_control(
			'tabs_container_margin',
			[
				'label'                 => '外边距',
				'type'                  => Controls_Manager::DIMENSIONS,
				'size_units'            => [ 'px', 'em', '%' ],
				'selectors'             => [
					'{{WRAPPER}} .infility_tab .infility_tab_title' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				],
			]
		);


		$this->end_controls_section();
	}

	protected function register_style_title_controls() {
		/**
		 * Style Tab: Title
		 */

		$this->start_controls_section(
			'section_title_style',
			array(
				'label' => __( 'Title', 'infility-global' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);
		
		$this->add_responsive_control(
			'title_char_align',
			array(
				'label'     => '对齐方向',
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'flex-start' => array(
						'title' => '左对齐',
						'icon'  => 'eicon-h-align-left',
					),
					'center'     => array(
						'title' => '居中',
						'icon'  => 'eicon-h-align-center',
					),
					'flex-end'   => array(
						'title' => '右对齐',
						'icon'  => 'eicon-h-align-right',
					),
				),
				'default'   => 'left',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'justify-content: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_text_indent',
			array(
				'label'      => '文字缩进',
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 0,
				),
				'range'      => array(
					'px' => array(
						'min'  => 0,
						'max'  => 500,
						'step' => 1,
					),
				),
				'size_units' => array(  'px'),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'text-indent: {{SIZE}}{{UNIT}}',
				),
			)
		);

		$this->add_control(
			'icon_position',
			array(
				'label'   => __( 'Icon Position', 'infility-global' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'top'    => __( 'Top', 'infility-global' ),
					'bottom' => __( 'Bottom', 'infility-global' ),
					'left'   => __( 'Left', 'infility-global' ),
					'right'  => __( 'Right', 'infility-global' ),
				),
				'default' => 'left',
			)
		);
		$this->add_responsive_control(
			'icon_size',
			array(
				'label'      => __( 'Icon Size', 'infility-global' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 15,
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items .pp-icon' => 'font-size: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_responsive_control(
			'icon_image_width',
			array(
				'label'      => __( 'Icon Image Width', 'infility-global' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 30,
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items .pp-icon-img img' => 'width: {{SIZE}}{{UNIT}}',
				),
				'separator'  => 'after',
			)
		);
		$this->add_control(
			'title_line_height',
			array(
				'label'      => __( 'Line Height', 'infility-global' ),
				'type'       => Controls_Manager::SLIDER,
				'default'    => array(
					'size' => 30,
				),
				'range'      => array(
					'px' => array(
						'min'  => 1,
						'max'  => 100,
						'step' => 1,
					),
				),
				'size_units' => array( 'px' ),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items .char' => 'line-height: {{SIZE}}{{UNIT}}',
				),
			)
		);
		$this->add_control(
			'title_border_radius',
			array(
				'label'      => __( 'Border Radius', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'default'    => array(
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'title_padding',
			array(
				'label'      => __( 'Padding', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'separator'  => 'after',
				'default'    => array(
					'top'    => 10,
					'bottom' => 10,
					'left'   => 10,
					'right'  => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->start_controls_tabs( 'tabs_title_style' );

		$this->start_controls_tab(
			'tab_title_normal',
			array(
				'label' => __( 'Normal', 'infility-global' ),
			)
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography',
				'label'    => __( 'Title Typography', 'infility-global' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .infility_tab .infility_tab_title .title_items .char',
			)
		);

		$this->add_control(
			'icon_color',
			array(
				'label'     => __( 'Icon Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items .pp-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items svg' => 'fill: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_text_color',
			array(
				'label'     => __( 'Title Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items .char' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_bg_color',
			array(
				'label'     => __( 'Title Background Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#ffffff',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items ' => 'background-color: {{VALUE}}',
				),
				// 'condition' => array(
				// 	'custom_style!' => 'style-6',
				// ),
			)
		);

		$this->add_control(
			'title_border_style',
			array(
				'label'   => __( 'Title Border Style', 'infility-global' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'none'   => __( 'None', 'infility-global' ),
					'solid'  => __( 'Solid', 'infility-global' ),
					'double' => __( 'Double', 'infility-global' ),
					'dotted' => __( 'Dotted', 'infility-global' ),
					'dashed' => __( 'Dashed', 'infility-global' ),
					'groove' => __( 'Groove', 'infility-global' ),
				),
				'default' => 'solid',
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'border-style: {{VALUE}};',
				),
			)
		);

		$this->add_responsive_control(
			'title_border_width',
			array(
				'label'      => __( 'Title Border Width', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px'),
				'separator'  => 'after',
				'default'    => array(
					'top'    => 1,
					'bottom' => 1,
					'left'   => 1,
					'right'  => 1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition' => array(
					'title_border_style!' => 'none',
				),
			)
		);

		$this->add_control(
			'title_border_color',
			array(
				'label'     => __( 'Title Border Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'title_border_style!' => 'none',
				),
			)
		);

		$this->add_group_control(
			Group_Control_Border::get_type(),
			array(
				'name'      => 'tab_title_border',
				'label'     => esc_html__( 'Border', 'infility-global' ),
				'selector'  => '{{WRAPPER}} .infility_tab .infility_tab_title .title_items',
				'condition' => array(
					'custom_style' => array( 'style-custom' ),
				),
			)
		);

		$this->end_controls_tab(); // End Normal Tab

		$this->start_controls_tab(
			'tab_title_active',
			array(
				'label' => __( 'Active', 'infility-global' ),
			)
		);


		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'title_typography_active',
				'label'    => __( 'Title Typography', 'infility-global' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur .char,{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover .char',
			)
		);
		
		$this->add_control(
			'icon_color_active',
			array(
				'label'     => __( 'Icon Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur .pp-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur svg' => 'fill: {{VALUE}}',
					'{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover .pp-icon' => 'color: {{VALUE}}',
					'{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover svg' => 'fill: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_text_color_active',
			array(
				'label'     => __( 'Title Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur .char' => 'color: {{VALUE}}',
					'{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover .char' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_bg_color_active',
			array(
				'label'     => __( 'Background Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover' => 'background-color: {{VALUE}}',
					// '{{WRAPPER}} .pp-style-1 .at-horizontal .pp-tab-active:after' => 'border-top-color: {{VALUE}}',
					// '{{WRAPPER}} .pp-style-1 .at-vertical .pp-tab-active:after' => 'border-left-color: {{VALUE}}',
					// '{{WRAPPER}} .pp-style-6 .pp-advanced-tabs-title.pp-tab-active:after' => 'background-color: {{VALUE}}',
				),
			)
		);
		$this->add_control(
			'title_border_color_active',
			array(
				'label'     => __( 'Border Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur' => 'border-color: {{VALUE}}',
					'{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover' => 'border-color: {{VALUE}}',
					// '{{WRAPPER}} .pp-style-2 .pp-advanced-tabs-title.pp-tab-active:before' => 'background-color: {{VALUE}}',
					// '{{WRAPPER}} .pp-style-2 .at-hover .pp-advanced-tabs-title.pp-tab-active:before' => 'background-color: {{VALUE}}',
					// '{{WRAPPER}} .pp-style-3 .pp-advanced-tabs-title.pp-tab-active:before' => 'background-color: {{VALUE}}',
					// '{{WRAPPER}} .pp-style-3 .at-hover .pp-advanced-tabs-title.pp-tab-active:before' => 'background-color: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'title_border_width_active',
			array(
				'label'      => __( 'Title Border Width', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px'),
				'separator'  => 'after',
				'default'    => array(
					'top'    => 1,
					'bottom' => 1,
					'left'   => 1,
					'right'  => 1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
					'{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->add_control(
			'title_border_style_active',
			array(
				'label'   => __( 'Title Border Style', 'infility-global' ),
				'type'    => Controls_Manager::SELECT,
				'options' => array(
					'solid'    => __( 'Solid', 'infility-global' ),
					'dotted'   => __( 'Dotted', 'infility-global' ),
					'dashed'   => __( 'Dashed', 'infility-global' ),
				),
				'default' => 'solid',
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab .infility_tab_title .title_items.cur' => 'border-style: {{VALUE}};',
					'{{WRAPPER}} .infility_tab .infility_tab_title.at-hover .title_items:hover' => 'border-style: {{VALUE}};',
				),
			)
		);

		$this->end_controls_tab(); // End Hover Tab

		$this->end_controls_tabs(); // End Controls Tab

		$this->add_control(
			'tab_hover_effect',
			array(
				'label'     => __( 'Hover Effect', 'infility-global' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'yes' => array(
						'title' => __( 'Yes', 'infility-global' ),
						'icon'  => 'eicon-check',
					),
					'no'  => array(
						'title' => __( 'No', 'infility-global' ),
						'icon'  => 'eicon-ban',
					),
				),
				'separator' => 'before',
				'default'   => 'no',
			)
		);

		$this->end_controls_section();
	}

	protected function register_style_content_controls() {
		/**
		 * Style Tab: Content
		 */
		$this->start_controls_section(
			'section_content_style',
			array(
				'label' => __( 'Content', 'infility-global' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			)
		);


		$this->add_control(
			'content_hover_effect',
			array(
				'label'     => __( 'Hover Effect', 'infility-global' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'none',
				'options'   => array(
					'none'   => __( 'None', 'infility-global' ),
					'fade'  => __( 'Fade In', 'infility-global' ),
					'slide' => __( 'Slide', 'infility-global' ),
				),
			)
		);

		$this->add_responsive_control(
			'tab_align',
			array(
				'label'     => __( 'Alignment', 'infility-global' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => array(
					'start'  => array(
						'title' => __( 'Left', 'infility-global' ),
						'icon'  => 'eicon-text-align-left',
					),
					'center' => array(
						'title' => __( 'Center', 'infility-global' ),
						'icon'  => 'eicon-text-align-center',
					),
					'end'    => array(
						'title' => __( 'Right', 'infility-global' ),
						'icon'  => 'eicon-text-align-right',
					),
				),
				'default'   => 'center',
				'separator' => 'after',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content'   => 'text-align: {{VALUE}};',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Background::get_type(),
			array(
				'name'     => 'tab_bg_style',
				'label'    => __( 'Background', 'infility-global' ),
				'types'    => array( 'none', 'classic', 'gradient' ),
				'selector' => '{{WRAPPER}} .infility_tab_content .title_items_content',
			)
		);
		$this->add_control(
			'text_color',
			array(
				'label'     => __( 'Text Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'separator' => 'before',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content' => 'color: {{VALUE}}',
				),
			)
		);
		$this->add_group_control(
			Group_Control_Typography::get_type(),
			array(
				'name'     => 'tab_text_typography',
				'label'    => __( 'Text Typography', 'infility-global' ),
				'scheme'   => Scheme_Typography::TYPOGRAPHY_4,
				'selector' => '{{WRAPPER}} .infility_tab_content .title_items_content',
			)
		);

		$this->add_control(
			'tab_border_type',
			array(
				'label'     => __( 'Border Type', 'infility-global' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => 'solid',
				'options'   => array(
					'none'   => __( 'None', 'infility-global' ),
					'solid'  => __( 'Solid', 'infility-global' ),
					'double' => __( 'Double', 'infility-global' ),
					'dotted' => __( 'Dotted', 'infility-global' ),
					'dashed' => __( 'Dashed', 'infility-global' ),
					'groove' => __( 'Groove', 'infility-global' ),
				),
				'selectors' => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content' => 'border-style: {{VALUE}}',
				),
			)
		);

		$this->add_responsive_control(
			'tab_border_width',
			array(
				'label'      => __( 'Border Width', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px' ),
				'default'    => array(
					'top'    => 1,
					'bottom' => 1,
					'left'   => 1,
					'right'  => 1,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content' => 'border-width: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
				'condition'  => array(
					'tab_border_type!' => 'none',
				),
			)
		);

		$this->add_control(
			'tab_border_color',
			array(
				'label'     => __( 'Border Color', 'infility-global' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#808080',
				'selectors' => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content' => 'border-color: {{VALUE}}',
				),
				'condition' => array(
					'tab_border_type!' => 'none',
				),
			)
		);
		$this->add_control(
			'tab_border_radius',
			array(
				'label'      => __( 'Border Radius', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', '%' ),
				'separator'  => 'before',
				'default'    => array(
					'top'    => 0,
					'bottom' => 0,
					'left'   => 0,
					'right'  => 0,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'tab_padding',
			array(
				'label'      => __( 'Padding', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'    => 10,
					'bottom' => 10,
					'left'   => 10,
					'right'  => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);
		$this->add_responsive_control(
			'tab_margin',
			array(
				'label'      => __( 'Margin', 'infility-global' ),
				'type'       => Controls_Manager::DIMENSIONS,
				'size_units' => array( 'px', 'em', '%' ),
				'default'    => array(
					'top'    => 10,
					'bottom' => 10,
					'left'   => 10,
					'right'  => 10,
				),
				'selectors'  => array(
					'{{WRAPPER}} .infility_tab_content .title_items_content' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
				),
			)
		);

		$this->end_controls_tab();

		$this->end_controls_section();
	}

	/**
	 * Render tabs content.
	 *
	 * @since 2.3.2
	 */
	protected function get_tabs_content( $item ) {
		$settings     = $this->get_settings_for_display();
		$content_type = $item['content_type'];
		$output       = '';

		switch ( $content_type ) {
			case 'tab_content':
				$output = $this->parse_text_editor( $item['content'] );
				break;

			case 'tab_photo':
				if ( $item['image']['url'] ) {
					$output = wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $item, 'image', 'image' ) );
				}
				break;

			case 'tab_video':
				$output = wp_kses_post( $this->parse_text_editor( $item['link_video'] ) );
				break;

			case 'section':
				$output = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $item['saved_section'] );
				break;

			case 'template':
				$output = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $item['templates'] );
				break;

			case 'widget':
				$output = \Elementor\Plugin::$instance->frontend->get_builder_content_for_display( $item['saved_widget'] );
				break;

			default:
				return;
		}

		return $output;
	}

	/**
	 * Render list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings       = $this->get_settings();
		$tabs 			= $this->get_settings_for_display();
		
		// str::dump($settings);
		


		$hover_state = $settings['tab_hover_effect'];

		if ( 'yes' === $hover_state ) {
			$hover_class = ' at-hover';
		} else {
			$hover_class = ' at-no-hover';
		}

		$this->add_render_attribute( 'container', 'class', array(
			'infility_tab',
			$settings['type'],	
		) );

		if ( 'no' !== $settings['scroll_top'] ) {
			$this->add_render_attribute( 'container', 'data-scroll-top', '1' );
		}


		$this->add_render_attribute( 'container_title', 'class', array(
			'infility_tab_title',
			'icon_'.$settings['icon_position'],
			$hover_class
		) );

		$this->add_render_attribute( 'container_content', 'class', array(
			'infility_tab_content',
			'effect_'.$settings['content_hover_effect']
		) );

		$this->add_render_attribute( 'container_content_slide', 'class', array(
			'container_content_slide',			
			$settings['content_hover_effect']=='slide'?'slide_box clean trans':'',
		) );

		$title_char_align = '';
		switch ($settings['title_char_align']) {
			case 'flex-start': $title_char_align = 'left';break;
			case 'center': $title_char_align = 'center';break;
			case 'flex-end': $title_char_align = 'right';break;
		}
		?>
		<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container' ) ); ?>>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container_title' ) ); ?>>
				<?php
				foreach ( $settings['list_items'] as $index => $item ) {
					$repeater_setting_key = $this->get_repeater_setting_key( 'text', 'list_items', $index );
					$this->add_render_attribute( $repeater_setting_key, 'class', array(
						'title_items',
						'trans',
						'icon_'.$settings['icon_position'],						
						!$index?'cur':'',
						$title_char_align
					) );

					$this->add_render_attribute(
						$repeater_setting_key,
						array(
							'key'    => $index,
						)
					);
					
					$iconHtml = $this->render_tab_title_icon( $item );
					?>
					<div <?php echo wp_kses_post( $this->get_render_attribute_string($repeater_setting_key) ); ?>>
						<?php echo wp_kses_post($iconHtml)?>
						<span class="char"><?php echo wp_kses_post($item['text'])?></span>
					</div>
					<?php
				}
				?>
			</div>
			<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container_content' ) ); ?>>
				<div <?php echo wp_kses_post( $this->get_render_attribute_string( 'container_content_slide' ) ); ?>>
					<?php
					foreach ( $settings['list_items'] as $index => $item ) {
						$repeater_setting_key = $this->get_repeater_setting_key( 'content', 'list_items', $index );
						$this->add_render_attribute( $repeater_setting_key, 'class', array(
							'title_items_content',
							'trans',
							!$index?'cur':' load',
							// !$index?'cur':' ',
						) );


						$this->add_render_attribute(
							$repeater_setting_key,
							array(
								'key'    => $index,
							)
						);
						
						$iconHtml = $this->render_tab_title_icon( $item );
						?>
						<div <?php echo wp_kses_post( $this->get_render_attribute_string($repeater_setting_key) ); ?>>
							<div class="height_box">
								<?php echo $this->get_tabs_content( $item ); // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped ?>
							</div>
						</div>
						<?php
					}
					?>
				</div>
			</div>
		</div>
		<?php if ($settings['content_hover_effect']=='slide') {?>
			<script>(function($) {	elementor_tab_obj.silde_box_init();})( jQuery );</script>
		<?php } ?>
		<?php
	}

	public function render_tab_title_icon( $item ) {
		$settings = $this->get_settings();

		if ( 'none' === $item['pp_icon_type'] ) {
			return;
		}

		$migration_allowed = Icons_Manager::is_migration_allowed();

		// add old default
		if ( ! isset( $item['icon'] ) && ! $migration_allowed ) {
			$item['icon'] = isset( $fallback_defaults[ $index ] ) ? $fallback_defaults[ $index ] : 'fa fa-check';
		}

		$migrated = isset( $item['__fa4_migrated']['selected_icon'] );
		$is_new   = ! isset( $item['icon'] ) && $migration_allowed;

		ob_start();
		if ( 'icon' === $item['pp_icon_type'] && ( ! empty( $item['icon'] ) || ( ! empty( $item['selected_icon']['value'] ) && $is_new ) ) ) {
			?>
			<span class="pp-icon pp-advanced-tabs-icon-<?php echo esc_attr( $settings['icon_position'] ); ?>">
			<?php
			if ( $is_new || $migrated ) {
				Icons_Manager::render_icon( $item['selected_icon'], array( 'aria-hidden' => 'true' ) );
			} else {
				?>
				<i class="<?php echo esc_attr( $item['icon'] ); ?>" aria-hidden="true"></i>
			<?php } ?>
			</span>
			<?php
		} elseif ( 'image' === $item['pp_icon_type'] ) {
			?>
			<span class="pp-icon-img pp-advanced-tabs-icon-<?php echo esc_attr( $settings['icon_position'] ); ?>">
			<?php echo wp_kses_post( Group_Control_Image_Size::get_attachment_image_html( $item, 'icon_img', 'icon_img' ) ); ?>
			</span>
			<?php
		}
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

}