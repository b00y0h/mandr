<?php
/**
 *
 */
function mysite_options_init() {
	register_setting( MYSITE_SETTINGS, MYSITE_SETTINGS );
	
	# Add default options if they don't exist
	add_option( MYSITE_SETTINGS, mysite_default_options( 'settings' ) );
	add_option( MYSITE_INTERNAL_SETTINGS, mysite_default_options( 'internal' ) );
	# delete_option(MYSITE_SETTINGS);
	# delete_option(MYSITE_INTERNAL_SETTINGS);
	
	if( mysite_ajax_request() ) {
		# Ajax option save
		if( isset( $_POST['mysite_option_save'] ) ) {
			mysite_ajax_option_save();
			
		# Sidebar option save
		} elseif( isset( $_POST['mysite_sidebar_save'] ) ) {
			mysite_sidebar_option_save();
			
		} elseif( isset( $_POST['mysite_sidebar_delete'] ) ) {
			mysite_sidebar_option_delete();
			
		} elseif( isset( $_POST['action'] ) && $_POST['action'] == 'add-menu-item' ) {
			add_filter( 'nav_menu_description', create_function('','return "";') );
		}
	}
	
	# Option import
	if( ( !mysite_ajax_request() ) && ( isset( $_POST['mysite_import_options'] ) ) ) {
		mysite_import_options( $_POST[MYSITE_SETTINGS]['import_options'] );

	# Reset options
	} elseif( ( !mysite_ajax_request() ) && ( isset( $_POST[MYSITE_SETTINGS]['reset'] ) ) ) {
		update_option( MYSITE_SETTINGS, mysite_default_options( 'settings' ) );
		delete_option( MYSITE_SIDEBARS );
		wp_redirect( admin_url( 'admin.php?page=mysite-options&reset=true' ) );
		exit;
		
	# $_POST option save
	} elseif( ( !mysite_ajax_request() ) && ( isset( $_POST['mysite_admin_wpnonce'] ) ) ) {
		unset(  $_POST[MYSITE_SETTINGS]['export_options'] );
	}
	
}

/**
 *
 */
function mysite_sidebar_option_delete() {
	check_ajax_referer( MYSITE_SETTINGS . '_wpnonce', 'mysite_admin_wpnonce' );
	
	$data = $_POST;
	
	$saved_sidebars = get_option( MYSITE_SIDEBARS );
	
	$msg = array( 'success' => false, 'sidebar_id' => $data['sidebar_id'], 'message' => sprintf( __( 'Error: Sidebar &quot;%1$s&quot; not deleted, please try again.', MYSITE_ADMIN_TEXTDOMAIN ), $data['mysite_sidebar_delete'] ) );
	
	unset( $saved_sidebars[$data['sidebar_id']] );
	
	if( update_option( MYSITE_SIDEBARS, $saved_sidebars ) ) {
		$msg = array( 'success' => 'deleted_sidebar', 'sidebar_id' => $data['sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Deleted.', MYSITE_ADMIN_TEXTDOMAIN ), $data['mysite_sidebar_delete'] ) );
	}
	
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 *
 */
