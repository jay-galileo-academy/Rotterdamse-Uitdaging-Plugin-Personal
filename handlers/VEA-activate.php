<?php 
/**
 * @package VraagEnAanbod
 */

class VEAactivate
{

    public static function activate() {
        flush_rewrite_rules();
    }
    
}