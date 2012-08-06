<?php
/**
 *
 */
class mysiteBlog {

	/**
	 *
	 */
	function blog_grid( $atts, $content = null, $code = null ) {
		if( $atts == 'generator' ) {
			$option = array(
				'name' => __( 'Blog Grid Layout', MYSITE_ADMIN_TEXTDOMAIN ),
				'value' => 'blog_grid',
				'options' => array(
					array(
						'name' => __( 'Number of Columns', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Select the number of columns you wish to have your posts displayed in.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'column',
						'options' => array(
							'1' => __('One Column', MYSITE_ADMIN_TEXTDOMAIN ),
							'2' => __('Two Column', MYSITE_ADMIN_TEXTDOMAIN ),
							'3' => __('Three Column', MYSITE_ADMIN_TEXTDOMAIN ),
							'4' => __('Four Column', MYSITE_ADMIN_TEXTDOMAIN ),
							'5' => __('Five Column', MYSITE_ADMIN_TEXTDOMAIN )
						),
						'type' => 'select',
					),
					array(
						'name' => __( 'Number of Posts', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Select the number of posts you wish to have displayed on each page.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'showposts',
						'options' => array_combine(range(1,40), array_values(range(1,40))),
						'type' => 'select'
					),
					array(
						'name' => __( 'Offset Posts <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'This will skip a number of posts at the beginning.<br /><br />Useful if you are using multiple blog shortcodes on the same page.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'offset',
						'options' => array_combine(range(1,10), array_values(range(1,10))),
						'type' => 'select'
					),
					array(
						'name' => __( 'Post Content <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'You can choose to have the post excerpt displayed or the full content of your post including shortcodes.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'post_content',
						'options' => array(
							'excerpt' => __('Excerpt', MYSITE_ADMIN_TEXTDOMAIN ),
							'full' => __('Full Post', MYSITE_ADMIN_TEXTDOMAIN )
						),
						'type' => 'select',
					),
					array(
						'name' => __('Blog Categories <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'If you want posts from specific categories to display then you may choose them here.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'category_in',
						'default' => array(),
						'target' => 'cat',
						'type' => 'multidropdown'
					),
					array(
						'name' => __('Show Post Pagination <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Checking this will show pagination at the bottom so the reader can go to the next page.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'pagination',
						'options' => array('true' => 'Show Post Pagination'),
						'type' => 'checkbox'
					),
					array(
						'name' => __('Disable Post Elements <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'You can hide certain elements from displaying here.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'disable',
						'options' => array(
							'image' => __('Disable Post Image', MYSITE_ADMIN_TEXTDOMAIN ),
							'title' => __('Disable Post Title', MYSITE_ADMIN_TEXTDOMAIN ),
							'content' => __('Disable Post Content', MYSITE_ADMIN_TEXTDOMAIN ),
							'meta' => __('Disable Post Meta', MYSITE_ADMIN_TEXTDOMAIN ),
							'more' => __('Disable Read More', MYSITE_ADMIN_TEXTDOMAIN )
							
						),
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true,
				)
			);
			
			return $option;
		}
		
		$defaults = array(
			'column' 		=> '',
			'showposts'		=> '',
			'offset' 		=> '',
			'post_content'	=> '',
			'categories' 	=> '',
			'pagination' 	=> '',
			'disable' 		=> '',
			'post_in'		=> '',
			'category_in'	=> '',
			'tag_in'		=> ''
		);
		
		$atts = shortcode_atts( $defaults, $atts );
		
		$args = array( 'type' => $code, 'atts' => $atts );
		
		return self::_blog_shortcode( $args );
	}
	
	/**
	 *
	 */
	function blog_list($atts, $content = null, $code = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __('Blog List Layout', MYSITE_ADMIN_TEXTDOMAIN ),
				'value' => 'blog_list',
				'options' => array(
					array(
						'name' => __('Select Thumbnail Size', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( "Select the size of thumbnails that you wish to have displayed.<br /><br />This is a thumbnail of the 'Featured Image' in each of your posts.", MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'thumb',
						'default' => '',
						'options' => array(
							'small' => __('Small', MYSITE_ADMIN_TEXTDOMAIN ),
							'medium' => __('Medium', MYSITE_ADMIN_TEXTDOMAIN ),
							'large' => __('Large', MYSITE_ADMIN_TEXTDOMAIN )
						),
						'type' => 'select',
					),
					array(
						'name' => __('Number of Posts', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Select the number of posts you wish to have displayed on each page.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'showposts',
						'default' => '',
						'options' => array_combine(range(1,40), array_values(range(1,40))),
						'type' => 'select'
					),
					array(
						'name' => __('Offset Posts <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'This will skip a number of posts at the beginning.<br /><br />Useful if you are using multiple blog shortcodes on the same page.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'offset',
						'default' => '',
						'options' => array_combine(range(1,10), array_values(range(1,10))),
						'type' => 'select'
					),
					array(
						'name' => __('Post Content <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'You can choose to have the post excerpt displayed or the full content of your post including shortcodes.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'post_content',
						'default' => '',
						'options' => array(
							'excerpt' => __('Excerpt', MYSITE_ADMIN_TEXTDOMAIN ),
							'full' => __('Full Post', MYSITE_ADMIN_TEXTDOMAIN )
						),
						'type' => 'select',
					),
					array(
						'name' => __('Blog Categories <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'If you want posts from specific categories to display then you may choose them here.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'category_in',
						'default' => array(),
						'target' => 'cat',
						'type' => 'multidropdown'
					),
					array(
						'name' => __('Show Post Pagination <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Checking this will show pagination at the bottom so the reader can go to the next page.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'pagination',
						'options' => array('true' => __('Show Post Pagination', MYSITE_ADMIN_TEXTDOMAIN )),
						'default' => '',
						'type' => 'checkbox'
					),
					array(
						'name' => __( 'Disable Post Elements <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'You can hide certain elements from displaying here.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'disable',
						'options' => array(
							'image' => __( 'Disable Post Image', MYSITE_ADMIN_TEXTDOMAIN ),
							'title' => __( 'Disable Post Title', MYSITE_ADMIN_TEXTDOMAIN ),
							'content' => __( 'Disable Post Content', MYSITE_ADMIN_TEXTDOMAIN ),
							'meta' => __( 'Disable Post Meta', MYSITE_ADMIN_TEXTDOMAIN ),
							'more' => __( 'Disable Read More', MYSITE_ADMIN_TEXTDOMAIN )
							
						),
						'default' => '',
						'type' => 'checkbox'
					),
				'shortcode_has_atts' => true,
				)
			);
			
			return $option;
		}
		
		$defaults = array(
			'thumb' 		=> '',
			'showposts'		=> '',
			'offset' 		=> '',
			'post_content'	=> '',
			'categories' 	=> '',
			'pagination' 	=> '',
			'disable' 		=> '',
			'post_in'		=> '',
			'category_in'	=> '',
			'tag_in'		=> ''
		);
		
		$atts = shortcode_atts( $defaults, $atts );
		
		$args = array( 'type' => $code, 'atts' => $atts );
		
		return self::_blog_shortcode( $args );
	}
	
	function _blog_shortcode( $args = array() ) {
		global $post, $wp_rewrite, $wp_query, $mysite;

		extract( $args['atts'] );

		$out = '';

		$showposts = trim( $showposts );
		$column = ( !empty( $column ) ) ? trim( $column ) : '3';
		$thumb = ( !empty( $thumb ) ) ? trim( $thumb ) : 'medium';
		$offset = ( isset( $offset ) ) ? trim( $offset ) : '';
		$post_in = ( !empty($post_in) ) ? explode(",", trim( $post_in )) : '';
		$category_in = ( !empty($category_in) ) ? explode(",", trim( $category_in )) : '';
		$tag_in = ( !empty($tag_in) ) ? explode(",", trim( $tag_in )) : '';

		if( is_front_page() ) {
			$_layout = mysite_get_setting( 'homepage_layout' );
			$images = ( $_layout == 'full_width' ? 'images' : ( $_layout == 'left_sidebar' ? 'small_sidebar_images' : 'big_sidebar_images' ) );
		} else {
			$post_obj = $wp_query->get_queried_object();
			$_layout = get_post_meta( $post_obj->ID, '_layout', true );
			$template = get_post_meta( $post_obj->ID, '_wp_page_template', true );
			$images = ( $_layout == 'full_width' ? 'images' : ( $_layout == 'left_sidebar' || $template == 'template-featuretour.php' ? 'small_sidebar_images' : 'big_sidebar_images' ) );
		}
		
		$post_img = '';

		$blog_query = new WP_Query();

		if( trim( $pagination ) == 'true' ) {
			$paged = mysite_get_page_query();
			$blog_query->query(array(
				'post__in' => $post_in,
				'category__in' => $category_in,
				'tag__in' => $tag_in,
				'post_type' => 'post',
				'posts_per_page' => $showposts,
				'paged' => $paged,
				'offset' => $offset,
				'ignore_sticky_posts' => 1
			));

		} else {

			$blog_query->query(array(
				'post__in' => $post_in,
				'category__in' => $category_in,
				'tag__in' => $tag_in,
				'post_type' => 'post',
				'showposts' => $showposts,
				'nopaging' => 0,
				'offset' => $offset,
				'ignore_sticky_posts' => 1
			));
		}

		if( $blog_query->have_posts() ) :

		$img_sizes = $mysite->layout[$images];
		$width = '';
		$height = '';

		if( $args['type'] == 'blog_grid' ) {
			switch( $column ) {
				case 1:
					$main_class = 'post_grid one_column_blog';
					$post_class = 'post_grid_module';
					$content_class = 'post_grid_content';
					$img_class = 'post_grid_image';
					$excerpt_lenth = 400;
					$width = $img_sizes['one_column_blog'][0];
					$height = $img_sizes['one_column_blog'][1];
					break;
				case 2:
					$main_class = 'post_grid two_column_blog';
					$post_class = 'post_grid_module';
					$content_class = 'post_grid_content';
					$img_class = 'post_grid_image';
					$column_class = 'one_half';
					$excerpt_lenth = 150;
					$width = $img_sizes['two_column_blog'][0];
					$height = $img_sizes['two_column_blog'][1];
					break;
				case 3:
					$main_class = 'post_grid three_column_blog';
					$post_class = 'post_grid_module';
					$content_class = 'post_grid_content';
					$img_class = 'post_grid_image';
					$column_class = 'one_third';
					$excerpt_lenth = 75;
					$width = $img_sizes['three_column_blog'][0];
					$height = $img_sizes['three_column_blog'][1];
					break;
				case 4:
					$main_class = 'post_grid four_column_blog';
					$post_class = 'post_grid_module';
					$content_class = 'post_grid_content';
					$img_class = 'post_grid_image';
					$column_class = 'one_fourth';
					$excerpt_lenth = 50;
					$width = $img_sizes['four_column_blog'][0];
					$height = $img_sizes['four_column_blog'][1];
					break;
			}

		} else {

			if( $args['type'] == 'blog_list' ) {
				switch( $thumb ) {
					case 'small':
						$main_class = 'post_list small_post_list';
						$post_class = 'post_list_module';
						$content_class = 'post_list_content';
						$img_class = 'post_list_image';
						$excerpt_lenth = 180;
						$width = $img_sizes['small_post_list'][0];
						$height = $img_sizes['small_post_list'][1];
						break;
					case 'medium':
						$main_class = 'post_list medium_post_list';
						$post_class = 'post_list_module';
						$content_class = 'post_list_content';
						$img_class = 'post_list_image';
						$excerpt_lenth = 180;
						$width = $img_sizes['medium_post_list'][0];
						$height = $img_sizes['medium_post_list'][1];
						break;
					case 'large':
						$main_class = 'post_list large_post_list';
						$post_class = 'post_list_module';
						$content_class = 'post_list_content';
						$img_class = 'post_list_image';
						$excerpt_lenth = 180;
						$width = $img_sizes['large_post_list'][0];
						$height = $img_sizes['large_post_list'][1];
						break;
				}
			}
		}
		
		$filter_args = array( 'width' => $width, 'height' => $height, 'img_class' => $img_class, 'link_class' => 'blog_sc_image_load', 'preload' => true, 'post_content' => $post_content, 'disable' => $disable, 'column' => $column, 'thumb' => $thumb, 'type' => $args['type'], 'shortcode' => true, 'echo' => false );

		$out .= ( $args['type'] == 'blog_grid' ) ? '<div class="' .  $main_class . '">' : '<ul class="' . $main_class . '">';

		$i=1;
		while( $blog_query->have_posts() ) : $blog_query->the_post();

		$out .= ( $args['type'] == 'blog_list' ? '' : ( $column != 1 ? '<div class="' . ( $i%$column == 0 ? $column_class . ' last' : $column_class ) . '">' : '' ) );

		$out .= ( $args['type'] == 'blog_grid' ) ? '<div class="' . join( ' ', get_post_class( $post_class, get_the_ID() ) ) . '">' : '<li class="' . join( ' ', get_post_class( $post_class, get_the_ID() ) ) . '">';
		
		$out .= mysite_before_post_sc( $filter_args );

		$out .= '<div class="' . $content_class . '">';
		
		$out .= mysite_before_entry_sc( $filter_args );
		
		$out .= '<div class="post_excerpt">';
		if( strpos( $disable, 'content' ) === false ) {
			ob_start();
			mysite_post_content( $filter_args );
			$out .= ob_get_clean();
		}
		$out .= '</div>';
		
		$out .= mysite_after_entry_sc( $filter_args );

		$out .= '</div><!-- .post_class -->';

		$out .= ( $args['type'] == 'blog_grid' ) ? '</div>' : '</li>';

		$out .= ( $args['type'] == 'blog_list' ? '' : ( $column != 1 ? '</div>' : '' ) );

		if( $args['type'] == 'blog_grid' ) {
			if( ( $i % $column ) == 0 )
				$out .= '<div class="clearboth"></div>';
		}

		$i++;

		endwhile;

		$out .= ( $args['type'] == 'blog_grid' ) ? '</div>' : '</ul>';

		if( $pagination == 'true' ) {
			$out .= mysite_pagenavi( '', '', $blog_query );
		}

		endif;

		wp_reset_query();

		return $out;
	}

	/**
	 *
	 */
	function _options( $class ) {
		$shortcode = array();
		
		$class_methods = get_class_methods( $class );
		
		foreach( $class_methods as $method ) {
			if( $method[0] != '_' ) {
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
			}
		}
		
		$options = array(
			'name' => __('Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Choose which type of blog you wish to use.<br /><br />The grid will display posts in a column layout while the list will display your posts from top to bottom.', MYSITE_ADMIN_TEXTDOMAIN ),
			'value' => 'blog',
			'options' => $shortcode,
			'shortcode_has_types' => true
		);
		
		return $options;
	}
	
}

?>