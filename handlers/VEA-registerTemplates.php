<?php 
/**
 * @package VraagEnAanbod
 */

class VEAregisterTemplates
{

    function __construct() {
        add_filter('single_template', [ $this, 'singleTemplate']);
        add_filter('archive_template', [$this, 'archiveTemplate']);
    }
    
    function singleTemplate($single) {
        global $post;
        
        if ( $post->post_type == 'vraag-en-aanbod' ) {
            if (file_exists( plugin_dir_path(__FILE__) . '../templates/single-vraag-en-aanbod.php' )) {
                $single = plugin_dir_path(__FILE__) . '../templates/single-vraag-en-aanbod.php';
            }
        }
        return $single;
    }

    function archiveTemplate($archive) {

        if ( is_post_type_archive('vraag-en-aanbod') ) {
            if (file_exists( plugin_dir_path(__FILE__) . '../templates/archive-vraag-en-aanbod.php')) {
                $archive = plugin_dir_path(__FILE__) . '../templates/archive-vraag-en-aanbod.php';
            }
        }

        return $archive;
    }

}