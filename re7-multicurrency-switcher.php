<?php
/*
Plugin Name: RE7 Multi-Currency
Description: Multi-currency support for Real Estate 7 theme with admin-configurable currencies and a frontend switcher.
Version: 1.0
Author: Jiksdi
*/

if ( ! defined( 'ABSPATH' ) ) exit;

define( 'RE7MC_PATH', plugin_dir_path( __FILE__ ) );

// Load shared functions
require_once RE7MC_PATH . 'includes/common.php';

// Admin
if ( is_admin() ) {
    require_once RE7MC_PATH . 'admin/settings.php';
}

// Public
require_once RE7MC_PATH . 'public/functions.php';
require_once RE7MC_PATH . 'public/shortcodes.php';
