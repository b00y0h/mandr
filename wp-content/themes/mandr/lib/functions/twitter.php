<?php
/**
 *
 */
function mysite_relative_time( $original, $do_more = 0 ) {
        # array of time period chunks
        $chunks = array(
                array(60 * 60 * 24 * 365 , 'year'),
                array(60 * 60 * 24 * 30 , 'month'),
                array(60 * 60 * 24 * 7, 'week'),
                array(60 * 60 * 24 , 'day'),
                array(60 * 60 , 'hour'),
                array(60 , 'minute'),
        );

        $today = time();
        $since = $today - $original;

        for ($i = 0, $j = count($chunks); $i < $j; $i++) {
                $seconds = $chunks[$i][0];
                $name = $chunks[$i][1];

                if (($count = floor($since / $seconds)) != 0)
                        break;
        }

        $print = ($count == 1) ? '1 '.$name : "$count {$name}s";

        if ($i + 1 < $j) {
                $seconds2 = $chunks[$i + 1][0];
                $name2 = $chunks[$i + 1][1];

                # add second item if it's greater than 0
                if ( (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) && $do_more )
                        $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
        }
        return $print;
}

/**
 *
 */
function mysite_twitter_feed( $usernames, $limit, $type ) {
	$out = '';
	
	if( empty( $usernames ) )
		return __( 'Twitter not configured.', MYSITE_TEXTDOMAIN );
		
	include_once(ABSPATH . WPINC . '/feed.php');
	
	$rss = fetch_feed( 'http://twitter.com/statuses/user_timeline/' . $usernames . '.rss' );
	
	if ( !is_wp_error( $rss ) )
	{ 
	    $maxitems = $rss->get_item_quantity(40);
	    $rss_items = $rss->get_items(0, $maxitems);
	}
	else 
	{
	    add_filter( 'wp_feed_cache_transient_lifetime', 'mysite_twitter_feed_cahce_error');
            $rss = fetch_feed( 'http://twitter.com/statuses/user_timeline/' . $usernames . '.rss' );
		if ( !is_wp_error( $rss ) )
		{
			$maxitems = $rss->get_item_quantity(40);
			$rss_items = $rss->get_items(0, $maxitems);
		}
		else 
		{
			remove_filter( 'wp_feed_cache_transient_lifetime', 'mysite_twitter_feed_cahce_error');
			return '<p>No Twitter Messages</p>';
		}
		
	    remove_filter( 'wp_feed_cache_transient_lifetime', 'mysite_twitter_feed_cahce_error');
	}
	
	$i = 0;
	foreach ( $rss_items as $item ) {
		
		if( $type == 'teaser' ) {
			$out .= '<a class="tweet target_blank" href="' . esc_url( $item->get_permalink() ) . '">';
			$out .= mysite_filter_tweet( $item->get_title() );
			$out .= sprintf( __( '<small> (%1$s&nbsp;ago)</small>', MYSITE_TEXTDOMAIN ), mysite_relative_time(strtotime( $item->get_date() ) ) );
			$out .= '</a>';
		}
		
		if( $type == 'widget' ) {
			$out .= '<li>';
			$out .= '<a class="target_blank" href="' . $item->get_permalink() . '" title="' . sprintf( esc_attr__( '%1$s&nbsp;ago', MYSITE_TEXTDOMAIN ), mysite_relative_time(strtotime( $item->get_date() ) ) ) . '">' . mysite_filter_tweet( $item->get_title() ) . '</a>';
			$out .= '</li>';
		}
		
		$i++;
		if ( $i >= $limit ) break;
	}
	
	return $out;
}

/**
 *
 */
function mysite_filter_tweet( $twit ) {
	
	# Remove the preceding 'username: '
	$twit = substr(strstr( $twit, ': ' ), 2, strlen( $twit ));
	
	# Specifically for non-English tweets, converts UTF-8 into ISO-8859-1
	//$twit = iconv( 'UTF-8', 'ISO-8859-1//TRANSLIT', $twit );
	
	// Convert URLs into hyperlinks
	//$twit = preg_replace("/(http:\/\/)(.*?)\/([\w\.\/\&\=\?\-\,\:\;\#\_\~\%\+]*)/", "<a href=\"\\0\">\\0</a>", $twit);
	// Convert usernames (@) into links 
	//$twit = preg_replace("(@([a-zA-Z0-9\_]+))", "<a href=\"http://www.twitter.com/\\1\">\\0</a>", $twit);
	// Convert hash tags (#) to links 
	//$twit = preg_replace('/(^|\s)#(\w+)/', '\1<a href="http://search.twitter.com/search?q=%23\2">#\2</a>', $twit);
	
	return $twit;
}

?>