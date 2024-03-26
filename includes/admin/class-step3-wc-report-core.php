<?php
/**
 * Product Reports for WooCommerce - Core Class
 *
 * @version 1.0.0
 * @since   1.0.0
 * @author  Step3 Digital
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( ! class_exists( 'Step3_WC_Report_Core' ) ) {

    class Step3_WC_Report_Core {
        
        function __construct() {
            
            add_action( 'admin_menu', array( $this, 'add_dashboard_page' ), PHP_INT_MAX );

        }

        /**
         * Add submenu item.
         *
         * @version 1.0.0
         * @since   1.0.0
         */
        function add_dashboard_page() {
            add_submenu_page(
                'woocommerce',
                __( 'Step3 Product Report', 'product-reports-for-woocommerce' ),
                __( 'Step3 Product Report', 'product-reports-for-woocommerce' ),
                'manage_woocommerce',
                'step3-wc-report-dashboard',
                array( $this, 'create_dashboard_page' )
            );
        
        }

        /**
         * Dashboard page content.
         *
         * @version 1.0.0
         * @since   1.0.0
         */
        function create_dashboard_page() { ?>
            <div class="wrap woocommerce">
                <nav class="nav-tab-wrapper woo-nav-tab-wrapper">
                    <a href="<?php echo esc_url( admin_url( 'admin.php?page=alg-wc-export-tools' ) ); ?>" class="nav-tab nav-tab-active">
                        <?php _e( 'Dashboard', 'product-reports-for-woocommerce' ); ?>
                    </a>
                </nav>
                <h1 class="screen-reader-text"><?php _e( 'Dashboard', 'product-reports-for-woocommerce' ); ?></h1>
                <h2><?php _e( 'Export Products', 'product-reports-for-woocommerce' ); ?></h2>
                <p>This plugin is a <strong>work in progress</strong>. The options to edit the export data will be added soon.</p>
                <a href="#" class= "button-primary">Export CSV</a>
            </div>
        <?php }

    }

}

return new Step3_WC_Report_Core();