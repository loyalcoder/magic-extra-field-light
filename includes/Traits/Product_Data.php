<?php 
namespace MagicExtraFieldLight\Traits;
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

trait Product_Data {

    /**
     * Get cached products or query if cache is empty
     *
     * @return array WC_Product objects
     */
    public function get_cached_products() {
        $products = get_transient('magic_ef_products_cache');
        
        if (false === $products) {
            $args = array(
                'post_type'      => 'product',
                'posts_per_page' => -1,
                'orderby'        => 'title',
                'order'          => 'ASC',
                'post_status'    => 'publish'
            );
            
            $products = wc_get_products($args);
            
            // Cache for 12 hours
            set_transient('magic_ef_products_cache', $products, 12 * HOUR_IN_SECONDS);
        }

        return $products;
    }

    /**
     * Clear products transient cache
     */
    public function clear_products_cache() {
        delete_transient('magic_ef_products_cache');
    }

    /**
     * Get products by taxonomy
     *
     * @param string $taxonomy Taxonomy name
     * @param array $terms Array of term IDs
     * @return array WC_Product objects
     */
    public function get_products_by_taxonomy($taxonomy, $terms) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'tax_query'      => array(
                array(
                    'taxonomy' => $taxonomy,
                    'field'    => 'term_id',
                    'terms'    => $terms,
                ),
            ),
        );

        return wc_get_products($args);
    }

    /**
     * Get products by IDs
     * 
     * @param array $product_ids Array of product IDs
     * @return array WC_Product objects
     */
    public function get_products_by_ids($product_ids) {
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'post__in'       => $product_ids,
            'orderby'        => 'post__in',
        );

        return wc_get_products($args);
    }

    /**
     * Get product categories
     *
     * @param array $args Optional. Arguments to get categories
     * @return array WP_Term objects
     */
    public function get_product_categories($args = []) {
        $default_args = array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
        );
        
        $args = wp_parse_args($args, $default_args);
        
        return get_terms($args);
    }

    /**
     * Get product tags
     *
     * @param array $args Optional. Arguments to get tags
     * @return array WP_Term objects
     */
    public function get_product_tags($args = []) {
        $default_args = array(
            'taxonomy'   => 'product_tag',
            'hide_empty' => false,
        );
        
        $args = wp_parse_args($args, $default_args);
        
        return get_terms($args);
    }

}
