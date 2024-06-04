<?php 
/*
 * Plugin Name:       Vraag en Aanbod
 * Plugin URI:        https://galileo-academy.nl/
 * Description:       Creates a CPT, and adds forms for users to submit their own posts.
 * Version:           1.0.5
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Jay Schmidt
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal/
 * Text Domain:       vraag-en-aanbod
 * Domain Path:       /languages
 */

if ( ! defined( 'ABSPATH' ) ) {
    die;
} 

include 'handlers/VEA-registerPostTypes.php';
include 'handlers/VEA-registerTemplates.php';
include 'handlers/VEA-registerShortcodes.php';
include 'handlers/VEA-formSubmissions.php';
include 'handlers/VEA-registerMetaboxes.php';

class VraagEnAanbod
{

    function events() {
        $registerPostTypes = new VEAregisterPostTypes();
        $registerMetaBoxes = new VEAregisterMetaboxes();
        $registerShortcodes = new VEAregisterShortcodes();
        $registerTemplates = new VEAregisterTemplates();
        $formSubmit = new VEAformSubmissions();
    }

    function register() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
        add_filter( 'script_loader_tag', [$this, 'set_scripts_type_attribute'], 10, 3 );
        add_action('init', [$this, 'update']);
    }

    function enqueue() {
        wp_enqueue_style( 'vea-style',  plugins_url('/assets/css/style.css', __FILE__) );
        wp_enqueue_script( 'vea-js', plugins_url('/assets/js/main.js', __FILE__), false, true);
    }

    function update() {
        include_once 'handlers/VEA-updater.php';

        define( 'WP_GITHUB_FORCE_UPDATE', true );

        if ( is_admin() ) {

            $config = array(
                'slug' => plugin_basename( __FILE__ ),
                'proper_folder_name' => 'rotterdamse-uitdaging-plugin-personal',
                'api_url' => 'https://api.github.com/repos/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal',
                'raw_url' => 'https://raw.github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal/master',
                'github_url' => 'https://github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal',
                'zip_url' => 'https://github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal/archive/master.zip',
                'sslverify' => true,
                'requires' => '3.0',
                'tested' => '3.3',
                'readme' => 'README.md',
                'access_token' => '',
            );

            new WP_GitHub_Updater( $config );
        }
    }

    function enqueueAdmin() {
        wp_enqueue_script( 'vea-admin-js', plugins_url('/assets/js/admin/admin.js', __FILE__), false, true);
    }

    function set_scripts_type_attribute( $tag, $handle, $src ) {
        if ( 'vea-js' === $handle ) {
            $tag = '<script type="module" src="'. $src .'"></script>';
        }

        if ( 'vea-admin-js' === $handle ) {
            $tag = '<script type="module" src="'. $src .'"></script>';
        }
        return $tag;
    }
    

}

if ( class_exists( 'VraagEnAanbod' ) ) {
    $vraagenaanbod = new VraagEnAanbod();
    $vraagenaanbod->events();
    $vraagenaanbod->register();
}


// activation
require_once plugin_dir_path(__FILE__) . 'handlers/VEA-activate.php';
register_activation_hook( __FILE__, [ 'VEAactivate', 'activate']);

// deactivation
require_once plugin_dir_path(__FILE__) . 'handlers/VEA-deactivate.php';
register_deactivation_hook( __FILE__, ['VEAdeactivate', 'deactivate']);