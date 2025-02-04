<?php

namespace MagicExtraFieldLight;

use Elementor\Plugin;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Load elementor class
 */
class LoadElementor
{
    /**
     * Init elementor class
     *
     * @since 1.0.0
     * @return null
     */
    public function __construct()
    {
        add_action('elementor/elements/categories_registered', [$this, 'register_category']);
        add_action('elementor/widgets/widgets_registered', [$this, 'register_widgets']);
        add_action('elementor/editor/after_enqueue_scripts', [$this, 'custom_elementor_scripts']);
    }

    /**
     * custom_elementor_scripts
     * 
     * @since 1.0.0
     */
    public function custom_elementor_scripts()
    {
        $scripts = $this->get_scripts();

        foreach ($scripts as $handle => $script) {
            $deps    = isset($script['deps']) ? $script['deps'] : false;
            $version = isset($script['version']) ? $script['version'] : MAGIC_EXTRA_FIELD_LIGHT_VERSION;
            wp_register_script($handle, $script['src'], $deps, $version, true);
            wp_enqueue_script($handle);
        }
    }

    /**
     * Register elementor category
     *
     * @param object $elementor
     *
     * @since 1.0.0
     * @return object
     */
    public function register_category($elementor)
    {
        $elementor->add_category(
            'magic-extra-field-widgets',
            [
                'title' =>  esc_html__('Magic Extra Field Widgets', 'magic-extra-field'),
                'icon'  => 'eicon-font',
            ]
        );

        return $elementor;
    }

    /**
     * Register elementor widgets
     *
     * @since 1.0.0
     * @return void
     */
    public function register_widgets()
    {
        $this->include_widgets_files();

        Plugin::instance()->widgets_manager->register(new Elementor\Input_Text());
    }

    /**
     * Widget Scripts
     *
     * @since 1.0.0
     * @return array
     */
    public static function get_widget_script()
    {
        return [];
    }

    /**
     * Get scripts
     *
     * @return array
     */
    public function get_scripts()
    {
        return [
            'magic-extra-field' => [
                'src'     => MAGIC_EXTRA_FIELD_LIGHT_ASSETS . '/js/magic-extra-field.js',
                // 'version' => filemtime(MAGIC_EXTRA_FIELD_PATH . '/assets/js/magic-extra-field.js'),
                'deps'    => ['jquery']
            ],
        ];
    }

    /**
     * Get styles
     *
     * @since 1.0.0
     * @return array
     */
    public function get_styles()
    {
        return [
            'magic-extra-field' => [
                'src'     => MAGIC_EXTRA_FIELD_LIGHT_ASSETS . '/css/magic-extra-field.css',
                // 'version' => filemtime(MAGIC_EXTRA_FIELD_PATH . '/assets/css/magic-extra-field.css'),
            ]
        ];
    }

    /**
     * Widget list
     *
     * @since 1.0.0
     * @return array
     */
    public static function get_widget_list()
    {
        return [
            'HelloWorld',
        ];
    }

    /**
     * Include widget files
     *
     * @since 1.0.0
     * @return void
     */
    public function include_widgets_files()
    {
        $scripts     = $this->get_scripts();
        $styles      = $this->get_styles();
        $widget_list = $this->get_widget_list();

        if (!count($widget_list)) {
            return;
        }

        foreach ($widget_list as $handle => $widget) {
            $file = MAGIC_EXTRA_FIELD_LIGHT_ELEMENTOR . $widget . '.php';
            if (!file_exists($file)) {
                continue;
            }
            require_once $file;
        }

        foreach ($scripts as $handle => $script) {
            $deps    = isset($script['deps']) ? $script['deps'] : false;
            $version = isset($script['version']) ? $script['version'] : MAGIC_EXTRA_FIELD_LIGHT_VERSION;
            //wp_register_script($handle, $script['src'], $deps, $version, true);
            // wp_enqueue_script($handle);
        }

        foreach ($styles as $handle => $style) {
            $deps = isset($style['deps']) ? $style['deps'] : false;
            $version = isset($style['version']) ? $style['version'] : MAGIC_EXTRA_FIELD_LIGHT_VERSION;
           // wp_register_style($handle, $style['src'], $deps, $version);
            // wp_enqueue_style($handle);
        }
    }
}
