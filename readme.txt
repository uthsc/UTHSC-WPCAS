=== UTHSC WPCAS ===
Contributors: gpspake
Donate Link: http://uthsc.edu
Tags: cas, authentication, central authentication service, phpCAS
Requires at least: 3.0.1
Tested up to: 4.3.1
Stable tag: 1.0.1
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Integrate Central Authentication Service (CAS) with WordPress

== Description ==

This plugin uses the phpCAS library to integrate CAS single sign on with Wordpress.

*	Provide users with a familiar secure login on multiple WordPress sites without the need for additional expensive ssl certificates.
*	phpCAS configuration settings can be set in the plugin options 
*	Login screen redirects to CAS url specified in options  
*	New user accounts will be created for users who have not logged in to the site yet  
*	User attributes returned by CAS can be used to populate new user account details such as email address and display name.  
*	Service urls can be captured to redirect users to the same page on log in/out. (Logoutwithredirectservice must be enabled on CAS server for log out redirects to work.)

== Installation ==

Note: UTHSC WPCAS is meant to provide anyone already using CAS, and preferably phpCAS, a way to integrate it in to WordPress.
Some tweaks to your CAS server configuration may be necessary to take advantage of all of the CAS features. 
So, while most of the settings can be changed in the admin panel, it's not necessarily an out-of-the-box plugin.

Warning: UTHSC-WPCAS overrides WordPress authentication so you will not be able to log in normally once it is activated.
Make sure to keep a separate session open during configuration and testing so you can de-activate the plugin if necessary. 

1. Upload `uthsc-wpcas` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place your certificate(s) in uthsc-wpcas/cas-keys directory (Replace the existing sample)
1. Modify configuration settings in the uthsc-wpcas options page

== Frequently Asked Questions ==

= Why was this plugin developed? =

This plugin was developed for UTHSC because there weren't any existing plugins, being actively maintained, that took full advantage of CAS.
SSL certificates are expensive and CAS single sign on prevents the need for multiple certs and provides users with a familiar login experience.
We realized the WordPress community needed a go-to CAS plugin so this is a starting point.

= Why did you use the phpCAS lirary? =

phpCAS is the standard, vetted, php library for CAS, so rewriting it from scratch would be counterproductive.
It also makes the plugin easier to configure.

= Will this work with our version of CAS? =

This should work with CAS 3.4 and later. It's possible that it will work with earlier versions but we haven't tried.

= Will it work with Multisite? =

We've tested the plugin with and without multisite and it works great either way.

= How should I know what my settings should be? = 

The plugin comes with all settings prepopulated with defaults for UTHSC.
Chances are, if you've downloaded this plugin you're already using CAS and hopefully phpCAS so most of these settings should look pretty familiar. 
If you're having trouble, check the phpCAS documentation or let us know in the support section.

= The plugin is working but new user account attributes are blank or incorrect. = 

You may want to test CAS outside of WordPress first to make sure everything works and you're getting attributes back. For more information about testing and to download some example files from phpCAS, go to https://github.com/uthsc/UTHSC-WPCAS/tree/master/test

If you aren't getting attributes back, you'll probably need to make some adjustments to your CAS server. Check the CAS documentation at https://wiki.jasig.org/display/casum/attributes for more information about attributes and getting them to work.

If you are getting attributes back and they are being applied to new user accounts incorrectly, it's probably just a matter of how the CAS response is being parsed by the plugin.

Right now, it is based on the response we get but it may be different for other users. You can change the array indexes in the plugin settings if they are different from the defaults but if your response is completely incompatible, let us know and we'll consider updating the plugin to accept more formats.

= How can I contribute to this plugin? =

We'll be managing the project through Github and would love your feedback.
UTHSC WPCAS was developed to work with UTHSC's configuration but we want it to work for as many people as possible;
If you have ideas for features or improvements, let us know or submit a pull request.

== Screenshots ==

1. Profile page of a user after logging in with UTHSC-WPCAS. Password fields are hidden and Name fields are populated by the attributes returned by CAS.
2. Test page in UTHSC-WPCAS settings. The test page provides session info and lists information about the current user. Manual test files are available in the plugin's test directory.

== Changelog ==

= 1.0.1 =
Made method static to resolve error

= 1.0 =
Tested with WordPress version 4.3.1

= 0.2.2 =
Fixed format issue with first name value
Changed menu position to avoid conflicts with other plugins.

= 0.2.1 =
Updated option names to avoid potential conflicts

= 0.2 =
Initial release

== Upgrade Notice ==

= 0.2.2 =

== Special thanks ==

David R. Poindexter III and Indiana University - During the development of this plugin, IU-WPCAS was one of the only CAS plugins for WordPress and provided a good bit of inspiration. Clearly, our plugin's name is completely original.

Todd Barber and Billy Barnet @ UTHSC for all of their patience, support and good advice
