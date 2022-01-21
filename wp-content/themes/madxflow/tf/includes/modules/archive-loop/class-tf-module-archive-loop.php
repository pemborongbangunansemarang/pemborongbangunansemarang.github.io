<?php
/**
 * Module Text.
 * 
 * Show text blocks with rich editor.
 * @package madxFlow
 * @since 1.0.0
 */
class TF_Module_Archive_Loop extends TF_Module {
	/**
	 * Constructor.
	 */
	public function __construct() {
		parent::__construct(array(
			'name' => __('Archive Post', 'madx-flow'),
			'slug' => 'archive-loop',
			'shortcode' => 'tf_archive_loop',
			'description' => 'Archive Post module',
			'category' => 'archive'
		));
	}

	/**
	 * Module settings field
	 * 
	 * @since 1.0.0
	 * @access public
	 * @return array
	 */
	public function fields() {
		global $TF;

		$image_base = $TF->framework_uri() . '/assets/img/builder';
                $categories = get_terms( 'category', array( 'hide_empty' => true ) );
                $cats = array();
                if(!empty($categories)){
                    $cats[] = array('name'=>'---','value'=>'0');
                    foreach ($categories as $c){
                        $cats[] = array('name'=>$c->name,'value'=>$c->term_id);
                    }
                }
		return apply_filters( 'tf_module_archive_loop_fields', array(
			'layout'  => array(
				'type'       => 'layout',
				'label'      => __('Post Layout', 'madx-flow'),
				'options'    => array(
					array( 'img' => $image_base . '/list-post.png', 'value' => 'list_post', 'label' => __('List Post', 'madx-flow'), 'selected' => true ),
					array( 'img' => $image_base . '/grid3.png', 'value' => 'grid3', 'label' => __('Grid 3', 'madx-flow')),
					array( 'img' => $image_base . '/grid2.png', 'value' => 'grid2', 'label' => __('Grid 2', 'madx-flow')),
					array( 'img' => $image_base . '/grid4.png', 'value' => 'grid4', 'label' => __('Grid 4', 'madx-flow'))
				)
			),
			'order' => array(
				'type' => 'select',
				'label' => __('Order', 'madx-flow'),
				'options' => array(
					array( 'name' => __('Descending','madx-flow'), 'value' => 'desc' ),
					array( 'name' => __('Ascending','madx-flow'), 'value' => 'asc' )
				)
			),
			'orderby' => array(
				'type' => 'select',
				'label' => __('Order By', 'madx-flow'),
				'options' => array(
					array( 'name' => __('Date','madx-flow'), 'value' => 'date' ),
					array( 'name' => __('Id','madx-flow'), 'value' => 'id' ),
					array( 'name' => __('Author','madx-flow'), 'value' => 'author' ),
					array( 'name' => __('Title','madx-flow'), 'value' => 'title' ),
					array( 'name' => __('Name','madx-flow'), 'value' => 'name' ),
					array( 'name' => __('Modified','madx-flow'), 'value' => 'modified' ),
					array( 'name' => __('Rand','madx-flow'), 'value' => 'rand' ),
					array( 'name' => __('Comment Count','madx-flow'), 'value' => 'comment_count' ),
				)
			),
			'pagination' => array(
				'type' => 'radio',
				'label' => __('Pagination', 'madx-flow'),
				'options' => array(
					array( 'name' => __('Yes','madx-flow'), 'value' => 'yes', 'selected' => true ),
					array( 'name' => __('No','madx-flow'), 'value' => 'no' )
				)
			),
			'content' => array(
				'type' => 'builder',
				'wrapper' => 'no',
				'options' => array(
					'category' => 'loop'
				),
				'default' => '[tf_back_row][tf_back_column grid="fullwidth"][tf_post_title][tf_post_excerpt_content][/tf_back_column][/tf_back_row]'
			)
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
		return apply_filters( 'tf_module_archive_loop_styles', array(
			'tf_module_archive_loop_wrapper' => array(
				'label' => __('Posts Wrapper', 'madx-flow' ),
				'selector' => '.tf_loops_wrapper',
				'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
			),
			'tf_module_archive_loop_container' => array(
				'label' => __('Post Container', 'madx-flow' ),
				'selector' => '.tf_post',
				'basic_styling' => array( 'background', 'font', 'padding', 'margin', 'border' ),
			),
			'tf_module_archive_loop_post_link' => array(
				'label' => __( 'Post Link', 'madx-flow' ),
				'selector' => '.tf_post a',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_link_hover' => array(
				'label' => __( 'Post Link Hover', 'madx-flow' ),
				'selector' => '.tf_post a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_title' => array(
				'label' => __( 'Post Title', 'madx-flow' ),
				'selector' => '.tf_post_title',
				'basic_styling' => array(  'font' ),
			),
			'tf_module_archive_loop_post_title_link' => array(
				'label' => __( 'Post Title Link', 'madx-flow' ),
				'selector' => '.tf_post_title a',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_title_link_hover' => array(
				'label' => __( 'Post Title Link Hover', 'madx-flow' ),
				'selector' => '.tf_post_title a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_content' => array(
				'label' => __( 'Post Content', 'madx-flow' ),
				'selector' => '.tf_post_content',
				'basic_styling' => array( 'border', 'font', 'margin', 'padding', 'background' ),
			),
			'tf_module_archive_loop_post_meta' => array(
				'label' => __( 'Post Meta Container', 'madx-flow' ),
				'selector' => '.tf_post_meta',
				'basic_styling' => array( 'border', 'font', 'margin' ),
			),
			'tf_module_archive_loop_post_meta_link' => array(
				'label' => __( 'Post Meta Link', 'madx-flow' ),
				'selector' => '.tf_post_meta a',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_meta_link_hover' => array(
				'label' => __( 'Post Meta Link Hover', 'madx-flow' ),
				'selector' => '.tf_post_meta a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_date' => array(
				'label' => __( 'Post Meta - Date', 'madx-flow' ),
				'selector' => '.tf_post_date',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_category' => array(
				'label' => __( 'Post Meta - Category Link', 'madx-flow' ),
				'selector' => '.tf_post_category a',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_category_hover' => array(
				'label' => __( 'Post Meta - Category Link Hover', 'madx-flow' ),
				'selector' => '.tf_post_category a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_tag' => array(
				'label' => __( 'Post Meta - Tag Link', 'madx-flow' ),
				'selector' => '.tf_post_tag a',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_tag_hover' => array(
				'label' => __( 'Post Meta - Tag Link Hover', 'madx-flow' ),
				'selector' => '.tf_post_tag a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_author' => array(
				'label' => __( 'Post Meta - Author', 'madx-flow' ),
				'selector' => '.tf_post_author a',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_author_hover' => array(
				'label' => __( 'Post Meta - Author Hover', 'madx-flow' ),
				'selector' => '.tf_post_author a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_comment' => array(
				'label' => __( 'Post Meta - Comment Count', 'madx-flow' ),
				'selector' => '.tf_post_comment a',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_post_comment_hover' => array(
				'label' => __( 'Post Meta - Comment Count Hover', 'madx-flow' ),
				'selector' => '.tf_post_comment a:hover',
				'basic_styling' => array( 'font' ),
			),
			'tf_module_archive_loop_pagination_container' => array(
				'label' => __( 'Pagination Container', 'madx-flow' ),
				'selector' => '.tf_pagination',
				'basic_styling' => array( 'background', 'border', 'padding', 'margin' ),
			),
			'tf_module_archive_loop_pagination_link' => array(
				'label' => __( 'Pagination Link', 'madx-flow' ),
				'selector' => '.tf_pagination a, .tf_pagination span',
				'basic_styling' => array( 'border', 'font', 'margin' ),
			),
			'tf_module_archive_loop_pagination_link_hover' => array(
				'label' => __( 'Pagination Link Hover', 'madx-flow' ),
				'selector' => '.tf_pagination a:hover',
				'basic_styling' => array( 'border', 'font', 'margin' ),
			)
		) );
	}

	/**
	 * Render main shortcode.
	 * 
	 * @since 1.0.0
	 * @access public
	 * @param array $original_atts 
	 * @param string $content 
	 * @return string
	 */
	public function render_shortcode( $original_atts, $content = null ) {
		global $wp_query, $query_string, $TF;

		$atts = shortcode_atts( array(
			'layout' => 'post-list',
			'order' => 'DESC',
			'orderby' => 'date',
			'pagination' => 'yes',
		), $original_atts, $this->shortcode );

		$output = '';
		
                $build_query = array(
                        'posts_per_page' =>get_option('posts_per_page'),
                        'order' => $atts['order'],
                        'orderby' => $atts['orderby']
                );
		if ( TF_Model::is_template_page()) {
			query_posts( build_query( $build_query ) );
		} else {
			//query_posts( array_merge( $wp_query->query_vars, $build_query ) );
			
			// Fix Product archive page (site.com/shop) doesn't query product post_type, somehow using $query_string works.
			query_posts( $query_string . '&' . build_query( $build_query ) );
		}
		if ( have_posts() ) {
			ob_start();
			?>
			<!-- loopswrapper -->
                        <div class="tf_loops_wrapper clearfix <?php echo esc_attr( $atts['layout'] ); ?>">
				<?php 
				$TF->in_archive_loop = true;
				while ( have_posts() ) {
					the_post(); ?>

					<?php do_action( 'tf_archive_loop_before_post' ); ?>

					<article <?php echo tf_get_attr( 'post', $original_atts ); ?>>

						<?php do_action( 'tf_archive_loop_start_post' ); ?>

						<?php echo do_shortcode( $content ); ?>

						<?php do_action( 'tf_archive_loop_end_post' ); ?>
                                                <meta itemprop="datePublished" content="<?php the_modified_date('c')?>"/>
					</article>

					<?php do_action( 'tf_archive_loop_after_post' ); ?>

					<?php
				}
				$TF->in_archive_loop = false; ?>
			</div><!-- /tf_loops_wrapper -->
			<?php 
			// Pagination links
			if( 'yes' == $atts['pagination']) {
				get_template_part( 'includes/pagination', $wp_query->query_vars['post_type'] );
			}
			$output = ob_get_contents();
			ob_get_clean();
		}

		wp_reset_query();

		wp_reset_postdata();

		return $output;
	}
}

new TF_Module_Archive_Loop();