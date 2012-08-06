<?php
/**
 *
 */
function mysite_get_context() {
	global $wp_query, $post, $mysite;
	$blog_page = mysite_blog_page();
	
	# If $mysite->context has been set, don't run through the conditionals again. Just return the variable.
	if ( !empty( $mysite->context ) )
		if ( is_array( $mysite->context ) )
			return $mysite->context;

	$mysite->context = array();

	# Front page of the site.
	if ( is_front_page() )
		$mysite->context[] = 'home';

	# Blog page.
	if ( is_home() )
		$mysite->context[] = 'blog';
		
	# Mysite blog.
	if( !empty( $post->ID ) && $blog_page == $post->ID )
		$mysite->context[] = 'blog';

	# Singular views.
	elseif ( is_singular() ) {
		$mysite->context[] = 'singular';
		$mysite->context[] = "singular-{$wp_query->post->post_type}";
		$mysite->context[] = "singular-{$wp_query->post->post_type}-{$wp_query->post->ID}";
	}

	# Archive views.
	elseif ( is_archive() ) {
		$mysite->context[] = 'archive';

		# Taxonomy archives.
		if ( is_tax() || is_category() || is_tag() ) {
			$term = $wp_query->get_queried_object();
			$mysite->context[] = 'taxonomy';
			$mysite->context[] = $term->taxonomy;
			$mysite->context[] = "{$term->taxonomy}-" . sanitize_html_class( $term->slug, $term->term_id );
		}

		# User/author archives.
		elseif ( is_author() ) {
			$mysite->context[] = 'user';
			$mysite->context[] = 'user-' . sanitize_html_class( get_the_author_meta( 'user_nicename', get_query_var( 'author' ) ), $wp_query->get_queried_object_id() );
		}

		# Time/Date archives.
		else {
			if ( is_date() ) {
				$mysite->context[] = 'date';
				if ( is_year() )
					$mysite->context[] = 'year';
				if ( is_month() )
					$mysite->context[] = 'month';
				if ( get_query_var( 'w' ) )
					$mysite->context[] = 'week';
				if ( is_day() )
					$mysite->context[] = 'day';
			}
			if ( is_time() ) {
				$mysite->context[] = 'time';
				if ( get_query_var( 'hour' ) )
					$mysite->context[] = 'hour';
				if ( get_query_var( 'minute' ) )
					$mysite->context[] = 'minute';
			}
		}
	}

	# Search results.
	elseif ( is_search() )
		$mysite->context[] = 'search';

	# Error 404 pages.
	elseif ( is_404() )
		$mysite->context[] = 'error-404';

	return $mysite->context;
}


if ( !function_exists( 'mysite_body_class' ) ) :
/**
 *
 */
