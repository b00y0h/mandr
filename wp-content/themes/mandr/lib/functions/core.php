<?php
/**
 *
 */
function do_atomic( $tag = '', $args = array() ) {
	if ( !$tag )
		return false;

	# Get the theme prefix.
	$pre = MYSITE_PREFIX;

	# Do actions on the basic hook.
	do_action( "{$pre}_{$tag}", $args );

	# Loop through context array and fire actions on a contextual scale.
	foreach ( (array)mysite_get_context() as $context )
		do_action( "{$pre}_{$context}_{$tag}", $args );
}

/**
 * 
 */
function apply_atomic( $tag = '', $value = '' ) {
	if ( !$tag )
		return false;

	# Get theme prefix.
	$pre = MYSITE_PREFIX;

	# Apply filters on the basic hook.
	$value = apply_filters( "{$pre}_{$tag}", $value );

	# Loop through context array and apply filters on a contextual scale.
	foreach ( (array)mysite_get_context() as $context )
		$value = apply_filters( "{$pre}_{$context}_{$tag}", $value );

	# Return the final value once all filters have been applied.
	return $value;
}

/**
 *
 */
function apply_atomic_shortcode( $tag = '', $value = '' ) {
	return do_shortcode( apply_atomic( $tag, $value ) );
}

/**
 *
 */
function mysite_get_setting( $option = '' ) {
	$settings = '';

	if ( !$option )
		return false;

	$settings = get_option( MYSITE_SETTINGS );
	
	if( !empty( $settings[$option] ) )
		return $settings[$option];
		
	return false;
}

/**
 * 
 */
function mysite_shortcodes() {
	$shortcodes = array();
	if ( is_dir( THEME_SHORTCODES ) ) {
		if ( $dh = opendir( THEME_SHORTCODES ) ) {
			while ( false !== ( $file = readdir( $dh ) ) ) {
				if( $file != '.' && $file != '..' && stristr( $file, '.php' ) !== false )
					$shortcodes[] = $file;
			}
			
			closedir( $dh );
		}
	}
	
	asort( $shortcodes );
	
	return $shortcodes;
}

/**
 * Disable Automatic Formatting on Posts
 *
 * @param string $content
 * @return string
 */
function mysite_formatter($content) {

	$new_content = '';
	
	# Matches the contents and the open and closing tags
	$pattern_full = '{(\[raw\].*?\[/raw\])}is';
	
	# Matches just the contents
	$pattern_contents = '{\[raw\](.*?)\[/raw\]}is';
	
	# Divide content into pieces
	$pieces = preg_split($pattern_full, $content, -1, PREG_SPLIT_DELIM_CAPTURE);

	# Loop over pieces
	foreach ($pieces as $piece) {
	
		# Look for presence of the shortcode
		if (preg_match($pattern_contents, $piece, $matches)) {
		
			# Append to content (no formatting)
			$new_content .= $matches[1];
		
		} else {
		
			# Format and append to content
			$new_content .= wptexturize(wpautop($piece));
		
		}
	}

	return $new_content;
}

/**
 *
 */
function mysite_remove_wpautop( $content ) { 
	$content = do_shortcode( shortcode_unautop( $content ) ); 
	$content = preg_replace('#^<\/p>|^<br \/>|<p>$#', '', $content);
	return $content;
}

/**
 *
 */
function mysite_texturize_shortcode_before($content) {
	$content = preg_replace('/\]\[/im', "]\n[", $content);
	return $content;
}

/**
 *
 */
function mysite_twitter_feed_cahce( $age, $url ) {
	if( strstr( $url, 'twitter.com/statuses/user_timeline' ) )
		$age = 900;
	
	return $age;
}

/**
 *
 */
function mysite_twitter_feed_cahce_error() {
	return 86400;
}

/**
 *
 */
function mysite_stripslashes() {
	if ( function_exists('get_magic_quotes_gpc') && get_magic_quotes_gpc() ) {
		if( !empty( $_POST ) )
			$_POST = array_map( 'stripslashes_deep', $_POST );
		
		if( !empty( $_GET ) )
			$_GET = array_map( 'stripslashes_deep', $_GET );
		
		if( !empty( $_COOKIE ) )
			$_COOKIE = array_map( 'stripslashes_deep', $_COOKIE );
		
		if( !empty( $_REQUEST ) )
			$_REQUEST = array_map( 'stripslashes_deep', $_REQUEST );
	}
}

