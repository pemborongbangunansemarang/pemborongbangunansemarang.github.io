<?php
/**
 * Class TF Template.
 * 
 * Register post type, settings and page builder.
 * 
 * @package madxFlow
 * @since 1.0.0
 */
class TF_Template {

	/**
	 * Post type name.
	 * 
	 * @since 1.0.0
	 * @access protected
	 * @var string $post_type
	 */
	protected $post_type = 'tf_template';

	/**
	 * Default fields.
	 * 
	 * @since 1.0.0
	 * @access protected
	 * @var array $defaults
	 */
	protected $defaults = array();

	/**
	 * Constructor.
	 * 
	 * @since 1.0.0
	 * @access public
	 */
	public function __construct(){
		// Set default fields
		$this->defaults = array(
			'tf_template_name'             => __( 'New Template', 'madx-flow'),
			'tf_template_header_option'    => 'default',
			'tf_template_sidebar_option'   => 'sidebar_right',
			'tf_template_footer_option'    => 'default',
			'tf_template_type'             => 'archive',
			'tf_template_assign'           => array(),
			'menu_order'                   => 0,
			'tf_template_custom_css_class' => ''
		);

		add_action( 'init', array( $this, 'register_post_types' ) );
		//add_action( 'init', array( $this, 'register_taxonomies' ) );
		add_action( 'tf_lightbox_render_form_template', array( $this, 'render_form' ) );
		add_action( 'tf_form_saving_template', array( $this, 'saving_form' ) );
		add_action( 'tf_form_validate_template', array( $this, 'validate_fields' ) );
		
		if ( ! is_admin() ) {
			add_filter( 'template_include', array( $this, 'render_template_region' ) );
		} else {
			add_action( 'edit_form_top', array( $this, 'add_view_btn') );

			add_filter( 'manage_edit-' . $this->post_type . '_columns', array( $this, 'edit_columns' ) );
			add_action( 'manage_' . $this->post_type . '_posts_custom_column', array( $this, 'manage_custom_column' ), 10, 2 );
			add_filter( 'post_row_actions', array( $this, 'post_row_actions' ) );

			// Metaboxes
			add_action( 'add_meta_boxes', array( $this, 'options_metaboxes' ) );
			add_action( 'save_post', array( $this, 'save_option_metabox' ) );
		}

		// Duplicate Template
		add_action( 'tf_lightbox_render_form_template_duplicate', array( $this, 'render_duplicate_form' ) );
		add_action( 'tf_form_validate_template_duplicate', array( $this, 'validate_fields' ) );
		add_action( 'tf_form_saving_template_duplicate', array( $this, 'saving_duplicate_form' ) );

		// Delete cached template
		add_action( 'save_post', array( $this, 'delete_template_cached' ) );
		add_action( 'before_delete_post', array( $this, 'delete_template_cached' ) );
		add_action( 'wp_trash_post', array( $this, 'delete_template_cached' ) );
	}

	/**
	 * Register post type template.
	 * 
	 * @since 1.0.0
	 * @access public
	 */
	public function register_post_types() {
		global $pagenow;
		$can_export = true;
		
		// Disallow post type to be exportable in WP > Tools > Export
		if ( is_admin() && 'export.php' == $pagenow ) 
			$can_export = false;

		register_post_type( $this->post_type,
			apply_filters( 'tf_register_post_type_tf_template', array(
				'labels' => array(
					'name'               => __( 'Templates', 'madx-flow' ),
					'singular_name'      => __( 'Template', 'madx-flow' ),
					'menu_name'          => _x( 'Templates', 'admin menu', 'madx-flow' ),
					'name_admin_bar'     => _x( 'Template', 'add new on admin bar', 'madx-flow' ),
					'add_new'            => _x( 'Add New', 'template', 'madx-flow' ),
					'add_new_item'       => __( 'Add New Template', 'madx-flow' ),
					'new_item'           => __( 'New Template', 'madx-flow' ),
					'edit_item'          => __( 'Edit Template', 'madx-flow' ),
					'view_item'          => __( 'View Template', 'madx-flow' ),
					'all_items'          => __( 'All Templates', 'madx-flow' ),
					'search_items'       => __( 'Search Templates', 'madx-flow' ),
					'parent_item_colon'  => __( 'Parent Templates:', 'madx-flow' ),
					'not_found'          => __( 'No templates found.', 'madx-flow' ),
					'not_found_in_trash' => __( 'No templates found in Trash.', 'madx-flow' )
				),
				'public'              => false,
				'exclude_from_search' => true,
				'publicly_queryable'  => current_user_can( 'manage_options' ),
				'show_ui'             => true,
				'show_in_menu'        => false,
				'query_var'           => true,
				'rewrite'             => array( 'slug' => 'templates' ),
				'capability_type'     => 'post',
				'has_archive'         => false,
				'hierarchical'        => false,
				'menu_position'       => null,
				'supports'            => array( 'title' ),
				'can_export'          => $can_export
			))
		);
	}

