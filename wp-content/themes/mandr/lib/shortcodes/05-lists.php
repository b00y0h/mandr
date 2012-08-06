<?php
/**
 *
 */
class mysiteLists {
	
	/**
	 *
	 */
	function fancy_list( $atts = null, $content = null ) {
		if( $atts == 'generator' ) {
			$option = array( 
				'name' => __( 'Fancy List', MYSITE_ADMIN_TEXTDOMAIN ),
				'value' => 'fancy_list',
				'options' => array(
					array(
						'name' => __( 'Type', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Choose the style of list that you wish to use.  Each one has a different icon.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'style',
						'default' => '',
						'options' => array(
							'arrow_list' => __( 'Arrow List', MYSITE_ADMIN_TEXTDOMAIN ),
							'bullet_list' => __( 'Bullet List', MYSITE_ADMIN_TEXTDOMAIN ),
							'check_list' => __( 'Check List', MYSITE_ADMIN_TEXTDOMAIN ),
							'circle_arrow' => __( 'Circle Arrow', MYSITE_ADMIN_TEXTDOMAIN ),
							'triangle_arrow' => __( 'Triangle Arrow', MYSITE_ADMIN_TEXTDOMAIN ),
							'comment_list' => __('Comment List', MYSITE_ADMIN_TEXTDOMAIN ),
							'minus_list' => __( 'Minus List', MYSITE_ADMIN_TEXTDOMAIN ),
							'plus_list' => __( 'Plus List', MYSITE_ADMIN_TEXTDOMAIN ),
							'star_list' => __( 'Star List', MYSITE_ADMIN_TEXTDOMAIN )
						),
						'type' => 'select'
					),
					array(
						'name' => __( 'List Html', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Type out the content of your list.  You need to use the &#60;ul&#62; and &#60;li&#62; elements when typing out your list content.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'content',
						'default' => '',
						'type' => 'textarea',
						'return' => true
					),
					array(
						'name' => __( 'Color Variation <small>(optional)</small>', MYSITE_ADMIN_TEXTDOMAIN ),
						'desc' => __( 'Choose one of our predefined color skins to use with your list.', MYSITE_ADMIN_TEXTDOMAIN ),
						'id' => 'variation',
						'default' => '',
						'target' => 'color_variations',
						'type' => 'select'
					),
				'shortcode_has_atts' => true,
				'shortcode_carriage_return' => true
				)
			);
			
			return $option;
		}
		
		extract(shortcode_atts(array(
			'style'     => '',
			'variation'	=> '',
	    ), $atts));
	
		$style = ( $style ) ? trim( $style ) : 'arrow_list';
	
		$variation = ( $variation ) ? ' ' . trim( $variation ) . '_sprite' : '';

		$content = str_replace( '<ul>', '<ul class="fancy_list">', $content );
		$content = str_replace( '<li>', '<li class="' . $style . $variation . '">', $content );
	
		return mysite_remove_wpautop( $content );
	}

	
	/**
	 *
	 */
	function _options( $class ) {
		$shortcode = array();
		
		$class_methods = get_class_methods( $class );
		
		foreach( $class_methods as $method ) {
			if( $method[0] != '_' )
				$shortcode[] = call_user_func(array( &$class, $method ), $atts = 'generator' );
		}
		
		$options = array(
			'name' => __( 'Fancy List', MYSITE_ADMIN_TEXTDOMAIN ),
			'value' => 'fancy_list',
			'options' => $shortcode
		);
		
		return $options;
	}
	
}

?>