/**
 *
 */
function mysite_strlen( $str ) {
	return strlen( $str ) > 1;
}

/**
 *
 */
function mysite_mbstrlen( $str ) {
	return mb_strlen( $str,  get_option( 'blog_charset' ) ) > 1;
}

/**
 *
 */
function mysite_ajax_request() {
	if( ( !empty( $_SERVER['HTTP_X_REQUESTED_WITH'] ) ) && ( strtolower( $_SERVER['HTTP_X_REQUESTED_WITH'] ) == 'xmlhttprequest' ) )
		return true;
		
	return false;
}

/**
 * Check if file is write-able
 * 
 * @param string $path
 * @return boolean
 */
function mysite_is_writable( $file ) {
    $exists = file_exists( $file );
    
    $fp = @fopen( $file, 'a' );
    
    if ( $fp ) {
        fclose( $fp );
        
        if ( !$exists ) {
            @unlink( $file );
        }
        
        return true;
    }
    
    return false;
}

/**
 * Check if dir is write-able
 * 
 * @param string $dir
 * @return boolean
 */
function mysite_is_writable_dir( $dir ) {
    $file = $dir . '/' . uniqid( mt_rand() ) . '.tmp';
    
    return mysite_is_writable( $file );
}

/**
 *
 */
function mysite_is_cache_writable() {
	
	# check if cache folder exists, if not try to create it
	if ( !@is_dir( THEME_CACHE ) ) {
		if ( !wp_mkdir_p( THEME_CACHE ) )
			return false;
	}
	
	# check if cache folder is writable, if not try to chmod
	if( !mysite_is_writable_dir( THEME_CACHE ) ) {
		if( !@chmod( THEME_CACHE, 0777) )
			return false;
	}
	
	return true;
}

/**
 *
 */
function mysite_is_styles_writable() {
	
	if( is_multisite() ) {
		global $blog_id;
		$wpmu_styles_path = $_SERVER['DOCUMENT_ROOT'] . '/' . get_blog_option( $blog_id, 'upload_path' ) . '/styles';

		# check if styles folder exists, if not try to create it
		if ( !@is_dir( $wpmu_styles_path ) ) {
			if ( !wp_mkdir_p( $wpmu_styles_path ) )
				return false;
		}

		# check if styles folder is writable, if not try to chmod
		if( !mysite_is_writable_dir( $wpmu_styles_path ) ) {
			if( !@chmod( $wpmu_styles_path, 0777) )
				return false;
		}
		
		return true;
		
	} else {
		
		# check if styles folder exists, if not try to create it
		if ( !@is_dir( THEME_STYLES_DIR ) ) {
			if ( !wp_mkdir_p( THEME_STYLES_DIR ) )
				return false;
		}

		# check if styles folder is writable, if not try to chmod
		if( !mysite_is_writable_dir( THEME_STYLES_DIR ) ) {
			if( !@chmod( THEME_STYLES_DIR, 0777) )
				return false;
		}

		return true;
	}
}

/**
 *
 */
function mysite_is_wpmu_styles_writable() {
	
	if( !is_multisite() ) return false;
	
	global $blog_id;
	$wpmu_styles_path = $_SERVER['DOCUMENT_ROOT'] . get_blog_option( $blog_id, 'upload_path' ) . '/styles';
	
	# check if styles folder exists, if not try to create it
	if ( !@is_dir( $wpmu_styles_path ) ) {
		if ( !wp_mkdir_p( $wpmu_styles_path ) )
			return false;
	}
	
	# check if styles folder is writable, if not try to chmod
	if( !mysite_is_writable_dir( $wpmu_styles_path ) ) {
		if( !@chmod( $wpmu_styles_path, 0777) )
			return false;
	}
	
	return true;
}

/**
 *
 */
function mysite_is_sprite_writable() {
	
	# check if sprite folder exists, if not try to create it
	if ( !@is_dir( THEME_SPRITES_DIR ) ) {
		if ( !wp_mkdir_p( THEME_SPRITES_DIR ) )
			return false;
	}
	
	# check if styles folder is writable, if not try to chmod
	if( !mysite_is_writable_dir( THEME_SPRITES_DIR ) ) {
		if( !@chmod( THEME_SPRITE, 0777) )
			return false;
	}
	
	return true;
}
/**
 *
 */
