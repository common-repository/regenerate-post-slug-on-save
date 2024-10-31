<?php
/**
 * Plugin Name: Regenerate Post Slug on Save
 * Description: Regenerate the post (or any other post type) slug on each save. Useful if you want to mass edit slugs for example.
 * Version: 1.1
 * Author:      wp-hotline.com ~ Stefan
 * Author URI:  https://wp-hotline.com
 */

defined( 'ABSPATH' ) or exit;

function bhrs_save_post_callback( $post_ID, $post, $update ) {
    // allow 'publish', 'draft', 'future'
    if ($post->post_type != 'post' || $post->post_status == 'auto-draft')
        return;

    // unhook this function to prevent infinite looping
    remove_action( 'save_post', 'bhrs_save_post_callback', 10, 3 );
    // update the post slug (WP handles unique post slug)
    wp_update_post( array(
        'ID' => $post_ID,
        'post_name' => ''
    ));
    // re-hook this function
    add_action( 'save_post', 'bhrs_save_post_callback', 10, 3 );
}
add_action( 'save_post', 'bhrs_save_post_callback', 10, 3 );
