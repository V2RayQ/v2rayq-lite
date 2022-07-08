<?php 
/**
 * @package  V2RayQ
 */
namespace Inc\Pages;

use Inc\Api\SettingApi;
use Inc\Base\BaseControl;
use Inc\Api\Callbacks\AdminCallback; 

/**
* 
*/
class Administrator extends BaseControl
{
	public $settings;

	public $callbacks; 

	public $pages = array();

	public $subpages = array();

	public function register() 
	{
		$this->settings = new SettingApi();

		$this->callbacks = new AdminCallback(); 

		$this->setPages(); 

		$this->setSettings();
		$this->setSections();
		$this->setFields();

		$this->settings->addPages( $this->pages )->register();
	}

	public function setPages() 
	{
		$this->pages = array(
			array(
				'page_title' => 'V2RayQ Lite', 
				'menu_title' => __('V2RayQ Lite', 'v2rayq-lite'), 
				'capability' => 'manage_options', 
				'menu_slug' => 'v2rayq_lite', 
				'callback' => array( $this->callbacks, 'adminDashboard' ), 
				'icon_url' => 'dashicons-privacy', 
				'position' => 111
			)
		);
	}

 

	public function setSettings()
	{
		$args = array( 
			array(
				'option_group' => 'v2rayq_lite_settings',
				'option_name' => 'v2rayq_lite_domain' 
			) 
		);

		$this->settings->setSettings( $args );
	}

	public function setSections()
	{
		$args = array(
			array(
				'id' => 'v2rayq_admin_index',
				'title' => __('Input Your domain below, and the A record should point to this server IP.', 'v2rayq-lite'), 
				'page' => 'v2rayq_lite'
			) 
		);

		$this->settings->setSections( $args );
	}

	public function setFields()
	{
		$args = array(  
			array(
				'id' => 'v2rayq_lite_domain',
				'title' => __('VMess Domain Name', 'v2rayq-lite'),
				'callback' => array( $this->callbacks, 'v2rayqDomainName' ),
				'page' => 'v2rayq_lite',
				'section' => 'v2rayq_admin_index',
				'args' => array(
					'label_for' => 'v2rayq_lite_domain',
					'class' => 'v2class'
				)
			) 
		); 

		$this->settings->setFields( $args );
	}
}