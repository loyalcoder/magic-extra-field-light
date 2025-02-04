<?php

namespace MagicExtraFieldLight;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Ajax handler class
 */
class Ajax
{
    /**
     * Initialize ajax handlers
     */
    public function __construct()
    {
        add_action('wp_ajax_magic_ef_get_taxonomy_terms', [$this, 'get_taxonomy_terms']);
        add_action('wp_ajax_magic_ef_get_settings', [$this, 'get_settings']);
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

        $taxonomy = sanitize_text_field($_POST['taxonomy']);

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
}
