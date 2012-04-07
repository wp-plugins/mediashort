=== Plugin Name ===
Contributors: EkAndreas
Tags: media, short url, wp-admin
Requires at least: 3.1
Tested up to: 3.3.1
Stable tag: 1.2

Gives a shorter url to media links in your media library.

== Description ==

Adds a custom url rewrite to media files and expose these in the Media Library in WP-Admin.
You can set your own unique tag-url to the media files and the MediaShort will listen to the ID of the image and redirect your visitors to the real url for the specific media file.

Please use Twitter <a href="http://twitter.com/ekandreas" target="new">@ekandreas</a> for contact regarding this plugin!


== Installation ==

How to install the plugin and get it working.

1. Upload `mediashort` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure and make the function active via the option page under WP-Admin/Settings/MediaShort
4. Make sure your site supports redirects as standard permalinks via .htaccess

== Screenshots ==
1. Option page to choose the tag url/name as http://yourblogurl/tagname/post-id/, Eg http://www.amek.se/m/123123
2. Edit the file and you get some alternative short media urls to copy, click the one you like andcopy with standard CTRL+C or CMD+C

== Frequently Asked Questions ==

= Tell me more about the settings parameter "Is active" =
It will redirect the URLs and make a flush to the rewrite rules in WordPress when activate and deactivate.

= Tell me more about the settings parameter "Base URL replacement" =
It will replace the standard URL in case you have a host environment that allowes differential access, eg, http://amek.se is the same as http://www.amek.se
Insert the whole URL with http://

= Tell me more about the settings parameter "Short URL tag" =
It's the tag that is included in the WordPress rewrite rules and makes a call to the MediaShort redirect.

= Tell me more about the settings parameter "Transfer mode" =
Redirect means the URL will transform to the File URL given in the Media Library.
Rewrite will not touch the MediaShort URL and persist the address for the visitors using the URL.

= Tell me more about the settings parameter "Show link type..." =
The alternatives will show in the Media Library Dialog and all of them will work as a substitute to the File URL.

== Changelog ==

= 1.2 =
* Replace base url in options
* Use of distributed content as rewrite instead of redirect
* Choose type of urls presented in the media library dialog

= 1.1 =
* Small bugfixes
* Readme and screenshot updates

= 1.0 =
* A fresh start
