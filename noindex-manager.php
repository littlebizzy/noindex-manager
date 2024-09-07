<?php 
/*
Plugin Name:  Noindex Manager
Plugin URI: https://www.littlebizzy.com/plugins/noindex-manager
Description: Noindex thin WordPress content
Version: 1.4.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
GitHub Plugin URI: littlebizzy/noindex-manager
Primary Branch: main
Prefix: NIDMNG
*/

// Disable WordPress.org updates for this plugin
add_filter('gu_override_dot_org', function ($overrides) {
    $overrides['noindex-manager/noindex-manager.php'] = true;
    return $overrides;
});

// Main function to noindex thin content across WordPress, WooCommerce, and bbPress
function noindex_thin_content() {
    // Noindex for WordPress tag archives
    if ( function_exists( 'is_tag' ) && is_tag() ) {
        wp_no_robots();
        return;
    }

    // Noindex for WooCommerce product attribute archives
    if ( class_exists( 'WooCommerce' ) && is_product_taxonomy() ) {
        wp_no_robots();
        return;
    }

    // Noindex for bbPress content
    if ( class_exists( 'bbPress' ) ) {
        
        // Noindex bbPress user profiles
        if ( function_exists( 'bbp_is_single_user' ) && bbp_is_single_user() ) {
            wp_no_robots();
            return;
        }

        // Noindex bbPress topics with 2 or fewer replies
        if ( function_exists( 'bbp_is_single_topic' ) && bbp_is_single_topic() && bbp_get_topic_reply_count() <= 2 ) {
            wp_no_robots();
            return;
        }

        // Noindex bbPress views (e.g., popular views, recent replies)
        if ( function_exists( 'bbp_is_single_view' ) && bbp_is_single_view() ) {
            wp_no_robots();
            return;
        }

        // Noindex bbPress single replies
        if ( function_exists( 'bbp_is_single_reply' ) && bbp_is_single_reply() ) {
            wp_no_robots();
            return;
        }
    }
}
add_action( 'wp_head', 'noindex_thin_content' );

// Ref: ChatGPT
// https://bbpress.org/forums/topic/add-noindex-to-some-forum-pages/
// https://wordpress.stackexchange.com/questions/333424/check-if-page-is-a-woocommerce-attribute
// https://stackoverflow.com/questions/72013417/check-the-woocommerce-product-attribute-on-archive-page-and-do-something
// https://wordpress.org/support/topic/taxonomy_is_product_attribute/
