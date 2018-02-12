<?php
/**
 * Plugin Name: Hide Default WooCommerce Category
 * Description: Hides the new uncategorized / default category in WooCommerce.
 * Author: Caleb Burks
 * Author URI: https://calebburks.com
 * Version: 1.0.0
 * License: GPLv2 or later
 * WC tested up to: 3.3
 * WC requires at least: 3.3
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'Hide_Default_WooCommerce_Category' ) ) :

/**
 * Main class.
 */
class Hide_Default_WooCommerce_Category {

	/**
	 * Instance of this class.
	 *
	 * @var object
	 */
	protected static $instance = null;

	/**
	 * Initialize the plugin.
	 */
	private function __construct() {
		if ( defined( 'WC_VERSION' ) && version_compare( WC_VERSION, '3.3', '>=' ) ) {
			$this->hooks();
		}
	}

	/**
	 * Return an instance of this class.
	 *
	 * @return object A single instance of this class.
	 */
	public static function get_instance() {
		// If the single instance hasn't been set, set it now.
		if ( null == self::$instance ) {
			self::$instance = new self;
		}

		return self::$instance;
	}

	/**
	 * Includes.
	 */
	public function hooks() {
		// Remove category from main shop page.
		add_filter( 'woocommerce_product_subcategories_args', array( $this, 'hide_from_main_loop' ) );
	}

	public function hide_from_main_loop( $args ) {
		if ( false !== get_option( 'default_product_cat' ) ) {
			$args['exclude'] = get_option( 'default_product_cat' );
		}

		return $args;
	}

}

add_action( 'plugins_loaded', array( 'Hide_Default_WooCommerce_Category', 'get_instance' ) );

endif; // class_exists()