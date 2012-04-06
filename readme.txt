=== Plugin Name ===
Contributors: EkAndreas
Tags: media, short url, wp-admin
Requires at least: 3.1
Tested up to: 3.2
Stable tag: 1.1

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

Screenshots
1. Option page to choose the tag url/name as http://yourblogurl/tagname/post-id/, Eg http://www.dn.se/m/123123
2. Edit the file and you get some alternative short media urls to copy, click the one you like andcopy with standard CTRL+C or CMD+C
3. Now test the file in your browser
4. The redirect is complete!

== Frequently Asked Questions ==

= What about the Remove www? =

If you host an enviroment that converts the url with or without www you can spare som chars to remove the www from the base urls of short media files.

== Changelog ==

= 1.1 =
* Small bugfixes
* Readme and screenshot updates

= 1.0 =
* A fresh start