	public function register_taxonomies() {
		register_taxonomy( 'associated_theme',
			apply_filters( 'tf_taxonomy_objects_associated_theme', array( 'tf_template' ) ),
			apply_filters( 'tf_taxonomy_args_associated_theme', array(
				'hierarchical'      => false,
				'labels'            => array(
					'name'              => _x( 'Associated Themes', 'taxonomy general name', 'madx-flow' ),
					'singular_name'     => _x( 'Associated Theme', 'taxonomy singular name', 'madx-flow' ),
					'search_items'      => __( 'Search Associated Themes', 'madx-flow' ),
					'all_items'         => __( 'All Associated Themes', 'madx-flow' ),
					'parent_item'       => __( 'Parent Associated Theme', 'madx-flow' ),
					'parent_item_colon' => __( 'Parent Associated Theme:', 'madx-flow' ),
					'edit_item'         => __( 'Edit Associated Theme', 'madx-flow' ),
					'update_item'       => __( 'Update Associated Theme', 'madx-flow' ),
					'add_new_item'      => __( 'Add New Associated Theme', 'madx-flow' ),
					'new_item_name'     => __( 'New Associated Theme Name', 'madx-flow' ),
					'menu_name'         => __( 'Associated Themes', 'madx-flow' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'associated-theme' ),
			))
		);

		/*register_taxonomy( 'tf_template_type',
			apply_filters( 'tf_taxonomy_objects_template_type', array( 'tf_template' ) ),
			apply_filters( 'tf_taxonomy_args_template_type', array(
				'hierarchical'      => false,
				'labels'            => array(
					'name'              => _x( 'Template Types', 'taxonomy general name', 'madx-flow' ),
					'singular_name'     => _x( 'Template Types', 'taxonomy singular name', 'madx-flow' ),
					'search_items'      => __( 'Search Template Types', 'madx-flow' ),
					'all_items'         => __( 'All Template Types', 'madx-flow' ),
					'parent_item'       => __( 'Parent Template Types', 'madx-flow' ),
					'parent_item_colon' => __( 'Parent Template Types:', 'madx-flow' ),
					'edit_item'         => __( 'Edit Template Types', 'madx-flow' ),
					'update_item'       => __( 'Update Template Types', 'madx-flow' ),
					'add_new_item'      => __( 'Add New Template Types', 'madx-flow' ),
					'new_item_name'     => __( 'New Template Type Name', 'madx-flow' ),
					'menu_name'         => __( 'Template Types', 'madx-flow' ),
				),
				'show_ui'           => true,
				'show_admin_column' => true,
				'query_var'         => true,
				'rewrite'           => array( 'slug' => 'template-type' ),
			))
		);*/
	}

	/**
	 * Post Type Custom column.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $columns 
	 * @return array
	 */
	public function edit_columns( $columns ) {
		$columns = array(
			'cb'        => '<input type="checkbox" />',
			'title'     => __('Template', 'madx-flow'),
			'type'      => __('Type', 'madx-flow'),
			'assign_to' => __('Assign To', 'madx-flow'),
			'priority'  => __('Template Priority', 'madx-flow'),
			'date'      => __('Date', 'madx-flow')
		);
		return $columns;
	}

	/**
	 * Manage Post Type Custom Columns.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $column 
	 * @param int $post_id 
	 */
	public function manage_custom_column( $column, $post_id  ) {
		switch ( $column ) {
			case 'type':
				echo get_post_meta( $post_id, 'tf_template_type', true );
			break;

			case 'assign_to':
				$assign = get_post_meta( $post_id, 'tf_template_assign', true );
				if ( ! empty( $assign ) && is_array( $assign ) && count( $assign ) > 0 ) {
					echo '<ul>';
					foreach ( $assign as $type => $page ) {
						$text = ucfirst( $type ) . ' > ';
						foreach( $page as $key => $value ) {
							$text .= ucfirst( $key );
							if ( is_array( $value ) ) {
								foreach( $value as $sub_key => $val ) {
									$text .= ' > ' . ucfirst( $sub_key );
								}
							}
						}
						echo '<li>'. $text .'</li>';
					}
					echo '</ul>';
				}
			break;

			case 'priority':
				global $post;
				echo $post->menu_order;
			break;
		}
	}

	/**
	 * Post Row Actions
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $actions 
	 * @return array
	 */
	public function post_row_actions( $actions ) {
		global $post;
		if ( $this->post_type == $post->post_type ) {
			$actions['tf-export-template'] = sprintf( '<a href="%s">%s</a>', 
				wp_nonce_url( admin_url( 'post.php?post=' . $post->ID . '&action=export_tf_template' ), 'export_tf_nonce' ), 
				__('Export', 'madx-flow') 
			);
			$actions['tf-duplicate-template'] = sprintf( '<a href="#" class="tf_lightbox_duplicate" data-type="template" data-post-id="%d">%s</a>', 
				$post->ID, 
				__('Duplicate', 'madx-flow') 
			);
			$actions['tf-replace-template'] = sprintf( '<a href="#" class="tf_lightbox_replace" data-type="template" data-post-id="%d">%s</a>', 
				$post->ID, 
				__('Replace', 'madx-flow') 
			);
			$actions['tf-view-template'] = sprintf( '<a href="%s" target="_blank">%s</a>', 
				esc_url( add_query_arg( 'tf', 1, get_permalink( $post->ID ) ) ), 
				__('Frontend Edit', 'madx-flow') 
			);
			if ( isset( $actions['inline hide-if-no-js'] ) ) 
				unset( $actions['inline hide-if-no-js'] );
		}
		return $actions;
	}

	/**
	 * Add view link button.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param object $post
	 */
	public function add_view_btn( $post ) {
		if ( $this->post_type == $post->post_type ) {
			echo sprintf( '<a href="%s" class="button">%s</a>', 
				esc_url( add_query_arg( 'tf', 1, get_permalink( $post->ID ) ) ),
				__('Switch to frontend', 'madx-flow') 
			);

		}
	}

	/**
	 * Template form fields.
	 * 
	 * @since 1.0.0
	 * @access public
	 */
	public function fields() {
		global $TF;

		$image_base = $TF->framework_uri() . '/assets/img/layout-icons';
		$type_options = TF_Model::template_types();
		$type_options[0]['selected'] = true;

		return apply_filters( 'tf_post_type_tf_template_fields', array(
			'tf_template_name'           => array(
				'type'  => 'text',
				'class' => 'tf_input_width_40',
				'label' => __('Name', 'madx-flow')
			),
			'tf_template_header_option'  => array(
				'type'       => 'layout',
				'label'      => __('Header', 'madx-flow'),
				'options'    => array(
					array( 'img' => $image_base . '/header.png', 'value' => 'default', 'label' => __('Header', 'madx-flow'), 'selected' => true ),
					array( 'img' => $image_base . '/none.png', 'value' => 'header-none', 'label' => __('Header None', 'madx-flow') )
				)
			),
			'tf_template_sidebar_option' => array(
				'type'       => 'layout',
				'label'      => __('Sidebar', 'madx-flow'),
				'options'    => array(
					array( 'img' => $image_base . '/sidebar1.png', 'value' => 'sidebar_right', 'label' => __('Sidebar Right', 'madx-flow'), 'selected' => true ),
					array( 'img' => $image_base . '/sidebar1-left.png', 'value' => 'sidebar_left', 'label' => __('Sidebar1 Left', 'madx-flow') ),
					array( 'img' => $image_base . '/none.png', 'value' => 'sidebar_none', 'label' => __('Sidebar None', 'madx-flow') )
				)
			),
			'tf_template_footer_option'  => array(
				'type'       => 'layout',
				'label'      => __('Footer', 'madx-flow'),
				'options'    => array(
					array( 'img' => $image_base . '/footer.png', 'value' => 'default', 'label' => __('Footer', 'madx-flow'), 'selected' => true ),
					array( 'img' => $image_base . '/none.png', 'value' => 'footer-none', 'label' => __('Footer None', 'madx-flow') )
				)
			),
			'tf_template_type'           => array(
				'type'         => 'radio',
				'label'        => __('Template Type', 'madx-flow'),
				'options'      => $type_options,
				'toggleable'   => array(
					'target_class' => 'visibility-tabs-tf_template_assign'
				)
			),
			'tf_template_assign'         => array(
				'type'        => 'template_assign',
				'label'       => __('Assign Template To:', 'madx-flow'),
				'description' => __('Leave everything unchecked will apply to all (eg. if it is an archive template, it will apply to all archive views of all categories, tags, archives, post types, and taxonomies)', 'madx-flow')
			),
			'menu_order' => array(
				'type' => 'text',
				'class' => 'tf_input_width_20',
				'label' => __('Template Priority', 'madx-flow'),
				'description' => __('If multiple templates are assigned to the same views, the higher priority will be used', 'madx-flow'),
				'default' => 0
			),
			'tf_template_custom_css_class' => array(
				'type'  => 'text',
				'class' => 'tf_input_width_80',
				'label' => __('Custom CSS Class', 'madx-flow')
			)
		));
	}

	/**
	 * Render form ajax.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param string $method Form state (Add/Edit/Delete).
	 */
	public function render_form( $method ) {
		$label_submit_btn = 'add' == $method ? __('Add', 'madx-flow') : __('Update', 'madx-flow');
		$data = array();
		
		if ( 'edit' == $method ) {
			$template_id = $_POST['template_id'];
			$data = TF_Model::get_field_exist_values( $this->fields(), $template_id );
			$get_post = get_post( $template_id );
			$data['tf_template_name'] = $get_post->post_title;
			$data['menu_order'] = $get_post->menu_order;
		}

		echo TF_Form::open( array( 'id' => 'tf_template_form' ) );
		echo sprintf( '<input type="hidden" name="tf_template_form_state" value="%s">', $method );
		if ( 'edit' == $method ) {
			echo sprintf( '<input type="hidden" name="_template_id" value="%d">', $template_id );
		}
		echo TF_Form::render( $this->fields(), $data );
		echo TF_Form::submit_button( $label_submit_btn );
		echo TF_Form::close();
	}

	/**
	 * Validate some form fields input
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $fields 
	 * @return json
	 */
	public function validate_fields( $fields ) {
		
		$validator = new TF_Validator( $fields, apply_filters( 'tf_form_validate_template_field_rules', array(
			'tf_template_name' => array( 'rule' => 'notEmpty', 'error_msg' => __('You should enter the template name', 'madx-flow') )
		)));

		if ( $validator->fails() ) {
			wp_send_json_error( $validator->get_error_messages() );
		}

	}

	/**
	 * Saving form data.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $post_data 
	 */
	public function saving_form( $post_data ) {
		global $TF;
		
		$post_data = wp_parse_args( $post_data, $this->defaults );

		if ( 'edit' == $post_data['tf_template_form_state'] ) {
			$new_id = $post_data['_template_id'];
			$new_post = array();
			$new_post['ID'] = $new_id;
			$new_post['post_title'] = sanitize_text_field( $post_data['tf_template_name'] );
			$new_post['menu_order'] = $post_data['menu_order'];

			wp_update_post( $new_post );
		} else {
			// Create post object
			$post_title = sanitize_text_field( $post_data['tf_template_name'] );
			$set_slug = sanitize_title( $TF->active_theme->slug . ' ' . $post_title );
			$my_post = array(
				'post_title'  => $post_title,
				'post_name'   => $set_slug,
				'post_status' => 'publish',
				'post_type'   => $this->post_type,
				'menu_order'  => $post_data['menu_order']
			);
			$new_id = wp_insert_post( $my_post );
		}
		
		if ( $new_id ) {
			foreach( $this->defaults as $key => $value ) {
				if ( in_array( $key, array( 'tf_template_name', 'menu_order' ) ) ) continue;
				update_post_meta( $new_id, $key, $post_data[ $key ] );
			}

			// Update associated theme
			update_post_meta( $new_id, 'associated_theme', $TF->active_theme->slug );

			$callback_uri = add_query_arg( 'tf', 1, get_permalink( $new_id ) );
			wp_send_json_success( esc_url( $callback_uri ) );
		}
	}

	/**
	 * Use custom template for Template post type.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param string $original_template 
	 * @return string
	 */
	public function render_template_region( $original_template ) {
		if ( is_singular( array( $this->post_type ) ) ) {
			global $TF, $TF_Layout, $post;

			$templatefilename = TF_Model::is_tf_editor_active() ? 'template-region-edit.php' : 'template-region.php';
			
			// locate on theme
			$return_template = locate_template(
				array(
					trailingslashit( 'templates' ) . $templatefilename
				)
			);

			// Setup Layout
			$TF_Layout->setup_layout( $post );

			// Get default template
			if ( ! $return_template )
				$return_template = $TF->framework_path() . '/includes/templates/' . $templatefilename;

			return $return_template;
		} else {
			return $original_template;
		}
	}

	/**
	 * Add Template menu to Admin Bar.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param object $wp_admin_bar 
	 */
	public function add_admin_bar_menu( $wp_admin_bar ) {

		if ( ! TF_Model::is_tf_editor_active() )
			return;
		
		$args = array(
			array(
				'id'    => 'tf_template_admin_menu',
				'title' => __('TF Template', 'madx-flow'),
				'href'  => '#'
			),
			array(
				'id'     => 'tf_template_admin_menu_options',
				'parent' => 'tf_template_admin_menu',
				'title'  => __( 'Template Options', 'madx-flow' ),
				'href'   => '#',
				'meta'   => array( 'class' => 'tf_template_admin_menu_options' )
			),
			array(
				'id'     => 'tf_template_admin_menu_global_styling',
				'parent' => 'tf_template_admin_menu',
				'title'  => __( 'Global Styling', 'madx-flow' ),
				'href'   => '#',
				'meta'   => array( 'class' => 'tf_load_global_styling' )
			),
			array(
				'id'     => 'tf_template_admin_menu_export', 
				'parent' => 'tf_template_admin_menu',
				'title'  => __( 'Export', 'madx-flow' ), 
				'href'   => '#', 
				'meta'   => array( 'class' => 'tf_template_admin_menu_export' )
			),
			array(
				'id'     => 'tf_template_admin_menu_import', 
				'parent' => 'tf_template_admin_menu',
				'title'  => __( 'Replace (Import)', 'madx-flow' ), 
				'href'   => '#', 
				'meta'   => array( 'class' => 'tf_template_admin_menu_import' )
			)
		);

		if ( TF_Model::is_tf_styling_active() ) {
			unset( $args[1] );
			unset( $args[3] );
			unset( $args[4] );
		} else if ( ! is_singular( $this->post_type ) ) {
			$args = array();
		} 

		foreach ( $args as $arg ) {
			$wp_admin_bar->add_node( $arg );
		}
	}

	/**
	 * Render duplicate form options in Lightbox via Hooks
	 * 
	 * @since 1.0.0
	 * @access public
	 */
	public function render_duplicate_form() {
		$template_id = (int) $_POST['postid'];
		$data = TF_Model::get_field_exist_values( $this->fields(), $template_id );
		$get_post = get_post( $template_id );
		$data['tf_template_name'] = $get_post->post_title . ' Copy';
		$data['menu_order'] = $get_post->menu_order;

		echo TF_Form::open( array( 
			'id' => 'tf_template_duplicate_form'
		) );
		echo sprintf( '<input type="hidden" name="_template_id" value="%d">', $template_id );
		echo TF_Form::render( $this->fields(), $data );
		echo TF_Form::submit_button( __('Duplicate', 'madx-flow') );
		echo TF_Form::close();
	}

	/**
	 * Saving form data.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $post_data 
	 */
	public function saving_duplicate_form( $post_data ) {
		global $TF, $tf_duplicate;
		
		$post_data = wp_parse_args( $post_data, $this->defaults );
		$template = get_post($post_data['_template_id']);
		$template->post_title = $post_data['tf_template_name'];
		$template->post_name = $post_data['tf_template_name'];
		$template->menu_order = $post_data['menu_order'];

		$new_id = $tf_duplicate->duplicate( $template );
		
		if ( $new_id ) {
			foreach( $this->defaults as $key => $value ) {
				if ( in_array( $key, array( 'tf_template_name', 'menu_order' ) ) ) continue;
				update_post_meta( $new_id, $key, $post_data[ $key ] );
			}

			// Update associated theme
			update_post_meta( $new_id, 'associated_theme', $TF->active_theme->slug );
		}
	}

	/**
	 * Delete theme cached.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param int $post_id 
	 * @param object $post 
	 * @param type $update 
	 */
	public function delete_template_cached( $post_id ) {
		// If this is just a revision, don't send the email.
		if ( wp_is_post_revision( $post_id ) )
			return;

		// If this isn't a 'tf_theme' post, don't update it.
		if ( $this->post_type != get_post_type( $post_id ) ) 
			return;

		delete_transient( 'tf_cached_template_assignment_archive' );
		delete_transient( 'tf_cached_template_assignment_single' );
		delete_transient( 'tf_cached_template_assignment_page' );
	}

	/**
	 * Metabox Settings.
	 * 
	 * @since 1.0.0
	 * @access public
	 */
	public function options_metaboxes() {
		add_meta_box(
			'tf_template_options_metabox',
			__( 'Template Options', 'madx-flow' ),
			array( $this, 'render_template_option' ),
			$this->post_type
		);
		add_meta_box(
			'tf_template_regions_metabox',
			__( 'Template Regions', 'madx-flow' ),
			array( $this, 'render_template_regions' ),
			$this->post_type
		);
	}

	/**
	 * Render Template Options metabox.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param object $post 
	 */
	public function render_template_option( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'tf_template_option_custom_box', 'tf_template_option_custom_box_nonce' );
		$fields = $this->fields();
		unset( $fields['tf_template_name'] );
		$data = TF_Model::get_field_exist_values( $fields, $post->ID );
		$data['menu_order'] = $post->menu_order;

		echo '<div class="tf_interface">';
		echo TF_Form::render( $fields, $data );
		echo '</div>';
	}

