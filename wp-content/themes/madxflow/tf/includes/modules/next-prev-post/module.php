<?php
/**
 * Module Prev/Next Post.
 * 
 * Show the Post Navigation
 * @package madxFlow
 * @since 1.0.0
 */
class TF_Module_Next_Prev_Post extends TF_Module {
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct( array(
			'name' => __( 'Next/Prev Post', 'madx-flow' ),
			'slug' => 'next_prev_post',
			'shortcode' => 'tf_next_prev_post',
			'description' => __( 'Display Post Navigation.', 'madx-flow' ),
			'category' => 'single'
		) );
	}

	/**
	 * Module settings field.
	 * 
	 * Display module options.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function fields() {
		return apply_filters( 'tf_module_prev_next_post_fields', array(
			'prev_post_label' => array(
				'type' => 'text',
				'label' => __( 'Prev Post Label', 'madx-flow' ),
				'class' => 'tf_input_width_70',
			),
			'next_post_label' => array(
				'type' => 'text',
				'label' => __( 'Next Post Label', 'madx-flow' ),
				'class' => 'tf_input_width_70',
			),
			'show_arrow' => array(
				'type' => 'radio',
				'label' => __( 'Show Arrow Icon', 'madx-flow' ),
				'options' => array(
					array( 'name' => __( 'Yes', 'madx-flow' ), 'value' => 'yes', 'selected' => true ),
					array( 'name' => __( 'No', 'madx-flow' ), 'value' => 'no' ),
				),
			),
			'in_same_cat' => array(
				'type' => 'checkbox',
				'label' => __( 'Same Category', 'madx-flow' ),
				'text' => __( 'Show only from the same category', 'madx-flow' ),
			),
		) );
	}

	/**
	 * Module style selectors.
	 * 
	 * Hold module stye selectors to be used in Styling Panel.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function styles() {
		return apply_filters( 'tf_module_prev_next_post_styles', array(
			'tf_module_prev_next_post_container' => array(
				'label' => __( 'Next/Prev Container', 'madx-flow' ),
				'selector' => '.tf_post_nav',
				'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
			),
			'tf_module_prev_next_post_link' => array(
				'label' => __( 'Next/Prev Link', 'madx-flow' ),
				'selector' => '.tf_post_nav a',
				'basic_styling' => array( 'border', 'font', 'margin' ),
			),
			'tf_module_prev_next_post_link_hover' => array(
				'label' => __( 'Next/Prev Link Hover', 'madx-flow' ),
				'selector' => '.tf_post_nav a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_prev_next_post_arrow' => array(
				'label' => __( 'Next/Prev Arrow', 'madx-flow' ),
				'selector' => '.tf_post_nav .prev .arrow:before, .tf_post_nav .next .arrow:before',
				'basic_styling' => array( 'background', 'border', 'font', 'padding' ),
			),
			'tf_module_prev_next_post_label' => array(
				'label' => __( 'Next/Prev Post Label', 'madx-flow' ),
				'selector' => '.tf_post_nav .next_prev_post_label',
				'basic_styling' => array( 'font' ),
			),
		) );
	}

	/**
	 * Render main shortcode.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $atts 
	 * @param string $content 
	 * @return string
	 */
	public function render_shortcode( $atts, $content = null ) {
		extract( shortcode_atts( array(
			'prev_post_label' => '',
			'next_post_label' => '',
			'show_arrow' => 'yes',
			'in_same_cat' => 0,
		), $atts, $this->shortcode ) );

		ob_start();

		// call the action hook used for get_template_part
		do_action( 'get_template_part_includes/post-nav' );

		$template = locate_template( array( 'includes/post-nav.php' ), false );
		ob_start();
			include( $template );
		$output = ob_get_clean();

		return $output;
	}
}

/** Initialize module */
new TF_Module_Next_Prev_Post();