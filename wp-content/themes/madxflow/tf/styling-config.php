<?php
/**
 * Styling Config
 * @param array $args 
 * @return array
 */
function tf_styling_global_settings( $args ) {
	$args = array(
		// Body
		'body' => array(
			'label' => __( 'General', 'madx-flow'),
		),
			// Body
			'body_main' => array(
				'label' => __( 'Body', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'body',
				'basic_styling' => array( 'background', 'font', 'padding' ),
			),
			'body_link' => array(
				'label' => __( 'Link', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'a',
				'basic_styling' => array( 'font' ),
			),
			'body_link_hover' => array(
				'label' => __( 'Link Hover', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'a:hover',
				'basic_styling' => array( 'font' ),
			),
			'body_strong' => array(
				'label' => __( 'Bold Text', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'strong, b',
				'basic_styling' => array( 'font' ),
			),
			'body_em' => array(
				'label' => __( 'Italic Text', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'em, i',
				'basic_styling' => array( 'font' ),
			),
			'body_p' => array(
				'label' => __( 'Paragraph', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'p',
				'basic_styling' => array( 'margin' ),
			),
			'body_img' => array(
				'label' => __( 'Image', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'img',
				'basic_styling' => array( 'background', 'padding', 'border' ),
			),
			'blockquote' => array(
				'label' => __( 'Blockquote', 'madx-flow' ),
				'parent' => 'body',
				'selector' => 'blockquote',
				'basic_styling' => array( 'font', 'background', 'margin', 'padding', 'border' ),
			),

		// Headings
		'heading' => array(
			'label' => __( 'Heading', 'madx-flow'),
		),
			// Headings
			'heading1' => array(
				'label' => __( 'H1', 'madx-flow' ),
				'parent' => 'heading',
				'selector' => 'h1',
				'basic_styling' => array( 'font', 'margin' ),
			),
			'heading2' => array(
				'label' => __( 'H2', 'madx-flow' ),
				'parent' => 'heading',
				'selector' => 'h2',
				'basic_styling' => array( 'font', 'margin' ),
			),
			'heading3' => array(
				'label' => __( 'H3', 'madx-flow' ),
				'parent' => 'heading',
				'selector' => 'h3',
				'basic_styling' => array( 'font', 'margin' ),
			),
			'heading4' => array(
				'label' => __( 'H4', 'madx-flow' ),
				'parent' => 'heading',
				'selector' => 'h4',
				'basic_styling' => array( 'font', 'margin' ),
			),
			'heading5' => array(
				'label' => __( 'H5', 'madx-flow' ),
				'parent' => 'heading',
				'selector' => 'h5',
				'basic_styling' => array( 'font', 'margin' ),
			),
			'heading6' => array(
				'label' => __( 'H6', 'madx-flow' ),
				'parent' => 'heading',
				'selector' => 'h6',
				'basic_styling' => array( 'font', 'margin' ),
			),

		// Form
		'form' => array(
			'label' => __( 'Form', 'madx-flow'),
		),
			'form_input' => array(
				'label' => __( 'Form Input', 'madx-flow' ),
				'parent' => 'form',
				'selector' => 'textarea, input[type=text], input[type=password], input[type=search], input[type=email], input[type=url], input[type=number], input[type=tel], input[type=date], input[type=datetime], input[type=datetime-local], input[type=month], input[type=time], input[type=week]',
				'basic_styling' => array( 'background', 'font', 'padding', 'border' ),
			),
			'form_input_focus' => array(
				'label' => __( 'Form Input Focus', 'madx-flow' ),
				'parent' => 'form',
				'selector' => 'textarea:focus, input[type=text]:focus, input[type=password]:focus, input[type=search]:focus, input[type=email]:focus, input[type=url]:focus, input[type=number]:focus, input[type=tel]:focus, input[type=date]:focus, input[type=datetime]:focus, input[type=datetime-local]:focus, input[type=month]:focus, input[type=time]:focus, input[type=week]:focus',
				'basic_styling' => array( 'background', 'font', 'padding', 'border' ),
			),
			'form_textarea' => array(
				'label' => __( 'Form Textarea', 'madx-flow' ),
				'parent' => 'form',
				'selector' => 'textarea',
				'basic_styling' => array( 'background', 'font', 'padding', 'border' ),
			),
			'form_button' => array(
				'label' => __( 'Form Button', 'madx-flow' ),
				'parent' => 'form',
				'selector' => 'input[type=reset], input[type=submit], button',
				'basic_styling' => array( 'background', 'font', 'padding', 'border' ),
			),
			'form_button_hover' => array(
				'label' => __( 'Form Button Hover', 'madx-flow' ),
				'parent' => 'form',
				'selector' => 'input[type=reset]:hover, input[type=submit]:hover, button:hover',
				'basic_styling' => array( 'background', 'font', 'padding', 'border' ),
			),

		// Header
		'header' => array(
			'label' => __( 'Header', 'madx-flow'),
		),
			'header_main' => array(
				'label' => __( 'Header', 'madx-flow' ),
				'parent' => 'header',
				'selector' => '.tf_header',
				'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
			),
			'header_link' => array(
				'label' => __( 'Header Link', 'madx-flow' ),
				'parent' => 'header',
				'selector' => '.tf_header a',
				'basic_styling' => array( 'font' ),
			),

		// Sidebar
		'sidebar' => array(
			'label' => __( 'Sidebar', 'madx-flow'),
		),
			'sidebar_main' => array(
				'label' => __( 'Sidebar', 'madx-flow' ),
				'parent' => 'sidebar',
				'selector' => '.tf_sidebar',
				'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
			),
			'sidebar_link' => array(
				'label' => __( 'Sidebar Link', 'madx-flow' ),
				'parent' => 'sidebar',
				'selector' => '.tf_sidebar a',
				'basic_styling' => array( 'font' ),
			),
			'widget_container' => array(
				'label' => __( 'Widget Container', 'madx-flow' ),
				'parent' => 'sidebar',
				'selector' => '.tf_widget',
				'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
			),
			'widget_title' => array(
				'label' => __( 'Widget Title', 'madx-flow' ),
				'parent' => 'sidebar',
				'selector' => '.tf_widget_title',
				'basic_styling' => array( 'font', 'margin' ),
			),

		// Footer
		'footer' => array(
			'label' => __( 'Footer', 'madx-flow'),
		),
			'footer_main' => array(
				'label' => __( 'Footer', 'madx-flow' ),
				'parent' => 'footer',
				'selector' => '.tf_footer',
				'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
			),
			'footer_link' => array(
				'label' => __( 'Footer Link', 'madx-flow' ),
				'parent' => 'footer',
				'selector' => '.tf_footer a',
				'basic_styling' => array( 'font' ),
			),

		// Layout Containers
		'container' => array(
			'label' => __( 'Layout Containers', 'madx-flow'),
		),
			'pagewrap' => array(
				'label' => __( 'Page Wrap', 'madx-flow' ),
				'parent' => 'container',
				'selector' => '#pagewrap',
				'basic_styling' => array( 'background', 'padding', 'margin', 'border' ),
			),
			'pagewidth' => array(
				'label' => __( 'Page Width', 'madx-flow' ),
				'parent' => 'container',
				'selector' => '.pagewidth, .madx_builder_row .row_inner, .tf_row_wrapper > .tf_row_inner',
				'basic_styling' => array( 'width' ),
			),
			'middlewrap' => array(
				'label' => __( 'Middle Wrap', 'madx-flow' ),
				'parent' => 'container',
				'selector' => '#middlewrap',
				'basic_styling' => array( 'background', 'padding', 'margin', 'border' ),
			),
                        'middle' => array(
				'label' => __( 'Middle Container', 'madx-flow' ),
				'parent' => 'container',
				'selector' => '#middle',
				'basic_styling' => array( 'background', 'padding', 'margin', 'border' ),
			),
			'content_container' => array(
				'label' => __( 'Content Container', 'madx-flow' ),
				'parent' => 'container',
				'selector' => '#content',
				'basic_styling' => array( 'background', 'padding', 'margin', 'border' ),
			),
			'sidebar_container' => array(
				'label' => __( 'Sidebar Container', 'madx-flow' ),
				'parent' => 'container',
				'selector' => '#sidebar',
				'basic_styling' => array( 'background', 'padding', 'margin', 'border' ),
			),

	);
	return $args;
}
add_filter( 'tf_styling_global_settings', 'tf_styling_global_settings' );