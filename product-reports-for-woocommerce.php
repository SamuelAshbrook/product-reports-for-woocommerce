<?php

/**
 * 
 * Plugin Name: Product Reports for WooCommerce
 * Description: Effortlessly Export WooCommerce Product Data to CSV with Versatile Filtering Options
 * Version: 1.0.0
 * Requires at least: 5.6
 * Author: Step3 Digital
 * Author URI: https://step3.digital
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: product-reports-for-woocommerce
 * Domain Path: /languages
 * 
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Step3_WC_Report' ) ) {
    class Step3_WC_Report {
        function __construct() {
            $this->define_constants();
            
            // Load classes when plugins are loaded
            add_action( 'plugins_loaded', array( $this, 'step3_load_classes' ) );
            
            // Include necessary files
            $this->step3_includes();

            // Is on admin
            if ( is_admin() ) {
                $this->step3_admin();
            }
        }

        function define_constants() {
            define( 'STEP3_WC_REPORT_PATH', plugin_dir_path( __FILE__ ) ); // Plugin file path
            define( 'STEP3_WC_REPORT_URL', plugin_dir_url( __FILE__ ) ); // Plugin web address
            define( 'STEP3_WC_REPORT_VERSION', '1.0.0' ); // Plugin version
        }

        function step3_load_classes() {
            if ( ! $this->step3_is_woocommerce_activated() ) {
                add_action( 'admin_notices', array ( $this, 'step3_need_woocommerce' ) );
                return;
            }
        }

        function step3_need_woocommerce() {
            $error_message = sprintf(
                /* translators: 1. open anchor tag, 2. close anchor tag, 3. Woo version */
                esc_html__( 'Product Reports for WooCommerce requires %1$sWooCommerce%2$s version %3$s or higher to be installed & activated!' , 'product-reports-for-woocommerce' ),
                '<a href="http://wordpress.org/extend/plugins/woocommerce/">',
                '</a>',
                esc_attr( '3.0.0' )
            );
            
            $message  = '<div class="error">';
            $message .= sprintf( '<p>%s</p>', $error_message );
            $message .= '</div>';
        
            echo wp_kses_post( $message );
        }

        function step3_is_woocommerce_activated() {
            $active_plugins = get_option( 'active_plugins', array() );

             // Check if WooCommerce is active
            if ( in_array( 'woocommerce/woocommerce.php', $active_plugins ) ) {
                return true;
            } else {
                return false;
            }
        }

        function step3_action_links( $links ) {
            // Add links to plugin on plugins page
            $custom_links = array();
            $custom_links[] = '<a href="' . admin_url( 'admin.php?page=step3-wc-report-dashboard' ) . '">' . __( 'Settings', 'product-reports-for-woocommerce' ) . '</a>';
            return array_merge( $custom_links, $links );
        }

        function step3_includes() {
            // Include Core class
            $this->core = require_once( 'includes/admin/class-step3-wc-report-core.php' );
        }

        function step3_admin() {
            add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), array( $this, 'step3_action_links' ) );
        }
    }
}

if ( class_exists( 'Step3_WC_Report' ) ) {
    $step3_wc_report = new Step3_WC_Report();
}