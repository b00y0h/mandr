<?php

$option_tabs = array(
	'mysite_generalsettings_tab' => __( 'General Settings', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_homepage_tab' => __( 'Homepage', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_skins_tab' => __( 'Skins', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_imageresizing_tab' => __( 'Image Resizing', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_slideshow_tab' => __( 'Slideshow', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_blog_tab' => __( 'Blog', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_sidebar_tab' => __( 'Sidebar', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_footer_tab' => __( 'Footer', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_sociable_tab' => __( 'Sociable', MYSITE_ADMIN_TEXTDOMAIN ),
	'mysite_advanced_tab' => __( 'Advanced', MYSITE_ADMIN_TEXTDOMAIN )
);

$options = array(
	
	/**
	 * Navigation
	 */
	array(
		'name' => $option_tabs,
		'type' => 'navigation'
	),
	
	/**
	 * General Settings
	 */
	array(
		'name' => array( 'mysite_generalsettings_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Logo Settings', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose whether you wish to display a custom logo or your site title.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'display_logo',
			'options' => array(
				'true' => __( 'Custom Image Logo', MYSITE_ADMIN_TEXTDOMAIN ),
				'' => sprintf( __( 'Display Site Title <small><a href="%1$s/wp-admin/options-general.php" target="_blank">(click here to edit site title)</a></small>', MYSITE_ADMIN_TEXTDOMAIN ), esc_url( get_option('siteurl') ) )
			),
			'type' => 'radio'
		),
		array(
			'name' => __( 'Custom Image Logo', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your logo.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Custom Favicon', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to use as your favicon.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'favicon_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Intro Default Options', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Choose the default behaviour for your intro that displays at the beginning of your pages and posts.<br /><br />Note:  This is just the default behaviour, you can still choose to override this setting when editing your posts and pages.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'intro_options',
			'options' => array( 
				'title_only' => __( 'Title Only', MYSITE_ADMIN_TEXTDOMAIN ),
				'title_teaser' => __( 'Title &amp; Teaser Text', MYSITE_ADMIN_TEXTDOMAIN ),
				'title_tweet' => __( 'Title &amp; Latest Tweet', MYSITE_ADMIN_TEXTDOMAIN ),
				'custom' => __( 'Custom Raw Html', MYSITE_ADMIN_TEXTDOMAIN ),
				'disable' => __( 'Completely Disable Intro', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'toggle' => 'toggle_true',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Teaser Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'The teaser text is the text that displays beside your title in your intro.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'custom_teaser',
			'toggle_class' => 'intro_options_title_teaser',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom Raw Html', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'In case you have some custom HTML you wish to display in the intro then you may insert it here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'custom_teaser_html',
			'toggle_class' => 'intro_options_custom',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Twitter Default Username', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This will be used for all twitter related features.  You may still use a different twitter username to override the default.<br /><br />Example:  When using the twitter widget you may choose a username to use instead of the default.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'twitter_id',
			'type' => 'text'
		),
		array(
			'name' => __( 'Extra Header Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This will display in your header.<br /><br />It is usually used for a phone number or something similar.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'extra_header',
			'htmlspecialchars' => true,
			'type' => 'text'
		),		
		array(
			'name' => __( 'Disable Cufon', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Cufon font replacement is a javascript tool which is used in various areas of the theme including headings, menus, buttons, etc etc.<br /><br />Check if you wish to disable this.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'disable_cufon',
			'options' => array( 'true' => __( 'Globally Disable Cufon Font Replacement', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Breadcrumbs', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Check if you do not want breadcrumbs to display anywhere in your site.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'disable_breadcrumbs',
			'options' => array( 'true' => __( 'Globally Disable Breadcrumbs', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Breadcrumb Delimiter', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This is the symbol that will appear in between your breadcrumbs.<br /><br />Some common examples would be:<br /><br /><code>/ > - , :: >></code>', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'breadcrumb_delimiter',
			'htmlentities' => true,
			'type' => 'text'
		),
		array(
			'name' => __( 'Google Analytics Code', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' =>  __( 'After signing up with Google Analytics paste the code that it gives you here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'analytics_code',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom CSS', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This is a great place for doing quick custom styles.  For example if you wanted to change the site title color then you would paste this:<br /><br /><code>.logo a { color: blue; }</code><br /><br />If you are having problems styling something then ask on the support forum and we will be with you shortly.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'custom_css',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Custom JavaScript', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'In case you need to add some custom javascript you may insert it here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'custom_js',
			'type' => 'textarea'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Homepage
	 */
	array(
		'name' => array( 'mysite_homepage_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Homepage Layout', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose between a left, right, or no sidebar layout for your homepage.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'homepage_layout',
			'options' => array(
				'full_width' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/1.png',
				'left_sidebar' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/fourth_threefourth.png',
				'right_sidebar' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/threefourth_fourth.png',
			),
			'type' => 'layout'
		),
		array(
			'name' => __( 'Call to Action Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This is the intro text that displays just below your slider on the left hand side.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'homepage_teaser_text',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Call to Action Button Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You may change the text for your call to action button.<br /><br />This is the button that displays just below the slider on the right hand side.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'teaser_button_text',
			'type' => 'text'
		),
		array(
			'name' => __( 'Call to Action Button Settings', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can link the button to a page, set a custom link, or disable it.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'teaser_button',
			'options' => array( 
				'page' =>  __( 'Link to a Page', MYSITE_ADMIN_TEXTDOMAIN ),
				'custom' => __( 'Define a Custom link', MYSITE_ADMIN_TEXTDOMAIN ),
				'disable' => __( 'Disable Button', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'toggle' => 'toggle_true',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Link to Page', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Choose a page to set as your link.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'teaser_button_page',
			'target' => 'page',
			'toggle_class' => 'teaser_button_page',
			'type' => 'select',
		),
		array(
			'name' => __( 'Custom link', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Place a URL to set as your link.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'teaser_button_custom',
			'toggle_class' => 'teaser_button_custom',
			'type' => 'text'
		),
		array(
			'name' => __( 'Custom Homepage Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can add some custom content to your homepage.<br /><br />This will display under the slider and call to action button.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'content',
			'type' => 'editor'
		),
		array(
			'name' => __( 'Additional Homepage Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose additional page content to display on your homepage.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => "mainpage_content",
			'target' => 'page',
			'type' => 'select'
		),
		array(
			'name' => __( 'Disable Slider', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Check to disable your slider on the homepage.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'home_slider_disable',
			'options' => array( 'true' => __( 'Disable Homepage Slider', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Display Blog Posts', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Check to display your blog posts in the homepage content.<br /><br />You can control how many posts you wish to display in Dashboard -> Settings -> Reading.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'frontpage_blog',
			'options' => array( 'display_teaser_title' => __( 'Display Blog Posts on Homepage', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Homepage Outro Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This is the text that will display right above your footer.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'homepage_footer_teaser',
			'type' => 'textarea'
		),

	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Skins
	 */
	array(
		'name' => array( 'mysite_skins_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
		
		array(
			'name' => __( 'Skin Generator Options', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'From here you can organize, create, and upload new skins to use.<br /><br />Download Skins:<br />http://mysitemyway.com/skins', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'skin_generator',
			'options' => array( 
				'choose' => __( 'Choose a Skin', MYSITE_ADMIN_TEXTDOMAIN ),
				'create' => __( 'Create a New Skin', MYSITE_ADMIN_TEXTDOMAIN ),
				'manage' => __( 'Manage Skins', MYSITE_ADMIN_TEXTDOMAIN )
				),
			'default' => 'choose',
			'toggle' => 'toggle_true',
			'type' => 'skin_generator'
		),
		array(
			'name' => __( 'Available Skins', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Select a skin to use with your theme.<br /><br />To upload new skins that you have downloaded click on the Manage Skins radio button.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'style_variations',
			'default' => '',
			'target' => 'style_variations',
			'toggle_class' => 'skin_generator_choose',
			'type' => 'skin_select'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Image Resizing
	 */
	
	array(
		'name' => array( 'mysite_imageresizing_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Disable Image Resizing', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Check to disable all image resizing.<br /><br />Images will be displayed in the dimensions as they were uploaded.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'image_resize',
			'options' => array( 'true' => __( 'Disable Image Resizing', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Type of Image Resizing', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Choose whether you wish to use the TimThumb resize script or Wordpress image resizing.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'image_resize_type',
			'options' => array( 
				'wordpress' => __( 'Built in WordPress', MYSITE_ADMIN_TEXTDOMAIN ),
				'timthumb' => __( 'Timthumb', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		array(
			'name' => __( 'Auto Featured Image', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'By default features such as the portfolio and blog will use the "featured image" in your posts.<br /><br />Check this if you wish to use the first image uploaded to your post instead of the featured image.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'auto_img',
			'options' => array( 'true' => __( 'Enable Auto Featured Image Selection', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => "checkbox"
		),
		array(
			'name' => __( 'Images Sizes for Full Width Layouts', MYSITE_ADMIN_TEXTDOMAIN ),
			'type' => 'toggle_start'
		),
		
		array(
			'name' => __( 'One Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the one column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'one_column_portfolio_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Two Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the two column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'two_column_portfolio_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Three Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the three column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'three_column_portfolio_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Four Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the four column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'four_column_portfolio_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Portfolio Single Post', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the portfolio single images to use.<br /><br />These are the images displayed on the portfolio single post.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'portfolio_single_full_full',
			'type' => 'resize'
		),
	
		array(
			'name' => __( 'One Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the one column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'one_column_blog_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Two Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the two column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'two_column_blog_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Three Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the three column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'three_column_blog_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Four Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the four column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'four_column_blog_full',
			'type' => 'resize'
		),
	
		array(
			'name' => __( 'Small Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "small" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'small_post_list_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Medium Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "medium" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'medium_post_list_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Large Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "large" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a full width layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'large_post_list_full',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Additional Posts Module', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the additional posts thumbnails to use.<br /><br />These are the images displayed in the additional posts module.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'additional_posts_grid_full',
			'type' => 'resize'
		),
				
		array(
			'type' => 'toggle_end'
		),
		
		array(
			'name' => __( 'Images Sizes for Right Sidebar Layouts', MYSITE_ADMIN_TEXTDOMAIN ),
			'type' => 'toggle_start'
		),
		
		array(
			'name' => __( 'One Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the one column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'one_column_portfolio_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Two Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the two column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'two_column_portfolio_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Three Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the three column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'three_column_portfolio_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Four Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the four column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'four_column_portfolio_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Portfolio Single Post', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the portfolio single images to use.<br /><br />These are the images displayed on the portfolio single post.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'portfolio_single_full_big',
			'type' => 'resize'
		),

		array(
			'name' => __( 'One Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the one column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'one_column_blog_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Two Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the two column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'two_column_blog_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Three Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the three column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'three_column_blog_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Four Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the four column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'four_column_blog_big',
			'type' => 'resize'
		),

		array(
			'name' => __( 'Small Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "small" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'small_post_list_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Medium Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "medium" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'medium_post_list_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Large Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "large" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a right sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'large_post_list_big',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Additional Posts Module', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the additional posts thumbnails to use.<br /><br />These are the images displayed in the additional posts module.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'additional_posts_grid_big',
			'type' => 'resize'
		),

		array(
			'type' => 'toggle_end'
		),
		
		array(
			'name' => __( 'Images Sizes for Left Sidebar Layouts', MYSITE_ADMIN_TEXTDOMAIN ),
			'type' => 'toggle_start'
		),

		array(
			'name' => __( 'One Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the one column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'one_column_portfolio_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Two Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the two column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'two_column_portfolio_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Three Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the three column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'three_column_portfolio_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Four Column Portfolio', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the four column portfolio images to use.<br /><br />These are the images displayed with the portfolio grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'four_column_portfolio_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Portfolio Single Post', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the portfolio single images to use.<br /><br />These are the images displayed on the portfolio single post.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'portfolio_single_full_small',
			'type' => 'resize'
		),

		array(
			'name' => __( 'One Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the one column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'one_column_blog_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Two Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the two column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'two_column_blog_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Three Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the three column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'three_column_blog_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Four Column Blog', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the four column blog images to use.<br /><br />These are the images displayed with the blog grid shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'four_column_blog_small',
			'type' => 'resize'
		),

		array(
			'name' => __( 'Small Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "small" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'small_post_list_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Medium Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "medium" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'medium_post_list_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Large Post List', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the "large" list thumbnails to use.<br /><br />These are the images displayed with the blog and portfolio list shortcode in a left sidebar layout.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'large_post_list_small',
			'type' => 'resize'
		),
		array(
			'name' => __( 'Additional Posts Module', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the dimensions that you would like the additional posts thumbnails to use.<br /><br />These are the images displayed in the additional posts module.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'additional_posts_grid_small',
			'type' => 'resize'
		),

		array(
			'type' => 'toggle_end'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Slideshow
	 */
	array(
		'name' => array( 'mysite_slideshow_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Choose Slider Type', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'To get started choose which slider you would like to use.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'homepage_slider',
			'options' => array( 
				'fading_slider' => __( 'Fading Slider', MYSITE_ADMIN_TEXTDOMAIN ),
				'scrolling_slider' => __( 'Scrolling Slider', MYSITE_ADMIN_TEXTDOMAIN ),
				'nivo_slider' => __( 'Nivo Slider', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'toggle' => 'toggle_true',
			'type' => 'select',
		),

		array(
			'name' => __( 'Advanced Slider Settings', MYSITE_ADMIN_TEXTDOMAIN ),
			'toggle_class' => 'slider_option_toggle',
			'type' => 'toggle_start'
		),

		array(
			'name' => __( 'Transition Effects', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'With the Nivo slider there are a few transition effects that you can use.<br /><br />To use them all click on random.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'nivo_effect',
			'target' => 'nivo_effects',
			'toggle_class' => 'homepage_slider_nivo_slider',
			'type' => 'select',
		),
		array(
			'name' => __( 'Segments', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input a number for how many segments (slices) you want the transitions to use.<br /><br />It would be best to stick between 5 - 15 for best results.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'nivo_slices',
			'toggle_class' => 'homepage_slider_nivo_slider',
			'type' => 'text'
		),
		array(
			'name' => __( 'Animation Speed', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input a number to use for the animation speed.  This is the speed at which the transitions play.<br /><br />This number is in milliseconds so common values would be 1000 - 5000.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'nivo_anim_speed',
			'toggle_class' => 'homepage_slider_nivo_slider',
			'type' => 'text'
		),
		array(
			'name' => __( 'Slider Transition Speed', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input a number to use for the transition speed.  This is the speed which determines how long an image is displayed before transitioning to the next.<br /><br />This number is in milliseconds so common values would be 1000 - 5000.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_speed',
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Slider Transitions', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This will stop automatic sliding which will leave it to the user to navigate through the images.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_disable_trans',
			'options' => array( 'true' => __( 'Disable Automatic Slider Transitions', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Pause On Hover', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'By default the slider will stop sliding when you hover over it.<br /><br />Check to disable this.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_hover_pause',
			'options' => array( 'true' => __( 'Disable Pause On Hover', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'default' => '',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Slider Fade Speed', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'The speed of the fade animations.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_fade_speed',
			'options' => array( 
				'slow' => __( 'Slow', MYSITE_ADMIN_TEXTDOMAIN ),
				'fast' => __( 'Fast', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'toggle_class' => 'homepage_slider_fading_slider homepage_slider_scrolling_slider',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Slider Navigation Style', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose between having dots or thumbnails for the slider navigation.<br /><br />If choosing thumbnails then they will be automatically generated and resized.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_nav',
			'options' => array( 
				'thumb' => __( 'Image Thumbnails', MYSITE_ADMIN_TEXTDOMAIN ),
				'dots' => __( 'Nav Dots', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'toggle_class' => 'homepage_slider_fading_slider homepage_slider_scrolling_slider',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Next &amp; Prev Buttons', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'The Nivo slider comes with next and previous buttons which you can choose to disable, display on hover, or always show.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'nivo_direction_nav',
			'options' => array( 
				'button' => __( 'Always Display Next &amp; Previous Buttons', MYSITE_ADMIN_TEXTDOMAIN ),
				'button_hover' => __( 'Display Next &amp; Previous Buttons on Hover', MYSITE_ADMIN_TEXTDOMAIN ),
				'disable' => __( 'Disable Next &amp; Previous Buttons', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'toggle_class' => 'homepage_slider_nivo_slider',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Display Nav Dots', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Checking this will display dots along the bottom where the user can navigate between images.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'nivo_control_nav',
			'options' => array( 'true' => __( 'Display Navigation Dots', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'toggle_class' => 'homepage_slider_nivo_slider',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Display Slider on Every Page', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Checking this will enable the slider to display on every page.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_page',
			'options' => array( 'true' => __( 'Display Homepage Slider on all Pages', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Slider Source', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose whether to populate the slider here or from your post categories.<br /><br />If you choose from post categories then you can set the images when editing your posts.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_custom',
			'options' => array( 
				'custom' => __( 'Custom Define Slides Below', MYSITE_ADMIN_TEXTDOMAIN ),
				'categories' => __( 'Automatically Create Slides from Blog Categories', MYSITE_ADMIN_TEXTDOMAIN ),
			),
			'toggle' => 'toggle_true',
			'type' => 'radio'
		),
		array(
			'name' => __( 'Number of Slides', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Enter the number of slider images to display (default is 5)', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_cat_count',
			'toggle_class' => 'slider_custom_categories',
			'type' => 'text'
		),
		
		array(
			'type' => 'toggle_end'
		),

		array(
			'name' => __( 'Slideshow', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slideshow',
			'toggle_class' => 'slider_custom_custom',
			'type' => 'slideshow'
		),
		array(
			'name' => __( 'Slider Categories', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'slider_cats',
			'target' => 'cat',
			'toggle_class' => 'slider_custom_categories',
			'type' => 'multidropdown'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Blog
	 */
	array(
		'name' => array( 'mysite_blog_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Blog Page', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Choose one of your pages to use as a blog page.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'blog_page',
			'target' => 'page',
			'type' => 'select'
		),
		array(
			'name' => __( 'Blog Layout', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Your blog posts will use the layout you select here.<br /><br />If you want an image to display in the layout then do not forget to set your featured image when editing your posts.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'blog_layout',
			'options' => array(
				'blog_layout1' => THEME_ADMIN_ASSETS_URI . '/images/blog_layout/blog_layout1.png',
				'blog_layout2' => THEME_ADMIN_ASSETS_URI . '/images/blog_layout/blog_layout2.png',
				'blog_layout3' => THEME_ADMIN_ASSETS_URI . '/images/blog_layout/blog_layout3.png'
			),
			'type' => 'layout'
		),
		array(
			'name' => __( 'Exclude Categories', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose certain categories to exclude from your blog page.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'exclude_categories',
			'target' => 'cat',
			'type' => 'multidropdown'
		),
		array(
			'name' => __( 'Popular &amp; Related Posts', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'By default a popular / related posts module will display on your posts.  You can choose how to display it or disable it here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'post_like_module',
			'options' => array( 
				'tab' => __( 'Display in a Tabbed Layout', MYSITE_ADMIN_TEXTDOMAIN ),
				'column' => __( 'Display in a Column Layout', MYSITE_ADMIN_TEXTDOMAIN ),
				'disable' => __( 'Disable Popular &amp; Related Posts Module', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		array(
			'name' => __( 'Comments &amp; Trackbacks', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose whether you want your comments and trackbacks bundled together or separated in tabs.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'post_comment_styles',
			'options' => array( 
				'tab' => __( 'Display in Separate Tabs', MYSITE_ADMIN_TEXTDOMAIN ),
				'list' => __( 'Display Together in a List', MYSITE_ADMIN_TEXTDOMAIN )
			),
			'type' => 'radio'
		),
		array(
			'name' => __( 'Display Full Blog Posts', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'By default blog posts will be displayed as excerpts.<br /><br />Checking this will display the full content of your post.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'display_full',
			'options' => array( 'true' => __( 'Display Full Blog Posts on Blog Index Page', MYSITE_ADMIN_TEXTDOMAIN ) ), 
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable About Author', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'By default an about the author module will display when viewing your posts.<br /><br />You can choose to disable it here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'disable_post_author',
			'options' => array( 'true' => __( 'Disable the About Author Module', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Post Nav', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'By default your posts will display links at the bottom to your other posts.<br /><br />Check this to disable those links.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'disable_post_nav',
			'options' => array( 'true' => __( 'Disable Post Navigation Module', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Disable Social Bookmarks', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'By default a social bookmarks module will display when viewing your posts.<br /><br />You can choose to disable it here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'social_bookmarks',
			'options' => array( 'true' => __( 'Disable the Social Bookmarks Module', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'URL shortening', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can choose to have certain links automatically use the bit.ly URL shortening service.<br /><br />For example the social icons on each post will use bit.ly URLs when this is checked.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'url_shortening',
			'options' => array( 'true' => __( 'Enable bit.ly URL Shortening', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'toggle' => 'toggle_true',
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'bit.ly Login', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the Username for your bit.ly account here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'bitly_login',
			'toggle_class' => 'url_shortening_true',
			'type' => 'text'
		),
		array(
			'name' => __( 'bit.ly API Key', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Input the API key for your bit.ly account here.<br /><br />You can find this by logging in at bit.ly and navigating to your settings page.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'bitly_api',
			'toggle_class' => 'url_shortening_true',
			'type' => 'text'
		),
		array(
			'name' => __( 'Disable Meta Options', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'The post meta will display under the title on your blog page.<br /><br />You can choose sections to disable here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'disable_meta_options',
			'options' => array(
				'author_meta' => 'Disable Author Meta',
				'date_meta' => 'Disable Date Meta',
				'comments_meta' => 'Disable Comments Meta',
				'categories_meta' => 'Disable Categories Meta',
				'tags_meta' => 'Disable Tags Meta'
			),
			'type' => 'checkbox'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sidebar
	 */
	array(
		'name' => array( 'mysite_sidebar_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Create New Sidebar', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can create additional sidebars to use.<br /><br />To display your new sidebar then you will need to select it in the &quot;Custom Sidebar&quot; dropdown when editing a post or page.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'custom_sidebars',
			'type' => 'sidebar'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Footer
	 */
	array(
		'name' => array( 'mysite_footer_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Footer Column layout', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Select which column layout you would like to display with your footer.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'footer_columns',
			'options' => array(
				'1' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/1.png',
				'2' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/2.png',
				'3' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/3.png',
				'4' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/4.png',
				'5' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/5.png',
				'6' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/6.png',
				
				'third_twothird' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/third_twothird.png',
				'fourth_threefourth' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/fourth_threefourth.png',
				'fourth_fourth_half' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/fourth_fourth_half.png',
				'sixth_fivesixth' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/sixth_fivesixth.png',
				'third_sixth_sixth_sixth_sixth' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/third_sixth_sixth_sixth_sixth.png',
				'half_sixth_sixth_sixth' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/half_sixth_sixth_sixth.png',
				
				'twothird_third' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/twothird_third.png',
				'threefourth_fourth' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/threefourth_fourth.png',
				'half_fourth_fourth' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/half_fourth_fourth.png',
				'fivesixth_sixth' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/fivesixth_sixth.png',
				'sixth_sixth_sixth_sixth_third' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/sixth_sixth_sixth_sixth_third.png',
				'sixth_sixth_sixth_half' => THEME_ADMIN_ASSETS_URI . '/images/footer_column/sixth_sixth_sixth_half.png'
			),
			'type' => 'layout'
		),
		array(
			'name' => __( 'Disable Footer Widgets', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Check this if you do not wish to display any widgets with your footer.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'footer_disable',
			'options' => array( 'true' => __( 'Disable All Footer Widgets', MYSITE_ADMIN_TEXTDOMAIN ) ),
			'type' => 'checkbox'
		),
		array(
			'name' => __( 'Footer Outro Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'This text will display just above your footer.<br /><br />By default it will display on all pages.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'footer_teaser',
			'default' => '',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Copyright Text', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'You can display copyright information here.  It will show below your footer on the left hand side.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'footer_text',
			'default' => '',
			'htmlspecialchars' => true,
			'type' => 'text'
		),
	
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Sociable
	 */
	array(
		'name' => array( 'mysite_sociable_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Sociable', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Sociable Generator', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'sociable',
			'type' => 'sociable'
		),
		
	array(
		'type' => 'tab_end'
	),
	
	/**
	 * Advanced
	 */
	array(
		'name' => array( 'mysite_advanced_tab' => $option_tabs ),
		'type' => 'tab_start'
	),
	
		array(
			'name' => __( 'Custom Admin Logo', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Upload an image to replace the default Mysitemyway logo.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'admin_logo_url',
			'type' => 'upload'
		),
		array(
			'name' => __( 'Import Options', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'Copy your export code here to import your theme settings.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'import_options',
			'type' => 'textarea'
		),
		array(
			'name' => __( 'Export Options', MYSITE_ADMIN_TEXTDOMAIN ),
			'desc' => __( 'When moving your site to a new Wordpress installation you can export your theme settings here.', MYSITE_ADMIN_TEXTDOMAIN ),
			'id' => 'export_options',
			'type' => 'export_options'
		),
		
	array(
		'type' => 'tab_end'
	),
	
);

return array(
	'load' => true,
	'name' => 'options',
	'options' => $options
);
	
?>