function mysite_nospam( $email, $filterLevel = 'normal' ) {
	$email = strrev( $email );
	$email = preg_replace( '[@]', '//', $email );
	$email = preg_replace( '[\.]', '/', $email );

	if( $filterLevel == 'low' ) 	{
		$email = strrev( $email );
	}
	
	return $email;
}

/**
 *
 */
function mysite_auto_width( $args ) {
	global $wp_query, $mysite;
	
	extract( $args );
	
	if( is_front_page() ) {
		$homepage_layout = mysite_get_setting( 'homepage_layout' );
		
		$img_type = ( $homepage_layout == 'right_sidebar' ? 'big_sidebar_images' : ( $homepage_layout == 'full_width' ? 'images' : 'small_sidebar_images' ) );
		$img_size = ( $width == 'one_half' ? 'two_column_blog' : ( $width == 'one_third' ? 'three_column_blog'
		: ( $width == 'one_fourth' ? 'four_column_blog' : 'one_column_blog' ) ) );
		
		$new_width = $mysite->layout[$img_type][$img_size][0];
		
		if( $img_size == 'one_column_blog' && $get_width > $new_width )
			return $new_width;
			
		elseif( $img_size == 'one_column_blog' && $get_width < $new_width )
			return $width;
			
		else
			return $new_width;
	}
	
	
	$post_obj = $wp_query->get_queried_object();
	if( !empty( $post_obj ) ) {
		$_layout = get_post_meta( $post_obj->ID, '_layout', true );
		$template = get_post_meta( $post_obj->ID, '_wp_page_template', true );

		$img_type = ( $template == 'template-featuretour.php' ? 'small_sidebar_images' : ( $_layout == 'right_sidebar' ? 'big_sidebar_images'
		: ( $_layout == 'full_width' ? 'images' : 'small_sidebar_images' ) ) );
		
		$img_size = ( $width == 'one_half' ? 'two_column_blog' : ( $width == 'one_third' ? 'three_column_blog'
		: ( $width == 'one_fourth' ? 'four_column_blog' : 'one_column_blog' ) ) );
		
		$new_width = $mysite->layout[$img_type][$img_size][0];
		
		if( $img_size == 'one_column_blog' && $get_width > $new_width )
			return $new_width;
			
		elseif( $img_size == 'one_column_blog' && $get_width < $new_width )
			return $width;
			
		else
			return $new_width;
	}
	
	return $width;
}

/**
 *
 */
function mysite_encode( $content, $serialize = false ) {
	
	if( $serialize )
		$encode = rtrim(strtr(base64_encode(gzdeflate(htmlspecialchars(serialize( $content )), 9)), '+/', '-_'), '=');
	else
		$encode = rtrim(strtr(base64_encode(gzdeflate(htmlspecialchars( $content ), 9)), '+/', '-_'), '=');
		
	
	return $encode;
}

/**
 *
 */
function mysite_decode( $content, $unserialize = false ) {
	$decode = @gzinflate(base64_decode(strtr( $content, '-_', '+/')));
	
	if( !$unserialize )
		$decode = htmlspecialchars_decode( $decode );
	else
		$decode = unserialize(htmlspecialchars_decode( $decode ) );
	
	return $decode;
}

/**
 *
 */
function mysite_video( $args = array() ) {
	
	extract( $args );
	
	# Vimeo video
	if( preg_match_all( '#http://(www.vimeo|vimeo)\.com(/|/clip:)(\d+)(.*?)#i', $url, $matches ) ) {
		if( !empty( $parse ) )
			return do_shortcode( '[vimeo url="' . $url . '" title="0" fs="0" portrait="0" height="' . $height . '" width="' . $width . '"]' );
		else
			return 'vimeo';
		
	} elseif( preg_match( '#http://(www.youtube|youtube|[A-Za-z]{2}.youtube)\.com/(.*?)#i', $url, $matches ) ) {
		if( !empty( $parse ) )
			return do_shortcode( '[youtube url="' . $url . '" controls="' . ( empty( $video_controls ) ? 0 : 1 ) . '" showinfo="0" fs="1" height="' . $height . '" width="' . $width . '"]' );
		else
			return 'youtube';
			
	} else {
		return false;
	}
}