function mysite_body_class( $class = array() ) {
	global $wp_query, $post;

	$classes = array();

	# Has breadcrumbs
	if( ( !mysite_get_setting( 'disable_breadcrumbs' ) ) && ( !is_front_page() ) && ( !empty( $post->ID ) && !get_post_meta( $post->ID, '_disable_breadcrumbs', true ) ) )
		$classes[] = 'has_breadcrumbs';

	# Search & Archive sidebar	
	if( is_search() || is_archive() )
		$classes[] = 'right_sidebar';

	# Slider
	if( is_front_page() || mysite_get_setting( 'slider_page' ) ) {
		if( !mysite_get_setting( 'home_slider_disable' ) ) {
			$classes[] = 'has_slider';
			$classes[] = 'slider_nav_' . mysite_get_setting( 'slider_nav' );

			if( mysite_get_setting( 'homepage_slider' ) )
				$classes[] = mysite_get_setting( 'homepage_slider' );
		}
	}

	# Header extras
	$sociable = mysite_get_setting( 'sociable' );
	$header_text = mysite_get_setting( 'extra_header' );

	if( $sociable['keys'] != '#' )
		$classes[] = 'has_header_social';

	if( !empty( $header_text ) )
		$classes[] = 'has_header_text';

	if( has_nav_menu( 'header-links' ) )
		$classes[] = 'has_header_links';

	# Homepage
	if( is_front_page() ) {
		$classes[] = 'is_home';

		$classes[] = ( mysite_get_setting( 'homepage_layout' ) )
		? mysite_get_setting( 'homepage_layout' ): 'full_width';

		if( mysite_get_setting( 'homepage_teaser_text' ) )
			$classes[] = 'has_intro';

		if( mysite_get_setting( 'homepage_footer_teaser' ) )
			$classes[] = 'has_outro';
	}

	# Is singluar post
	if( is_singular() ) {
		$type = get_post_type();
		$dependencies = get_post_meta( $post->ID, '_' . THEME_SLUG .'_dependencies', true );
		$template = get_post_meta( $post->ID, '_wp_page_template', true );
		$_layout = get_post_meta( $post->ID, '_layout', true );
		
		if( $type == 'portfolio' )
			$classes[] = 'portfolio_single';
			
		if( ( strpos( $dependencies, 'fancy_portfolio' ) !== false || apply_atomic( 'fancy_portfolio', false ) == true ) && ( $template != 'template-featuretour.php' ) )
			$classes[] = 'fancy_portfolio';
		
		if( $template == 'template-sitemap.php' )
			$classes[] = 'sitemap';

		if( $template == 'template-featuretour.php' || strpos( $dependencies, 'fancy_portfolio' ) !== false || apply_atomic( 'fancy_portfolio', false ) == true )
			$classes[] = 'full_width';

		elseif( !empty( $_layout ) )
			$classes[] = $_layout;

		elseif( strpos( $post->post_content, '[portfolio' ) !== false )
			$classes[] = 'full_width';

		elseif( $type == 'portfolio' )
			$classes[] = 'full_width';
		else
			$classes[] = 'right_sidebar';
	}

	# Intro
	if( is_singular() || is_archive() || is_search() ) {
		$_intro_text = get_post_meta( $post->ID, '_intro_text', true );
		$intro_options = mysite_get_setting( 'intro_options' );

		if ( empty( $_intro_text ) || is_archive() || is_search() )
			$_intro_text = 'default';

		if( ( $_intro_text == 'default' ) && ( $intro_options != 'disable' ) && ( $intro_options != 'custom' ) )
			$classes[] = 'has_intro';

		if( ( $_intro_text == 'default' ) && ( $intro_options == 'custom' ) && ( mysite_get_setting( '_intro_custom_html' ) ) )
			$classes[] = 'has_intro';

		if( ( $_intro_text != 'disable' ) && ( $_intro_text != 'default' ) && ( $_intro_text != 'custom' ) )
			$classes[] = 'has_intro';

		if( ( $_intro_text != 'disable' ) && ( $_intro_text == 'custom' ) && ( get_post_meta( $post->ID, '_intro_custom_html', true ) ) )
			$classes[] = 'has_intro';
	}
	
	# 404
	if( is_404() )
		$classes[] = 'full_width';
		
	# Outro
	if( ( mysite_get_setting( 'footer_teaser' ) ) && ( !is_front_page() ) )
		$classes[] = 'has_outro';

	# Footer
	foreach ( array( 'footer1', 'footer2', 'footer3', 'footer4', 'footer5', 'footer6' ) as $footer )
		$footer_sidebar[] = ( is_active_sidebar( $footer ) ) ? 'active' : 'inactive';

	if ( !in_array( 'active', $footer_sidebar ) || mysite_get_setting( 'footer_disable' ) )
		$classes[] = 'no_footer';
	
	# Merge any custom classes
	if( is_array( $class ) )
		$classes = array_merge( $classes, $class );

	# Merge any filtered body classes
	$filter_classes = apply_atomic( 'filter_body_class', '' );

	if( is_array( $filter_classes ) )
		$classes = array_merge( $classes, $filter_classes );

	# Join all the classes into one string
	$class = join( ' ', $classes );

	# Print the body class
	echo apply_atomic( 'body_class', $class );
}
endif;

?>