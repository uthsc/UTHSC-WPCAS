<?php

//Stores settings groups, options and defaults for the plugin
class UTHSC_WPCAS_Options {

	function uthsc_wpcas_settings() {

		$settings = array(
				'uthsc-wpcas-configuration' => array (
					'uthsc_wpcas_host'				=> 'auth.uthsc.edu',
					'uthsc_wpcas_user_email'	=> 'email',
					'uthsc_wpcas_first_name'	=> 'firstname',
					'uthsc_wpcas_last_name'		=> 'lastname',
					'uthsc_wpcas_context'			=> '/cas',
					'uthsc_wpcas_cert_path'		=> str_replace( 'admin/','',plugin_dir_path( __FILE__) )  . 'caskey/cacerts_auth.pem',
					'uthsc_wpcas_port'				=> '443',
				),
				'uthsc-wpcas-plugin-options'	=> array (
					'uthsc_wpcas_update_acct'					=> 'off',
					'uthsc_wpcas_lockdown'						=> 'off',
					'uthsc_wpcas_restrict_new_users'	=> 'off'
				)
			);

		return $settings;

	}

}