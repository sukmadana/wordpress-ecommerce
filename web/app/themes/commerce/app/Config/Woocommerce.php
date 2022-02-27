<?php

namespace Commerce\Config;

class Woocommerce{
    public function __construct(){
        add_action( 'after_setup_theme', [$this,'woocommerce_support'] );
        // Disable styling
        if (class_exists('Woocommerce')){
            add_filter( 'woocommerce_enqueue_styles', '__return_empty_array' );
        }
        if(!class_exists('WC_Product_Variable')){
            include(plugin_url.'/woocommerce/includes/class-wc-product-variable.php');// adjust the link
        }

        add_filter( 'woocommerce_defer_transactional_emails', '__return_true' );

        add_filter( 'woocommerce_add_to_cart_validation', [$this,'only_one_items_allowed_add_to_cart'], 10, 3 );
        add_filter( 'woocommerce_update_cart_validation', [$this,'only_one_items_allowed_cart_update'], 10, 4 );

        add_action( 'phpmailer_init', [$this,'send_smtp_email'] );
    }
    

    public function woocommerce_support(){
        add_theme_support( 'woocommerce');
        add_theme_support( 'wc-product-gallery-zoom' );
        // add_theme_support( 'wc-product-gallery-lightbox' );
        add_theme_support( 'wc-product-gallery-slider' );
    }

    public function woocommerce_theme_support(){
        // Image Size
        add_theme_support( 'woocommerce', 
            array(
                'thumbnail_image_width' => 380,
                'single_image_width'    => 1024,
            )
        );

        // Product Grid
        add_theme_support( 'woocommerce',array(
            'product_grid'          => array(
                    'default_rows'    => 4,
                    'min_rows'        => 2,
                    'max_rows'        => 4,
                    'default_columns' => 6,
                    'min_columns'     => 1,
                    'max_columns'     => 6,
                ),
            )
        );
        
    }

    public function only_one_items_allowed_add_to_cart( $passed, $product_id, $quantity ) {

        $cart_items_count = WC()->cart->get_cart_contents_count();
        $total_count = $cart_items_count + $quantity;
    
        if( $cart_items_count >= 1 || $total_count > 1 ){
            $passed = false;
            wc_add_notice( __( "You can’t have more than 1 item in cart", "woocommerce" ), "error" );
        }
        return $passed;
    }

    public function only_one_items_allowed_cart_update( $passed, $cart_item_key, $values, $updated_quantity ) {

        $cart_items_count = WC()->cart->get_cart_contents_count();
        $original_quantity = $values['quantity'];
        $total_count = $cart_items_count - $original_quantity + $updated_quantity;
    
        if( $cart_items_count > 1 || $total_count > 1 ){
            $passed = false;
            wc_add_notice( __( "You can’t have more than 1 item in cart", "woocommerce" ), "error" );
        }
        return $passed;
    }

    public function send_smtp_email( $phpmailer ) {
        $phpmailer->isSMTP();
        $phpmailer->Host       = SMTP_HOST;
        $phpmailer->SMTPAuth   = true;
        $phpmailer->Port       = SMTP_PORT;
        $phpmailer->Username   = SMTP_USERNAME;
        $phpmailer->Password   = SMTP_PASSWORD;
        $phpmailer->From       = SMTP_FROM;
        $phpmailer->FromName   = SMTP_FROMNAME;
    }
}