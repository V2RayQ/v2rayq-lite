<?php
/**
 * @package  V2RayQ_Lite
 */
namespace Inc\Base;

use Inc\Base\BaseControl;

class SettingsLinks extends BaseControl
{
	public function register() 
	{
		add_filter( "plugin_action_links_$this->plugin", array( $this, 'settings_link' ) );
	}

	public function settings_link( $links ) 
	{
		$settings_link = '<a href="admin.php?page=v2rayq_lite">Settings</a>';
		array_push( $links, $settings_link );
		return $links;
	}
}