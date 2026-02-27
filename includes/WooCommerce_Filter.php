<?php

namespace MagicExtraFieldLight;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

/**
 * WooCommerce filter handler class
 */
class WooCommerce_Filter {
    /**
     * Constructor
     */
    public function __construct() {
        add_action('init', [$this, 'init']);
        add_action('save_post_magic_ef_builder', [$this, 'delete_builder_cache']);
        add_action('delete_post', [$this, 'delete_builder_cache']);
    }

    /**
     * Initialize filters
     */
    public function init() {
        add_action('woocommerce_before_add_to_cart_button', [$this, 'before_add_to_cart_button']);
        add_filter('woocommerce_add_to_cart_validation', [$this, 'validate_custom_text_input'], 10, 3);
        add_filter('woocommerce_add_cart_item_data', [$this, 'save_custom_text_to_cart'], 10, 3);
        add_filter('woocommerce_get_item_data', [$this, 'display_custom_text_in_cart'], 10, 2);
        add_action('woocommerce_checkout_create_order_line_item', [$this, 'save_custom_text_to_order'], 10, 4);
       // add_filter('woocommerce_order_item_meta_end', [$this, 'display_custom_text_in_order'], 10, 4);
        add_action( 'woocommerce_before_calculate_totals', [$this, 'before_calculate_totals'], 10 );
    }

    /**
     * Display custom field before add to cart button
     */
    public function before_add_to_cart_button() {
        $builder_id = $this->should_display_field();
        if (class_exists('\Elementor\Plugin') && $builder_id) {
            $elementor_instance = \Elementor\Plugin::instance();
            $elementor_content = $elementor_instance->frontend->get_builder_content_for_display($builder_id);
            
            if (!empty($elementor_content)) {
                echo wp_kses($elementor_content, magic_extra_field_light_allow_html());
                wp_nonce_field('magic_extra_field_action', 'magic_extra_field_nonce');
            }
        }
    }

    /**
     * Validate custom text input before adding to cart
     */
    public function validate_custom_text_input($passed, $product_id, $quantity) {
        $fields = $this->get_field_name_by_product_id($product_id);
        $data = WC()->cart->get_cart();
        if(!empty($data) && !empty($fields)){
            foreach($data as $key => $item){
                foreach($fields as $field){
                    if($field['required'] === 'yes' && isset($item[$field['name']]) && empty($item[$field['name']])){
                        wc_add_notice(sprintf(
                            /* translators: %s: field name */
                            esc_html__('Please enter %s before adding to cart.', 'magic-extra-field-light'),
                            $field['name']
                        ), 'error');
                        return false;
                    }
                }
            }
        }
        return $passed;
    }

    /**
     * Save custom text to cart item data
     */
    public function save_custom_text_to_cart($cart_item_data, $product_id, $variation_id) {
        if (!isset($_POST['magic_extra_field_nonce']) || !wp_verify_nonce(sanitize_text_field(wp_unslash($_POST['magic_extra_field_nonce'])), 'magic_extra_field_action')) {
            return $cart_item_data;
        }
        
        $fields = $this->get_field_name_by_product_id($product_id);
        foreach ($fields as $field) {
            if (!empty($_POST[$field['name']])) {
                $custom_text = is_array($_POST[$field['name']]) 
                    ? implode(',', array_map('sanitize_text_field', wp_unslash($_POST[$field['name']])))
                    : sanitize_text_field(wp_unslash($_POST[$field['name']]));
                if (isset($_POST[$field['name'] . 'quantity'])) {
                    $cart_item_data[$field['name'] . 'quantity'] = absint(wp_unslash($_POST[$field['name'] . 'quantity']));
                }
                if (isset($_POST[$field['name'] . 'price'])) {
                    $cart_item_data[$field['name'] . 'price'] = sanitize_text_field(wp_unslash($_POST[$field['name'] . 'price']));
                }
                $cart_item_data[$field['name']] = $custom_text;
            }
        }
        return $cart_item_data;
    }

    /**
     * Display custom text in cart
     */
    public function display_custom_text_in_cart($item_data, $cart_item) {
        $fields = $this->get_field_name_by_product_id($cart_item['product_id']);
        foreach ($fields as $field) {
            if (isset($cart_item[$field['name']]) && !empty($cart_item[$field['name']])) {
                $display_price = isset($cart_item[$field['name'].'price']) ? $cart_item[$field['name'].'price'] : '';
                $display_quantity = isset($cart_item[$field['name'].'quantity']) ? $cart_item[$field['name'].'quantity'] : '';
                if($display_price != '' && $display_quantity != ''){
                    $display = $cart_item[$field['name']].' + '.$display_price.' x '.$display_quantity;
                }else{
                    $display = $cart_item[$field['name']];
                }
                $item_data[] = [
                    'name'  => esc_html($field['label']),
                    'value' => esc_html($display),
                ];

            }
        }
        return $item_data;
    }

    /**
     * Save custom text to order meta
     */
    public function save_custom_text_to_order($item, $cart_item_key, $values, $order) {
            $fields = $this->get_field_name_by_product_id($values['product_id']);
            foreach ($fields as $field) {
                if (!empty($values[$field['name']])) {
                    $item->add_meta_data(esc_html($field['label']), $values[$field['name']]);
                }
        }
    }

