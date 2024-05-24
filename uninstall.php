<?php 

/**
 * 
 * @package VraagEnAanbod
 * 
 */

 if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
    die;
 }

 // Clear database
 $vea_posts = get_posts( array( 'post_type' => 'vraag-en-aanbod', 'numberposts' => -1 ) );

 foreach( $vea_posts as $post ) {
   wp_delete_post( $post->ID, true );
 }