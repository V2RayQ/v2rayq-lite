<?php 
/**
 * @package  V2RayQ
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseControl;

class AdminCallback extends BaseControl
{
	public function adminDashboard()
	{
		return require_once( "$this->plugin_path/templates/admin.php" );
	} 

	public function v2rayqOptionsGroup( $input )
	{
		return $input;
	} 

	public function v2rayqDomainName()
	{
		$value = esc_attr( get_option( 'v2rayq_lite_domain' ) );
		echo '<input type="text" class="regular-text" name="v2rayq_lite_domain" value="' 
		      . $value . '" placeholder="like: v2.v2rayq.com">';
	}  

}