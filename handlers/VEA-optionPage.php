<?php 
/**
 * @package VraagEnAanbod
 */

class VEAoptionPage
{

    function __construct() {
        add_action('admin_init', [$this, 'veaSettingsInit']);
        add_action('admin_menu', [$this, 'registerOptionPage']);

    }

    public function veaSettingsInit() {

        register_setting(
            'vraag-en-aanbod', // Group
            'vea-pilled' // Name
        );

        add_settings_section(
            'vea_opties_sectie', // ID
            __( 'Algemene instellingen', 'vea' ), // Titel
            [$this, 'veaSectionCallback'], // Callback
		    'vraag-en-aanbod' // Pagina connectie
        );

        add_settings_field(
            'vea_cmpany_field', // ID
            __('Bedrijfsnaam', 'vea'), // Titel
            [$this, 'veaCompanyFieldCallback'], // Callback
            'vraag-en-aanbod', // Pagina connectie
            'vea_opties_sectie', // Section
        );

        add_settings_field(
            'vea_email_field', // ID
            __('Email', 'vea'), // Titel
            [$this, 'veaEmailFieldCallback'], // Callback
            'vraag-en-aanbod', // Pagina connectie
            'vea_opties_sectie', // Section
        );
    }

    public function registerOptionPage() {

        add_submenu_page(
            'edit.php?post_type=vraag-en-aanbod',
            __( 'Instellingen', 'vea' ),
            __( 'Instellingen', 'vea' ),
            'manage_options',
            'vea-opties',
            [$this, 'pageCallback']
        );

    }

    // CALLBACKS

    public function veaSectionCallback($args) {
        ?>
        <p id="<?php echo esc_attr( $args['id'] ); ?>"><?php esc_html_e( 'Hier kan je de algemene instellingen wijzigen', 'textdomain' ); ?></p>
        <?php
    }

    public function veaCompanyFieldCallback($args) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'vea-pilled' );

        ?>
            <input type="text" id="vea_company_field" name="vea-pilled[vea_company_field]" value="<?php echo isset( $options['vea_company_field'] ) ? esc_attr( $options['vea_company_field'] ) : ''; ?>">
        <?php
    }

    public function veaEmailFieldCallback($args) {
        // Get the value of the setting we've registered with register_setting()
        $options = get_option( 'vea-pilled' );

        ?>
            <input type="email" id="vea_email_field" name="vea-pilled[vea_email_field]" value="<?php echo isset( $options['vea_email_field'] ) ? esc_attr( $options['vea_email_field'] ) : ''; ?>">
        <?php
    }

    public function pageCallback() {

        if ( ! current_user_can( 'manage_options' ) ) {
            return;
        }

        // WordPress will add the "settings-updated" $_GET parameter to the url
        if ( isset( $_GET['settings-updated'] ) ) {
            // add settings saved message with the class of "updated"
            add_settings_error( 'vea_messages', 'vea_message', __( 'Settings Saved', 'vea' ), 'updated' );
        }

        // show error/update messages
        settings_errors( 'vea_messages' );
        ?>

        <div class="wrap">
            <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
            <form action="options.php" method="post">
                <?php
                // output security fields for the registered setting "wporg"
                settings_fields( 'vraag-en-aanbod' );
                // output setting sections and their fields
                // (sections are registered for "wporg", each field is registered to a specific section)
                do_settings_sections( 'vraag-en-aanbod' );
                // output save settings button
                submit_button( 'Save Settings' );
                ?>
            </form>
        </div>
        <?php
    }
    
}