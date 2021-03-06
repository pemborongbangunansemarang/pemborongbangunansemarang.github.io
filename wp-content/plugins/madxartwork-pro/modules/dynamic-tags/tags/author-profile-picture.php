<?php
namespace madxartworkPro\Modules\DynamicTags\Tags;

use madxartwork\Core\DynamicTags\Data_Tag;
use madxartworkPro\Classes\Utils;
use madxartworkPro\Modules\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Author_Profile_Picture extends Data_Tag {

	public function get_name() {
		return 'author-profile-picture';
	}

	public function get_title() {
		return __( 'Author Profile Picture', 'madxartwork-pro' );
	}

	public function get_group() {
		return Module::AUTHOR_GROUP;
	}

	public function get_categories() {
		return [ Module::IMAGE_CATEGORY ];
	}

	public function get_value( array $options = [] ) {
		Utils::set_global_authordata();

		return [
			'id' => '',
			'url' => get_avatar_url( (int) get_the_author_meta( 'ID' ) ),
		];
	}
}
