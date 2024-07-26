<?php
if (!class_exists('WPC_Smartform')) {
    class WPC_Smartform
    {
        private static $instance;
        private $prefix = 'wpc-smartform-integration';

        public function __construct()
        {
            add_filter('woocommerce_form_field_args', array($this, 'smartform_classes'), 10, 3);
            add_action('wp_footer', array($this, 'enqueue_smartform_scripts'));
            add_filter('woocommerce_get_settings_pages', array($this, 'add_smartform_settings_tab'));
        }

        public static function get_instance()
        {
            if (self::$instance === null) {
                self::$instance = new self;
            }
            return self::$instance;
        }

        public function smartform_classes($args, $field)
        {
            if ($field == 'billing_postcode') {
                $args['input_class'][] = 'smartform-instance';
                $args['input_class'][] = 'smartform-address-zip';
            }
            if ($field == 'billing_address_1') {
                $args['input_class'][] = 'smartform-instance';
                $args['input_class'][] = 'smartform-address-street-and-number';
            }
            if ($field == 'billing_city') {
                $args['input_class'][] = 'smartform-instance';
                $args['input_class'][] = 'smartform-address-city';
            }
            return $args;
        }

        public function add_smartform_settings_tab($settings)
        {
            $settings[] = include('class-wc-settings-smartform.php');
            return $settings;
        }

        public function enqueue_smartform_scripts()
        {
            if (get_option('wpc_smartform_api_key') && is_checkout()) {
                echo '<script type="text/javascript" src="https://client.smartform.cz/v2/smartform.js" async></script>';
                echo '<script type="text/javascript">';
                echo $this->get_smartform_inline_script();
                echo '</script>';
            }
        }

        private function get_smartform_inline_script()
        {
            $api_client = esc_js(get_option('wpc_smartform_api_key'));
            $country = esc_js(get_option('wpc_smartform_country'));

            $script = "
   var smartform = smartform || {};
   
   smartform.beforeInit = function () {
       smartform.setClientId('{$api_client}');
   }
   
    smartform.afterInit = function () {
        smartform.getInstance('smartform-instance').addressControl.setCountry('{$country}');
    }

            ";
            return $script;
        }
    }
}
?>
