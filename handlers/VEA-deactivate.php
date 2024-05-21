<?php 
/**
 * @package VraagEnAanbod
 */

class VEAdeactivate
{

    public static function deactivate() {
        flush_rewrite_rules();
    }

}