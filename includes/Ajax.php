<?php

namespace MagicExtraFieldLight;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}
use MagicExtraFieldLight\Traits\Product_Data;
/**
 * Ajax handler class
 */
class Ajax
{
    use Product_Data;
    /**
     * Initialize ajax handlers
     */
    public function __construct()
    {
        add_action('wp_ajax_magic_ef_get_taxonomy_terms', [$this, 'get_taxonomy_terms']);
        add_action('wp_ajax_magic_ef_get_settings', [$this, 'get_settings']);
        add_action('wp_ajax_magic_ef_get_settings_form', [$this, 'get_settings_form']);
        add_action('wp_ajax_magic_ef_save_settings', [$this, 'magic_ef_save_settings']);
        // Add hooks to clear product cache
        add_action('save_post_product', [$this, 'clear_products_cache']);
        add_action('deleted_post', [$this, 'clear_products_cache']);
        add_action('woocommerce_update_product', [$this, 'clear_products_cache']);
    }

    /**
     * Get taxonomy terms via AJAX
     *
     * @return void
     */
    public function get_taxonomy_terms()
    {
        check_ajax_referer('magic_ef_nonce', 'nonce');

        if (!isset($_POST['taxonomy'])) {
            wp_send_json_error('Taxonomy parameter is required');
        }

        $taxonomy = sanitize_text_field(wp_unslash($_POST['taxonomy']));

        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ]);

        if (is_wp_error($terms)) {
            wp_send_json_error($terms->get_error_message());
        }

        wp_send_json_success($terms);
    }

    /**
     * Get field settings via AJAX
     * 
     * @return void
     */
    public function get_settings()
    {
        check_ajax_referer('magic_ef_nonce', 'nonce');

        if (!isset($_POST['post_id'])) {
            wp_send_json_error('Post ID is required');
        }

        $post_id = absint($_POST['post_id']);
        $settings = get_post_meta($post_id, '_magic_ef_settings', true);

        wp_send_json_success($settings);
    }

    /**
     * Get settings form via AJAX
     * 
     * @return void
     */
    public function get_settings_form()
    {
        check_ajax_referer('magic_ef_nonce', 'nonce');
        $post_id = isset($_POST['post_id']) ? sanitize_text_field(wp_unslash($_POST['post_id'])) : '';
        $products = $this->get_cached_products();
        $taxonomies = get_object_taxonomies('product', 'objects');
        ob_start();
        if ($post_id != '') {
            include(MAGIC_EXTRA_FIELD_LIGHT_DIR_PATH . '/includes/templates/admin/settings-form.php');
        } else {
            include(MAGIC_EXTRA_FIELD_LIGHT_DIR_PATH . '/includes/templates/admin/create-new.php');
        }
        $form_html = ob_get_clean();

        wp_send_json_success($form_html);
    }

    /**
     * Clear products transient cache
     */
    public function clear_products_cache() {
        delete_transient('magic_ef_products_cache');
    }

    /**
     * Save settings
     */
    public function magic_ef_save_settings() {
        check_ajax_referer('magic_ef_nonce', 'nonce');

        // if (!isset($_POST['post_id'])) {
        //     wp_send_json_error('Post ID is required');
        // }   

        // Validate post ID
        if (!isset($_POST['post_id']) || empty($_POST['post_id'])) {
            wp_send_json_error('Post ID is required');
        }
        $post_id = absint($_POST['post_id']);

        // Validate settings
        if (!isset($_POST['settings']) || empty($_POST['settings'])) {
            wp_send_json_error('Settings data is required');
        }

        // Parse settings string into array
        $settings = isset($_POST['settings']) ? sanitize_text_field(wp_unslash($_POST['settings'])) : '';
        parse_str($settings, $settings);        
        // Sanitize settings
        $is_active = isset($settings['is_active']) ? '1' : '0';
        update_post_meta($post_id, '_magic_ef_is_active', $is_active);

        if ($is_active) {
            $display_type = isset($settings['display_type']) ? sanitize_text_field($settings['display_type']) : 'all';
            update_post_meta($post_id, '_magic_ef_display_type', $display_type);

            if ($display_type === 'specific' && isset($settings['selected_products'])) {
                $products = array_map('absint', $settings['selected_products']);
                update_post_meta($post_id, '_magic_ef_selected_products', $products);
            }

            if ($display_type === 'taxonomy') {
                if (isset($settings['selected_taxonomy'])) {
                    update_post_meta($post_id, '_magic_ef_selected_taxonomy', sanitize_text_field($settings['selected_taxonomy']));
                }
                if (isset($settings['selected_terms'])) {
                    $terms = array_map('absint', $settings['selected_terms']);
                    update_post_meta($post_id, '_magic_ef_selected_terms', $terms);
                }
            }
        }
        $edit_url = add_query_arg('action', 'elementor', get_edit_post_link($post_id));
        wp_send_json_success([
            'message' => esc_html__('Settings saved', 'magic-extra-field-light'),
            'edit_url' => $edit_url
        ]);
    }
}
