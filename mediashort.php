<?php
/*
Plugin Name: MediaShort
Plugin URI: http://wordpress.org/extend/plugins/medaishort/
Description: Adds a shorter url to media files in WordPress via WP-admin
Version: 1.2
Author: EkAndreas, Hypernode AB
Author URI: http://hypernode.se
License: GPLv2
*/

load_plugin_textdomain( 'mediashort', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

include_once "includes/ms_mediaview.class.php";
include_once "includes/ms_rewrite.class.php";
include_once "includes/ms_settings.class.php";




?>