/**
 *
 */
function mysite_blog_page() {
	$blog_page = mysite_get_setting( 'blog_page' );
	return apply_filters( 'mysite_blog_page', $blog_page );
}

/**
 *
 */
function my_post_limit($limit) { 
	global $paged, $mysite;
	if (empty($paged)) {
			$paged = 1;
	}
	$postperpage = intval($mysite->posts_per_page);
	$pgstrt = ((intval($paged) -1) * $postperpage)+$mysite->offset . ', ';
	$limit = 'LIMIT '.$pgstrt.$postperpage;
	return $limit;
}

/**
 *
 */
function mysite_get_page_query() {
	global $mysite, $paged;
	
	$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : 1;
		
	return $paged;
}

/**
 *
 */
function mysite_excerpt( $text, $length, $ellipsis ) {
	$text = ( $text == '' ) ? get_the_content() : $text;
	$text = preg_replace( '`\[(.*)]*\]`','',$text );
	$text = strip_tags( $text  );
	$text = substr( $text, 0, $length );
	$text = substr( $text, 0, strripos($text, " " ) );
	$text = $text.$ellipsis;
	return $text;
}

/**
 *
 */
function mysite_exclude_category_string( $minus = true ) {
	$exclude_categories = mysite_get_setting( 'exclude_categories' );
	
	if( is_array( $exclude_categories ) ) {
		foreach ( $exclude_categories as $key => $value ) {
			if( $minus )
				$exclude_cats[$key] = -$value;
			else
				$exclude_cats[$key] = $value;
		}
		
		$exclude_cats = join( ',', $exclude_cats );
			
		return $exclude_cats;
	}
	
	return false;
}

/**
 *
 */
function mysite_exclude_category_feed() {
	$exclude_categories = mysite_exclude_category_string();
	
	if( !empty( $exclude_categories ) ) {
		if ( is_feed() )
			set_query_var( 'cat', $exclude_categories );
	}
}

/**
 *
 */
function mysite_exclude_category_widget( $cat_args ) {
	$exclude_categories = mysite_get_setting( 'exclude_categories' );

	if( is_array( $exclude_categories ) )
		$cat_args['exclude'] = join( ',', $exclude_categories );

 	return $cat_args;
}

/**
 *
 */
function mysite_portfolio_comment_url( $nav = false ) {
	global $wpdb, $post, $wp_rewrite;
	
	if( !is_singular( 'portfolio' ) ) return;
	
	$gallery_name = get_query_var( 'gallery' );
	$gallery_id = $wpdb->get_var( "SELECT ID FROM $wpdb->posts WHERE post_name = '" . $gallery_name . "'" );
	$get_post = get_post( $gallery_id );
	
	$paginate = ( $nav ) ? 'comment-page-%#%/' : '';

	if( $wp_rewrite->using_permalinks() )
		$redirect_to = home_url() . '/portfolio/' . $post->post_name. '/gallery/' . $get_post->post_name . '/' . $paginate;
		
	elseif( $nav )
		$redirect_to = add_query_arg( 'cpage', '%#%' );
	
	else
		$redirect_to = htmlspecialchars( add_query_arg( array( 'gallery' => $get_post->post_name ), get_permalink( $post->ID )) );
		
	if( $nav && $wp_rewrite->using_permalinks() )
		return array( 'base' => $redirect_to );
		
	elseif( $nav )
		return array();
		
	else
		return $redirect_to;
}

/*
 *
 */
function mysite_multi_tax_terms($where) {
    global $wp_query;
    global $wpdb;
    if (isset($wp_query->query_vars['term']) && (strpos($wp_query->query_vars['term'], ',') !== false && strpos($where, "AND 0") !== false) ) {
        # it's failing because taxonomies can't handle multiple terms
        # first, get the terms
        $term_arr = explode(",", $wp_query->query_vars['term']);
        foreach($term_arr as $term_item) {
            $terms[] = get_terms($wp_query->query_vars['taxonomy'], array('slug' => $term_item));
        }

        # next, get the id of posts with that term in that tax
        foreach ( $terms as $term ) {
            $term_ids[] = $term[0]->term_id;
        }
        $post_ids = get_objects_in_term($term_ids, $wp_query->query_vars['taxonomy']);

        if ( !is_wp_error($post_ids) && count($post_ids) ) {
            # build the new query
            $new_where = " AND $wpdb->posts.ID IN (" . implode(', ', $post_ids) . ") ";
            # re-add any other query vars via concatenation on the $new_where string below here

            # now, sub out the bad where with the good
            $where = str_replace("AND 0", $new_where, $where);
        } else {
            # give up
        }
    }

    return $where;
}

