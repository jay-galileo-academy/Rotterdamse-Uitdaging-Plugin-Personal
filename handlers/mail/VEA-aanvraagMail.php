<?php 
/**
 * @package VraagEnAanbod
 */

class VEAaanvraagMail
{ 

    public function aanvraagBody($type, $naam, $bedrijf, $email, $telefoonnummer, $bericht, $categorie, $waarde, $tegenprestatie) {

        if ( isset($tegenprestatie) && $tegenprestatie != "" ) {
            $new_tegenprestatie = 'Tegenprestatie: </br>' . $tegenprestatie;
        } else {
            $new_tegenprestatie = '';
        }

        $body = "
        <body>
            <table cellspacing='0' cellpadding='0' border='0' role='presentation' width='600' align='center' class='main-table'>
            <tr>
                <td>
                    <h1 class='text-centered'>Er is een $type geplaatst op <a href='https://www.rotterdamseuitdaging.nl/'>Rotterdamse Uitdaging</a>.</h1>
                </td>
            </tr>
            <tr>
                <td height='3' style='width:100%;background:#05415E;'>
                </td>
            </tr>
            <tr>
                <td>
                    <h2>Gegevens:</h2>
                    <p><strong>Type:</strong> <span style='text-transform:capitalize;'>$type</span><br/>
                    <strong>Naam:</strong> $naam<br/>
                    <strong>Organisatie:</strong> $bedrijf<br/>
                    <strong>E-mailadres:</strong> $email<br/>
                    <strong>Tel:</strong> $telefoonnummer</p>
                    <p><strong>Bericht:</strong> <br/>$bericht</p>
                    <p><strong>Tegenprestatie:</strong> <br/>$tegenprestatie</p>
                    <p><strong>Categorie:</strong> <span style='text-transform:capitalize;'>$categorie</span><br/>
                    <strong>Maatschappelijke waarde:</strong> $waarde</p>
                </td>
            </tr>
            </table>
        </body>
        ";

        return $body;
    }
}