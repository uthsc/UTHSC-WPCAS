UTHSC-WPCAS Test
=========

Description
---

A way to manually test CAS outside of WordPress. If this works for you, then the plugin UTHSC-WPCAS work as well.

Instructions
---
1. Drop this directory in the UTHSC-WPCAS plugin directory (If you downloaded the plugin from GitHub, it should already be there.)
1. Manually edit the hardcoded variables in config.php. These variables are hardcoded to show how they correspond to the options in the plugin.
1. Navigate to authpage.php in a browser and you should be forced to authenticate through CAS. If all of the settings are correct and you are authenticated successfully, you should see the CAS response which you can use to modify the array indexes in the plugin options section if necessary.
1. Once this is working, you can modify the settings in the plugin's options pages to match those in config.php.

Notes
---
These files are slightly modified versions of the ones included files phpCAS library. If you are having trouble getting this to work, check out the phpCAS documentation at https://wiki.jasig.org/display/casc/phpcas
