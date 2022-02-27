<?php
namespace Commerce\Controller;

use WC_Product;

class WooMetaCart {
    public function __construct(){
        add_action( 'wp_ajax_product_set_price', [$this,'set_product_price'] );
        add_action( 'wp_ajax_nopriv_product_set_price', [$this, 'set_product_price'] );

        add_action( 'wp_ajax_send_inquiry_data', [$this,'send_inquiry_data'] );
        add_action( 'wp_ajax_nopriv_send_inquiry_data', [$this, 'send_inquiry_data'] );

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

    public function send_inquiry_data(){
        $billing_first_name = $_POST['billing_first_name'];
        $billing_last_name = $_POST['billing_last_name'];
        $billing_company = $_POST['billing_company'];
        $billing_country = $_POST['billing_country'];
        $billing_address_1 = $_POST['billing_address_1'];
        $billing_address_2 = $_POST['billing_address_2'];
        $billing_city = $_POST['billing_city'];
        $billing_state = $_POST['billing_state'];
        $billing_postcode = $_POST['billing_postcode'];
        $billing_phone = $_POST['billing_phone'];
        $billing_email = $_POST['billing_email'];

        $cart_data = array();
        $cart = WC()->cart->get_cart();

        foreach ($cart as $cart_item_key => $cart_item) {
            $_product = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
            $cart_data['product_name'] = $_product->get_name();
            $cart_data['material'] = $cart_item['material'];
        }

        $email = get_option( 'admin_email' );

        $data = array(
            'first_name' => $billing_first_name,
            'last_name' => $billing_last_name,          
            'company' => $billing_company,          
            'country' => $billing_country,          
            'addres_1' => $billing_address_1,           
            'address_2' => $billing_address_2,            
            'city' => $billing_city,       
            'state' => $billing_state,        
            'postcode' => $billing_postcode,           
            'phone' => $billing_phone,        
            'email' => $billing_email,
            'product' => $cart_data
        );

        $send = wp_mail($email, "Product Inquiry", $this->email_template($data));

        wp_send_json($send);
    }

    public function email_template($data){
        $template = 'Name '. $data['first_name'] . ' ' . $data['last_name'];
        $template .= ', Email = ' . $data['email'];
        $template .= ', Phone = ' . $data['phone'];
        $template .= ', Product Name = ' .$data['product']['product_name'];
        $template .= ', Material = ' .$data['product']['material'];

        return $template;
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
        echo '<div class="enquiry-button relative inline-block"><span class="sp-circle"></span><span id="send-enquiry" class="button-secondary">Send Inquiry</span></div><div class="ajax-notification"></div>';
    }


}