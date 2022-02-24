<?php
namespace Commerce\Controller;

use WC_Product_Variation;

class VariationMetaBox {
    public function __construct(){
        add_action('admin_init', [$this,'commerce_add_meta_boxes'], 2);

        add_action('woocommerce_process_product_meta', [$this,'custom_repeatable_meta_box_save']);

    }

    public function commerce_add_meta_boxes() {
        add_meta_box( 'commerce_variation', 'Product Variations', [$this,'Repeatable_meta_box_display'], 'product', 'normal', 'core');
    }

    public function Repeatable_meta_box_display() {
        global $post;

        $product = wc_get_product($post->ID);
        $meta_group = get_post_meta($post->ID, 'product_custom_data', true);
        
        wp_nonce_field( 'commerce_repeatable_meta_box_nonce', 'commerce_repeatable_meta_box_nonce' );

        $args = array(
            'hide_empty' => false
        );

        $material = get_terms( 'product_material', $args );

        ?>
        <script type="text/javascript">
        jQuery(document).ready(function( $ ){
            $( '#add-row' ).on('click', function() {
                var row = $( '.empty-row.screen-reader-text' ).clone(true);
                
                row.removeClass( 'empty-row screen-reader-text' );
                row.addClass('table-row');
                row.find('.price').attr('name', 'var_price[]');
                row.find('.material').attr('name', 'material[]');
                row.insertBefore( '#repeatable-fieldset-one .after-data' );
                console.log('object');
                return false;
            });
    
            $( '.remove-row' ).on('click', function() {
                $(this).parents('.table-row').remove();
                return false;
            });
        });
        </script>
        <table id="repeatable-fieldset-one" width="100%">
        <tbody>
        <?php
            if ( $meta_group ) :
            foreach ( $meta_group as $field ) {
        ?>
        <tr class="table-row" style="padding-bottom: 20px;">
                <td style="padding-bottom: 40px;"> 
                    <table width="100%" class="table-form">
                        <tr style="padding-bottom: 20px;">
                            <td><label for="">Price</label></td>
                            <td> <input type="number" step="1000"  value="<?= $field['var_price'] != '' ? $field['var_price'] : '' ?>" placeholder="Price (Required)" class="short price" name="var_price[]"  /></td>
                        </tr>
                        <tr style="padding-bottom: 20px;">
                            <td><label for="">Material</label></td>
                            <td>
                            <select name="material[]" id="" class="select short material" style="width: 40%;">
                                <?php foreach($material as $mtr):?>
                                <option value="<?= $mtr->name ?>" <?= $field['material'] == $mtr->name ? 'selected' : '' ?> ><?= $mtr->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            </td>
                        </tr>
                    </table>
                </td>
                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
        <?php
            }
            else :
            // show a blank one
            ?>
            
            <?php endif; ?>
        
            <!-- empty hidden one for jQuery -->
            <tr class="empty-row screen-reader-text" style="padding-bottom: 20px;">
                <td style="padding-bottom: 40px;"> 
                    <table width="100%" class="table-form">
                        <tr style="padding-bottom: 20px;">
                            <td><label for="">Price</label></td>
                            <td> <input type="number" value="0" step="1000"  placeholder="Price (Required)" class="short price" name="_var_price[]"  /></td>
                        </tr>
                        <tr style="padding-bottom: 20px;">
                            <td><label for="">Material</label></td>
                            <td>
                            <select name="_material[]" id="" class="select short material" style="width: 40%;">
                                <?php foreach($material as $mtr):?>
                                <option value="<?= $mtr->name ?>"><?= $mtr->name ?></option>
                                <?php endforeach; ?>
                            </select>
                            </td>
                        </tr>
                    </table>
                </td>
                <td><a class="button remove-row" href="#">Remove</a></td>
            </tr>
            <tr class="after-data">
                <td colspan="2"></td>
            </tr>
            </tbody>
        </table>
        <p><a id="add-row" class="button" href="#">Add another</a></p>
        <?php
    }

    public function custom_repeatable_meta_box_save($post_id) {
        if ( ! isset( $_POST['commerce_repeatable_meta_box_nonce'] ) ||
        ! wp_verify_nonce( $_POST['commerce_repeatable_meta_box_nonce'], 'commerce_repeatable_meta_box_nonce' ) )
            return;
    
        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
            return;
    
        if (!current_user_can('edit_post', $post_id))
            return;

        $old = get_post_meta($post_id, 'product_custom_data', true);
        $new = array();
        $prices = $_POST['var_price'];
        $material = $_POST['material'];
        $count = count($prices);

        for ( $i = 0; $i < $count; $i++ ) {
            if ( $prices[$i] != '' ) :
                $new[$i]['var_price'] = stripslashes( $prices[$i] );
                $new[$i]['material'] = stripslashes( $material[$i] );
            endif;
        }
        if ( !empty( $new ) && $new != $old )
            update_post_meta( $post_id, 'product_custom_data', $new );
        elseif ( empty($new) && $old )
            delete_post_meta( $post_id, 'product_custom_data', $old );

    }
}