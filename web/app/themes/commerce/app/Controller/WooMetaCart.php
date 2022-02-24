<?php
namespace Commerce\Controller;

use WC_Product;

class WooMetaCart {
    public function __construct(){
        add_action( 'wp_ajax_product_set_price', [$this,'set_product_price'] );
        add_action( 'wp_ajax_nopriv_product_set_price', [$this, 'set_product_price'] );

        add_filter('woocommerce_add_cart_item_data',[$this,'custom_add_item_data'],10,3);
        add_filter('woocommerce_get_item_data',[$this,'custom_add_item_meta'],10,2);
        add_action( 'woocommerce_checkout_create_order_line_item', [$this,'custom_add_custom_order_line_item_meta'],10,4 );

        add_action( 'woocommerce_review_order_after_submit', [$this,'add_after_checkout_button'] );

    }

    public function set_product_price(){
        global $post;
        $id = $_POST['product_id'];
        $material = $_POST['material_name'];

        // Get Meta
        $meta_group = get_post_meta($id, 'product_custom_data');
        $arr = array();
        $new_price = null;

        foreach($meta_group as $meta){
            foreach($meta as $key => $val){
                $arr[]= $val;
            }
        }

        foreach ($arr as $key => $val) {
            if($val['material'] === $material){
                $new_price = $val['var_price'];
            }
        }

        update_post_meta( $id, '_price', $new_price );

        wp_send_json( get_post_meta($id, '_price') );
    }

    public function custom_add_item_data($cart_item_data, $product_id, $variation_id){
        if(isset($_REQUEST['material']))
        {
            $cart_item_data['material'] = sanitize_text_field($_REQUEST['material']);
        }

        return $cart_item_data;
    }

    public function custom_add_item_meta($item_data, $cart_item){

        if(array_key_exists('material', $cart_item))
        {
            $custom_details = $cart_item['material'];

            $item_data[] = array(
                'key'   => 'Material',
                'value' => $custom_details
            );
        }

        return $item_data;
    }

    public function custom_add_custom_order_line_item_meta($item, $cart_item_key, $values, $order) {

        if(array_key_exists('material', $values))
        {
            $item->add_meta_data('_material',$values['material']);
        }
    }

    public function add_after_checkout_button() {
        echo '<a href="#" id="send-enquiry" class="button">Send Inquiry</a>';
    }


}