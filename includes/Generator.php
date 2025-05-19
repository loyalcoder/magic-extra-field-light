<?php

namespace MagicExtraFieldLight;
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
/**
 * Generator class
 * 
 * @description: Extended CPTs is a library which provides extended functionality to WordPress custom post types and taxonomies. 
 * This allows developers to quickly build post types and taxonomies without having to write the same code again and again.
 * 
 * @api https://github.com/johnbillion/extended-cpts
 */
use MagicExtraFieldLight\Traits\Product_Data;
class Generator
{
    use Product_Data;

    /**
     * Class initialize
     */
    public function __construct()
    {
        add_action('init', [$this, 'register_post_type']);
        //add_action('add_meta_boxes', [$this, 'add_display_options_meta_box']);
        add_filter('post_row_actions', [$this, 'remove_bulk_actions'], 10, 2);
        add_filter('manage_magic_ef_builder_posts_columns', [$this, 'add_custom_columns']);
        add_action('manage_magic_ef_builder_posts_custom_column', [$this, 'populate_custom_columns'], 10, 2);
        // Add hooks to clear product cache
        add_action('save_post_product', [$this, 'clear_products_cache']);
        add_action('deleted_post', [$this, 'clear_products_cache']);
        add_action('woocommerce_update_product', [$this, 'clear_products_cache']);
    }

    /**
     * Register custom post type for magic extra field builder
     */
    public function register_post_type()
    {
        $builder = register_post_type('magic_ef_builder', [
            'public' => true,
            'show_in_feed' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'elementor'],
            'has_archive' => true,
            'labels' => [
                'name' => esc_html__('Magic EF Builders', 'magic-extra-field-light'),
                'singular_name' => esc_html__('Magic EF Builder', 'magic-extra-field-light'),
                'add_new' => esc_html__('Add New Builder', 'magic-extra-field-light'),
                'add_new_item' => esc_html__('Add New Builder', 'magic-extra-field-light'),
                'edit_item' => esc_html__('Edit Builder', 'magic-extra-field-light'),
                'new_item' => esc_html__('New Builder', 'magic-extra-field-light'),
                'view_item' => esc_html__('View Builder', 'magic-extra-field-light'),
                'search_items' => esc_html__('Search Builders', 'magic-extra-field-light'),
                'not_found' => esc_html__('No builders found', 'magic-extra-field-light'),
                'not_found_in_trash' => esc_html__('No builders found in Trash', 'magic-extra-field-light'),
            ],
            'menu_icon' => 'dashicons-admin-customizer',
            'rewrite' => [
                'slug' => 'magic-ef-builder'
            ]
        ]);

        // Add custom columns to builder post type
        

        // Populate custom columns
    }
    public function add_custom_columns($columns) {
        $new_columns = array();
        foreach($columns as $key => $value) {
            if ($key === 'date') {
                $new_columns['display_type'] = esc_html__('Display Type', 'magic-extra-field-light');
                $new_columns['display_on'] = esc_html__('Display On', 'magic-extra-field-light');
                $new_columns['settings'] = esc_html__('Settings', 'magic-extra-field-light');
            }
            $new_columns[$key] = $value;
        }
        return $new_columns;
    }
    public function populate_custom_columns($column, $post_id) {
        switch($column) {
            case 'display_type':
                $display_type = get_post_meta($post_id, '_magic_ef_display_type', true);
                $types = array(
                    'all' => esc_html__('All Products', 'magic-extra-field-light'),
                    'specific' => esc_html__('Specific Products', 'magic-extra-field-light'),
                    'taxonomy' => esc_html__('By Taxonomy', 'magic-extra-field-light')
                );
                $display_type = isset($types[$display_type]) ? $types[$display_type] : esc_html__('Unknown', 'magic-extra-field-light');
                echo esc_html($display_type);
                break;

            case 'display_on':
                $display_type = get_post_meta($post_id, '_magic_ef_display_type', true);
                if ($display_type === 'specific') {
                    $products = get_post_meta($post_id, '_magic_ef_selected_products', true);
                    $products = is_array($products) ? $products : array();
                    $text = count($products) > 0 ? count($products) . ' ' . esc_html__('Products', 'magic-extra-field-light') : esc_html__('No Products', 'magic-extra-field-light');
                    echo esc_html($text);
                } elseif ($display_type === 'taxonomy') {
                    $taxonomy = get_post_meta($post_id, '_magic_ef_selected_taxonomy', true);
                    $taxonomy_name = ucfirst(str_replace('product_', '', $taxonomy));
                    echo esc_html($taxonomy_name);
                } else {
                    echo esc_html__('All Products', 'magic-extra-field-light');
                }
                break;

            case 'settings':
                printf(
                    '<button type="button" class="button magic-ef-settings-btn" data-id="%d">%s</button>',
                    esc_attr($post_id),
                    esc_html__('Edit Settings', 'magic-extra-field-light')
                );
                break;
        }
    }
    public function remove_bulk_actions($actions, $post) {
        if ($post->post_type === 'magic_ef_builder') {
            unset($actions['edit']);
            unset($actions['inline hide-if-no-js']);
        }
        return $actions;
    }
}
