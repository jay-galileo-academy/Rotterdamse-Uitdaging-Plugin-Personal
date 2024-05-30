<?php 
/**
 * @package VraagEnAanbod
 */

class VEAregisterMetaboxes
{

    function __construct() {
        add_action('add_meta_boxes', [$this, 'registerMetaBox']);
        add_action('save_post', [$this, 'saveMetaBox']);
    }


    function registerMetaBox() {
        
        add_meta_box(
            'vea_velden',
            'Vraag en Aanbod velden',
            [$this, 'createMetaFields'],
            'vraag-en-aanbod',
            'normal',
            'high'
        );

        add_meta_box(
            'vea_status',
            'Status',
            [$this, 'createStatusField'],
            'vraag-en-aanbod',
            'side',
            'low'
        );

    }

    function createStatusField($post) {
        wp_nonce_field( 'vraag_en_aanbod', 'vraag_en_aanbod_nonce');

        $status_key = get_post_meta( $post->ID, '_vraag_en_aanbod_status', true);
        $match_key = get_post_meta( $post->ID, '_vraag_en_aanbod_match', true);

        $status = isset($status_key) ? $status_key : '';
        $match = isset($match_key) ? $match_key : '';

        ?>
        <input type="radio" id="vea_open" name="vea_status" value="open" <?php if ($status == 'open') { echo 'checked'; } ?>>
        <label for="vea_vraag">Open</label><br>
        <input type="radio" id="vea_gesloten" name="vea_status" value="gesloten" <?php if ($status == 'gesloten') { echo 'checked'; } ?>>
        <label for="vea_aanbod">Gesloten</label><br>
        <input type="radio" id="vea_match" name="vea_status" value="match" <?php if ($status == 'match') { echo 'checked'; } ?>>
        <label for="vea_aanbod">Match</label><br>

        <div style="<?php if ($status === 'match') { echo 'display:block;'; } else { echo 'display:none'; } ?>">
            <label for="vea_match_company">Gematched met:</label>
            <input type="text" id="vea_match_company" name="vea_match_company" value="<?php echo $match; ?>">
        </div>
        
        <?php
    }

    function createMetaFields($post) {

        wp_nonce_field( 'vraag_en_aanbod', 'vraag_en_aanbod_nonce');

        $naam_key = get_post_meta( $post->ID, '_vraag_en_aanbod_naam', true );
        $email_key = get_post_meta( $post->ID, '_vraag_en_aanbod_email', true );
        $organisatie_key = get_post_meta( $post->ID, '_vraag_en_aanbod_organisatie', true );
        $telefoonnummmer_key = get_post_meta( $post->ID, '_vraag_en_aanbod_telefoonnummer', true);
        $beschrijving_key = get_post_meta( $post->ID, '_vraag_en_aanbod_beschrijving', true );
        $tegenprestatie_key = get_post_meta( $post->ID, '_vraag_en_aanbod_tegenprestatie', true );
        $type_key = get_post_meta( $post->ID, '_vraag_en_aanbod_type', true);
        $categorie_key = get_post_meta( $post->ID, '_vraag_en_aanbod_categorie', true);
        $maatschappelijk_key = get_post_meta($post->ID, '_vraag_en_aanbod_maatschappelijk', true);

        $categorie = isset($categorie_key) ? $categorie_key : '';
        $type = isset($type_key) ? $type_key : '';
        $naam = isset($naam_key) ? $naam_key : '';
        $email = isset($email_key) ? $email_key : '';
        $organisatie = isset($organisatie_key) ? $organisatie_key : '';
        $telefoonnummer = isset($telefoonnummmer_key) ? $telefoonnummmer_key : '';
        $beschrijving = isset($beschrijving_key) ? $beschrijving_key : '';
        $tegenprestatie = isset($tegenprestatie_key) ? $tegenprestatie_key : '';
        $maatschappelijk = isset($maatschappelijk_key) ? $maatschappelijk_key : '';

        ?>

        <div>
            <input type="radio" id="vea_vraag" name="vea_vraag_aanbod" value="vraag" <?php if ($type == 'vraag') { echo 'checked'; } ?>>
            <label for="vea_vraag">Vraag</label><br>
            <input type="radio" id="vea_aanbod" name="vea_vraag_aanbod" value="aanbod" <?php if ($type == 'aanbod') { echo 'checked'; } ?>>
            <label for="vea_aanbod">Aanbod</label><br>
        </div>

        <label for="vea_naam">Naam</label><br/>
        <input type="text" name="vea_naam" id="vea_naam" value="<?php echo $naam ?>"><br/>

        <label for="vea_organisatie">Organisatie</label><br/>
        <input type="text" name="vea_organisatie" id="vea_organisatie" value="<?php echo $organisatie ?>"><br/>

        <label for="vea_email">E-mailadres</label><br/>
        <input type="text" name="vea_email" id="vea_email" value="<?php echo $email ?>"><br/>

        <label for="vea_tel">Telefoonnummer</label><br/>
        <input type="tel" name="vea_tel" id="vea_tel" value="<?php echo $telefoonnummer ?>"><br/>

        <label for="vea_beschrijving">Beschrijving</label><br/>
        <textarea name="vea_beschrijving" id="vea_beschrijving" cols="30" rows="5"><?php echo $beschrijving ?></textarea><br/>

        <label for="vea_tegenprestatie">Tegenprestatie</label><br/>
        <textarea name="vea_tegenprestatie" id="vea_tegenprestatie" cols="30" rows="5" ><?php echo $tegenprestatie ?></textarea>

        <div>
            <p>Categorie</p>
            <input type="radio" id="handjes" name="vea_categorie" value="handjes" <?php if ($categorie == 'handjes') { echo 'checked'; } ?>>
            <label for="handjes">Handjes</label><br>
            <input type="radio" id="kennis" name="vea_categorie" value="kennis" <?php if ($categorie == 'kennis') { echo 'checked'; } ?>>
            <label for="kennis">Kennis</label><br>
            <input type="radio" id="diensten" name="vea_categorie" value="diensten" <?php if ($categorie == 'diensten') { echo 'checked'; } ?>>
            <label for="diensten">Diensten</label><br>
            <input type="radio" id="producten" name="vea_categorie" value="producten" <?php if ($categorie == 'producten') { echo 'checked'; } ?>>
            <label for="producten">Producten</label><br>
            <input type="radio" id="tickets" name="vea_categorie" value="tickets" <?php if ($categorie == 'tickets') { echo 'checked'; } ?>>
            <label for="tickets">Tickets</label><br>
            <input type="radio" id="anders" name="vea_categorie" value="anders" <?php if ($categorie == 'anders') { echo 'checked'; } ?>>
            <label for="anders">Anders</label><br>
        </div>

        <label for="vea_waarde">Maatschappelijke waarde</label><br/>
        <input type="number" name="vea_waarde" id="vea_waarde" value="<?php echo $maatschappelijk ?>"><br/>

        <?php
    }

