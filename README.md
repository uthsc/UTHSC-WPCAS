UTHSC WPCAS
=========

Contributors: gpspake  
Donate Link: http://uthsc.edu  
Tags: cas, authentication, central authentication service, phpCAS  
Requires at least: 3.0.1  
Tested up to: 4.3.1  
Stable tag: 1.0.1  
License: GPLv3  
License URI: http://www.gnu.org/licenses/gpl-3.0.html


Description
---

A plugin that uses the phpCAS library to integrate CAS with Wordpress.

Features
---

* Provide users with a familiar secure login on multiple WordPress sites without the need for additional expensive ssl certificates.
* phpCAS configuration settings can be set in the plugin options
* Login screen redirects to CAS url specified in options
* New user accounts will be created for users who have not logged in to the site yet
* User attributes returned by CAS can be used to populate new user account details such as email address and display name.
* Service urls can be captured to redirect users to the same page on log in/out. (Logoutwithredirectservice must be enabled on CAS server for log out redirects to work.)


Installation
---

Note: UTHSC WPCAS is meant to provide anyone already using CAS, and preferably phpCAS, a way to integrate it in to WordPress.
Some tweaks to your CAS server configuration may be necessary to take advantage of all of the CAS features. 
So, while most of the settings can be changed in the admin panel, it's not necessarily an out-of-the-box plugin.

Warning: UTHSC-WPCAS overrides WordPress authentication so you will not be able to log in normally once it is activated.
Make sure to keep a separate session open during configuration and testing so you can de-activate the plugin when necessary. 

1. Upload `uthsc-wpcas` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Place your certificate(s) in uthsc-wpcas/cas-keys directory (There's a sample already that can be deleted)
1. Modify configuration settings in the uthsc-wpcas options page


Frequently Asked Questions    
---

####Why was this plugin developed?

This plugin was developed for UTHSC because we wanted to integrate CAS in to WordPress and there weren't any existing, actively maintained, that worked for us.
As we were working on it, we decided the WordPress community needed a go-to CAS plugin that works for everyone; that's what we want UTHSC-WPCAS to be.

####Why did you use the phpCAS lirary?

phpCAS,by JASIG, is the standard, vetted, php library for CAS, so rewriting it from scratch would be counterproductive.  
It also makes the plugin easier to configure.

####Will this work with our version of CAS?

This should work with CAS 3.4 and later.

####Will it work with multisite?

We've tested the plugin with and without multisite and it seems to work in both cases.

####How should I know what my settings should be?

Chances are, if you've downloaded this plugin you're already using CAS and, hopefully, you're using phpCAS.
So, most of these settings should look pretty familiar. If you're having trouble, check the phpCAS documentation or let us know in the support section.

####How do I install phpCAS?

CAS is a php library and it's included with this plugin so you don't need to install anything.
for more information about phpCAS, visit https://wiki.jasig.org/display/casc/phpcas


####The plugin is working but new user account attributes are blank or incorrect.

You may want to test CAS outside of WordPress first to make sure everything works and you're getting attributes back. For more information about testing and to download some example files from phpCAS, go to https://github.com/uthsc/UTHSC-WPCAS/tree/master/test

If you aren't getting attributes back, you'll probably need to make some adjustments to your CAS server. Check the Cas documentation at https://wiki.jasig.org/display/casum/attributes for more information about attributes and getting them to work.  
If you are getting attributes back and they are being applied to new user accounts incorrectly, it's probably just a matter of how the cas response is being parsed by the plugin.  

Right now, it is based on the response we get but it may be different for pther users. You can change the array indexes in the plugin settings if they are different from the defaults but if your response is completely incompatible, let us know and we'll consider updating the plugin to accept more formats.

####How can I contribute to this plugin?

We'll be managing the project at https://github.com/uthsc/UTHSC-WPCAS and would love your feedback.
UTHSC WPCAS was developed to work with UTHSC's configuration but we want it to work for as many people as possible;
If you have ideas for features or improvements, let us know or submit a pull request.


Changelog
---
1.0.1 -  
Made method static to resolve error

1.0 -  
Tested with WordPress version 4.3.1

0.2.2 -  
Fixed format issue with first name value  
Changed menu position to avoid conflicts with other plugins.

0.2.1 -  
Updated option names to avoid potential conflicts  
  
0.2 -  
Initial release

Testing
---

Since UTHSC-WPCAS uses phpCAS, you should be able to refer phpCAS documentation at https://wiki.jasig.org/display/casc/phpcas for most CAS related issues.  
You can also checkout the UTHSC-WPCAS test directory at https://github.com/uthsc/UTHSC-WPCAS/tree/master/test that includes some instructions and is hardcoded with variables that correspond to the default plugin options.


Special thanks
---

David R. Poindexter III and Indiana University - During the development of this plugin, IU-WPCAS was one of the only CAS plugins for WordPress and provided a good bit of inspiration.

Todd Barber and Billy Barnet @ UTHSC for all of their patience, support and good advice
