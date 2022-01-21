<?php

namespace madxartworkPro\Modules\Gallery\Widgets;

use madxartwork\Controls_Manager;
use madxartwork\Core\Responsive\Responsive;
use madxartwork\Group_Control_Background;
use madxartwork\Group_Control_Border;
use madxartwork\Group_Control_Css_Filter;
use madxartwork\Group_Control_Image_Size;
use madxartwork\Group_Control_Typography;
use madxartwork\Repeater;
use madxartwork\Scheme_Color;
use madxartwork\Scheme_Typography;
use madxartworkPro\Base\Base_Widget;
use madxartworkPro\Plugin;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Gallery extends Base_Widget {

	/**
	 * Get element name.
	 *
	 * Retrieve the element name.
	 *
	 * @return string The name.
	 * @since 2.7.0
	 * @access public
	 *
	 */
	public function get_name() {
		return 'gallery';
	}

	public function get_title() {
		return __( 'Gallery', 'madxartwork-pro' );
	}

	public function get_script_depends() {
		return [ 'madxartwork-gallery' ];
	}

	public function get_style_depends() {
		return [ 'madxartwork-gallery' ];
	}

	public function get_icon() {
		return 'eicon-gallery-justified';
	}

	protected function _register_controls() {
		$this->start_controls_section( 'settings', [ 'label' => __( 'Settings', 'madxartwork-pro' ) ] );

		$this->add_control(
			'gallery_type',
			[
				'type' => Controls_Manager::SELECT,
				'label' => __( 'Type', 'madxartwork-pro' ),
				'default' => 'single',
				'options' => [
					'single' => __( 'Single', 'madxartwork-pro' ),
					'multiple' => __( 'Multiple', 'madxartwork-pro' ),
				],
			]
		);

		$this->add_control(
			'gallery',
			[
				'type' => Controls_Manager::GALLERY,
				'condition' => [
					'gallery_type' => 'single',
				],
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater = new Repeater();

		$repeater->add_control(
			'gallery_title',
			[
				'type' => Controls_Manager::TEXT,
				'label' => __( 'Title', 'madxartwork-pro' ),
				'default' => __( 'New Gallery', 'madxartwork-pro' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$repeater->add_control(
			'multiple_gallery',
			[
				'type' => Controls_Manager::GALLERY,
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$this->add_control(
			'galleries',
			[
				'type' => Controls_Manager::REPEATER,
				'label' => __( 'Galleries', 'madxartwork-pro' ),
				'fields' => $repeater->get_controls(),
				'title_field' => '{{{ gallery_title }}}',
				'default' => [
					[
						'gallery_title' => __( 'New Gallery', 'madxartwork-pro' ),
					],
				],
				'condition' => [
					'gallery_type' => 'multiple',
				],
				'separator' => 'after',
			]
		);

		$this->add_control(
			'gallery_layout',
			[
				'type' => Controls_Manager::SELECT,
				'label' => __( 'Layout', 'madxartwork-pro' ),
				'default' => 'grid',
				'options' => [
					'grid' => __( 'Grid', 'madxartwork-pro' ),
					'justified' => __( 'Justified', 'madxartwork-pro' ),
					'masonry' => __( 'Masonry', 'madxartwork-pro' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'columns',
			[
				'label' => __( 'Columns', 'madxartwork-pro' ),
				'type' => Controls_Manager::NUMBER,
				'default' => 4,
				'tablet_default' => 2,
				'mobile_default' => 1,
				'min' => 1,
				'max' => 24,
				'condition' => [
					'gallery_layout!' => 'justified',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'ideal_row_height',
			[
				'label' => __( 'Row Height', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'range' => [
					'px' => [
						'min' => 50,
						'max' => 500,
					],
				],
				'default' => [
					'size' => 200,
				],
				'tablet_default' => [
					'size' => 150,
				],
				'mobile_default' => [
					'size' => 150,
				],
				'condition' => [
					'gallery_layout' => 'justified',
				],
				'required' => true,
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_responsive_control(
			'gap',
			[
				'label' => __( 'Spacing', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 10,
				],
				'tablet_default' => [
					'size' => 10,
				],
				'mobile_default' => [
					'size' => 10,
				],
				'required' => true,
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'link_to',
			[
				'label' => __( 'Link', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'file',
				'options' => [
					'' => __( 'None', 'madxartwork-pro' ),
					'file' => __( 'Media File', 'madxartwork-pro' ),
					'custom' => __( 'Custom URL', 'madxartwork-pro' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'url',
			[
				'label' => __( 'URL', 'madxartwork-pro' ),
				'type' => Controls_Manager::URL,
				'show_external' => false,
				'condition' => [
					'link_to' => 'custom',
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'aspect_ratio',
			[
				'type' => Controls_Manager::SELECT,
				'label' => __( 'Aspect Ratio', 'madxartwork-pro' ),
				'default' => '3:2',
				'options' => [
					'1:1' => '1:1',
					'3:2' => '3:2',
					'4:3' => '4:3',
					'9:16' => '9:16',
					'16:9' => '16:9',
					'21:9' => '21:9',
				],
				'condition' => [
					'gallery_layout' => 'grid',
				],
				'render_type' => 'none',
				'frontend_available' => true,
			]
		);

		$this->add_group_control(
			Group_Control_Image_Size::get_type(),
			[
				'name' => 'thumbnail_image',
				'default' => 'medium',
			]
		);

		$this->end_controls_section(); // settings

		$this->start_controls_section(
			'section_filter_bar_content',
			[
				'label' => __( 'Filter Bar', 'madxartwork-pro' ),
				'condition' => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_control(
			'show_all_galleries',
			[
				'type' => Controls_Manager::SWITCHER,
				'label' => __( '"All" Filter', 'madxartwork-pro' ),
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'show_all_galleries_label',
			[
				'type' => Controls_Manager::TEXT,
				'label' => __( '"All" Filter Label', 'madxartwork-pro' ),
				'default' => __( 'All', 'madxartwork-pro' ),
				'condition' => [
					'show_all_galleries' => 'yes',
				],
			]
		);

		$this->add_control(
			'pointer',
			[
				'label' => __( 'Pointer', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'underline',
				'options' => [
					'none' => __( 'None', 'madxartwork-pro' ),
					'underline' => __( 'Underline', 'madxartwork-pro' ),
					'overline' => __( 'Overline', 'madxartwork-pro' ),
					'double-line' => __( 'Double Line', 'madxartwork-pro' ),
					'framed' => __( 'Framed', 'madxartwork-pro' ),
					'background' => __( 'Background', 'madxartwork-pro' ),
					'text' => __( 'Text', 'madxartwork-pro' ),
				],
				'style_transfer' => true,
			]
		);

		$this->add_control(
			'animation_line',
			[
				'label' => __( 'Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'slide' => 'Slide',
					'grow' => 'Grow',
					'drop-in' => 'Drop In',
					'drop-out' => 'Drop Out',
					'none' => 'None',
				],
				'condition' => [
					'pointer' => [ 'underline', 'overline', 'double-line' ],
				],
			]
		);

		$this->add_control(
			'animation_framed',
			[
				'label' => __( 'Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'draw' => 'Draw',
					'corners' => 'Corners',
					'none' => 'None',
				],
				'condition' => [
					'pointer' => 'framed',
				],
			]
		);

		$this->add_control(
			'animation_background',
			[
				'label' => __( 'Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'fade',
				'options' => [
					'fade' => 'Fade',
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sweep-left' => 'Sweep Left',
					'sweep-right' => 'Sweep Right',
					'sweep-up' => 'Sweep Up',
					'sweep-down' => 'Sweep Down',
					'shutter-in-vertical' => 'Shutter In Vertical',
					'shutter-out-vertical' => 'Shutter Out Vertical',
					'shutter-in-horizontal' => 'Shutter In Horizontal',
					'shutter-out-horizontal' => 'Shutter Out Horizontal',
					'none' => 'None',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'animation_text',
			[
				'label' => __( 'Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'grow',
				'options' => [
					'grow' => 'Grow',
					'shrink' => 'Shrink',
					'sink' => 'Sink',
					'float' => 'Float',
					'skew' => 'Skew',
					'rotate' => 'Rotate',
					'none' => 'None',
				],
				'condition' => [
					'pointer' => 'text',
				],
			]
		);

		$this->end_controls_section(); // settings

		$this->start_controls_section( 'overlay', [ 'label' => __( 'Overlay', 'madxartwork-pro' ) ] );

		$this->add_control(
			'overlay_background',
			[
				'label' => __( 'Background', 'madxartwork-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'default' => 'yes',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'overlay_title',
			[
				'label' => __( 'Title', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'madxartwork-pro' ),
					'title' => __( 'Title', 'madxartwork-pro' ),
					'caption' => __( 'Caption', 'madxartwork-pro' ),
					'alt' => __( 'Alt', 'madxartwork-pro' ),
					'description' => __( 'Description', 'madxartwork-pro' ),
				],
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'overlay_description',
			[
				'label' => __( 'Description', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'None', 'madxartwork-pro' ),
					'title' => __( 'Title', 'madxartwork-pro' ),
					'caption' => __( 'Caption', 'madxartwork-pro' ),
					'alt' => __( 'Alt', 'madxartwork-pro' ),
					'description' => __( 'Description', 'madxartwork-pro' ),
				],
				'frontend_available' => true,
			]
		);

		$this->end_controls_section(); // overlay

		$this->start_controls_section(
			'image_style',
			[
				'label' => __( 'Image', 'madxartwork-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
			]
		);

		$this->start_controls_tabs( 'image_tabs' );

		$this->start_controls_tab(
			'image_normal',
			[
				'label' => __( 'Normal', 'madxartwork-pro' ),
			]
		);

		$this->add_control(
			'image_border_color',
			[
				'label' => __( 'Border Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'image_border_width',
			[
				'label' => __( 'Border Width', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em' ],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item' => 'border-width: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_control(
			'image_border_radius',
			[
				'label' => __( 'Border Radius', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters',
				'selector' => '{{WRAPPER}} .e-gallery-image',
			]
		);

		$this->end_controls_tab(); // overlay_background normal

		$this->start_controls_tab(
			'image_hover',
			[
				'label' => __( 'Hover', 'madxartwork-pro' ),
			]
		);

		$this->add_control(
			'image_border_color_hover',
			[
				'label' => __( 'Border Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item:hover' => 'border-color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'image_border_radius_hover',
			[
				'label' => __( 'Border Radius', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', '%' ],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item:hover' => 'border-radius: {{SIZE}}{{UNIT}};',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Css_Filter::get_type(),
			[
				'name' => 'image_css_filters_hover',
				'selector' => '{{WRAPPER}} .e-gallery-item:hover .e-gallery-image',
			]
		);

		$this->end_controls_tab(); // overlay_background normal

		$this->end_controls_tabs();// overlay_background tabs

		$this->add_control(
			'image_hover_animation',
			[
				'label' => __( 'Hover Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'options' => [
					'' => 'None',
					'grow' => 'Zoom In',
					'shrink-contained' => 'Zoom Out',
					'move-contained-left' => 'Move Left',
					'move-contained-right' => 'Move Right',
					'move-contained-top' => 'Move Up',
					'move-contained-bottom' => 'Move Down',
				],
				'separator' => 'before',
				'default' => '',
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'image_animation_duration',
			[
				'label' => __( 'Animation Duration', 'madxartwork-pro' ) . ' (ms)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .e-gallery-image' => 'transition-duration: {{SIZE}}ms',
				],
			]
		);

		$this->end_controls_section(); // overlay_background

		$this->start_controls_section(
			'overlay_style',
			[
				'label' => __( 'Overlay', 'madxartwork-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'overlay_background' => 'yes',
				],
			]
		);

		$this->start_controls_tabs( 'overlay_background_tabs' );

		$this->start_controls_tab(
			'overlay_normal',
			[
				'label' => __( 'Normal', 'madxartwork-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background',
				'types' => [ 'classic', 'gradient' ],
				'exclude' => [ 'image' ],
				'selector' => '{{WRAPPER}} .madxartwork-gallery-item__overlay',
				'fields_options' => [
					'background' => [
						'label' => __( 'Overlay', 'madxartwork-pro' ),
					],
				],
			]
		);

		$this->end_controls_tab(); // overlay_background normal

		$this->start_controls_tab(
			'overlay_hover',
			[
				'label' => __( 'Hover', 'madxartwork-pro' ),
			]
		);

		$this->add_group_control(
			Group_Control_Background::get_type(),
			[
				'name' => 'overlay_background_hover',
				'types' => [ 'classic', 'gradient' ],
				'selector' => '{{WRAPPER}} .e-gallery-item:hover .madxartwork-gallery-item__overlay',
				'exclude' => [ 'image' ],
				'fields_options' => [
					'background' => [
						'default' => 'classic',
					],
					'color' => [
						'default' => 'rgba(0,0,0,0.5)',
					],
				],
			]
		);

		$this->end_controls_tab(); // overlay_background normal

		$this->end_controls_tabs();// overlay_background tabs

		$this->add_control(
			'image_blend_mode',
			[
				'label' => __( 'Blend Mode', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'default' => '',
				'options' => [
					'' => __( 'Normal', 'madxartwork-pro' ),
					'multiply' => 'Multiply',
					'screen' => 'Screen',
					'overlay' => 'Overlay',
					'darken' => 'Darken',
					'lighten' => 'Lighten',
					'color-dodge' => 'Color Dodge',
					'color-burn' => 'Color Burn',
					'hue' => 'Hue',
					'saturation' => 'Saturation',
					'color' => 'Color',
					'exclusion' => 'Exclusion',
					'luminosity' => 'Luminosity',
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__overlay' => 'mix-blend-mode: {{VALUE}}',
				],
				'separator' => 'before',
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'background_overlay_hover_animation',
			[
				'label' => __( 'Hover Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'groups' => [
					[
						'label' => __( 'None', 'madxartwork-pro' ),
						'options' => [
							'' => __( 'None', 'madxartwork-pro' ),
						],
					],
					[
						'label' => __( 'Entrance', 'madxartwork-pro' ),
						'options' => [
							'enter-from-right' => 'Slide In Right',
							'enter-from-left' => 'Slide In Left',
							'enter-from-top' => 'Slide In Up',
							'enter-from-bottom' => 'Slide In Down',
							'enter-zoom-in' => 'Zoom In',
							'enter-zoom-out' => 'Zoom Out',
							'fade-in' => 'Fade In',
						],
					],
					[
						'label' => __( 'Exit', 'madxartwork-pro' ),
						'options' => [
							'exit-to-right' => 'Slide Out Right',
							'exit-to-left' => 'Slide Out Left',
							'exit-to-top' => 'Slide Out Up',
							'exit-to-bottom' => 'Slide Out Down',
							'exit-zoom-in' => 'Zoom In',
							'exit-zoom-out' => 'Zoom Out',
							'fade-out' => 'Fade Out',
						],
					],
				],
				'separator' => 'before',
				'default' => '',
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->add_control(
			'background_overlay_animation_duration',
			[
				'label' => __( 'Animation Duration', 'madxartwork-pro' ) . ' (ms)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__overlay' => 'transition-duration: {{SIZE}}ms',
				],
			]
		);

		$this->end_controls_section(); // overlay_background

		$this->start_controls_section(
			'overlay_content_style',
			[
				'label' => __( 'Content', 'madxartwork-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				//TODO: add conditions for this section
			]
		);

		$this->add_control(
			'content_alignment',
			[
				'label' => __( 'Alignment', 'madxartwork-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'madxartwork-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'madxartwork-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'madxartwork-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'default' => 'center',
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__content' => 'text-align: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'content_vertical_position',
			[
				'label' => __( 'Vertical Position', 'madxartwork-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'top' => [
						'title' => __( 'Top', 'madxartwork-pro' ),
						'icon' => 'eicon-v-align-top',
					],
					'middle' => [
						'title' => __( 'Middle', 'madxartwork-pro' ),
						'icon' => 'eicon-v-align-middle',
					],
					'bottom' => [
						'title' => __( 'Bottom', 'madxartwork-pro' ),
						'icon' => 'eicon-v-align-bottom',
					],
				],
				'selectors_dictionary' => [
					'top' => 'flex-start',
					'middle' => 'center',
					'bottom' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__content' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->add_responsive_control(
			'content_padding',
			[
				'label' => __( 'Padding', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'default' => [
					'size' => 20,
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__content' => 'padding: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'heading_title',
			[
				'label' => __( 'Title', 'madxartwork-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_color',
			[
				'label' => __( 'Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__title' => 'color: {{VALUE}}',
				],
				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'title_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
				'selector' => '{{WRAPPER}} .madxartwork-gallery-item__title',
				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_control(
			'title_spacing',
			[
				'label' => __( 'Spacing', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__title + .madxartwork-gallery-item__description' => 'margin-top: {{SIZE}}{{UNIT}}',
				],
				'condition' => [
					'overlay_title!' => '',
				],
			]
		);

		$this->add_control(
			'heading_description',
			[
				'label' => __( 'Description', 'madxartwork-pro' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [
					'overlay_description!' => '',
				],
			]
		);

		$this->add_control(
			'description_color',
			[
				'label' => __( 'Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__description' => 'color: {{VALUE}}',
				],
				'condition' => [
					'overlay_description!' => '',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'description_typography',
				'scheme' => Scheme_Typography::TYPOGRAPHY_3,
				'selector' => '{{WRAPPER}} .madxartwork-gallery-item__description',
				'condition' => [
					'overlay_description!' => '',
				],
			]
		);

		$this->add_control(
			'content_hover_animation',
			[
				'label' => __( 'Hover Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SELECT,
				'groups' => [
					[
						'label' => __( 'None', 'madxartwork-pro' ),
						'options' => [
							'' => __( 'None', 'madxartwork-pro' ),
						],
					],
					[
						'label' => __( 'Entrance', 'madxartwork-pro' ),
						'options' => [
							'enter-from-right' => 'Slide In Right',
							'enter-from-left' => 'Slide In Left',
							'enter-from-top' => 'Slide In Up',
							'enter-from-bottom' => 'Slide In Down',
							'enter-zoom-in' => 'Zoom In',
							'enter-zoom-out' => 'Zoom Out',
							'fade-in' => 'Fade In',
						],
					],
					[
						'label' => __( 'Reaction', 'madxartwork-pro' ),
						'options' => [
							'grow' => 'Grow',
							'shrink' => 'Shrink',
							'move-right' => 'Move Right',
							'move-left' => 'Move Left',
							'move-up' => 'Move Up',
							'move-down' => 'Move Down',
						],
					],
					[
						'label' => __( 'Exit', 'madxartwork-pro' ),
						'options' => [
							'exit-to-right' => 'Slide Out Right',
							'exit-to-left' => 'Slide Out Left',
							'exit-to-top' => 'Slide Out Up',
							'exit-to-bottom' => 'Slide Out Down',
							'exit-zoom-in' => 'Zoom In',
							'exit-zoom-out' => 'Zoom Out',
							'fade-out' => 'Fade Out',
						],
					],
				],
				'default' => 'fade-in',
				'separator' => 'before',
				'render_type' => 'ui',
				'frontend_available' => true,
			]
		);

		$this->add_control(
			'content_animation_duration',
			[
				'label' => __( 'Animation Duration', 'madxartwork-pro' ) . ' (ms)',
				'type' => Controls_Manager::SLIDER,
				'default' => [
					'size' => 800,
				],
				'range' => [
					'px' => [
						'min' => 0,
						'max' => 3000,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-item__content > div' => 'transition-duration: {{SIZE}}ms',
					'{{WRAPPER}} .madxartwork-gallery-item__content.madxartwork-gallery--sequenced-animation > div:nth-child(2)' => 'transition-delay: calc( ( {{SIZE}}ms / 3 ) )',
					'{{WRAPPER}} .madxartwork-gallery-item__content.madxartwork-gallery--sequenced-animation > div:nth-child(3)' => 'transition-delay: calc( ( {{SIZE}}ms / 3 ) * 2 )',
					'{{WRAPPER}} .madxartwork-gallery-item__content.madxartwork-gallery--sequenced-animation > div:nth-child(4)' => 'transition-delay: calc( ( {{SIZE}}ms / 3 ) * 3 )',
				],
				'condition' => [
					'content_hover_animation!' => '',
				],
			]
		);

		$this->add_control(
			'content_sequenced_animation',
			[
				'label' => __( 'Sequenced Animation', 'madxartwork-pro' ),
				'type' => Controls_Manager::SWITCHER,
				'condition' => [
					'content_hover_animation!' => '',
				],
				'frontend_available' => true,
				'render_type' => 'ui',
			]
		);

		$this->end_controls_section(); // overlay_content

		$this->start_controls_section(
			'filter_bar_style',
			[
				'label' => __( 'Filter Bar', 'madxartwork-pro' ),
				'tab' => Controls_Manager::TAB_STYLE,
				'condition' => [
					'gallery_type' => 'multiple',
				],
			]
		);

		$this->add_control(
			'align_filter_bar_items',
			[
				'label' => __( 'Align', 'madxartwork-pro' ),
				'type' => Controls_Manager::CHOOSE,
				'label_block' => false,
				'options' => [
					'left' => [
						'title' => __( 'Left', 'madxartwork-pro' ),
						'icon' => 'eicon-text-align-left',
					],
					'center' => [
						'title' => __( 'Center', 'madxartwork-pro' ),
						'icon' => 'eicon-text-align-center',
					],
					'right' => [
						'title' => __( 'Right', 'madxartwork-pro' ),
						'icon' => 'eicon-text-align-right',
					],
				],
				'prefix_class' => 'madxartwork-gallery--filter-align-',
				'selectors_dictionary' => [
					'left' => 'flex-start',
					'right' => 'flex-end',
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery__titles-container' => 'justify-content: {{VALUE}}',
				],
			]
		);

		$this->start_controls_tabs( 'filter_bar_colors' );

		$this->start_controls_tab( 'filter_bar_colors_normal',
			[
				'label' => __( 'Normal', 'madxartwork-pro' ),
			]
		);

		$this->add_control(
			'galleries_title_color_normal',
			[
				'label' => __( 'Text Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_1,
				],
				'selectors' => [
					'{{WRAPPER}} a.madxartwork-item' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_group_control(
			Group_Control_Typography::get_type(),
			[
				'name' => 'galleries_titles_typography',
				'selector' => '{{WRAPPER}} .madxartwork-gallery-title',
				'scheme' => Scheme_Typography::TYPOGRAPHY_1,
			]
		);

		$this->end_controls_tab();// filter_bar_colors_normal

		$this->start_controls_tab( 'filter_bar_colors_hover',
			[
				'label' => __( 'Hover', 'madxartwork-pro' ),
			]
		);

		$this->add_control(
			'galleries_title_color_hover',
			[
				'label' => __( 'Text Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} a.madxartwork-item:hover,
					{{WRAPPER}} a.madxartwork-item.madxartwork-item-active,
					{{WRAPPER}} a.madxartwork-item.highlighted,
					{{WRAPPER}} a.madxartwork-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => 'background',
				],
			]
		);

		$this->add_control(
			'galleries_title_color_hover_pointer_bg',
			[
				'label' => __( 'Text Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'default' => '#fff',
				'selectors' => [
					'{{WRAPPER}} a.madxartwork-item:hover,
					{{WRAPPER}} a.madxartwork-item.madxartwork-item-active,
					{{WRAPPER}} a.madxartwork-item.highlighted,
					{{WRAPPER}} a.madxartwork-item:focus' => 'color: {{VALUE}}',
				],
				'condition' => [
					'pointer' => 'background',
				],
			]
		);

		$this->add_control(
			'galleries_pointer_color_hover',
			[
				'label' => __( 'Pointer Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery__titles-container:not(.e--pointer-framed) .madxartwork-item:before,
					{{WRAPPER}} .madxartwork-gallery__titles-container:not(.e--pointer-framed) .madxartwork-item:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .madxartwork-item:before,
					{{WRAPPER}} .e--pointer-framed .madxartwork-item:after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],
			]
		);

		$this->end_controls_tab();// filter_bar_colors_hover

		$this->start_controls_tab( 'filter_bar_colors_active',
			[
				'label' => __( 'Active', 'madxartwork-pro' ),
			]
		);

		$this->add_control(
			'galleries_title_color_active',
			[
				'label' => __( 'Text Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_2,
				],
				'selectors' => [
					'{{WRAPPER}} a.madxartwork-item.madxartwork-item-active' => 'color: {{VALUE}}',
				],
			]
		);

		$this->add_control(
			'galleries_pointer_color_active',
			[
				'label' => __( 'Pointer Color', 'madxartwork-pro' ),
				'type' => Controls_Manager::COLOR,
				'scheme' => [
					'type' => Scheme_Color::get_type(),
					'value' => Scheme_Color::COLOR_4,
				],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery__titles-container:not(.e--pointer-framed) .madxartwork-item.madxartwork-item-active:before,
					{{WRAPPER}} .madxartwork-gallery__titles-container:not(.e--pointer-framed) .madxartwork-item.madxartwork-item-active:after' => 'background-color: {{VALUE}}',
					'{{WRAPPER}} .e--pointer-framed .madxartwork-item.madxartwork-item-active:before,
					{{WRAPPER}} .e--pointer-framed .madxartwork-item.madxartwork-item-active:after' => 'border-color: {{VALUE}}',
				],
				'condition' => [
					'pointer!' => [ 'none', 'text' ],
				],

			]
		);

		$this->end_controls_tab();// filter_bar_colors_active

		$this->end_controls_tabs(); // filter_bar_colors

		$this->add_control(
			'pointer_width',
			[
				'label' => __( 'Pointer Width', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'devices' => [ self::RESPONSIVE_DESKTOP, self::RESPONSIVE_TABLET ],
				'range' => [
					'px' => [
						'max' => 30,
					],
				],
				'selectors' => [
					'{{WRAPPER}} .e--pointer-framed .madxartwork-item:before' => 'border-width: {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .madxartwork-item:before' => 'border-width: 0 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-draw .madxartwork-item:after' => 'border-width: {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0 0',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .madxartwork-item:before' => 'border-width: {{SIZE}}{{UNIT}} 0 0 {{SIZE}}{{UNIT}}',
					'{{WRAPPER}} .e--pointer-framed.e--animation-corners .madxartwork-item:after' => 'border-width: 0 {{SIZE}}{{UNIT}} {{SIZE}}{{UNIT}} 0',
					'{{WRAPPER}} .e--pointer-underline .madxartwork-item:after,
					 {{WRAPPER}} .e--pointer-overline .madxartwork-item:before,
					 {{WRAPPER}} .e--pointer-double-line .madxartwork-item:before,
					 {{WRAPPER}} .e--pointer-double-line .madxartwork-item:after' => 'height: {{SIZE}}{{UNIT}}',
				],
				'separator' => 'before',
				'condition' => [
					'pointer' => [ 'underline', 'overline', 'double-line', 'framed' ],
				],
			]
		);

		$this->add_control(
			'galleries_titles_space_between',
			[
				'label' => __( 'Space Between', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery-title' => '--space-between: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->add_control(
			'galleries_titles_gap',
			[
				'label' => __( 'Gap', 'madxartwork-pro' ),
				'type' => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', '%' ],
				'selectors' => [
					'{{WRAPPER}} .madxartwork-gallery__titles-container' => 'margin-bottom: {{SIZE}}{{UNIT}}',
				],
			]
		);

		$this->end_controls_section(); // filter_bar_style
	}

	/**
	 *
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$is_multiple = 'multiple' === $settings['gallery_type'] && ! empty( $settings['galleries'] );

		$is_single = 'single' === $settings['gallery_type'] && ! empty( $settings['gallery'] );

		$has_description = ! empty( $settings['overlay_description'] );

		$has_title = ! empty( $settings['overlay_title'] );

		$has_animation = ! empty( $settings['image_hover_animation'] ) || ! empty( $settings['content_hover_animation'] ) || ! empty( $settings['background_overlay_hover_animation'] );

		$gallery_item_tag = ! empty( $settings['link_to'] ) ? 'a' : 'div';

		$galleries = [];

		if ( $is_multiple ) {
			$this->add_render_attribute( 'titles-container', 'class', 'madxartwork-gallery__titles-container' );

			if ( $settings['pointer'] ) {
				$this->add_render_attribute( 'titles-container', 'class', 'e--pointer-' . $settings['pointer'] );

				foreach ( $settings as $key => $value ) {
					if ( 0 === strpos( $key, 'animation' ) && $value ) {
						$this->add_render_attribute( 'titles-container', 'class', 'e--animation-' . $value );
						break;
					}
				}
			} ?>
			<div <?php echo $this->get_render_attribute_string( 'titles-container' ); ?>>
				<?php if ( $settings['show_all_galleries'] ) { ?>
					<a data-gallery-index="all" class="madxartwork-item madxartwork-gallery-title"><?php echo $settings['show_all_galleries_label']; ?></a>
				<?php } ?>

				<?php foreach ( $settings['galleries'] as $index => $gallery ) :
					if ( ! $gallery['multiple_gallery'] ) {
						continue;
					}

					$galleries[ $index ] = $gallery['multiple_gallery'];
					?>
					<a data-gallery-index="<?php echo $index; ?>" class="madxartwork-item madxartwork-gallery-title"><?php echo $gallery['gallery_title']; ?></a>
					<?php
				endforeach; ?>
			</div>
			<?php
		} elseif ( $is_single ) {
			$galleries[0] = $settings['gallery'];
		} elseif ( Plugin::madxartwork()->editor->is_edit_mode() ) { ?>
			<i class="madxartwork-widget-empty-icon eicon-gallery-justified"></i>
		<?php }

		$this->add_render_attribute( 'gallery_container', 'class', 'madxartwork-gallery__container' );

		if ( $has_title || $has_description ) {
			$this->add_render_attribute( 'gallery_item_content', 'class', 'madxartwork-gallery-item__content' );

			if ( $has_title ) {
				$this->add_render_attribute( 'gallery_item_title', 'class', 'madxartwork-gallery-item__title' );
			}

			if ( $has_description ) {
				$this->add_render_attribute( 'gallery_item_description', 'class', 'madxartwork-gallery-item__description' );
			}
		}

		$this->add_render_attribute( 'gallery_item_background_overlay', [ 'class' => 'madxartwork-gallery-item__overlay' ] );

		$gallery_items = [];
		foreach ( $galleries as $gallery_index => $gallery ) {
			foreach ( $gallery as $index => $item ) {
				if ( in_array( $item['id'], array_keys( $gallery_items ), true ) ) {
					$gallery_items[ $item['id'] ][] = $gallery_index;
				} else {
					$gallery_items[ $item['id'] ] = [ $gallery_index ];
				}
			}
		}

		if ( ! empty( $galleries ) ) { ?>
		<div <?php echo $this->get_render_attribute_string( 'gallery_container' ); ?>>
			<?php
			foreach ( $gallery_items as $id => $tags ) :
				$unique_index = $id; //$gallery_index . '_' . $index;
				$thumbnail_size = $settings['thumbnail_image_size'];
				$attachment = get_post( $id );
				$image_data = [
					'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
					'permalink' => get_permalink( $attachment->ID ),
					'media' => wp_get_attachment_image_src( $id, 'full' )['0'],
					'src' => wp_get_attachment_image_src( $id, $thumbnail_size )['0'],
				];

				$this->add_render_attribute( 'gallery_item_' . $unique_index, [
					'class' => [
						'e-gallery-item',
						'madxartwork-gallery-item',
					],
				] );

				if ( $has_animation ) {
					$this->add_render_attribute( 'gallery_item_' . $unique_index, [ 'class' => 'madxartwork-animated-content' ] );
				}

				if ( $is_multiple ) {
					$this->add_render_attribute( 'gallery_item_' . $unique_index, [ 'data-e-gallery-tags' => implode( ',', $tags ) ] );
				}

				if ( 'a' === $gallery_item_tag ) {
					$href = '#';
					if ( 'file' === $settings['link_to'] ) {
						$href = $image_data['media'];
						$this->add_render_attribute( 'gallery_item_' . $unique_index, [ 'data-madxartwork-lightbox-slideshow' => 'all' ] );
					}
					$this->add_render_attribute( 'gallery_item_' . $unique_index, [ 'href' => $href ] );
				}

				$this->add_render_attribute( 'gallery_item_image_' . $unique_index,
					[
						'class' => [
							'e-gallery-image',
							'madxartwork-gallery-item__image',
						],
						'data-thumbnail' => $image_data['src'],
						'alt' => $image_data['alt'],
					]
				);?>

				<<?php echo $gallery_item_tag; ?> <?php echo $this->get_render_attribute_string( 'gallery_item_' . $unique_index ); ?>>
					<div <?php echo $this->get_render_attribute_string( 'gallery_item_image_' . $unique_index ); ?> ></div>
					<?php if ( ! empty( $settings['overlay_background'] ) ) : ?>
					<div <?php echo $this->get_render_attribute_string( 'gallery_item_background_overlay' ); ?>></div>
					<?php endif; ?>
					<?php if ( $has_title || $has_description ) :
						$image_data = [
							'caption' => $attachment->post_excerpt,
							'description' => $attachment->post_content,
							'title' => $attachment->post_title,
						];
						?>
					<div <?php echo $this->get_render_attribute_string( 'gallery_item_content' ); ?>>
						<?php if ( $has_title ) :
							$title = $image_data[ $settings['overlay_title'] ];
							if ( ! empty( $title ) ) : ?>
							<div <?php echo $this->get_render_attribute_string( 'gallery_item_title' ); ?>><?php echo $title; ?></div>
							<?php endif;
						endif;
						if ( $has_description ) :
							$description = $image_data[ $settings['overlay_description'] ];
							if ( ! empty( $description ) ) :?>
							<div <?php echo $this->get_render_attribute_string( 'gallery_item_description' ); ?>><?php echo $description; ?></div>
							<?php endif;
						endif; ?>
					</div>
					<?php endif; ?>
				</<?php echo $gallery_item_tag; ?>>
			<?php endforeach;
			//endforeach; ?>
		</div>
	<?php }
	}
}
