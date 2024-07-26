<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

if ( class_exists( 'WC_Settings_Page' ) ) {

    class WC_Settings_Smartform extends WC_Settings_Page {

        public function __construct() {
            $this->id    = 'wpc_smartform';
            $this->label = __( 'Smartform Integration', 'wpc-smartform' );

            add_filter( 'woocommerce_settings_tabs_array', array( $this, 'add_settings_page' ), 20 );
            add_action( 'woocommerce_settings_' . $this->id, array( $this, 'output' ) );
            add_action( 'woocommerce_settings_save_' . $this->id, array( $this, 'save' ) );
            add_action( 'woocommerce_sections_' . $this->id, array( $this, 'output_sections' ) );
        }

        public function get_sections() {
            $sections = array(
                ''        => __( 'General', 'wpc-smartform' ),
            );
            return apply_filters( 'woocommerce_get_sections_' . $this->id, $sections );
        }

        public function get_settings( $current_section = '' ) {
            $settings = array();

            $settings[] = array(
                'title' => __( 'Smartform Settings', 'wpc-smartform' ),
                'type'  => 'title',
                'desc'  => __( 'The following options are used to configure the Smartform integration.', 'wpc-smartform' ),
                'id'    => 'wpc_smartform_options',
            );

            $settings[] = array(
                'title'    => __( 'API Key', 'wpc-smartform' ),
                'id'       => 'wpc_smartform_api_key',
                'type'     => 'text',
                'desc'     => __( 'Enter your Smartform API key.', 'wpc-smartform' ),
                'default'  => '',
                'desc_tip' => true,
            );

            $settings[] = array(
                'title'    => __( 'Country', 'wpc-smartform' ),
                'id'       => 'wpc_smartform_country',
                'type'     => 'radio',
                'options'  => array(
                    'CZ' => __( 'Czech Republic', 'wpc-smartform' ),
                    'SK' => __( 'Slovakia', 'wpc-smartform' ),
                ),
                'default'  => 'CZ',
                'desc_tip' => true,
            );

            $settings[] = array( 'type' => 'sectionend', 'id' => 'wpc_smartform_options' );

            return apply_filters( 'woocommerce_get_settings_' . $this->id, $settings, $current_section );
        }
    }

    return new WC_Settings_Smartform();
}
?>
