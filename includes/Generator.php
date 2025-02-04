<?php

namespace MagicExtraField;

/**
 * Generator class
 * 
 * @description: Extended CPTs is a library which provides extended functionality to WordPress custom post types and taxonomies. 
 * This allows developers to quickly build post types and taxonomies without having to write the same code again and again.
 * 
 * @api https://github.com/johnbillion/extended-cpts
 */
class Generator
{
    /**
     * Transient key for products cache
     */
    const PRODUCTS_CACHE_KEY = 'magic_ef_products_cache';

    /**
     * Class initialize
     */
    function __construct()
    {
        add_action('init', [$this, 'init_generator']);
        add_action('add_meta_boxes', [$this, 'add_display_options_meta_box']);
        add_action('save_post_magic_ef_builder', [$this, 'save_display_options']);

        // Add hooks to clear product cache
        add_action('save_post_product', [$this, 'clear_products_cache']);
        add_action('deleted_post', [$this, 'clear_products_cache']);
        add_action('woocommerce_update_product', [$this, 'clear_products_cache']);
    }

    /**
     * Clear products transient cache
     */
    public function clear_products_cache() {
        delete_transient(self::PRODUCTS_CACHE_KEY);
    }

    /**
     * Get cached products or query if cache is empty
     */
    private function get_cached_products() {
        $products = get_transient(self::PRODUCTS_CACHE_KEY);
        
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
            set_transient(self::PRODUCTS_CACHE_KEY, $products, 12 * HOUR_IN_SECONDS);
        }

