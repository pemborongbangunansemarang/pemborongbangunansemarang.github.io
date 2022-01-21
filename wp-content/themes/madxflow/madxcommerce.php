<?php
/**
 * Template for woocommerce pages
 * 
 * @package madxFlow
 * @since 1.0.0
 */

add_action( 'tf_template_render_content', 'woocommerce_content' );

do_action( 'tf_template_render', basename( __FILE__ ) );