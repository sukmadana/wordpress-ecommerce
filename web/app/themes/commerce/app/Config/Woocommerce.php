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
}