	/**
	 * Render Template Regions metabox.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param object $post 
	 */
	public function render_template_regions( $post ) {
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'tf_template_option_custom_box', 'tf_template_option_custom_box_nonce' );
		$fields = array(
			'template_part_caption' => array(
				'type' => 'separator',
				'meta' => array(
					'html' => sprintf( __( '<h4>Select a <a href="%s">Template Part</a> for each region: Header, Sidebar, and Footer.</h4>', 'madx-flow'), admin_url('edit.php?post_type=tf_template_part') )
				)
			),
			'tf_template_region_header' => array(
				'type' => 'template_part_select',
				'label' => __('Header', 'madx-flow'),
				'show_extra_link' => false
			),
			'tf_template_region_sidebar' => array(
				'type' => 'template_part_select',
				'label' => __('Sidebar', 'madx-flow'),
				'show_extra_link' => false
			),
			'tf_template_region_footer' => array(
				'type' => 'template_part_select',
				'label' => __('Footer', 'madx-flow'),
				'show_extra_link' => false
			)
		);
		
		$data = TF_Model::get_field_exist_values( $fields, $post->ID );
		
		/* not used anymore
		if ( count( $data ) > 0 ) {
			foreach( $data as $key => $shortcode ) {
				preg_match('/.*slug="(.*)"/i', $shortcode, $slug );
				$data[ $key ] = isset( $slug[1] ) ? $slug[1] : '';
			}
		}*/

