<?php 
/**
 * @package VraagEnAanbod
 */

include 'mail/VEA-responseMail.php';
include 'mail/VEA-aanvraagMail.php';
include 'mail/VEA-klantAanvraagMail.php';
 
class VEAformSubmissions
{

    function __construct() {

        if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_vea_post") {
            add_action('init', [$this, 'validateForm']);
        }
        
        if( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_vea_response") {
            add_action('init', [$this, 'validateResponseForm']);
        }
        
    }

    function sanitizeVraagAanbod($value) {

        if ($value === 'vraag' || $value === 'aanbod') {
            return $value;
        } else {
            return false;
        }

    }

    function sanitizeCategorie($value) {

        if ($value === 'handjes' || $value === 'kennis' || $value === 'diensten' || $value === 'producten' || $value === 'tickets' || $value === 'anders') {
            return $value;
        } else {
            return false;
        }

    }

    function validateForm() {

        // Load in Mail classes
        $aanvraagMail = new VEAaanvraagMail();
        $klantAanvraagMail = new VEAklantAanvraagMail();

        // Do some minor form validation to make sure there is content
        if ( !empty($_POST['vea_password']) ) {
            return;
        }

        if (!empty($_POST['vraag_aanbod']) && $this->sanitizeVraagAanbod($_POST['vraag_aanbod'])) {
            $vraag_aanbod = $_POST['vraag_aanbod'];
        } else {
            $vraag_aanbod = '';
        }

        if (isset($_POST['vea_vnaam']) && isset($_POST['vea_anaam']) ) {
            $naam = sanitize_text_field($naam = $_POST['vea_vnaam']) . ' ' . sanitize_text_field($_POST['vea_anaam']);
        }

        if (isset($_POST['email'])) {
            $email = sanitize_text_field($_POST['email']);
        }

        if (isset($_POST['organisatie'])) {
            $organisatie = sanitize_text_field($_POST['organisatie']);
        }

        if (isset($_POST['telefoonnummer'])) {
            $telefoonnummer = sanitize_text_field($_POST['telefoonnummer']);
        }

        if (isset($_POST['korte_zin'])) {
            $korte_zin = sanitize_text_field($_POST['korte_zin']);
        }

        if (isset ($_POST['description'])) {
            $description = sanitize_textarea_field($_POST['description']);
        }

        if (isset($_POST['tegenprestatie'])) {
            $tegenprestatie = sanitize_textarea_field($_POST['tegenprestatie']);
        }

        if (isset($_POST['vea_categorie']) && $this->sanitizeCategorie($_POST['vea_categorie']) ) {
            $categorie = $_POST['vea_categorie'];
        } else {
            $categorie = '';
        }

        if (isset($_POST['vea_maatschappelijk'])) {
            $maatschappelijk = $_POST['vea_maatschappelijk'];
        }

        // Add the content of the form to $post as an array
        $new_post = array(
            'post_title'    => $korte_zin,
            'post_status'   => 'publish',
            'post_type' => 'vraag-en-aanbod', 
            'meta_input' => array(
                '_vraag_en_aanbod_naam' => $naam,
                '_vraag_en_aanbod_email' => $email,
                '_vraag_en_aanbod_organisatie' => $organisatie,
                '_vraag_en_aanbod_telefoonnummer' => $telefoonnummer,
                '_vraag_en_aanbod_beschrijving' => $description,
                '_vraag_en_aanbod_tegenprestatie' => $tegenprestatie,
                '_vraag_en_aanbod_type' => $vraag_aanbod,
                '_vraag_en_aanbod_categorie' => $categorie,
                '_vraag_en_aanbod_maatschappelijk' => $maatschappelijk,
                '_vraag_en_aanbod_status' => 'open',
            )
        );

        //save the new post and return its ID
        $pid = wp_insert_post($new_post); 

        //Send mail to admin
        $to = 'match@rotterdamseuitdaging.nl';
        $subject = 'Een nieuwe ' . $vraag_aanbod . ' op Rotterdamse Uitdaging';
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../templates/mail/vea-email-header.php'; 
        echo $aanvraagMail->aanvraagBody($vraag_aanbod, $naam, $organisatie, $email, $telefoonnummer, $description, $categorie, $maatschappelijk, $tegenprestatie);
        require_once plugin_dir_path(__FILE__) . '../templates/mail/vea-email-footer.php';
        $body_complete = ob_get_contents();
        ob_end_clean();

        $headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($to, $subject, $body_complete, $headers);

        //Send mail to customer
        $to_customer = $email;
        $subject_customer = "Uw $vraag_aanbod is succesvol geplaatst";
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../templates/mail/vea-email-header.php'; 
        echo $klantAanvraagMail->klantAanvraagBody($vraag_aanbod);
        require_once plugin_dir_path(__FILE__) . '../templates/mail/vea-email-footer.php';
        $customer_body_complete = ob_get_contents();
        ob_end_clean();

        $customer_headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($to_customer, $subject_customer, $customer_body_complete, $customer_headers);

    }

    public function validateResponseForm() {
        
        // Load in Mail class
        $responseMail = new VEAresponseMail();

        //check if form data exists
        if ( !empty($_POST['vea_password']) ) {
            return;
        }

        if (isset($_POST['vea_response_email']) ) {
            $response_email = sanitize_text_field($_POST['vea_response_email']);
        }

        if (isset($_POST['vea_response_vnaam']) && isset($_POST['vea_response_anaam'])) {
            $response_naam = sanitize_text_field($_POST['vea_response_vnaam']) . ' ' . sanitize_text_field($_POST['vea_response_anaam']);
        }

        if (isset($_POST['vea_response_bedrijf']) ) {
            $response_bedrijf = sanitize_text_field($_POST['vea_response_bedrijf']);
        }

        if (isset($_POST['vea_response_telefoonnummer']) ) {
            $response_telefoonnummer = sanitize_text_field($_POST['vea_response_telefoonnummer']);
        }

        if (isset($_POST['vea_response_reactie']) ) {
            $response_reactie = sanitize_textarea_field($_POST['vea_response_reactie']);
        }



        //collect post data
        $post_id = url_to_postid( $_SERVER['REQUEST_URI'], '_wpg_def_keyword', true );

        $title = get_the_title($post_id);
        $type_key = get_post_meta($post_id, '_vraag_en_aanbod_type', true);
        $post_email = get_post_meta($post_id, '_vraag_en_aanbod_email', true);
        $post_naam = get_post_meta($post_id, '_vraag_en_aanbod_naam', true);
        $post_url = get_the_permalink($post_id);
        
        $type = $type_key;
        $naam = $post_naam;

        // Send mail to Admin and Post type owner
        $to = array('match@rotterdamseuitdaging.nl', $post_email);
        $subject = 'Er is gereageerd op uw ' . $type . ' "' . $title . '"';
        $body = 'Beste ' . $naam . ',<br/><br/>Iemand heeft een nieuwe reactie geplaatst op uw ' . $type . ' bij de Rotterdamse Uitdaging <br/><br/> Bericht: <br/>' . $response_reactie;
        ob_start();
        require_once plugin_dir_path(__FILE__) . '../templates/mail/vea-email-header.php'; 
        echo $responseMail->responseMailBody($type, $naam, $response_reactie, $response_email, $response_bedrijf, $response_naam, $post_url, $response_telefoonnummer);
        require_once plugin_dir_path(__FILE__) . '../templates/mail/vea-email-footer.php';
        $body_complete = ob_get_contents();
        ob_end_clean();

        $headers = array('Content-Type: text/html; charset=UTF-8');

        wp_mail($to, $subject, $body_complete, $headers);
    }

}