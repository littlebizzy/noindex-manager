<?php 
/*
Plugin Name:  Noindex Manager
Plugin URI: https://www.littlebizzy.com/plugins/noindex-manager
Description: Noindex junk WordPress content
Version: 1.1.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
GitHub Plugin URI: littlebizzy/noindex-manager
Primary Branch: main
Prefix: NIDMNG
*/

// disable wordpress.org updates
add_filter(
	'gu_override_dot_org',
	function ( $overrides ) {
		return array_merge(
			$overrides,
			array( 'noindex-manager/noindex-manager.php' )
		);
	}
);

// noindex bbpress thin content
if ( !function_exists( 'noindex_bbpress_thin_content' ) ):
function noindex_bbpress_thin_content() {
	if ( function_exists( 'bbp_is_single_user' ) && bbp_is_single_user() ) { // bbpress user profiles
    	wp_no_robots();
  	}
	if ( function_exists( 'bbp_is_single_topic' ) && bbp_is_single_topic() && bbp_get_topic_reply_count()<=3) { // topics with few replies
    	wp_no_robots();
	}
	if ( function_exists( 'bbp_is_single_view' ) && bbp_is_single_view() ) { // view links
    	wp_no_robots();
	}
	if ( function_exists( 'bbp_is_single_reply' ) && bbp_is_single_reply() ) { // reply links
    	wp_no_robots();
	}
}
endif;
add_action( 'wp_head', 'noindex_bbpress_thin_content' );


// https://bbpress.org/forums/topic/add-noindex-to-some-forum-pages/
// https://wordpress.stackexchange.com/questions/333424/check-if-page-is-a-woocommerce-attribute
// https://stackoverflow.com/questions/72013417/check-the-woocommerce-product-attribute-on-archive-page-and-do-something
