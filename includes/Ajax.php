<?php

namespace MagicExtraField;

/**
 * Ajax class
 */
class MagicExtraFieldAjax
{
    /**
     * Initialize ajax class
     */
    public function __construct()
    {
        add_action('wp_ajax_magic_ef_get_taxonomy_terms', [$this, 'get_taxonomy_terms']);
        add_action('wp_ajax_magic_ef_get_settings', [$this, 'get_settings']);
    }
    public function get_taxonomy_terms()
    {
        check_ajax_referer('magic_ef_nonce', 'nonce');
        $taxonomy = $_POST['taxonomy'];
        $terms = get_terms([
            'taxonomy' => $taxonomy,
            'hide_empty' => false
        ]);
        wp_send_json_success($terms);
    }
    public function get_settings()
    {
        check_ajax_referer('magic_ef_nonce', 'nonce');
        $post_id = $_POST['post_id'];
        $settings = get_post_meta($post_id, '_magic_ef_settings', true);
        wp_send_json_success($settings);
    }
}