        return $products;
    }

    public function init_generator()
    {
        $builder = register_post_type('magic_ef_builder', [
            'public' => true,
            'show_in_feed' => true,
            'show_in_rest' => true,
            'supports' => ['title', 'editor', 'elementor'],
            'has_archive' => true,
            'labels' => [
                'name' => esc_html__('Magic EF Builders', 'magic-extra-field'),
                'singular_name' => esc_html__('Magic EF Builder', 'magic-extra-field'),
                'add_new' => esc_html__('Add New Builder', 'magic-extra-field'),
                'add_new_item' => esc_html__('Add New Builder', 'magic-extra-field'),
                'edit_item' => esc_html__('Edit Builder', 'magic-extra-field'),
                'new_item' => esc_html__('New Builder', 'magic-extra-field'),
                'view_item' => esc_html__('View Builder', 'magic-extra-field'),
                'search_items' => esc_html__('Search Builders', 'magic-extra-field'),
                'not_found' => esc_html__('No builders found', 'magic-extra-field'),
                'not_found_in_trash' => esc_html__('No builders found in Trash', 'magic-extra-field'),
            ],
            'menu_icon' => 'dashicons-admin-customizer',
            'rewrite' => [
                'slug' => 'magic-ef-builder'
            ]
        ]);

        // Add custom columns to builder post type
        add_filter('manage_magic_ef_builder_posts_columns', function($columns) {
            $new_columns = array();
            foreach($columns as $key => $value) {
                if ($key === 'date') {
                    $new_columns['display_type'] = esc_html__('Display Type', 'magic-extra-field');
                    $new_columns['display_on'] = esc_html__('Display On', 'magic-extra-field');
                    $new_columns['settings'] = esc_html__('Settings', 'magic-extra-field');
                }
                $new_columns[$key] = $value;
            }
            return $new_columns;
        });

        // Populate custom columns
        add_action('manage_magic_ef_builder_posts_custom_column', function($column, $post_id) {
            switch($column) {
                case 'display_type':
                    $display_type = get_post_meta($post_id, '_magic_ef_display_type', true);
                    $types = array(
                        'all' => esc_html__('All Products', 'magic-extra-field'),
                        'specific' => esc_html__('Specific Products', 'magic-extra-field'),
                        'taxonomy' => esc_html__('By Taxonomy', 'magic-extra-field')
                    );
                    echo esc_html($types[$display_type]);
                    break;

                case 'display_on':
                    $display_type = get_post_meta($post_id, '_magic_ef_display_type', true);
                    if ($display_type === 'specific') {
                        $products = get_post_meta($post_id, '_magic_ef_selected_products', true);
                        echo count($products) . ' ' . esc_html__('Products', 'magic-extra-field');
                    } elseif ($display_type === 'taxonomy') {
                        $taxonomy = get_post_meta($post_id, '_magic_ef_selected_taxonomy', true);
                        echo ucfirst(str_replace('product_', '', $taxonomy));
                    } else {
                        echo esc_html__('All Products', 'magic-extra-field');
                    }
                    break;

                case 'settings':
                    printf(
                        '<button type="button" class="button magic-ef-settings-btn" data-id="%d">%s</button>',
                        esc_attr($post_id),
                        esc_html__('Edit Settings', 'magic-extra-field')
                    );
                    break;
            }
        }, 10, 2);
    }

    /**
     * Add display options meta box
     */
    public function add_display_options_meta_box() {
        add_meta_box(
            'magic_ef_display_options',
            esc_html__('Display Options', 'magic-extra-field'),
            [$this, 'render_display_options_meta_box'],
            'magic_ef_builder',
            'side',
            'high'
        );
    }

    /**
     * Render display options meta box
     */
    public function render_display_options_meta_box($post) {
        wp_nonce_field('magic_ef_display_options', 'magic_ef_display_options_nonce');

        $is_active = get_post_meta($post->ID, '_magic_ef_is_active', true);
        $display_type = get_post_meta($post->ID, '_magic_ef_display_type', true);
        $selected_products = get_post_meta($post->ID, '_magic_ef_selected_products', true);
        $selected_taxonomy = get_post_meta($post->ID, '_magic_ef_selected_taxonomy', true);
        $selected_terms = get_post_meta($post->ID, '_magic_ef_selected_terms', true);
        ?>
        <div class="magic-ef-options-wrapper">
            <p>
                <label class="magic-ef-toggle">
                    <input type="checkbox" name="is_active" value="1" <?php checked($is_active, '1'); ?>>
                    <span class="slider round"></span>
                   <span class="magic-ef-toggle-text"><?php esc_html_e('Active', 'magic-extra-field'); ?></span>
                </label>
            </p>

            <div class="magic-ef-display-options" style="display: <?php echo $is_active ? 'block' : 'none'; ?>">
                <p>
                    <label for="display_type"><?php esc_html_e('Display Type:', 'magic-extra-field'); ?></label>
                    <select name="display_type" id="display_type">
                        <option value="all" <?php selected($display_type, 'all'); ?>><?php esc_html_e('All Products', 'magic-extra-field'); ?></option>
                        <option value="specific" <?php selected($display_type, 'specific'); ?>><?php esc_html_e('Specific Products', 'magic-extra-field'); ?></option>
                        <option value="taxonomy" <?php selected($display_type, 'taxonomy'); ?>><?php esc_html_e('By Taxonomy', 'magic-extra-field'); ?></option>
                    </select>
                </p>

                <div id="specific_products" style="display: <?php echo $display_type === 'specific' ? 'block' : 'none'; ?>">
                    <p>
                        <label><?php esc_html_e('Select Products:', 'magic-extra-field'); ?></label>
                        <select name="selected_products[]" multiple class="magic-ef-product-select" style="width: 100%">
                            <?php
                            $products = $this->get_cached_products();
                            
                            // Display selected products first
                            if (!empty($selected_products)) {
                                foreach ($selected_products as $product_id) {
                                    $product = wc_get_product($product_id);
                                    if ($product) {
                                        echo '<option value="' . esc_attr($product_id) . '" selected>' . esc_html($product->get_name()) . '</option>';
                                    }
                                }
                            }
                            // Display all other products
                            foreach ($products as $product) {
                                if (!in_array($product->get_id(), (array)$selected_products)) {
                                    echo '<option value="' . esc_attr($product->get_id()) . '">' . esc_html($product->get_name()) . '</option>';
                                }
                            }
                            ?>
                        </select>
                    </p>
                </div>

                <div id="taxonomy_options" style="display: <?php echo $display_type === 'taxonomy' ? 'block' : 'none'; ?>">
                    <p>
                        <label for="selected_taxonomy"><?php esc_html_e('Select Taxonomy:', 'magic-extra-field'); ?></label>
                        <select name="selected_taxonomy" id="selected_taxonomy">
                            <option value=""><?php esc_html_e('Select a taxonomy', 'magic-extra-field'); ?></option>
                            <?php
                            $taxonomies = get_object_taxonomies('product', 'objects');
                            $excluded_taxonomies = array(
                                'pa_*', // Product attributes
                                'product_visibility',
                                'product_shipping_class', 
                                'pa_color',
                                'pa_size'
                            );
                            foreach ($taxonomies as $taxonomy) {
                                // Skip excluded taxonomies
                                if (in_array($taxonomy->name, $excluded_taxonomies) || preg_match('/^pa_/', $taxonomy->name)) {
                                    continue;
                                }
                                echo '<option value="' . esc_attr($taxonomy->name) . '" ' . selected($selected_taxonomy, $taxonomy->name, false) . '>' . esc_html($taxonomy->label) . '</option>';
                            }
                            ?>
                        </select>
                    </p>

                    <div id="terms_selection" style="display: <?php echo !empty($selected_taxonomy) ? 'block' : 'none'; ?>">
                        <p>
                            <label><?php esc_html_e('Select Terms:', 'magic-extra-field'); ?></label>
                            <select name="selected_terms[]" multiple class="magic-ef-term-select" style="width: 100%">
                                <?php
                                if (!empty($selected_taxonomy)) {
                                    // Get all terms for the selected taxonomy
                                    $terms = get_terms([
                                        'taxonomy' => $selected_taxonomy,
                                        'hide_empty' => false
                                    ]);

                                    // Display selected terms first
                                    if (!empty($selected_terms)) {
                                        foreach ($selected_terms as $term_id) {
                                            $term = get_term($term_id, $selected_taxonomy);
                                            if ($term && !is_wp_error($term)) {
                                                echo '<option value="' . esc_attr($term_id) . '" selected>' . esc_html($term->name) . '</option>';
                                            }
                                        }
                                    }

                                    // Display all other terms
                                    foreach ($terms as $term) {
                                        if (!in_array($term->term_id, (array)$selected_terms)) {
                                            echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
                                        }
                                    }
                                }
                                ?>
                            </select>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }

    /**
     * Save display options
     */
    public function save_display_options($post_id) {
        if (!isset($_POST['magic_ef_display_options_nonce']) || 
            !wp_verify_nonce($_POST['magic_ef_display_options_nonce'], 'magic_ef_display_options')) {
            return;
        }

        if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
            return;
        }

        if (!current_user_can('edit_post', $post_id)) {
            return;
        }

        $is_active = isset($_POST['is_active']) ? '1' : '0';
        update_post_meta($post_id, '_magic_ef_is_active', $is_active);

        if ($is_active) {
            $display_type = isset($_POST['display_type']) ? sanitize_text_field($_POST['display_type']) : 'all';
            update_post_meta($post_id, '_magic_ef_display_type', $display_type);

            if ($display_type === 'specific' && isset($_POST['selected_products'])) {
                $products = array_map('absint', $_POST['selected_products']);
                update_post_meta($post_id, '_magic_ef_selected_products', $products);
            }

            if ($display_type === 'taxonomy') {
                if (isset($_POST['selected_taxonomy'])) {
                    update_post_meta($post_id, '_magic_ef_selected_taxonomy', sanitize_text_field($_POST['selected_taxonomy']));
                }
                if (isset($_POST['selected_terms'])) {
                    $terms = array_map('absint', $_POST['selected_terms']);
                    update_post_meta($post_id, '_magic_ef_selected_terms', $terms);
                }
            }
        }
    }
}
