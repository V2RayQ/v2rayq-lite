<?php
/**
 * Plugin Name: V2RayQ Lite
 * Plugin URI: https://www.v2rayq.com/docs/lite
 * Description: V2RayQ Lite generate V2Ray VMess VPN for Wordpress.
 * Version: 1.0.0
 * Author: V2RayQ
 * Author URI: https://www.v2rayq.com/docs/lite
 * Text Domain: v2rayq-lite
 * Requires at least: 5.7
 * Requires PHP: 7.2
 * 
 * @package  V2RayQ_Lite
 */
 
// If this file is called directly, abort!!!
defined( 'ABSPATH' ) or die( 'Hey, what are you doing here? You silly human!' );

// Require once the Composer Autoload
if( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_v2rayq_lite() {
	Inc\Base\Activate::activate();
}
register_activation_hook( __FILE__, 'activate_v2rayq_lite' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_v2rayq_lite() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_v2rayq_lite' );

/**
 * Initialize all the core classes of the plugin
 */
if( class_exists( 'Inc\\Initi' ) ) {
	Inc\Initi::register_service();
}
