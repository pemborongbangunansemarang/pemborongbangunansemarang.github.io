<?php
namespace madxartworkPro\Base;

use madxartwork\Widget_Base;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

abstract class Base_Widget extends Widget_Base {

	public function get_categories() {
		return [ 'pro-elements' ];
	}
}
