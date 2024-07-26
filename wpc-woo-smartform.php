<?php
/**
 * Plugin Name: WPC Smartform Integration
 * Plugin URI: https://github.com/kosarlukascz/wpc-smartform
 * Description: Integrates Smartform.cz into WooCommerce checkout.
 * Version: 1.0.0
 * Author: Lukáš Kosař
 * Author URI: https://github.com/kosarlukascz
 * License: GPL2
 * WC requires at least: 5.0
 * WC tested up to: 8.5.0
 */

include_once('includes/wpc-woocommerce-smartform.php');

add_action( 'plugins_loaded', function() {
    WPC_Smartform::get_instance();
});
