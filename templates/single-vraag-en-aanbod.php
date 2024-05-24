<?php get_header(); 
global $post;

$naam_key = get_post_meta( $post->ID, '_vraag_en_aanbod_naam', true );
$email_key = get_post_meta( $post->ID, '_vraag_en_aanbod_email', true );
$organisatie_key = get_post_meta( $post->ID, '_vraag_en_aanbod_organisatie', true );
$beschrijving_key = get_post_meta( $post->ID, '_vraag_en_aanbod_beschrijving', true );
$tegenprestatie_key = get_post_meta( $post->ID, '_vraag_en_aanbod_tegenprestatie', true );
$type_key = get_post_meta( $post->ID, '_vraag_en_aanbod_type', true);
$status_key = get_post_meta( $post->ID, '_vraag_en_aanbod_status', true);
$categorie_key = get_post_meta( $post->ID, '_vraag_en_aanbod_categorie', true);
$maatschappelijk_key = get_post_meta( $post->ID, '_vraag_en_aanbod_maatschappelijk', true );
if (has_post_thumbnail()) { $thumbnail = get_the_post_thumbnail_url(); } else { $thumbnail = plugin_dir_url(__FILE__) . '../assets/images/placeholder-vraag-en-aanbod.jpg'; }

$categorie = isset($categorie_key) ? $categorie_key : '';
$type = isset($type_key) ? $type_key : '';
$naam = isset($naam_key) ? $naam_key : '';
$email = isset($email_key) ? $email_key : '';
$organisatie = isset($organisatie_key) ? $organisatie_key : '';
$vea_beschrijving = isset($beschrijving_key) ? $beschrijving_key : '';
$vea_tegenprestatie = isset($tegenprestatie_key) ? $tegenprestatie_key : '';
$status = isset($status_key) ? $status_key : '';
$date = get_the_date();

if (isset($maatschappelijk_key) && $maatschappelijk_key !== '' && $maatschappelijk_key > 0) {
    $float_maatschappelijk = floatval($maatschappelijk_key);
    $maatschappelijk = '&euro; ' . number_format($float_maatschappelijk, 2);
} else {
    $maatschappelijk = 'Onbekend';
}

?>

<div class="vea-hero" style="background-image:url(<?php echo $thumbnail ?>)">
    <div class="vea-hero__inner">
        <div class="maatschappelijke-waarde">
            <div class="top">
                <p>Maatschappelijke waarde</p>
            </div>
            <div class="bottom">
                <p><?php echo $maatschappelijk; ?></p>
            </div>
        </div>
    </div>
</div>

<div class="vea-wrapper">
    <div class="vea-wrapper__inner">
        <div class="left">
            <div class="intro bg-white">
                <h1><?php the_title(); ?></h1>
                <p class="meta"><span style="text-transform:capitalize;font-weight:bold;"><?php echo $type; ?></span> voor de <span style="text-transform:capitalize;font-weight:bold;"><?php echo $categorie ?></span>, via de <span style="text-transform:capitalize;font-weight:bold;">Rotterdamse Uitdaging</span> - Status: <span style="text-transform:capitalize;font-weight:bold;"><?php echo $status; ?></span></p>
            </div>
            
            <div class="vea_beschrijving bg-white">
                <strong>Beschrijving</strong>
                <p><?php echo $vea_beschrijving; ?></p>
            </div>

            <div class="vea_tegenprestatie bg-white" style="<?php if ( $type == "aanbod" || empty($vea_tegenprestatie) ) { echo 'display:none'; }; ?>">
                <strong>Tegenprestatie</strong>
                <p><?php echo $vea_tegenprestatie; ?></p>
            </div>

            <div class="vea_respond bg-white" style="">
                <form id="new_vea_response" name="new_vea_response" method="post" action="">
                    <div class="vea_response_email_container">
                        <label for="vea_response_email">Email<span class="vea-verplicht">*</span></label>
                        <input type="email" id="vea_response_email" name="vea_response_email" placeholder="Vul een e-mailadres in" required>
                        <p class="error-notif"></p>
                    </div>
                    
                    <div class="vea_naam_block">
                        <div class="vea_response_vnaam_container">
                            <label for="vea_response_vnaam">Voornaam<span class="vea-verplicht">*</span></label>
                            <input type="text" id="vea_response_vnaam" name="vea_response_vnaam" placeholder="Vul uw voornaam in" required>
                            <p class="error-notif"></p>
                        </div>

                        <div class="vea_response_anaam_container">
                            <label for="vea_response_anaam">Achternaam<span class="vea-verplicht">*</span></label>
                            <input type="text" id="vea_response_anaam" name="vea_response_anaam" placeholder="Vul uw achternaam in" required>
                            <p class="error-notif"></p>
                        </div>
                    </div>

                    <div class="vea_response_bedrijf_container">
                        <label for="vea_response_bedrijf">Bedrijf<span class="vea-verplicht">*</span></label>
                        <input type="text" id="vea_response_bedrijf" name="vea_response_bedrijf" placeholder="Vul uw bedrijfsnaam in" required>
                        <p class="error-notif"></p>
                    </div>
                    
                    <div class="vea_response_telefoonnummer_container">
                        <label for="vea_response_telefoonnummer">Telefoonnummer<span class="vea-verplicht">*</span></label>
                        <input type="tel" id="vea_response_telefoonnummer" name="vea_response_telefoonnummer" placeholder="Vul uw telefoonnummer in" required>
                        <p class="error-notif"></p>
                    </div>

                    <div class="vea_response_reactie_container">
                        <label for="vea_response_reactie">Bericht<span class="vea-verplicht">*</span></label>
                        <textarea id="vea_response_reactie" name="vea_response_reactie" placeholder="Vul hier het bericht in dat u wil versturen" rows="5" required></textarea>
                        <p class="error-notif"></p>
                    </div>

                    <div>
                        <input type="text" id="vea_password" name="vea_password" style="display:none !important;" tabindex="-1" autocomplete="off">
                    </div>
                    
                    <input type="submit" value="Verstuur uw reactie">
                    <input type="hidden" name="action" value="new_vea_response" />
                </form>
            </div>
            <div class="vea-notices" style="<?php if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_vea_response" ) { echo "display:flex;"; } else { echo "display:none;"; } ?>">
                <i>&check;</i><p>Uw reactie is succesvol verzonden!</p>
            </div>
        </div>
        <div class="right">
            <div class="info bg-white">
                <div class="top">
                    <p><span style="text-transform:capitalize;font-weight:bold;"><?php echo $type; ?></span></p>
                    <p>Aangemeld door:</p>
                    <p><span style="text-transform:capitalize;font-weight:bold;"><?php echo $organisatie; ?></span></p>
                </div>
                <div class="bottom">
                    <p>Aangemeld op: <span style="text-transform:capitalize;font-weight:bold;"><?php echo $date; ?></p>
                    <p>Status: <span style="text-transform:capitalize;font-weight:bold;"><?php echo $status; ?></span></p>
                </div>
                <div class="reactie" style="<?php if ( $status == "gesloten" || $status == 'match' ) { echo 'display:none'; }; ?>">
                    <button id="vea_reactie_btn">Reageren</button>
                </div>
            </div>
        </div>
        
    </div>
</div>

<?php get_footer(); ?>