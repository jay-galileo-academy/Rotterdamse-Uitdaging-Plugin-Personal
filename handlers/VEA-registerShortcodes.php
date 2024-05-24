<?php 
/**
 * @package VraagEnAanbod
 */

class VEAregisterShortcodes
{

    function __construct() {
        add_shortcode('registreer-vraag-en-aanbod', [$this, 'vraagEnAanbodForm']);
    }
    
    function vraagEnAanbodForm() {

        ob_start();
        ?>

        <div class="vea-form-wrapper">
            <form id="vea_form" name="vea_form" method="post" action="" enctype="multipart/form-data">
                <div class="vea-inner">
                    <div class="vea-naam-grid">
                        <div class="vnaam-container">
                            <label for="vea_vnaam">Voornaam<span class="vea-verplicht">*</span></label><br />
                            <input type="text" name="vea_vnaam" id="vea_vnaam" placeholder="Voornaam" required>
                            <p class="error-notif"></p>
                        </div>
                        <div class="anaam-container">
                            <label for="vea_anaam">Achternaam<span class="vea-verplicht">*</span></label><br />
                            <input type="text" name="vea_anaam" id="vea_anaam" placeholder="Achternaam" required>
                            <p class="error-notif"></p>
                        </div>                        
                    </div>

                    <div class="organisatie-container">
                        <label for="organisatie">Organisatie<span class="vea-verplicht">*</span></label><br />
                        <input type="text" name="organisatie" id="organisatie" placeholder="Organisatie" required>
                        <p class="error-notif"></p>
                    </div>
                    
                    <div class="email-container">
                        <label for="email">Email<span class="vea-verplicht">*</span></label><br />
                        <input type="email" name="email" id="email" placeholder="Email" required>
                        <p class="error-notif"></p>
                    </div>

                    <div class="phone-container">
                        <label for="telefoonnummer">Telefoonnummer<span class="vea-verplicht">*</span></label><br />
                        <input type="tel" name="telefoonnummer" id="telefoonnummer" placeholder="Telefoonnummer" required>
                        <p class="error-notif"></p>
                    </div>

                    <div id="vea_vraag_aanbod">
                        <p>Heeft u een vraag of aanbod?<span class="vea-verplicht">*</span></p>
                        <input type="radio" id="vraag" name="vraag_aanbod" value="vraag" required>
                        <label for="vraag">Vraag</label><br>
                        <input type="radio" id="aanbod" name="vraag_aanbod" value="aanbod">
                        <label for="aanbod">Aanbod</label><br>
                        <p class="error-notif"></p>
                    </div>

                    <div class="title-container">
                        <label for="korte_zin">Korte zin over vraag/aanbod<span class="vea-verplicht">*</span></label><br />
                        <input type="text" name="korte_zin" id="korte_zin" placeholder="Korte zin over uw vraag/aanbod" maxlength="70" required>
                        <p class="error-notif"></p>
                    </div>

                    <div class="description-container">
                        <label for="description">Beschrijf je vraag/aanbod<span class="vea-verplicht">*</span></label><br />
                        <textarea id="description" tabindex="3" name="description" cols="50" rows="4" placeholder="Beschrijf zo volledig mogelijk je vraag/aanbod. Denk bv aan aantal, datum, afmetingen, etc. Maak het zo specifiek mogelijk!" required></textarea>
                        <p class="error-notif"></p>
                    </div>
                    
                    <div class="vea-hidden" id="vea_tegenprestatie" style="display:none;">
                        <label for="tegenprestatie">Tegenprestatie</label><br />
                        <textarea id="tegenprestatie" tabindex="3" name="tegenprestatie" cols="50" rows="4" placeholder="Denk aan een sympathieke tegenprestatie voor je match. Bijvoorbeeld een lunch, een taart, meedoen met een activiteit of een aardigheidje voor de gever. Iets wat past bij jouw organisatie en activiteiten. Zo maak je geven nog leuker!"></textarea>
                        <p class="error-notif"></p>
                    </div>

                    <div id="vea_categorie_radio">
                        <p>Onder welke categorie valt de vraag/aanbod?<span class="vea-verplicht">*</span></p>
                        <input type="radio" id="handjes" name="vea_categorie" value="handjes" required>
                        <label for="handjes">Handjes</label><br>
                        <input type="radio" id="kennis" name="vea_categorie" value="kennis">
                        <label for="kennis">Kennis</label><br>
                        <input type="radio" id="diensten" name="vea_categorie" value="diensten">
                        <label for="diensten">Diensten</label><br>
                        <input type="radio" id="producten" name="vea_categorie" value="producten">
                        <label for="producten">Producten</label><br>
                        <input type="radio" id="tickets" name="vea_categorie" value="tickets">
                        <label for="tickets">Tickets</label><br>
                        <input type="radio" id="anders" name="vea_categorie" value="anders">
                        <label for="anders">Anders</label><br>
                        <p class="error-notif"></p>
                    </div>

                    <div>
                        <label for="email">Maatschappelijke waarde</label><br />
                        <div class="vea-grid">
                            <span class="vea-euro-indicator">&euro;</span>
                            <input min="0" max="30000" type="number" name="vea_maatschappelijk" id="vea_maatschappelijk">
                        </div>
                    </div>

                    <div>
                        <input type="text" id="vea_password" name="vea_password" style="display:none !important;" tabindex="-1" autocomplete="off">
                    </div>

                    <input type="submit" value="Verzenden" tabindex="6" id="submit" name="submit" />
                    <input type="hidden" name="action" value="new_vea_post" />
                </div>
            </form>
            <div class="vea-notices" style="<?php if ( 'POST' == $_SERVER['REQUEST_METHOD'] && !empty( $_POST['action'] ) &&  $_POST['action'] == "new_vea_post" ) { echo "display:flex;"; } else { echo "display:none;"; } ?>">
                <i>&check;</i><p>Uw <?php if ( isset($_POST['vraag_aanbod']) ) {  echo $_POST['vraag_aanbod']; } else { echo '';} ?> is verstuurd. U ontvangt een mail met meer details over uw <?php if ( isset($_POST['vraag_aanbod']) ) {  echo $_POST['vraag_aanbod']; } else { echo '';} ?></p>
            </div>
        </div>

        <?php
        $output_string = ob_get_contents();
        ob_end_clean();
        return $output_string;
    }

}