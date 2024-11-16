<?php 
/*
Plugin Name:  Noindex Manager
Plugin URI: https://www.littlebizzy.com/plugins/noindex-manager
Description: Noindex thin WordPress content
Version: 1.5.0
Author: LittleBizzy
Author URI: https://www.littlebizzy.com
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html
GitHub Plugin URI: littlebizzy/noindex-manager
Primary Branch: main
*/

// prevent direct access
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// disable wordpress.org updates for this plugin
add_filter( 'gu_override_dot_org', function( $overrides ) {
    $overrides[] = 'noindex-manager/noindex-manager.php';
    return $overrides;
}, 999 );

// Create settings page in WP Admin
function noindex_manager_add_admin_menu() {
    add_options_page(
        'Noindex Manager Settings',
        'Noindex Manager',
        'manage_options',
        'noindex-manager',
        'noindex_manager_options_page'
    );
}
add_action( 'admin_menu', 'noindex_manager_add_admin_menu' );

// Register settings
function noindex_manager_settings_init() {
    register_setting( 'noindex_manager', 'noindex_manager_settings', [
        'sanitize_callback' => 'noindex_manager_sanitize_settings'
    ]);

    // WordPress options section
    add_settings_section(
        'noindex_manager_wp_section',
        null,
        null,
        'noindex_manager_wp'
    );

    // Noindex WordPress Tag Archives
    add_settings_field(
        'noindex_tag',
        __( 'WordPress Tag Archives', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_wp',
        'noindex_manager_wp_section',
        [
            'label_for' => 'noindex_tag',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );
    
    // Noindex WordPress Date Archives
    add_settings_field(
        'noindex_date',
        __( 'WordPress Date Archives', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_wp',
        'noindex_manager_wp_section',
        [
            'label_for' => 'noindex_date',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WordPress Attachment Pages
    add_settings_field(
        'noindex_attachments',
        __( 'WordPress Attachment Pages', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_wp',
        'noindex_manager_wp_section',
        [
            'label_for' => 'noindex_attachments',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WordPress Author Pages
    add_settings_field(
        'noindex_author',
        __( 'WordPress Author Pages', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_wp',
        'noindex_manager_wp_section',
        [
            'label_for' => 'noindex_author',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // WooCommerce options section
    add_settings_section(
        'noindex_manager_woocommerce_section',
        null,
        null,
        'noindex_manager_woocommerce'
    );

    // Noindex WooCommerce Grouped Products
    add_settings_field(
        'noindex_grouped_products',
        __( 'WooCommerce Grouped Products', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_grouped_products',
            'default'   => 'index',
            'recommended' => 'index'
        ]
    );

    // Noindex WooCommerce Product Attribute Archives (Default to Index)
    add_settings_field(
        'noindex_woocommerce',
        __( 'WooCommerce Product Attribute Archives', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_woocommerce',
            'default'   => 'index', // Updated to Index
            'recommended' => 'index'
        ]
    );

    // Noindex WooCommerce Product Categories (Default to Index)
    add_settings_field(
        'noindex_product_categories',
        __( 'WooCommerce Product Categories', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_product_categories',
            'default'   => 'index', // Updated to Index
            'recommended' => 'index'
        ]
    );

    // Noindex WooCommerce Product Tags
    add_settings_field(
        'noindex_product_tags',
        __( 'WooCommerce Product Tags', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_product_tags',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WooCommerce Shipping Classes
    add_settings_field(
        'noindex_shipping_classes',
        __( 'WooCommerce Shipping Classes', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_shipping_classes',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WooCommerce Checkout Page
    add_settings_field(
        'noindex_checkout',
        __( 'WooCommerce Checkout Page', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_checkout',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WooCommerce Cart Page
    add_settings_field(
        'noindex_cart',
        __( 'WooCommerce Cart Page', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_cart',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WooCommerce My Account Page
    add_settings_field(
        'noindex_my_account',
        __( 'WooCommerce My Account Page', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_my_account',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WooCommerce Order Confirmation Page
    add_settings_field(
        'noindex_order_confirmation',
        __( 'WooCommerce Order Confirmation Page', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_order_confirmation',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex WooCommerce Out-of-Stock Products (Default to Index)
    add_settings_field(
        'noindex_out_of_stock',
        __( 'WooCommerce Out-of-Stock Products', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_woocommerce',
        'noindex_manager_woocommerce_section',
        [
            'label_for' => 'noindex_out_of_stock',
            'default'   => 'index', // Updated to Index
            'recommended' => 'index'
        ]
    );

    // bbPress options section
    add_settings_section(
        'noindex_manager_bbpress_section',
        null,
        null,
        'noindex_manager_bbpress'
    );

    // Noindex bbPress Single Forums
    add_settings_field(
        'noindex_bbpress_forums',
        __( 'bbPress Single Forums', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_bbpress',
        'noindex_manager_bbpress_section',
        [
            'label_for' => 'noindex_bbpress_forums',
            'default'   => 'index',
            'recommended' => 'index'
        ]
    );

    // Noindex bbPress Topic Archive
    add_settings_field(
        'noindex_bbpress_topic_archive',
        __( 'bbPress Topic Archive', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_bbpress',
        'noindex_manager_bbpress_section',
        [
            'label_for' => 'noindex_bbpress_topic_archive',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex bbPress Topic Tag Archives
    add_settings_field(
        'noindex_bbpress_topic_tag_archive',
        __( 'bbPress Topic Tag Archives', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_bbpress',
        'noindex_manager_bbpress_section',
        [
            'label_for' => 'noindex_bbpress_topic_tag_archive',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex bbPress User Profiles
    add_settings_field(
        'noindex_bbpress_user',
        __( 'bbPress User Profiles', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_bbpress',
        'noindex_manager_bbpress_section',
        [
            'label_for' => 'noindex_bbpress_user',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex bbPress Topics with 2 or fewer replies
    add_settings_field(
        'noindex_bbpress_topics',
        __( 'bbPress Topics with 2 or Fewer Replies', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_bbpress',
        'noindex_manager_bbpress_section',
        [
            'label_for' => 'noindex_bbpress_topics',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex bbPress Views
    add_settings_field(
        'noindex_bbpress_views',
        __( 'bbPress Views', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_bbpress',
        'noindex_manager_bbpress_section',
        [
            'label_for' => 'noindex_bbpress_views',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );

    // Noindex bbPress Replies
    add_settings_field(
        'noindex_bbpress_replies',
        __( 'bbPress Replies', 'noindex-manager' ),
        'noindex_manager_render_select',
        'noindex_manager_bbpress',
        'noindex_manager_bbpress_section',
        [
            'label_for' => 'noindex_bbpress_replies',
            'default'   => 'noindex',
            'recommended' => 'noindex'
        ]
    );
}
add_action( 'admin_init', 'noindex_manager_settings_init' );

// Sanitize settings input
function noindex_manager_sanitize_settings($input) {
    $sanitized_input = [];

    // Sanitize each setting
    $sanitized_input['noindex_tag'] = in_array( $input['noindex_tag'], ['noindex', 'index'], true ) ? $input['noindex_tag'] : 'noindex';
    $sanitized_input['noindex_date'] = in_array( $input['noindex_date'], ['noindex', 'index'], true ) ? $input['noindex_date'] : 'noindex';
    $sanitized_input['noindex_attachments'] = in_array( $input['noindex_attachments'], ['noindex', 'index'], true ) ? $input['noindex_attachments'] : 'noindex';
    $sanitized_input['noindex_author'] = in_array( $input['noindex_author'], ['noindex', 'index'], true ) ? $input['noindex_author'] : 'noindex';

    
    $sanitized_input['noindex_woocommerce'] = in_array( $input['noindex_woocommerce'], ['noindex', 'index'], true ) ? $input['noindex_woocommerce'] : 'index'; // Updated to Index
    $sanitized_input['noindex_grouped_products'] = in_array( $input['noindex_grouped_products'], ['noindex', 'index'], true ) ? $input['noindex_grouped_products'] : 'index';

    // Add sanitization for all other options
    $sanitized_input['noindex_product_categories'] = in_array( $input['noindex_product_categories'], ['noindex', 'index'], true ) ? $input['noindex_product_categories'] : 'index'; // Updated to Index
    $sanitized_input['noindex_product_tags'] = in_array( $input['noindex_product_tags'], ['noindex', 'index'], true ) ? $input['noindex_product_tags'] : 'noindex';
    $sanitized_input['noindex_shipping_classes'] = in_array( $input['noindex_shipping_classes'], ['noindex', 'index'], true ) ? $input['noindex_shipping_classes'] : 'noindex';
    $sanitized_input['noindex_checkout'] = in_array( $input['noindex_checkout'], ['noindex', 'index'], true ) ? $input['noindex_checkout'] : 'noindex';
    $sanitized_input['noindex_cart'] = in_array( $input['noindex_cart'], ['noindex', 'index'], true ) ? $input['noindex_cart'] : 'noindex';
    $sanitized_input['noindex_my_account'] = in_array( $input['noindex_my_account'], ['noindex', 'index'], true ) ? $input['noindex_my_account'] : 'noindex';
    $sanitized_input['noindex_order_confirmation'] = in_array( $input['noindex_order_confirmation'], ['noindex', 'index'], true ) ? $input['noindex_order_confirmation'] : 'noindex';
    $sanitized_input['noindex_out_of_stock'] = in_array( $input['noindex_out_of_stock'], ['noindex', 'index'], true ) ? $input['noindex_out_of_stock'] : 'index'; // Updated to Index

    // Sanitize bbPress settings
    $sanitized_input['noindex_bbpress_forums'] = in_array( $input['noindex_bbpress_forums'], ['noindex', 'index'], true ) ? $input['noindex_bbpress_forums'] : 'index';
    $sanitized_input['noindex_bbpress_topic_archive'] = in_array( $input['noindex_bbpress_topic_archive'], ['noindex', 'index'], true ) ? $input['noindex_bbpress_topic_archive'] : 'noindex';
    $sanitized_input['noindex_bbpress_topic_tag_archive'] = in_array( $input['noindex_bbpress_topic_tag_archive'], ['noindex', 'index'], true ) ? $input['noindex_bbpress_topic_tag_archive'] : 'noindex';
    $sanitized_input['noindex_bbpress_user'] = in_array( $input['noindex_bbpress_user'], ['noindex', 'index'], true ) ? $input['noindex_bbpress_user'] : 'noindex';
    $sanitized_input['noindex_bbpress_topics'] = in_array( $input['noindex_bbpress_topics'], ['noindex', 'index'], true ) ? $input['noindex_bbpress_topics'] : 'noindex';
    $sanitized_input['noindex_bbpress_views'] = in_array( $input['noindex_bbpress_views'], ['noindex', 'index'], true ) ? $input['noindex_bbpress_views'] : 'noindex';
    $sanitized_input['noindex_bbpress_replies'] = in_array( $input['noindex_bbpress_replies'], ['noindex', 'index'], true ) ? $input['noindex_bbpress_replies'] : 'noindex';

    return $sanitized_input;
}

// Render select dropdown for each option
function noindex_manager_render_select($args) {
    $options = get_option( 'noindex_manager_settings' );
    $current_value = isset( $options[$args['label_for']] ) ? $options[$args['label_for']] : $args['default'];
    ?>
    <select id="<?php echo esc_attr( $args['label_for'] ); ?>" name="noindex_manager_settings[<?php echo esc_attr( $args['label_for'] ); ?>]">
        <option value="noindex" <?php selected( $current_value, 'noindex' ); ?>><?php esc_html_e( 'Noindex', 'noindex-manager' ); ?></option>
        <option value="index" <?php selected( $current_value, 'index' ); ?>><?php esc_html_e( 'Index', 'noindex-manager' ); ?></option>
    </select>
    <span class="description" style="margin-left: 10px;"><?php printf( esc_html__( 'Recommended: %s', 'noindex-manager' ), esc_html( ucfirst( $args['recommended'] ) ) ); ?></span>
    <?php
}

// Output settings page with tabs
function noindex_manager_options_page() {
    ?>
    <div class="wrap">
        <h1><?php esc_html_e( 'Noindex Manager Settings', 'noindex-manager' ); ?></h1>
        <h2 class="nav-tab-wrapper">
            <a href="#wp-settings" class="nav-tab nav-tab-active"><?php esc_html_e( 'WordPress', 'noindex-manager' ); ?></a>
            <a href="#woocommerce-settings" class="nav-tab"><?php esc_html_e( 'WooCommerce', 'noindex-manager' ); ?></a>
            <a href="#bbpress-settings" class="nav-tab"><?php esc_html_e( 'bbPress', 'noindex-manager' ); ?></a>
        </h2>
        <form action="options.php" method="post">
            <div id="wp-settings" class="tab-content" style="display:block;">
                <?php
                settings_fields( 'noindex_manager' ); 
                do_settings_sections( 'noindex_manager_wp' ); 
                ?>
            </div>
            <div id="woocommerce-settings" class="tab-content" style="display:none;">
                <?php
                settings_fields( 'noindex_manager' ); 
                do_settings_sections( 'noindex_manager_woocommerce' ); 
                ?>
            </div>
            <div id="bbpress-settings" class="tab-content" style="display:none;">
                <?php
                settings_fields( 'noindex_manager' ); 
                do_settings_sections( 'noindex_manager_bbpress' ); 
                ?>
            </div>
            <?php submit_button(); ?>
        </form>
        <style>
            .nav-tab:focus, .nav-tab:active {
                outline: none;
                box-shadow: none;
            }
        </style>
        <script>
            jQuery(document).ready(function($) {
                $('.nav-tab').on('click', function(e) {
                    e.preventDefault();
                    $('.nav-tab-active').removeClass('nav-tab-active');
                    $(this).addClass('nav-tab-active');
                    $('.tab-content').hide();
                    $($(this).attr('href')).show();
                });
            });
        </script>
    </div>
    <?php
}

// Main function to noindex grouped products and other settings
function noindex_thin_content() {
    $options = get_option( 'noindex_manager_settings' );

    // Noindex for WooCommerce grouped products
    $noindex_grouped_products = isset( $options['noindex_grouped_products'] ) ? $options['noindex_grouped_products'] : 'index';
    if ( class_exists( 'WooCommerce' ) && is_product() && wc_get_product()->is_type( 'grouped' ) && $noindex_grouped_products === 'noindex' ) {
        wp_no_robots();
        return;
    }

    // Add this snippet for date archives
    $noindex_date = isset( $options['noindex_date'] ) ? $options['noindex_date'] : 'noindex';
    if ( is_date() && $noindex_date === 'noindex' ) {
        wp_no_robots();
        return;
    }

    // Noindex for WordPress attachment pages
    $noindex_attachments = isset( $options['noindex_attachments'] ) ? $options['noindex_attachments'] : 'noindex';
    if ( is_attachment() && $noindex_attachments === 'noindex' ) {
        wp_no_robots();
        return;
    }

    // Noindex for WordPress author pages
    $noindex_author = isset( $options['noindex_author'] ) ? $options['noindex_author'] : 'noindex';
    if ( is_author() && $noindex_author === 'noindex' ) {
        wp_no_robots();
        return;
    }

    // (Other noindex logic for other settings)
}

// Hardcode noindex for all search result pages (WordPress, WooCommerce, bbPress)
function noindex_search_results() {
    if ( is_search() ) {
        wp_no_robots();
    }
}

add_action( 'wp_head', 'noindex_thin_content' );
add_action( 'wp_head', 'noindex_search_results' );

// Ref: ChatGPT
// https://bbpress.org/forums/topic/add-noindex-to-some-forum-pages/
// https://wordpress.stackexchange.com/questions/333424/check-if-page-is-a-woocommerce-attribute
// https://stackoverflow.com/questions/72013417/check-the-woocommerce-product-attribute-on-archive-page-and-do-something
// https://wordpress.org/support/topic/taxonomy_is_product_attribute/