function mysite_sidebar_option_save() {
	check_ajax_referer( MYSITE_SETTINGS . '_wpnonce', 'mysite_admin_wpnonce' );
	
	$data = $_POST;
	
	$saved_sidebars = get_option( MYSITE_SIDEBARS );
	
	$msg = array( 'success' => false, 'sidebar' => $data['custom_sidebars'], 'message' => sprintf( __( 'Error: Sidebar &quot;%1$s&quot; not saved, please try again.', MYSITE_ADMIN_TEXTDOMAIN ), $data['custom_sidebars'] ) );
	
	if( empty( $saved_sidebars ) ) {
		$update_sidebar[$data['mysite_sidebar_id']] = $data['custom_sidebars'];
		
		if( update_option( MYSITE_SIDEBARS, $update_sidebar ) )
			$msg = array( 'success' => 'saved_sidebar', 'sidebar' => $data['custom_sidebars'], 'sidebar_id' => $data['mysite_sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Added.', MYSITE_ADMIN_TEXTDOMAIN ), $data['custom_sidebars'] ) );
		
	} elseif( is_array( $saved_sidebars ) ) {
		
		if( in_array( $data['custom_sidebars'], $saved_sidebars ) ) {
			$msg = array( 'success' => false, 'sidebar' => $data['custom_sidebars'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Already Exists.', MYSITE_ADMIN_TEXTDOMAIN ), $data['custom_sidebars'] ) );
			
		} elseif( !in_array( $data['custom_sidebars'], $saved_sidebars ) ) {
			$sidebar[$data['mysite_sidebar_id']] = $data['custom_sidebars'];
			$update_sidebar = $saved_sidebars + $sidebar;
			
			if( update_option( MYSITE_SIDEBARS, $update_sidebar ) )
				$msg = array( 'success' => 'saved_sidebar', 'sidebar' => $data['custom_sidebars'], 'sidebar_id' => $data['mysite_sidebar_id'], 'message' => sprintf( __( 'Sidebar &quot;%1$s&quot; Added.', MYSITE_ADMIN_TEXTDOMAIN ), $data['custom_sidebars'] ) );
			
		}
	}
		
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 *
 */
function mysite_ajax_option_save() {
	check_ajax_referer( MYSITE_SETTINGS . '_wpnonce', 'mysite_admin_wpnonce' );
	
	$data = $_POST;
	
	unset( $data['_wp_http_referer'], $data['_wpnonce'], $data['action'], $data['mysite_full_submit'], $data[MYSITE_SETTINGS]['export_options'] );
	unset( $data['mysite_admin_wpnonce'], $data['mysite_option_save'], $data['option_page'] );
	
	$msg = array( 'success' => false, 'message' => __( 'Error: Options not saved, please try again.', MYSITE_ADMIN_TEXTDOMAIN ) );
	
	if( get_option( MYSITE_SETTINGS ) != $data[MYSITE_SETTINGS] ) {
		
		if( update_option( MYSITE_SETTINGS, $data[MYSITE_SETTINGS] ) )
			$msg = array( 'success' => 'options_saved', 'message' => __( 'Options Saved.', MYSITE_ADMIN_TEXTDOMAIN ) );
			
	} else {
		$msg = array( 'success' => true, 'message' => __( 'Options Saved.', MYSITE_ADMIN_TEXTDOMAIN ) );
	}
	
	$echo = json_encode( $msg );

	@header( 'Content-Type: application/json; charset=' . get_option( 'blog_charset' ) );
	echo $echo;
	exit;
}

/**
 * 
 */
function mysite_shortcode_generator() {
	global $mysite;
	
	$shortcodes = mysite_shortcodes();
	
	$options = array();
	
	foreach( $shortcodes as $shortcode ) {
		$shortcode = str_replace( '.php', '',$shortcode );
		$shortcode = preg_replace( '/[0-9-]/', '', $shortcode );
		
		if( $shortcode[0] != '_' ) {
			$class = 'mysite' . ucwords( $shortcode );
			$options[] = call_user_func( array( &$class, '_options' ), $class );
		}
	}
	
	return $options;
}

/**
 *
 */
function mysite_check_wp_version(){
	global $wp_version;
	
	$check_WP = '3.0';
	$is_ok = version_compare($wp_version, $check_WP, '>=');
	
	if ( ($is_ok == FALSE) ) {
		return false;
	}
	
	return true;
}

/**
 * 
 */
function mysite_wpmu_style_option() {
	$styles = array();
	if( is_multisite() ) {
		global $blog_id;
		$wpmu_styles_path = $_SERVER['DOCUMENT_ROOT'] . '/' . get_blog_option( $blog_id, 'upload_path' ) . '/styles/';
		if(is_dir( $wpmu_styles_path ) ) {
			if($open_dirs = opendir( $wpmu_styles_path ) ) {
				while(($style = readdir($open_dirs)) !== false) {
					if(stristr($style, '.css') !== false) {
						$theme_name = md5( THEME_NAME ) . 'muskin_';
						$style_mu = str_replace( $theme_name, '', $style );
						$styles[$style_mu] = @filemtime( $wpmu_styles_path . $style);
						
						if( stristr($style, 'muskin_') !== false && stristr($style, $theme_name) === false )
							unset($styles[$style_mu]);
						
					}
				}
			}
		}
	}
	
	return $styles;
}

/**
 * 
 */
function mysite_style_option() {
	$styles = array();
	$sort_styles = array();
	
	if(is_dir(TEMPLATEPATH . '/styles/')) {
		if($open_dirs = opendir(TEMPLATEPATH . '/styles/')) {
			while(($style = readdir($open_dirs)) !== false) {
				if(stristr($style, '.css') !== false) {
					$styles[$style] = @filemtime(TEMPLATEPATH . '/styles/' . $style);
				}
			}
		}
	}
	
	$styles = array_merge( $styles, mysite_wpmu_style_option() );
	
	arsort($styles);
	
	$nt_writable = get_option( MYSITE_SKIN_NT_WRITABLE );
	if( !empty( $nt_writable ) ) {
		foreach ( $nt_writable as $key => $val ) {
			$val = $val . '.css';
			$sort_styles[$val] = $val;
		}
	}
	
	foreach ($styles as $key => $val) {
	    $sort_styles[$key] = $key;
	}
	
	unset( $sort_styles['_create_new.css'] );
	
	return $sort_styles;
}

/**
 * 
 */
function mysite_sociable_option() {
	$sociables = array();
	$styles = array();
	
	$pic_types = array('jpg', 'jpeg', 'gif', 'png');

	if( is_dir( THEME_DIR . '/images/sociables/default/' ) ) {
		if( $open_dirs = opendir( THEME_DIR . '/images/sociables/default/' ) ) {
			while( ( $sociable = readdir( $open_dirs ) ) !== false ) {
				$parts = explode( '.', $sociable );
				$ext = strtolower( $parts[count($parts) - 1] );
				
				if( in_array( $ext, $pic_types ) ) {
					$option = str_replace( '_',' ', $parts[count($parts) - 2] );
					$option = ucwords( $option );
					$sociables[$sociable] = str_replace( ' ','', $option );
				}
			}
		}
	}
	
	if( is_dir( THEME_DIR . '/images/sociables/' ) ) {
		if( $open_dirs = opendir( THEME_DIR . '/images/sociables/' ) ) {
			while( ( $style = readdir( $open_dirs ) ) !== false ) {
				
				$styles[$style] = ucwords( str_replace( '_',' ', $style ) );
				
				while(($ix = array_search('.',$styles)) > -1)
					unset($styles[$ix]);
			        while(($ix = array_search('..',$styles)) > -1)
			         	unset($styles[$ix]);
			}
			
		}
	}
	
	return array( 'styles' => $styles, 'sociables' => $sociables );
}

/**
 * 
 */
function mysite_pattern_presets() {
	$patterns = array();
	$pic_types = array( 'jpg', 'jpeg', 'gif', 'png' );

	if( is_dir( THEME_PATTERNS_DIR ) ) {
		if( $open_dirs = opendir( THEME_PATTERNS_DIR ) ) {
			while( ( $pattern = readdir( $open_dirs ) ) !== false ) {
				$parts = explode( '.', $pattern );
				$ext = strtolower( $parts[count($parts) - 1] );
				
				if( in_array( $ext, $pic_types ) ) {
					$patterns[$pattern] = $parts[count($parts) - 2];
				}
			}
		}
	}
	
	asort( $patterns );
	
	return $patterns;
}

/**
 * 
 */
function mysite_cufon_fonts() {
	$cufon = array();
	if(is_dir(THEME_FONTS)) {
		if($open_dirs = opendir(THEME_FONTS)) {
			while(($font = readdir($open_dirs)) !== false) {
				if(stristr($font, '.js') !== false) {
					$font =  str_replace( '.js', '', $font );
					$cufon[$font] = ucfirst( $font );
				}
			}
		}
	}
	
	asort( $cufon );
	
	return $cufon;
}

/**
 * 
 */
function mysite_typography_options() {
	$font = array(
		'Web' => 'Web',
		'Arial, Helvetica, sans-serif' => 'Arial',
		'"Copperplate Light", "Copperplate Gothic Light", serif' => 'Copperplate Light',
		'"Courier New", Courier, monospace' => 'Courier New',
		'Futura, "Century Gothic", AppleGothic, sans-serif' => 'Futura',
		'Georgia, Times, "Times New Roman", serif' => 'Georgia',
		'"Gill Sans", Calibri, "Trebuchet MS", sans-serif' => 'Gill Sans',
		'Impact, Haettenschweiler, "Arial Narrow Bold", sans-serif' => 'Impact',
		'"Lucida Sans", "Lucida Grande", "Lucida Sans Unicode", sans-serif' => 'Lucida',
		'Palatino, "Palatino Linotype", Georgia, Times, "Times New Roman", serif' => 'Palatino',
		'Tahoma, Geneva, Verdana, sans-serif' => 'Tahoma',
		'"Times New Roman", Times, Georgia, serif' => 'Times New Roman',
		'"Trebuchet MS", Tahoma, Arial, sans-serif' => 'Trebuchet',
		'Verdana, Geneva, Tahoma, sans-serif' => 'Verdana',
		'inherit' =>'Inherit',
		'optgroup' => 'optgroup');
		
	$cufon = mysite_cufon_fonts();
		
	if( !empty( $cufon ) ) {
		array_unshift( $cufon, 'Cufon' );
		array_push( $cufon, 'optgroup' );

		$font = array_merge( $font, $cufon );
	}
	
	$size = range( 1,100 );
	$weight = array( 'normal', 'bold' );
	$style = array( 'normal', 'italic', 'oblique' );
		
	$options = array( 'font-size' => $size, 'font-weight' => $weight,  'font-style' => $style, 'font-family' => $font );
	
	return $options;
}

/**
 *
 */
function mysite_dependencies( $post_id ) {
	global $mysite;
	
	if( !is_admin() ) return;
	
	  if ( empty( $mysite->dependencies ) && !empty( $_POST[MYSITE_SETTINGS] ) ) {
	    $post = $_POST;
		
		$dependencies = array();
		
		if( preg_match( '/\[portfolio_grid (.*)fancy_layout(\s)?=(\s)?\\\"(\s)?true(\s)?\\\"/', $post['post_content'] ) ||
		    preg_match( '/\[portfolio_grid (.*)fancy_layout(\s)?=(\s)?\\\"(\s)?true(\s)?\\\"/', $post[MYSITE_SETTINGS]['_intro_custom_html'] ) ||
		    preg_match( '/\[portfolio_grid (.*)fancy_layout(\s)?=(\s)?\\\"(\s)?true(\s)?\\\"/', $post[MYSITE_SETTINGS]['_intro_custom_text'] ) ) { $dependencies[] = 'fancy_portfolio'; }
		
		if( strpos( $post['post_content'], '[nivo' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_html'], '[nivo' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_text'], '[nivo' ) !== false ) { $dependencies[] = 'nivo'; }
		
		if( strpos( $post['post_content'], '[galleria' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_html'], '[galleria' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_text'], '[galleria' ) !== false ) { $dependencies[] = 'galleria'; }
		
		if( strpos( $post['post_content'], '[tab' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_html'], '[tab' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_text'], '[tab' ) !== false ) { $dependencies[] = 'tabs'; }
		
		if( strpos( $post['post_content'], '[tooltip' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_html'], '[tooltip' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_text'], '[tooltip' ) !== false ) { $dependencies[] = 'tooltip'; }
		
		if( strpos( $post['post_content'], '[contactform' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_html'], '[contactform' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_text'], '[contactform' ) !== false ) { $dependencies[] = 'contactform'; }
		
		if( strpos( $post['post_content'], 'post_content=\"full' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_html'], 'post_content=\"full' ) !== false ||
		    strpos( $post[MYSITE_SETTINGS]['_intro_custom_text'], 'post_content=\"full' ) !== false ) { $dependencies[] = 'all_scripts'; }
		
		$dependencies = serialize( $dependencies );
		update_post_meta( $post_id, '_' . THEME_SLUG .'_dependencies', $dependencies );
	  }
	
	$mysite->dependencies = true;
}

/**
 * 
 */
function mysite_tinymce_init_size() {
	if( isset( $_GET['page'] ) ) {
		if( $_GET['page'] == 'mysite-options' ) {
			$tinymce = 'TinyMCE_' . MYSITE_SETTINGS . '_content_size';
			if( !isset( $_COOKIE[$tinymce] ) )
				setcookie($tinymce, 'cw=577&ch=251');
		}
	}
}

/**
 *
 */
function mysite_import_options( $import ) {
	
	$imported_options = mysite_decode( $import, $serialize = true );
	
	if( is_array( $imported_options ) ) {
		
		if( array_key_exists( 'mysitemyway_options_export', $imported_options ) ) {
			if( get_option( MYSITE_SETTINGS ) != $imported_options ) {

				if( update_option( MYSITE_SETTINGS, $imported_options ) )
					wp_redirect( admin_url( 'admin.php?page=mysite-options&import=true' ) );
				else
					wp_redirect( admin_url( 'admin.php?page=mysite-options&import=false' ) );

			} else {
				wp_redirect( admin_url( 'admin.php?page=mysite-options&import=true' ) );
			}
			
		} else {
			wp_redirect( admin_url( 'admin.php?page=mysite-options&import=false' ) );
		}
		
	} else {
		wp_redirect( admin_url( 'admin.php?page=mysite-options&import=false' ) );
	}
	
	exit;
}

/**
 *
 */
function mysite_default_options( $type ) {
	global $mysite;
	
	$options = '';
	
	$default_options = '7VpNj9s2EP0rBILsyfC3Nxsveihy6CUoAhToZREItEjbk5VILTn0xg3y3zuU9WVR9hpI5DZpgSDQijMazuPjI-khX94tll_scjJd3jw5jfcCbJbwfZTojT68ubfLedGIxsnq5V3x0ltGziRVw7hoqF5MJsWbNd9BrNUL1rPiDSg0OtIZgla2bi57ioCJjFByK03oHDuLOm0335aZ_CktwsolLmVcoWSQWXrMDKRgGSi25i6mdsu0iYElLkZ6lsgybZ00clgHvOsKGG0xPZdi-QafAZHMQZwxLhOWn9HwaCu5aGQUmE_LNytDlrFx6SoSMqHEsIlTYTSq35TQcMWTPUJso1gLeUESReaxtaeN3x7bfjpjOlkUb7Y6lRnfyIj4qB2GgdcuSaJnELgNs6-ciwFBQq-mbjlo77WRaTH4QifaMAvIeCpxwIioVsYo0RnGBWRgY1Ab4ohEIHNnFGdPjuiC2tC_I_uQHkU3Vg6RJsBRb6rp8RsR7A_kBqUICX30gZrQR7i-FNYDcgFzjp1an55VCCNmy9Eo3RNkMt0_8_0w1unIuiwjQCr7N2UPNc0z1cz6tiT2g1YyWmtncPvxJvHMZaObDfWs9by99U8fttS7JKH5SOFSLbRvGh3aTnk_CKOzmGeTj5OHUfX8znCa1DSE9BVmtlpRqgxBxSCcwiH7VSrJFctcsgPFDcu2nAbfcEbiMfAqsZVKGGmIMtJw9AwQkFKSRA-l1ZC9owerYyCSKI76yUmWSXrKlYUGO-UbRW2kuSyjYXcGyJmlHik7IBcb52wyICB2PuPU2eHD6AK4rgnp9H9Ivzeks_8cpCTyFnvHdf5T4VpgVilquRikHFS-9rU1N5T8aXu5XGuN-XJ5vK0af8OKSZsPvGzZlLWdd6rDl4sIpL6PRlr4i1b2fRbuRhFS3NKep06x3E543GJNOz5aByn0WiegI7-FKEz5cprvhAvz5zM7lBK0UyZfG2HxWV8zbIkUbo28ar4l-Tw1_4m4dSxLpKOTQb477C_uOKTVio5CV4jYYFTPEaddZOo55qSDR1cC1qacKENHPIwSoP_6TzKVgsTuKiHLVwk3JKHXiFjOTC4E-DM8P2Brow0taT3GnZ8T_BVs-o3aqfe9Rb09L_e9xV2cVfvew3aLfV9hJ29PaH3vAdtS3xuwk5NK31vI8Smh7x3Vts73nmIg872n2Fb53mdkt8j3rnudGp-Pb89626XyPca9O6_zPUZ-c1bprxC4W-t7DDw5ofZXCNnW-x5Dzk4qfo9Bp6c0_wrYtlX_CmkGun-FNNvKf4UZ2q39_QUOK0Q2AdFVBVxzQZoRNJdBFOx0JNdrGeMF1cvcmj4Vy0uqV7k1V5BGNpPykvreoZct8_JYMR-Px-HvYYULpSlP-NlEP4eVs8JP8V3gIDTasI6UZyPAEFI00EeOVf-LetFW77qGogjZqiadql_dtrw4kly4cz9lvm162G2VNV--WX6B5YQebnMOtjBo1qKrSfTa17R80-uRRSKYGH7KNsFvjTzBiCOeKcZWNXJQj-er3otmVfsSsvhutbl73CoOvA-JTPjEBvK6-slZBsvpJYjNFiFi_sdsIC1oduJ741f_cN1Zhfy-sFa06Mrs_WX4TsdlVz4YDYrtaPHDjCNbS1MUDTJnnGVWCrbjBpwdst9pp8NTBgqlEWSRcms54yyBlTSa_kSEvJTA49illismgKdVyaKqYQgHh6rFWroNUFAlY2b5BnJ_Rw2JXtE2y1cqtGKYF1govI8tDtUNCsp9gaTyIrRpZ1bTZXYRXd6cpsvGkFgTEj8DYaYtwhzndiljytYPNB7SV4V8CWnLV4A8LxSZFTA0tMiDb7A01uU1FSWxrDEl0jouOFvzVFoiCkNnMs-aDTGC0yg3rsJUt17yosyTo3E_cCGnxa4yHLK6DFeUcVIY1O5lSYjl_I21yaTxnKvZMr9IjmchW9aJ5khr-g8iyOWqWnb72yR5cQlq1W8ATdRoIH4QxI4u93wDWvVW8lW1E3gRu5PZ_8xLfcO8gORR7m34rclgOpgN5oPF4FXtWpItP8Wdv19UfSi3bV_qmoaNk3A_WJxrHmWUauEa8FXHWb4KZ0Lu5e8L5BKM-6Sxg-90rHpKQ5TfhQT18s7zYMwzOANBpQeHMvvhCGyD089tx1HmX1mYn7R717jXtiiBueFpdh_rbH_P_LUMzrZGrn95eTn2dzfaDf62B88veLQnnr9qwVcVJVpHzloE5v51OQ7-OmqItb8vGYOmPVCmNsG8jT26odOKNkiPUQwmbtLrxAEnYMa8IR9nZmppdjxDWzl-bd7mFCmo6II7uhUifluHwbXb8OpIddukHqHSK5KfG3cAV3T4-vo3';
	
	
	$widgets = '7VnbbuM2EH1Ov2KKIvsURXHsxLsO-rCby2KLpOs2affRoCVaYsKLwksctyjQ3-jv9UtK6mJTjupNglhGg77Z54zIMyPOcEihQX_wuxp0eoM3t0boo9N7xDKK4QuJE6wL7Mjy_U6_tHhD9ZGhEFGk1PcFlAmlR5QoDYohSkfz_-UTiT76Zmtryz1JSfOTIyZiQ_HiAWcck7t_sSYMJUvGCDTRFJemPyIGXHCgONJGAYlBYQZ2AINl-SCkEk9K8-_qYxGWwJTEOi3pg73qEUySVC-jiFZQCTxViZJRab2tiMYjI-l2mHurU8PGuxlPSks_HKm4w3I0QTEeXau6AyGa_7JB_Ho8I8E15ro-SPbQOHfs5eMOEtMSGQtxw5C8WUyyesi6s9kK7QxrVJeuMsRrds5kFCO95CJm7tfQDoJjEHwA-VwF-jAEl4bHaLYDPxiO4UCnO7C_1-nsQH_Q60LGVi6-vcPgIHDmS345pQ-d9N9tSEmeZ20n2qkm9v1kmFK7frC6NRgwJwxsKI1qNdEeo-T1JNrz4r4y0VYP-Z9KtP3Xl2hDKQgHZCItJFAhbQ3EZiM72mOUvJ5Ee17cVyba6iH_T7QHiZb_NTRnqpb0bdmPnmGkjcRqThz2D2qtar39XHjo6U21zgZhqFPMsNplM7dk2WyKZruRYOF2jo84Yng7nJTThcxQTWyrHChKYixVuPD5wlCiXRd9WVBLrpd-vbwkimbCaF_JeY7A50wTwVvToWeZSCTK0pkn5WoOtiUDxYzwwK4zTANRRMDT896xMHRs2_FRqZA6EjEOEsyxRLYMeMIuKxY-Vmxrwm5swBo1WeLrcprS9F2Zix_twRBL4uXpu8O9NeZpUs1ndx2pJ4ISEXSCSFDDuOfYsCKhA8c5ueZYN-naL3WpRmH7pTC1AWXdlcq6G1TWW6ms17qyqZBxZnNIBTGeILs3eLq-WG7ouL___EvBScG3pqz8hQKv7OSQX53L9EQwrz6t6ZsgHs2CvP_1X-aZg-FTDremZb6pL6Datp6TsKhlTyiEVVMyzB2aNytve2ssglkeUzS2PUBgapufg-CXdQe2mD-TJCI8CcbivhbPYYHDB4e3okRheUeimojLEmplfnuq1oQJThD1NVx58Jp1uGMRivzidFwg7cTfGaDMD3-BrHn23l4vwFIKGTgd3vSWgFNHgEvLp6Rzp2pe5gVTeVy3u8asntdxFV7f2iPjLNBo7K-n658cClcWXXNgG6QI4apkk5ySaU_SNP-IEXiItyfnHHhvrzVZd_ZQKJpV_eqojYhSIrLlJ2A4JsjPzxyGCwe3KCY_NzeHqDhTbyRGYyqSwN28qGZpHywP7lJFbUTeojluVLfojl9E3LKqWEQqJDzG97tZmoVnhtLRfKLRee1r4HseAzNRCkxI_O1Tym71FbK42FiU3N7hYRuXPtUNy8R6F-T3qX7HakH34VSnbV_4UDyxZc7mxRj5p_ZzC8NlAbctSbpr5QZNPzt8U6KKI2Pw8J6sOC1CtaqesCCr9v2CqGgBdvvPXI3L_iiTubT261-BwJmQhq0vfy8Q4aNh7ZvEZ04Jx3AiIsOwbRrdndm629UU8QTbsuq_qwpbn_PHRmnByG-Fi4uZffgla6e7d_O-d5yIKacCxXl5hIJ89JL84x8';
		
	
	# Default theme settings
	if( $type == 'settings' ) {
		# Set to "false" to create initial export
		$include_images = true;
		
		# Decode options and unserialize
		$default_options = mysite_decode( $default_options, $serialize = true );
		foreach( $default_options as $key => $value )
			if( is_array( $value ) )
				foreach( $value as $key2 => $value2 )
					$default_options[$key][$key2] = str_replace( '%site_url%', THEME_IMAGES . '/activation', $value2 );
		
		if( $include_images ) {
			# Add default image sizes to options array 
			foreach( $mysite->layout['images'] as $img_key_full => $image_full ) {
				$image_sizes_full['w'] = $image_full[0];
				$image_sizes_full['h'] = $image_full[1];
				$images_full["${img_key_full}_full"] = $image_sizes_full;
			}

			foreach( $mysite->layout['big_sidebar_images'] as $img_key_big => $image_big ) {
				$image_sizes_big['w'] = $image_big[0];
				$image_sizes_big['h'] = $image_big[1];
				$images_big["${img_key_big}_big"] = $image_sizes_big;
			}

			foreach( $mysite->layout['small_sidebar_images'] as $img_key_small => $image_small ) {
				$image_sizes_small['w'] = $image_small[0];
				$image_sizes_small['h'] = $image_small[1];
				$images_small["${img_key_small}_small"] = $image_sizes_small;
			}

			# Merge default options & images sizes 
			$image_merge1 = array_merge( $default_options, $images_full );
			$image_merge2 = array_merge( $image_merge1, $images_big );
			$options = array_merge( $image_merge2, $images_small );
			
		} else {
			$options = $default_options;
		}
	}
	
	# Interanl framework settings
	if( $type == 'internal' ) {
		$options = array();
		
		if( defined( 'FRAMEWORK_VERSION' ) )
			$options['framework_version'] = FRAMEWORK_VERSION;
			
		if( defined( 'DOCUMENTATION_URL' ) )
			$options['documentation_url'] = DOCUMENTATION_URL;
			
		if( defined( 'SUPPORT_URL' ) )
			$options['support_url'] = SUPPORT_URL;
	}
	
	# Default activation widgets
	if( $type == 'widgets' ) {
		
		$widget_text = array();
		
		$widgets = mysite_decode( $widgets, $serialize = true );
		$i=2;
		foreach( $widgets as $key => $value ) {
			$text = str_replace( '%theme_name%', strtolower( THEME_NAME ), str_replace( '%site_url%', THEME_IMAGES . '/assets', $value ) );
			$widget_text[$i] = array( 'title' => $key, 'text' => $text, 'filter' => array() );
			$i++;
		}
		
		update_option( 'widget_text', $widget_text + array( '_multiwidget' => 6 ) );
		
		update_option( 'sidebars_widgets', array(
			'primary' => array( 'text-2' ),
			'footer1' => array( 'text-3' ),
			'footer2' => array( 'text-4' ),
			'footer3' => array( 'text-5' ),
			'footer4' => array( 'text-6' ),
			'footer5' => array( 'text-7' ),
			'footer6' => array( 'text-8' )
		));
		
		return;
	}
		
	
	return $options;
}

?>