<?php 
/*
 * Plugin Name:       Vraag en Aanbod
 * Plugin URI:        https://github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal/
 * Description:       Creates a CPT, and adds forms for users to submit their own posts.
 * Version:           2.1.4
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Jay Schmidt
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
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
include_once 'handlers/VEA-updater.php';

class VraagEnAanbod
{

    function events() {
        $registerPostTypes = new VEAregisterPostTypes();
        $registerMetaBoxes = new VEAregisterMetaboxes();
        $registerShortcodes = new VEAregisterShortcodes();
        $registerTemplates = new VEAregisterTemplates();
        $formSubmit = new VEAformSubmissions();

        if (is_admin()) { // note the use of is_admin() to double check that this is happening in the admin
            $config = array(
                'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
                'proper_folder_name' => 'Rotterdamse-Uitdaging-Plugin-Personal', // this is the name of the folder your plugin lives in
                'api_url' => 'https://api.github.com/repos/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal', // the GitHub API url of your GitHub repo
                'raw_url' => 'https://raw.github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal/master', // the GitHub raw url of your GitHub repo
                'github_url' => 'https://github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal', // the GitHub url of your GitHub repo
                'zip_url' => 'https://github.com/jay-galileo-academy/Rotterdamse-Uitdaging-Plugin-Personal/zipball/master', // the zip url of the GitHub repo
                'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
                'requires' => '5.2', // which version of WordPress does your plugin require?
                'tested' => '6.5.3', // which version of WordPress is your plugin tested up to?
                'readme' => 'README.md', // which file to use as the readme for the version number
                'access_token' => '', // Access private repositories by authorizing under Plugins > GitHub Updates when this example plugin is installed
            );
            new WP_GitHub_Updater($config);
        }
    }

    function register() {
        add_action('wp_enqueue_scripts', [$this, 'enqueue']);
        add_action('admin_enqueue_scripts', [$this, 'enqueueAdmin']);
        add_filter( 'script_loader_tag', [$this, 'set_scripts_type_attribute'], 10, 3 );
    }

    function enqueue() {
        wp_enqueue_style( 'vea-style',  plugins_url('/assets/css/style.css', __FILE__) );
        wp_enqueue_script( 'vea-js', plugins_url('/assets/js/main.js', __FILE__), false, true);
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

require_once plugin_dir_path(__FILE__) . 'handlers/VEA-activate.php';
register_activation_hook( __FILE__, [ 'VEAactivate', 'createPages']);

// deactivation
require_once plugin_dir_path(__FILE__) . 'handlers/VEA-deactivate.php';
register_deactivation_hook( __FILE__, ['VEAdeactivate', 'deactivate']);