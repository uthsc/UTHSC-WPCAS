<?php
/**
 * Plugin Name: UTHSC WPCAS
 * Plugin URI: https://github.com/uthsc/uthsc-wpcas
 * Description: A plugin that uses phpCAS to integrate CAS with WordPress.
 * Author: George Spake - UTHSC
 * Version: 1.0
 * Author URI: http://uthsc.edu/
 * License: GPLv3
*/

/*
A plugin that uses phpCAS to integrate CAS with WordPress.

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/

//To Do:
//Lockdown option to restrict users who aren't authenticated
//Update user info if cas response doesn't match user account
//Restrict access to users who already have WordPress accounts (WP Accounts must be entered manually before users can Authenticate with CAS)


//Checks if the plugin class has already been defined. If not, it defines it here.
//This is to avoid class name conflicts within WordPress and plugins.
if ( !class_exists('UTHSCWPCAS') ) {

	class UTHSCWPCAS {

		public function __construct() {
			
			add_action('login_init',array($this, 'bypass_login'));
			
			
			//Hook into WordPress authentication system
			$this -> wp_cas_authentication_hooks();

			//Register settings
			add_action('admin_init', array($this, 'register_wpcas_settings'));

			//Add options to admin menu
			if (is_admin()) {
				include_once('admin/uthsc-wpcas-about.php');
				include_once('admin/uthsc-wpcas-settings.php');
				include_once('admin/uthsc-wpcas-test.php');
				add_action('admin_menu', array($this, 'add_options_pages'));
			}

			//activation hooks
			if (isset($_GET['activate']) and $_GET['activate'] == 'true') {
				add_action('init', array(&$this, 'activate'));
			}
			
			if ( get_option( 'uthsc_wpcas_host' ) ) {
				//Initialize phpCAS
				$this->initialize_phpCAS();
			}

			//Get wpcas options
			require_once('admin/uthsc-wpcas-options.php');
		}

		function wp_cas_authentication_hooks(){
			//add_action('init', array('UTHSCWPCAS', 'lock_down_check'));
			add_filter('authenticate', array('UTHSCWPCAS', 'authenticate'), 10, 3);
			add_action('wp_logout', array('UTHSCWPCAS', 'logout'));
			add_action('lost_password', array('UTHSCWPCAS', 'disable_function'));
			add_action('retrieve_password', array('UTHSCWPCAS', 'disable_function'));
			add_action('password_reset', array('UTHSCWPCAS', 'disable_function'));
			add_filter('show_password_fields', array('UTHSCWPCAS', 'show_password_fields'));
			add_action('check_passwords', array('UTHSCWPCAS', 'check_passwords'), 10, 3);
			add_filter('wp_signon', array('UTHSCWPCAS', 'authenticate'),10,3);
			add_filter('login_url', array('UTHSCWPCAS', 'wpcas_login_url'),10,3);
		}

		//Register settings in lib/wpcas-options.php
		public function register_wpcas_settings() {
			$wpcas_options = new UTHSC_WPCAS_Options;

			foreach ( $wpcas_options->uthsc_wpcas_settings() as $group => $options) {
				foreach ($options as $option => $default){
					register_setting($group, $option);
				}
			}
		}

		//Update settings in lib/wpcas-options.php
		public static function activate() {
			$wpcas_options = new UTHSC_WPCAS_Options;
			
			foreach ( $wpcas_options->uthsc_wpcas_settings() as $group => $options) {
				foreach ($options as $option => $default){
					update_option($option, $default);
				}
			}
		}

		//Unregister settings in lib/wpcas-options.php
		public static function deactivate() {
			$wpcas_options = new UTHSC_WPCAS_Options;
			
			foreach ( $wpcas_options->uthsc_wpcas_settings() as $group => $options) {
				foreach ($options as $option => $default){
					update_option($option, '');
					unregister_setting($group, $option);
				}
			}
		}

		//Delete settings in lib/wpcas-options.php
		public static function uninstall() {
			$wpcas_options = new UTHSC_WPCAS_Options;
			
			foreach ( $wpcas_options->uthsc_wpcas_settings() as $group => $options) {
				foreach ($options as $option => $default){
					delete_option($option);
				}
			}
		}

		function add_options_pages() {
			$icon = plugin_dir_url( __FILE__ ).'img/cas-logo.png';

			add_menu_page('UTHSC WP CAS', 'UTHSC WP CAS', 'administrator', 'uthsc-wpcas-settings', 'uthsc_wpcas_preferences', $icon, '98.9');
			add_submenu_page('uthsc-wpcas-settings', 'CAS Test', 'CAS Test', 'administrator', 'uthsc-wpcas-test', 'uthsc_wpcas_test');
			add_submenu_page('uthsc-wpcas-settings', 'About', 'About', 'administrator', 'uthsc-wpcas-about', 'uthsc_wpcas_about');		
		}

		function bypass_login(){
			if ( ! phpCAS::isAuthenticated() ) {
				if ($_GET['redirect_to']) {
					$redirect = wp_login_url( $_GET['redirect_to'] );
				} else {
					$redirect = wp_login_url(); //TO DO: Add default redirect?
				}
				header( 'Location: ' . $redirect );
			}
		}

		static function wpcas_login_url($redirect = '', $force_reauth = false) {
			$login_url = site_url('wp-login.php', 'login');
		
			if ( !empty($redirect) ) {

				if (get_permalink()){
					$redirect = get_permalink();
				} else {
				 	$redirect = $login_url;
				}
					$login_url = add_query_arg('redirect_to', urlencode($redirect), $login_url);

			}

			return 'https://'. get_option('uthsc_wpcas_host') . get_option('uthsc_wpcas_context') . '/login?service='. $login_url;

		}

		function initialize_phpCAS() {

			//This comes from phpCAS's authpage.php example but instead of using the options from config.php we get the wordpress options that are set in the plugin admin section.
			//If you want to test CAS to see if it's working, you can use the authpage.php included in the plugin directory.

			// Load the settings from the central config file
			//require_once 'config.php';
			
			// Load the CAS lib
			require_once 'phpCAS-1.3-stable/CAS.php';
			
			// Initialize phpCAS
			phpCAS::client(SAML_VERSION_1_1, get_option('uthsc_wpcas_host'),intval(get_option('uthsc_wpcas_port')), get_option('uthsc_wpcas_context'));
			
			// For production use set the CA certificate that is the issuer of the cert
			// on the CAS server and uncomment the line below
			phpCAS::setCasServerCACert(get_option('uthsc_wpcas_cert_path'));

			// For quick testing you can disable SSL validation of the CAS server.
			// THIS SETTING IS NOT RECOMMENDED FOR PRODUCTION.
			// VALIDATING THE CAS SERVER IS CRUCIAL TO THE SECURITY OF THE CAS PROTOCOL!
			//phpCAS::setNoCasServerValidation();

			// Handle SAML logout requests that emanate from the CAS host exclusively.
			// Failure to restrict SAML logout requests to authorized hosts could
			// allow denial of service attacks where at the least the server is
			// tied up parsing bogus XML messages.
			phpCAS::handleLogoutRequests(true, array('cas-real-1.example.com', 'cas-real-2.example.com'));

			// Uncomment to enable debugging		
			//phpCAS::setDebug( dirname( __FILE__ ) . "/" );

		}

		function authenticate($login_url) {

			if ( phpCAS::isAuthenticated() ) {

				$cas_user = phpCAS::getUser();
				$cas_attributes = phpCAS::getAttributes();

				//This is based on the CAS reponse; it may be different for your configuration.
				//To test, you can use var_dump($cas_attributes)
				$userdata = array (
				'user_login'		=>	$cas_user,
				'last_name'		=>	$cas_attributes[get_option('uthsc_wpcas_last_name')],
				'first_name'		=>	is_array( $cas_attributes[get_option('uthsc_wpcas_first_name')] ) ? $cas_attributes[get_option('uthsc_wpcas_first_name')]['1'] : $cas_attributes[get_option('uthsc_wpcas_first_name')],
				'user_email'		=>	$cas_attributes[get_option('uthsc_wpcas_user_email')]
				);

				//If the user hasn't logged in to Wordpress before, create an account with the Attributes returned by cas
				if ( !get_user_by( 'login', $cas_user ) ) {
					wp_insert_user( $userdata );
				}

				return get_user_by( 'login', $cas_attributes['uid'] );

			} else {
				
				//trim reauth from service url to prevent users from being redirected back to WP login screen after logging in.
	 			if ( preg_match("/&reauth=1/", $login_url) ) {
				  $login_url = rtrim($login_url,'&reauth=1');
				}

				//return the login url
				return 'https://'. get_option('uthsc_wpcas_host') . get_option('uthsc_wpcas_context') . '/login?service='. $login_url;				
				
			}

		}

		//Custom logout function to bypass WordPress default logout and provide a custom redirect target (needs work).
		function logout(){

			wp_set_current_user(0);
			wp_clear_auth_cookie();

			if ($_GET['action']=='logout') {
				if ($_GET['redirect_to']) {
					phpCAS::logoutWithRedirectService($_GET['redirect_to']);
				} else {
					phpCAS::logoutWithRedirectService(site_url());
				}
			}

			exit();
		}

		//Disables display of password fields in the user profile page.
		//We don't use WP authentication, so we don't need to worry about any WP-specific passwords.
		function show_password_fields( $show_password_fields ) {
			return false;
		}

		//Utility function to disable WP behaviors.
		function disable_function() {
			die('Disabled');
		}
	}
}

register_activation_hook( __FILE__, array( 'UTHSCWPCAS', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'UTHSCWPCAS', 'deactivate' ) );
register_uninstall_hook( __FILE__, array( 'UTHSCWPCAS', 'uninstall' ) );

//Load plugin
$uthscwpcas = new UTHSCWPCAS();
