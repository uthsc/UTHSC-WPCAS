<?php

//Stores settings groups, options and defaults for the plugin
class UTHSC_WPCAS_Options {

	function wpcas_settings() {

		$settings = array(
				'uthsc-wpcas-configuration' => array (
					'wpcas_host'				=> 'auth.uthsc.edu',
					'wpcas_user_email'	=> 'email',
					'wpcas_first_name'	=> 'firstname',
					'wpcas_last_name'		=> 'lastname',
					'wpcas_context'			=> '/cas',
					'wpcas_cert_path'		=> str_replace( 'admin/','',plugin_dir_path( __FILE__) )  . 'caskey/cacerts_auth.pem',
					'wpcas_port'				=> '443',
				),
				'uthsc-wpcas-plugin-options'	=> array (
					'wpcas_update_acct'					=> 'off',
					'wpcas_lockdown'						=> 'off',
					'wpcas_restrict_new_users'	=> 'off'
				)
			);

		return $settings;

	}

}