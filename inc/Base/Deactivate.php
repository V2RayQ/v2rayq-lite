<?php
/**
 * @package  V2RayQ_Lite
 */
namespace Inc\Base;

class Deactivate
{
	public static function deactivate() {
		flush_rewrite_rules(); 
	}
}