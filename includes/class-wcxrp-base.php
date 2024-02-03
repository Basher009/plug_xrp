<?php

if(!class_exists('WC_Payment_XRP')) {
    /**
     * WooCommerce XRPL Payment main class
     *
     * @since 1.1.0
     */
    class WC_Payment_XRP
    {
        /**
         * Single instance of the class
         *
         * @var WC_Payment_XRP
         * @since 1.0.0
         */
        protected static $instance;

        /**
         * XRP Payment gateway id
         *
         * @var string Id of specific gateway
         * @since 1.0
         */
        public static $gateway_id = 'WC_Gateway_XRP';

        /**
         * The gateway object
         *
         * @var WC_Payment_XRP
         * @since 1.0
         */
        public $gateway = null;

        /**
         * Returns single instance of the class
         *
         * @return WC_Payment_XRP
         * @since 1.0.0
         */
        public static function get_instance()
        {
            if (is_null(self::$instance)) {
                self::$instance = new self;
            }

            return self::$instance;
        }

        /**
         * Constructor.
         *
         * @return WC_Payment_XRP
         * @since 1.1.0
         */
        public function __construct()
        {
            /* add filter to append wallet as payment gateway */
            include_once('class-wcxrp-webhooks.php');
            include_once('class-wcxrp-rates.php');
            include_once('class-wcxrp-helpers.php');
            include_once('class-wcxrp-ledger.php');

            $this->helpers = new WCXRP_Helpers();

            add_filter(
                'woocommerce_payment_gateways',
                [$this, 'add_to_gateways']
            );


          add_action( 'woocommerce_product_data_tabs', array ($this,'xrp_create_product_tab_link') );
          add_action( 'woocommerce_product_data_panels', array ($this, 'xrp_show_product_tab_link_content')  );
          add_action( 'woocommerce_process_product_meta', array ($this, 'xrp_save_product_tab_data'), 10, 1 );
          add_action( 'after_wcfm_products_manage_meta_save',array($this, 'xrp_save_product_tab_data_2') , 80 , 2);

         // add_filter( 'woocommerce_get_price_html', 'crypto_algo_change_product_price_display', 20, 2 );
          add_action( 'woocommerce_get_price_html', 'xrp_algo_change_product_price_display', 22, 3 );

        }


    
        public function xrp_change_product_price_display($price_html, $product ) {
            $options = get_option('woocommerce_xrp_settings');
         
              $ledger = new WCXRP_Ledger(
                     $options['xrp_node'],
                     $options['xrp_bypass']
                 );
              $rates = new WCXRP_Rates(
                     $ledger,
                     $options['xrp_account'],
                     'usd'
                 );
              
               $rate = $rates->get_rate(
                     $options['exchange'],
                     $options
                 );
               
                 $xrp = round(ceil(( $product->get_price() / $rate) * 1000000) / 1000000, 6);
         
         //  $gateway_Settings = get_cryptoalgo_gateway_settings();
         //
         //  if(is_product_can_be_buy_with_crypto_algo($product)){
         //
         //    if( $product->is_type( 'variable' ) ) {
         //      $min = $product->get_variation_regular_price('min');
         //      $max = $product->get_variation_regular_price('max');
         //      $DGL_price_min  =   get_exchange_rate_of_given_assest($min, $gateway_Settings['assest']);
         //      $DGL_price_max  =   get_exchange_rate_of_given_assest($max, $gateway_Settings['assest']);
         //      $DGL_price_min  =   number_format($DGL_price_min['price'],5, '.', '');
         //      $DGL_price_max  =   number_format($DGL_price_max['price'],5, '.', '');
         //
         //      $price_h  =  get_crypto_algo_price_range_html($DGL_price_min, $DGL_price_max, $gateway_Settings['unit']);
         //
         //
         //      if($gateway_Settings['algo_enabled']  == "yes"){
         //
         //        $Algo_price_min  =   get_exchange_rate_of_given_assest($min, 0);
         //        $Algo_price_max  =   get_exchange_rate_of_given_assest($max, 0);
         //        $Algo_price_min  =   number_format($Algo_price_min['price'],5, '.', '');
         //        $Algo_price_max  =   number_format($Algo_price_max['price'],5, '.', '');
         //
         //        $price_h  .= "<br>".get_crypto_algo_price_range_html($Algo_price_min, $Algo_price_max, '$Algo');
         //      }
         //
         //    }else{
         //      
         //      $amount = $product->get_price();
         //      $DGL_price  =   get_exchange_rate_of_given_assest($amount, $gateway_Settings['assest']);
         //      
         //
         //      $price_h  = get_crypto_algo_price_html($DGL_price['price'], $gateway_Settings['unit']);
         //      if($gateway_Settings['algo_enabled']  == "yes"){
         //       $Algo_price  =   get_exchange_rate_of_given_assest($amount, 0);
         //      $price_h  .= "<br>".get_crypto_algo_price_html($Algo_price['price'], '$Algo');
         //      }
         //
         //
         //    }
         //
         //
             $price_html .=  "<br>"."XRP $xrp";
         //  }
           
           return $price_html ;
         }

public function xrp_create_product_tab_link($tabs) {
    $tabs['xrp_tab'] = array(
        'label' => 'xrp Settings',
        'target' => 'xrp_tab_options',
        'class' => array(),
        'priority' => 65,
    );
    return $tabs;
}

    public function xrp_show_product_tab_link_content() {
    global $woocommerce, $post;
    ?>
    <div id="xrp_tab_options" class="panel woocommerce_options_panel">
        <?php

            woocommerce_wp_checkbox( array(
                'id'            => '_xrp_product',
                'wrapper_class' => 'show_if_simple2',
                'label'         =>  __( 'Accept '.$this->assest_unit.' At Checkout', 'xrp' ),
                'description'   =>  __( 'This will restrict the payment Gatway for this product.', 'xrp' ),
                'desc_tip'   =>  __( 'This will restrict the payment Gatway for this product.', 'xrp' ),
                'default'       => 'no'
            ) );

            woocommerce_wp_checkbox( array(
                'id'            => '_xrp_force',
                'wrapper_class' => 'show_if_simple2',
                'label'         =>  __( 'Force xrp Payment', 'xrp' ),
                'description'   =>  __( 'When this option is enabled customer can only pay with xrp.', 'xrp' ),
                'desc_tip'   =>  __( 'When this option is enabled customer can only pay with xrp.', 'xrp' ),
                'default'       => 'no'
            ) );

        ?>
    </div>
    <?php
}


function xrp_save_product_tab_data($product_id){

    //   echo "<pre>";
    //   print_r($_POST);
    //   echo "<pre>";
    //  die();
    $keys = array(
        '_xrp_product',
        '_xrp_force',
    );
    
    foreach ($keys as $key) {

          $value = (isset( $_POST[$key] ) && $_POST[$key] == 'yes' ) ? 'yes' : 'no';
          update_post_meta($product_id, $key,$value); 

        
    }
}

function xrp_save_product_tab_data_2($product_id, $form_data){

    //   echo "<pre>";
    //   print_r($_POST);
    //   echo "<pre>";
    //  die();
    $keys = array(
        '_xrp_product',
        '_xrp_force',
    );
    
    foreach ($keys as $key) {

          $value = (isset( $form_data[$key] ) && $form_data[$key] == 'yes' ) ? 'yes' : 'no';
          update_post_meta($product_id, $key,$value); 

        
    }
}

        /**
         * Adds XRP Payment Gateway to payment gateways available for woocommerce checkout
         *
         * @param $methods array Previously available gataways, to filter with the function
         *
         * @return array New list of available gateways
         * @since 1.0.0
         */
        public function add_to_gateways($methods)
        {
            self::$gateway_id = apply_filters(
                'wc_xrp_gateway_id',
                self::$gateway_id
            );
            include_once('class-wcxrp-gateway.php');
            $methods[] = 'WC_Gateway_XRP';
            return $methods;
        }
    }
}
