<?php

$portfolio_box = array(
	'title' => 'Portfolio Options',
	'id' => 'mysite_portfolio_meta_box',
	'pages' => array( 'portfolio' ),
	'callback' => '',
	'context' => 'normal',
	'priority' => 'high',
	'fields' => array(
		array(
			'name' => __( 'Portfolio Layout', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose between a left, right, or no sidebar layout for your portfolio.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_layout',
			'options' => array(
				'full_width' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/1.png',
				'left_sidebar' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/fourth_threefourth.png',
				'right_sidebar' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/threefourth_fourth.png',
			),
			'default' => 'full_width',
			'type' => 'layout'
		),
		array(
			'name' => __( 'Custom Sidebar', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "Select the custom sidebar that you'd like to be displayed on this page.<br /><br />Note:  You will need to first create a custom sidebar under the &quot;Sidebar&quot; tab in your theme's option panel before it will show up here.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_custom_sidebar',
			'target' => 'custom_sidebars',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Breadcrumbs', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "Here you can disable breadcrumbs on a page by page basis.  Alternatively you can globally disable breadcrumbs under the &quot;General Settings&quot; tab in your theme's option panel.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_disable_breadcrumbs',
			'options' => array( 'true' => __( 'Check to disable breadcrumbs on this post', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Bookmarks', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "By default a social bookmarks module will display when viewing your posts.<br /><br />You can choose to disable it here.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_disable_social_bookmarks',
			'options' => array( 'true' => __( 'Disable the Social Bookmarks Module', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Intro Options', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "This is the text that displays at the beginning of your pages and posts.<br /><br />Note:  You can set the default behaviour in the &quot;General Settings&quot; tab in your theme's option panel.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_intro_text',
			'options' => array( 
				'default' => sprintf( __( 'Default Intro <small><a targe href="%1$s/wp-admin/admin.php?page=mysite-options" target="_blank">(click here to edit your default intro settings)</a></small>', MYSITE_ADMIN_TEXTDOMAIN ), esc_url( get_option('siteurl') ) ),
				'title_only' => __( 'Title Only', MYSITE_ADMIN_TEXTDOMAIN ),
				'title_teaser' => __( 'Title & Teaser Text', MYSITE_ADMIN_TEXTDOMAIN ),
				'title_tweet' => __( 'Title & Latest Tweet', MYSITE_ADMIN_TEXTDOMAIN ),
				'custom' => __( 'Custom Raw Html', MYSITE_ADMIN_TEXTDOMAIN ),
				'disable' => __( 'Completely Disable Intro', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'toggle' => 'toggle_true',
			'type' => 'radio',
			'default' => 'default'
		),
		array(
			'name' => __( 'Teaser Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'The teaser text is the text that displays beside your title in your intro.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_intro_custom_text',
			'toggle_class' => '_intro_text_title_teaser',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom Raw Html', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'In case you have some custom HTML you wish to display in the intro then you may insert it here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_intro_custom_html',
			'toggle_class' => '_intro_text_custom',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Portfolio Date <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Enter the date that the project was completed.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_date',
			"default" => '',
			"type" => "text"
		),
		array(
			'name' => __( 'Portfolio Link <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Enter the url of the project for the "Visit Site" button.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_link',
			"default" => '',
			"class" => 'full',
			"type" => "text"
		),
		array(
			'name' => __( 'Portfolio Excerpt Text <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "The text you enter here will show up next to or below the gallery image depending on which column layout you've selected.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_teaser',
			'default' => '',
			'type' => 'textarea'
		),
		array(
			"name" => __( 'Fullsize Image for Lightbox <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			"desc" => __( 'The fullsize images you would like to use for the portfolio lightbox pop-up demonstration.  If not assigned, it will use your featured image instead.', MYSITE_ADMIN_TEXTDOMAIN ),
			"id" => "_image",
			"button" => "Insert Image",
			"default" => '',
			"type" => "Upload",
		),
		array(
			"name" => __( 'Portfolio Video Link <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			"desc" => __( 'Supports Flash, YouTube, Vimeo & iFrames.<br />Examples on how to format the links:<br /><br />Vimeo:<br />http://vimeo.com/8011831<br /><br />YouTube:<br />http://www.youtube.com/watch?v=NN9MmXAuWPg<br /><br />.swf:<br />http://www.adobe.com/products/flashplayer/include/marquee/design.swf?width=792&height=294<br /><br />.mov:<br />http://trailers.apple.com/movies/disney/oceans/oceans-clip1_r640s.mov?width=640&height=272<br /><br />iFrame:<br />http://www.google.com?iframe=true&width=100%&height=100%<br />', MYSITE_ADMIN_TEXTDOMAIN ),
			"id" => "_featured_video",
			"default" => '',
			"class" => 'full',
			"type" => "text",
		),
		array(
			'name' => __( 'Link to post? <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "Check this box if you'd like the portfolio gallery image to link to the portfolio post instead of the jQuery lightbox image pop-up effect.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_post',
			"options" => array( "true" => "Check to have the portfolio gallery image link to the portfolio post" ),
			'default' => '',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Read More Link <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "Check this box if you'd like to disable the portfolio &quot;Read More&quot; button which links to the blog post.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_more',
			"options" => array( "true" => "Check to disable read more link" ),
			'default' => '',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Portfolio Fullsize Image <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( "Check this box if you'd like to disable the fullsize image that appears at the top of the portfolio blog post.", MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => '_fullsize',
			"options" => array( "true" => "Check to disable fullsize image on portfolio blog post." ),
			'default' => '',
			'type' => 'checkbox'
		)
	)
);
return array(
	'load' => true,
	'options' => $portfolio_box
);

?>