		echo '<div class="tf_interface">';
		echo TF_Form::render( $fields, $data );
		echo '</div>';
	}

	/**
	 * Save template option metabox.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param int $post_id
	 */
	public function save_option_metabox( $post_id ) {
		/*
		 * We need to verify this came from the our screen and with proper authorization,
		 * because save_post can be triggered at other times.
		 */

		// Check if our nonce is set.
		if ( ! isset( $_POST['tf_template_option_custom_box_nonce'] ) )
			return $post_id;

		$nonce = $_POST['tf_template_option_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'tf_template_option_custom_box' ) )
			return $post_id;

		// If this is an autosave, our form has not been submitted,
                //     so we don't want to do anything.
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) 
			return $post_id;

		if ( $this->post_type != $_POST['post_type'] ) 
			return $post_id;	

		/* OK, its safe for us to save the data now. */

		// Save Template Options
		foreach( $this->defaults as $key => $value ) {
			if ( in_array( $key, array( 'tf_template_name', 'menu_order' ) ) ) continue;
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, $_POST[ $key ] );
			} else {
				update_post_meta( $post_id, $key, $value );
			}
		}

		// Save Template Regions
		$meta_keys = array(
			'tf_template_region_header', 
			'tf_template_region_sidebar', 
			'tf_template_region_footer'
		);

		foreach( $meta_keys as $key ) {
			if ( isset( $_POST[ $key ] ) ) {
				update_post_meta( $post_id, $key, sanitize_text_field( $_POST[ $key ] ) );
			}
		}

	}
}

/** Initialize Class */
new TF_Template();