<?php

namespace MagicExtraField\Admin;

/**
 * Admin menu class
 */
class Menu
{
    /**
     * Initialize menu
     */
    function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Handle plugin menu
     *
     * @return void
     */
    public function admin_menu()
    {
        $parent_slug = 'magic-extra-field-dashboard';
        $capability = 'manage_options';

        add_menu_page(
            esc_html__('Magic Extra Field Dashboard', 'magic-extra-field'),
            esc_html__('Magic Extra Field', 'magic-extra-field'),
            $capability,
            $parent_slug,
            [$this, 'dashboard_page'],
            'dashicons-buddicons-groups'
        );
        add_submenu_page(
            $parent_slug,
            esc_html__('Settings', 'magic-extra-field'),
            esc_html__('Settings', 'magic-extra-field'),
            $capability,
            $parent_slug,
            [$this, 'dashboard_page']
        );
        add_submenu_page(
            $parent_slug,
            esc_html__('Report', 'magic-extra-field'),
            esc_html__('Report', 'magic-extra-field'),
            $capability,
            'magic-extra-field-report',
            [$this, 'report_page']
        );
    }

    /**
     * Handle menu page
     *
     * @return void
     */
    public function dashboard_page()
    {
        $settings = new Settings();
        $settings->settings_page();
    }

    /**
     * Report page
     *
     * @return void
     */
    public function report_page()
    {
        $settings = new Settings();
        $settings->report_page();
    }
}
