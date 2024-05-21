<?php 
/**
 * @package VraagEnAanbod
 */

class VEAresponseMail
{

    public function responseMailBody($type, $naam, $bericht, $email, $bedrijf, $response_naam, $post_url, $response_telefoonnummer) {
        $body = "
        <body>
            <table cellspacing='0' cellpadding='0' border='0' role='presentation' width='600' align='center' class='main-table'>
            <tr>
                <td>
                    <h1 class='text-centered'>Iemand heeft gereageerd op uw $type!</h1>
                </td>
            </tr>
            <tr>
                <td height='3' style='width:100%;background:#05415E;'>
                </td>
            </tr>
            <tr>
                <td>
                    <p>Beste $naam,</p>
                    <p>Iemand heeft een nieuwe reactie geplaatst op uw aanbod bij de <a href='$post_url' target='_blank'>Rotterdamse Uitdaging</a>. Hier onder kunt u de details van de reactie bekijken.</p>
                </td>
            </tr>
            <tr>
                <td>
                    <p><strong>Reactie:</strong></p>
                    <p>$bericht</p>
                    <p><strong>Contactgegevens:</strong></p>
                    <p>Naam: $response_naam</br>Email: <a href='mailto:$email'>$email</a><br/>Bedrijf: $bedrijf<br/>Telefoonnummer: $response_telefoonnummer</p>
                </td>
            </tr>
            </table>
        </body>
        ";

        return $body;
    }
}