/**
 *
 */
function mysite_page_menu_args( $args ) {
	$args['show_home'] = true;
	$args['link_before'] = '<span>';
	$args['link_after'] = '</span>';
	return $args;
}

/**
 *
 */
function mysite_pagenavi($before = '', $after = '', $custom_query = array() ) {
	global $wpdb, $wp_query, $mysite;
	
	$out = '';
	if (!is_single()) {
		
		$pagenavi_options = array();
		$pagenavi_options['pages_text'] = __('Page %CURRENT_PAGE% of %TOTAL_PAGES%', MYSITE_TEXTDOMAIN );
		$pagenavi_options['current_text'] = '%PAGE_NUMBER%';
		$pagenavi_options['page_text'] = '%PAGE_NUMBER%';
		$pagenavi_options['first_text'] = __('&laquo; First', MYSITE_TEXTDOMAIN );
		$pagenavi_options['last_text'] = __('Last &raquo;', MYSITE_TEXTDOMAIN );
		$pagenavi_options['next_text'] = __('&raquo;', MYSITE_TEXTDOMAIN );
		$pagenavi_options['prev_text'] = __('&laquo;', MYSITE_TEXTDOMAIN );
		$pagenavi_options['dotright_text'] = __('...', MYSITE_TEXTDOMAIN );
		$pagenavi_options['dotleft_text'] = __('...', MYSITE_TEXTDOMAIN );
		$pagenavi_options['style'] = 1;
		$pagenavi_options['num_pages'] = 5;
		$pagenavi_options['always_show'] = 0;
		$pagenavi_options['num_larger_page_numbers'] = 3;
		$pagenavi_options['larger_page_numbers_multiple'] = 10;
		
		$request = $wp_query->request;
		$posts_per_page = intval(get_query_var('posts_per_page'));
		$paged = intval(mysite_get_page_query());
		
		if( !empty( $custom_query ) ) {
			$numposts = $custom_query->found_posts;

			if( !empty( $mysite->offset ) && $mysite->offset>0 && !empty( $mysite->posts_per_page ) && $mysite->posts_per_page>0  ) {
				$max_page = $custom_query->max_num_pages = ceil(($custom_query->found_posts - $mysite->offset) / $mysite->posts_per_page);
			} else {
				$max_page = $custom_query->max_num_pages;
			}
			
		} else {
			$numposts = $wp_query->found_posts;
			$max_page = $wp_query->max_num_pages;
		}
		
		if(empty($paged) || $paged == 0) {
			$paged = 1;
		}
		$pages_to_show = intval($pagenavi_options['num_pages']);
		$larger_page_to_show = intval($pagenavi_options['num_larger_page_numbers']);
		$larger_page_multiple = intval($pagenavi_options['larger_page_numbers_multiple']);
		$pages_to_show_minus_1 = $pages_to_show - 1;
		$half_page_start = floor($pages_to_show_minus_1/2);
		$half_page_end = ceil($pages_to_show_minus_1/2);
		$start_page = $paged - $half_page_start;
		if($start_page <= 0) {
			$start_page = 1;
		}
		$end_page = $paged + $half_page_end;
		if(($end_page - $start_page) != $pages_to_show_minus_1) {
			$end_page = $start_page + $pages_to_show_minus_1;
		}
		if($end_page > $max_page) {
			$start_page = $max_page - $pages_to_show_minus_1;
			$end_page = $max_page;
		}
		if($start_page <= 0) {
			$start_page = 1;
		}
		$larger_per_page = $larger_page_to_show*$larger_page_multiple;
		$larger_start_page_start = (mysite_n_round($start_page, 10) + $larger_page_multiple) - $larger_per_page;
		$larger_start_page_end = mysite_n_round($start_page, 10) + $larger_page_multiple;
		$larger_end_page_start = mysite_n_round($end_page, 10) + $larger_page_multiple;
		$larger_end_page_end = mysite_n_round($end_page, 10) + ($larger_per_page);
		if($larger_start_page_end - $larger_page_multiple == $start_page) {
			$larger_start_page_start = $larger_start_page_start - $larger_page_multiple;
			$larger_start_page_end = $larger_start_page_end - $larger_page_multiple;
		}
		if($larger_start_page_start <= 0) {
			$larger_start_page_start = $larger_page_multiple;
		}
		if($larger_start_page_end > $max_page) {
			$larger_start_page_end = $max_page;
		}
		if($larger_end_page_end > $max_page) {
			$larger_end_page_end = $max_page;
		}
		if($max_page > 1 || intval($pagenavi_options['always_show']) == 1) {
			$pages_text = str_replace("%CURRENT_PAGE%", number_format_i18n($paged), $pagenavi_options['pages_text']);
			$pages_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pages_text);
			$out = $before.'<div class="wp-pagenavi">'."\n";
			switch(intval($pagenavi_options['style'])) {
				case 1:
					if(!empty($pages_text)) {
						$out .= '<span class="pagenavi-pages">'.$pages_text.'</span>';
					}
					if ($start_page >= 2 && $pages_to_show < $max_page) {
						$first_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['first_text']);
						$out .= '<a href="'.esc_url(get_pagenum_link()).'" class="first" title="'.$first_page_text.'">'.$first_page_text.'</a>';
						if(!empty($pagenavi_options['dotleft_text'])) {
							$out .= '<span class="extend">'.$pagenavi_options['dotleft_text'].'</span>';
						}
					}
					if($larger_page_to_show > 0 && $larger_start_page_start > 0 && $larger_start_page_end <= $max_page) {
						for($i = $larger_start_page_start; $i < $larger_start_page_end; $i+=$larger_page_multiple) {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
							$out .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="pagenavi-page" title="'.$page_text.'">'.$page_text.'</a>';
						}
					}
					$out .= get_previous_posts_link($pagenavi_options['prev_text']);
					for($i = $start_page; $i  <= $end_page; $i++) {						
						if($i == $paged) {
							$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
							$out .= '<span class="current">'.$current_page_text.'</span>';
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
							$out .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="pagenavi-page" title="'.$page_text.'">'.$page_text.'</a>';
						}
					}
					$out .= get_next_posts_link($pagenavi_options['next_text'], $max_page);
					if($larger_page_to_show > 0 && $larger_end_page_start < $max_page) {
						for($i = $larger_end_page_start; $i <= $larger_end_page_end; $i+=$larger_page_multiple) {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
							$out .= '<a href="'.esc_url(get_pagenum_link($i)).'" class="pagenavi-page" title="'.$page_text.'">'.$page_text.'</a>';
						}
					}
					if ($end_page < $max_page) {
						if(!empty($pagenavi_options['dotright_text'])) {
							$out .= '<span class="extend">'.$pagenavi_options['dotright_text'].'</span>';
						}
						$last_page_text = str_replace("%TOTAL_PAGES%", number_format_i18n($max_page), $pagenavi_options['last_text']);
						$out .= '<a href="'.esc_url(get_pagenum_link($max_page)).'" class="last" title="'.$last_page_text.'">'.$last_page_text.'</a>';
					}
					break;
				case 2;
					$out .= '<form action="'.htmlspecialchars($_SERVER['PHP_SELF']).'" method="get">'."\n";
					$out .= '<select size="1" onchange="document.location.href = this.options[this.selectedIndex].value;">'."\n";
					for($i = 1; $i  <= $max_page; $i++) {
						$page_num = $i;
						if($page_num == 1) {
							$page_num = 0;
						}
						if($i == $paged) {
							$current_page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['current_text']);
							$out .= '<option value="'.esc_url(get_pagenum_link($page_num)).'" selected="selected" class="current">'.$current_page_text."</option>\n";
						} else {
							$page_text = str_replace("%PAGE_NUMBER%", number_format_i18n($i), $pagenavi_options['page_text']);
							$out .= '<option value="'.esc_url(get_pagenum_link($page_num)).'">'.$page_text."</option>\n";
						}
					}
					$out .= "</select>\n";
					$out .= "</form>\n";
					break;
			}
			$out .= '</div>'.$after."\n";
		}
	}
	return $out;
}

/**
 *
 */
function mysite_n_round($num, $tonearest) {
   return floor($num/$tonearest)*$tonearest;
}

?>