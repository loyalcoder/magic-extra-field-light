<?php

namespace MagicExtraFieldLight;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Assets class handler
 */
class Assets
{
    /**
     * Initialize assets
     */
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'register_assets']);
        add_action('admin_enqueue_scripts', [$this, 'register_admin_assets']);
    }

    /**
     * Get scripts
     *
     * @return array
     */
    public function get_scripts()
    {
        return [
            'magic-extra-field-light-script' => [
                'src'     => MAGIC_EXTRA_FIELD_LIGHT_ASSETS . '/js/frontend.js',
                'version' => filemtime(MAGIC_EXTRA_FIELD_LIGHT_PATH . '/assets/js/frontend.js'),
                'deps'    => ['jquery']
            ]
        ];
    }

    /**
     * Get styles
     *
     * @return array
     */
    public function get_styles()
    {
        return [
            'magic-extra-field-light-style' => [
                'src'     => MAGIC_EXTRA_FIELD_LIGHT_ASSETS . '/dist/style.css',
                'version' => filemtime(MAGIC_EXTRA_FIELD_LIGHT_PATH . '/assets/dist/style.css'),
            ]
        ];
    }

    /**
     * Register assets
     */
    public function register_assets()
    {
        $scripts = $this->get_scripts();
        $styles = $this->get_styles();

        foreach ($scripts as $handle => $script) {
            $deps = isset($script['deps']) ? $script['deps'] : false;
            $version = isset($script['version']) ? $script['version'] : MAGIC_EXTRA_FIELD_LIGHT_VERSION;

            wp_register_script($handle, $script['src'], $deps, $version, true);
        }

        wp_localize_script('magic-extra-field-light-enquiry-script', 'magic_extra_field_light_data', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'message' => esc_html__('Message from enquiry form', 'magic-extra-field-light'),
        ]);

        foreach ($styles as $handle => $style) {
            $deps = isset($style['deps']) ? $style['deps'] : false;
            $version = isset($style['version']) ? $style['version'] : MAGIC_EXTRA_FIELD_LIGHT_VERSION;

            wp_register_style($handle, $style['src'], $deps, $version);
        }
    }

    /**
     * Register admin assets
     */
    public function register_admin_assets()
    {
        $screen = get_current_screen();
        if (!$screen || $screen->post_type !== 'magic_ef_builder') {
            return;
        }

        wp_enqueue_style('magic-extra-field-light-admin', MAGIC_EXTRA_FIELD_LIGHT_ASSETS_DIST . '/admin-style.css', [], MAGIC_EXTRA_FIELD_LIGHT_VERSION);
        wp_enqueue_script('magic-extra-field-light-admin', MAGIC_EXTRA_FIELD_LIGHT_ASSETS_DIST . '/admin.js', ['jquery'], MAGIC_EXTRA_FIELD_LIGHT_VERSION, true);
        wp_localize_script('magic-extra-field-light-admin', 'magic_ef_vars', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('magic_ef_nonce')
        ]);
        wp_enqueue_style('select2', MAGIC_EXTRA_FIELD_LIGHT_ASSETS_VENDORS . '/select2/css/select2.min.css', [], MAGIC_EXTRA_FIELD_LIGHT_VERSION);
        wp_enqueue_script('select2', MAGIC_EXTRA_FIELD_LIGHT_ASSETS_VENDORS . '/select2/js/select2.min.js', [], MAGIC_EXTRA_FIELD_LIGHT_VERSION, true);    
    }
}