    /**
     * Display custom text in order details
     */
    public function display_custom_text_in_order($item_id, $item, $order, $plain_text) {
        $fields = $this->get_field_name_by_product_id($item['product_id']);
        foreach ($fields as $field) {
            if (!empty($item[$field['name']])) {
                $output = sprintf(
                    '<p><strong>%s</strong> %s</p>',
                    esc_html($field['label']),
                    esc_html($item[$field['name']])
                );
                echo wp_kses($output, array(
                    'p' => array(),
                    'strong' => array()
                ));
            }
        }
    }
    /**
     * Get field name by product ID
     *
     * @param int $product_id Product ID
     * @return array Array of field data
     * @since 1.0.0
     */
    public function get_field_name_by_product_id( $product_id ) {
        // Validate product ID
        $product_id = absint( $product_id );
        if ( ! $product_id ) {
            return array();
        }

        // Get field ID - this should probably come from product meta or settings
        $field_id = $this->should_display_field($product_id);
        
        // Get Elementor data
        $field_data = get_post_meta( $field_id, '_elementor_data', true );
        if ( empty( $field_data ) ) {
            return array();
        }

        // Decode JSON safely
        $data = json_decode( $field_data, true );
        if ( json_last_error() !== JSON_ERROR_NONE ) {
            return array();
        }

        $result = [];

        // Parse Elementor data
        if ( ! empty( $data ) && is_array( $data ) ) {
            foreach ( $data as $container ) {
                if ( ! isset( $container['elements'] ) || ! is_array( $container['elements'] ) ) {
                    continue;
                }
                foreach ( $container['elements'] as $element ) {
                    if ( ! isset( $element['widgetType'] )) {
                        continue;
                    }
                    $result[] = [
                        'name' => isset($element['settings']['field_name']) ? sanitize_text_field($element['settings']['field_name']) : '',
                        'label' => isset($element['settings']['field_label']) ? sanitize_text_field($element['settings']['field_label']) : (isset($element['settings']['field_name']) ? sanitize_text_field($element['settings']['field_name']) : ''),
                        'required' => $element['settings']['required'] ?? false
                    ];
                }
            }
        }

        return apply_filters( 'magic_extra_field_light_data', $result, $product_id );
    }

    /**
     * Delete builder cache when a builder post is saved or deleted
     */
    public function delete_builder_cache() {
        delete_transient('magic_ef_builder_ids');
    }

    /**
     * Get builder IDs with transient caching
     */
    public function get_builder_id() {
        $cached_builder_ids = get_transient('magic_ef_builder_ids');
        
        if (false !== $cached_builder_ids) {
            return $cached_builder_ids;
        }

        $args = [
            'post_type' => 'magic_ef_builder',
            'post_status' => 'publish',
            'posts_per_page' => -1, // Get all posts
            'fields' => 'ids',
            'meta_query' => [
                [
                    'key' => '_magic_ef_is_active',
                    'value' => '1', 
                    'compare' => '='
                ]
            ]
        ];

        $posts = get_posts($args);
        $builder_ids = !empty($posts) ? $posts : [];

        set_transient('magic_ef_builder_ids', $builder_ids, HOUR_IN_SECONDS);

        return $builder_ids;
    }

    public function should_display_field( $product_id = '') {
        $builder_ids = $this->get_builder_id();
        if(empty($builder_ids)){
            return false;
        }
        if($product_id == ''){
            global $product;
            $product_id = $product->get_id();
        }
        if($product_id == ''){
            return false;
        }

        foreach ($builder_ids as $builder_id) {
            $field_data = get_post_meta($builder_id, '_magic_ef_display_type', true);
            if($field_data === 'all'){
                return $builder_id;
            }
            if($field_data === 'specific'){
                $selected_products = get_post_meta($builder_id, '_magic_ef_selected_products', true);
                if(in_array($product_id, $selected_products)){
                    return $builder_id;
                }
            }
            if($field_data === 'taxonomy'){
                $selected_taxonomy = get_post_meta($builder_id, '_magic_ef_selected_taxonomy', true);
                $selected_terms = get_post_meta($builder_id, '_magic_ef_selected_terms', true);
                
                // Get product terms for the selected taxonomy
                $product_terms = wp_get_post_terms($product_id, $selected_taxonomy, array('fields' => 'ids'));
                
                // Check if product has any of the selected terms
                if (!empty($product_terms) && !is_wp_error($product_terms)) {
                    foreach ($product_terms as $term_id) {
                        if (in_array($term_id, (array)$selected_terms)) {
                            return $builder_id;
                        }
                    }
                }
                
            }
        }
        return false;
    } 
    public function before_calculate_totals($cart) {
        if ( is_admin() && ! defined( 'DOING_AJAX' ) ){
            return;
        }
      // Check to ensure action is only performed once
      if (did_action('woocommerce_before_calculate_totals') >= 2) {
        return;
      }
        $custom_price = [];
        if (is_object($cart)) {
            foreach ($cart->get_cart() as $cart_item_key => $cart_item) {
                // Get product ID from cart item
                $product_id = $cart_item['product_id'];
                $fields = $this->get_field_name_by_product_id($product_id);
                if(!empty($fields)){
                    foreach($fields as $field){
                        if(isset($cart_item[$field['name'].'price'])){
                            $framed_price = $cart_item[$field['name'].'price'];
                            $quantity = isset($cart_item[$field['name'].'quantity']) ? $cart_item[$field['name'].'quantity'] : 1;
                            $custom_price[] = (int) $framed_price * (int) $quantity;
                        }
                    }
                }
            }
        }
        if(!empty($custom_price)){
            $total_custom_price = array_sum($custom_price);
            foreach ( $cart->get_cart() as $item ) {
                $item['data']->set_price( $item['data']->get_price() + $total_custom_price );
            }
        }
    }
}