    public function saveMetaBox($post_id) {

        if(! isset($_POST['vraag_en_aanbod_nonce'] )) {
            return $post_id;
        }

        $nonce = $_POST['vraag_en_aanbod_nonce'];

        if (! wp_verify_nonce( $nonce, 'vraag_en_aanbod') ) {
            return $post_id;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
            return $post_id;
        }

        if (! current_user_can('edit_post', $post_id)) {
            return $post_id;
        }

        $naam = sanitize_text_field($_POST['vea_naam']);
        $email = sanitize_text_field($_POST['vea_email']);
        $organisatie = sanitize_text_field($_POST['vea_organisatie']);
        $beschrijving = sanitize_textarea_field($_POST['vea_beschrijving']);
        $telefoonnummer = sanitize_text_field($_POST['vea_tel']);
        $tegenprestatie = sanitize_textarea_field($_POST['vea_tegenprestatie']);
        $maatschappelijk = sanitize_text_field($_POST['vea_waarde']);
        $type = sanitize_text_field($_POST['vea_vraag_aanbod']);
        $status = sanitize_text_field($_POST['vea_status']);
        $match = sanitize_text_field($_POST['vea_match_company']);
        $categorie = sanitize_text_field($_POST['vea_categorie']);
        
        
        update_post_meta($post_id, '_vraag_en_aanbod_naam', $naam);
        update_post_meta($post_id, '_vraag_en_aanbod_email', $email);
        update_post_meta($post_id, '_vraag_en_aanbod_organisatie', $organisatie);
        update_post_meta($post_id, '_vraag_en_aanbod_telefoonnummer', $telefoonnummer);
        update_post_meta($post_id, '_vraag_en_aanbod_beschrijving', $beschrijving);
        update_post_meta($post_id, '_vraag_en_aanbod_tegenprestatie', $tegenprestatie);
        update_post_meta($post_id, '_vraag_en_aanbod_type', $type);
        update_post_meta($post_id, '_vraag_en_aanbod_status', $status);
        update_post_meta($post_id, '_vraag_en_aanbod_match', $match);
        update_post_meta($post_id, '_vraag_en_aanbod_categorie', $categorie);
        update_post_meta($post_id, '_vraag_en_aanbod_maatschappelijk', $maatschappelijk);

    }

}