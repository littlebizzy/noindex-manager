<?php 

// noindex junk bbpress pages
if ( !function_exists( 'topic_add_noindex' ) ):
function topic_add_noindex() {
	if (bbp_is_single_user()) { // bbpress user profiles
    	wp_no_robots();
  	}	
	if ( bbp_is_single_topic() && bbp_get_topic_reply_count()<=3) { // topics with zero replies
    	wp_no_robots();
	}
	if (bbp_is_single_view()) { // view links
    	wp_no_robots();
	}	
	if (bbp_is_single_reply()) { // reply links
    	wp_no_robots();
	}	
}
endif;
add_action( 'wp_head', 'topic_add_noindex' );

// https://bbpress.org/forums/topic/add-noindex-to-some-forum-pages/
