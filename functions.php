<?php
/**
 * Author: Ole Fredrik Lie
 * URL: http://olefredrik.com
 *
 * FoundationPress functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @package FoundationPress
 * @since FoundationPress 1.0.0
 */

/** Various clean up functions */
require_once( 'library/cleanup.php' );

/** Required for Foundation to work properly */
require_once( 'library/foundation.php' );

/** Format comments */
require_once( 'library/class-foundationpress-comments.php' );

/** Register all navigation menus */
require_once( 'library/navigation.php' );

/** Add menu walkers for top-bar and off-canvas */
require_once( 'library/class-foundationpress-top-bar-walker.php' );
require_once( 'library/class-foundationpress-mobile-walker.php' );

/** Return entry meta information for posts */
require_once( 'library/entry-meta.php' );

/** Enqueue scripts */
require_once( 'library/enqueue-scripts.php' );

/** Add theme support */
require_once( 'library/theme-support.php' );

/** Change WP's sticky post class */
require_once( 'library/sticky-posts.php' );

/** Configure responsive image sizes */
require_once( 'library/responsive-images.php' );

/** Customization Admin */
require_once( 'library/custom-admin.php' );

/** If your site requires protocol relative url's for theme assets, uncomment the line below */
// require_once( 'library/class-foundationpress-protocol-relative-theme-assets.php' );

//Added Options Page
if(function_exists('acf_add_options_page')){
    acf_add_options_page('Theme Options');
}

//Remove "p" in wysiwyg editor
function acf_wysiwyg_remove_wpautop() {
    remove_filter('acf_the_content', 'wpautop' );
}
add_action('acf/init', 'acf_wysiwyg_remove_wpautop');

//Image size
add_image_size('news_thumbnail', 385, 275, true);
add_image_size('single_post', 535, 335, true);

//Remove 'p' in content and excerpt
remove_filter('term_description','wpautop');
remove_filter( 'the_excerpt', 'wpautop' );

//Contact Form 7 remove "p"
add_filter( 'wpcf7_autop_or_not', '__return_false' );

//Services pagination in archive page
function services_posts_per_page( $query ) {
    if ( $query->query_vars['post_type'] == 'services' && is_archive() )
        $query->query_vars['posts_per_page'] = 3;
    return $query;
}
if ( !is_admin() ) add_filter( 'pre_get_posts', 'services_posts_per_page' );