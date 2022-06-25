<?php
/**
 * @package  V2RayQ_Lite
 */
namespace Inc\Base;

class Activate
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

        if( get_option( 'v2rayq_lite' ) ) {
            //return;
        }else {
            update_option( 'v2rayq_lite', $default );
        }

    }

}