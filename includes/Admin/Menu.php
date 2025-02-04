<?php

namespace MagicExtraFieldLight\Admin;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Admin menu class
 * 
 * Handles the WordPress admin menu setup for Magic Extra Field Light plugin.
 * 
 * @since 1.0.0
 */
class Menu
{
    /**
     * Initialize menu
     * 
     * @since 1.0.0
     * @return void
     */
    function __construct()
    {
        add_action('admin_menu', [$this, 'admin_menu']);
    }

    /**
     * Handle plugin menu registration
     * 
     * Registers the main plugin menu and its submenus in WordPress admin.
     *
     * @since 1.0.0
     * @return void
     */
    public function admin_menu()
    {
        $parent_slug = 'magic-extra-field-dashboard';
        $capability = 'manage_options';

        add_menu_page(
            esc_html__('Magic Extra Field Dashboard', 'magic-extra-field-light'),
            esc_html__('Magic Extra Field', 'magic-extra-field-light'),
            $capability,
            $parent_slug,
            [$this, 'dashboard_page'],
            'dashicons-buddicons-groups'
        );
        add_submenu_page(
            $parent_slug,
            esc_html__('Settings', 'magic-extra-field-light'),
            esc_html__('Settings', 'magic-extra-field-light'),
            $capability,
            $parent_slug,
            [$this, 'dashboard_page']
        );
        add_submenu_page(
            $parent_slug,
            esc_html__('Report', 'magic-extra-field-light'),
            esc_html__('Report', 'magic-extra-field-light'),
            $capability,
            'magic-extra-field-report',
            [$this, 'report_page']
        );
    }

    /**
     * Handle dashboard page display
     * 
     * Initializes and displays the main settings page.
     *
     * @since 1.0.0
     * @return void
     */
    public function dashboard_page()
    {
        $settings = new Settings();
        $settings->settings_page();
    }

    /**
     * Handle report page display
     * 
     * Initializes and displays the report page.
     *
     * @since 1.0.0
     * @return void
     */
    public function report_page()
    {
        $settings = new Settings();
        $settings->report_page();
    }
}
