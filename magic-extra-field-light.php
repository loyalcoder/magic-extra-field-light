<?php

/**
 * Plugin Name:       Magic Extra Field Light
 * Plugin URI:        https://marlink-checkout.com
 * Description:       Add extra fields to WordPress - Light version
 * Version:           1.0.0
 * Author:            Loyalcoder
 * Author URI:        https://loyalcoder.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       magic-extra-field-light
 * Domain Path:       /languages
 * Elementor support: true
 * Requires at least: 5.8
 * Requires PHP:      7.4
 * WC requires at least: 6.0
 * WC tested up to:   8.7
 * Requires Plugins:  woocommerce, elementor
 */

if (!defined('ABSPATH')) {
    exit;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Main plugin class
 */
final class Magic_Extra_Field_Light
{
    /**
     * Plugin version
     * 
     * @var string
     */
    const version = '1.0.0';

    /**
     * contractor
     */
    private function __construct()
    {
        $this->define_constants();

        register_activation_hook(__FILE__, [$this, 'activate']);
        add_action('plugins_loaded', [$this, 'init_plugin']);
        add_action('before_woocommerce_init', [$this, 'declare_compatibility']);
    }

    /**
     * Initialize singleton instance
     *
     * @return \Magic_Extra_Field_Light
     */
    public static function init()
    {
        static $instance = false;

        if (!$instance) {
            $instance = new self();
        }

        return $instance;
    }

    /**
     * Define constants
     *
     * @return void
     */
    public function define_constants()
    {
        define('MAGIC_EXTRA_FIELD_LIGHT_VERSION', self::version);
        define('MAGIC_EXTRA_FIELD_LIGHT_FILE', __FILE__);
        define('MAGIC_EXTRA_FIELD_LIGHT_PATH', __DIR__);
        define('MAGIC_EXTRA_FIELD_LIGHT_URL', plugins_url('', MAGIC_EXTRA_FIELD_LIGHT_FILE));
        define('MAGIC_EXTRA_FIELD_LIGHT_ASSETS', MAGIC_EXTRA_FIELD_LIGHT_URL . '/assets');
        define('MAGIC_EXTRA_FIELD_LIGHT_ASSETS_DIST', MAGIC_EXTRA_FIELD_LIGHT_ASSETS . '/dist');
        define('MAGIC_EXTRA_FIELD_LIGHT_ASSETS_VENDORS', MAGIC_EXTRA_FIELD_LIGHT_ASSETS . '/vendors');
        define('MAGIC_EXTRA_FIELD_LIGHT_DIR_PATH', plugin_dir_path(__FILE__));
        define('MAGIC_EXTRA_FIELD_LIGHT_ELEMENTOR', MAGIC_EXTRA_FIELD_LIGHT_DIR_PATH . 'includes/Elementor/');
    }

    /**
     * Plugin information
     *
     * @return void
     */
    public function activate()
    {
        $installer = new MagicExtraFieldLight\Installer();

        $installer->run();
    }

    /**
     * Load plugin files
     *
     * @return void
     */
    public function init_plugin()
    {
        new MagicExtraFieldLight\Assets();
        new MagicExtraFieldLight\Ajax();
        new MagicExtraFieldLight\LoadElementor();
        new MagicExtraFieldLight\Generator();
        new MagicExtraFieldLight\WooCommerce_Filter();
        if (is_admin()) {
            new MagicExtraFieldLight\Admin();
        } 
    }

    /**
     * Declare compatibility with WooCommerce HPOS (High Performance Order Storage)
     * This method ensures our plugin works with WooCommerce Custom Order Tables
     * 
     * @since 1.0.0
     * @return void 
     */
    public function declare_compatibility()
    {
        if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
            \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
        }
    }
}

/**
 * Initialize main plugin
 *
 * @return \Magic_Extra_Field_Light
 */
if ( ! function_exists( 'magic_extra_field_light' ) ) {
    function magic_extra_field_light()
    {
        return Magic_Extra_Field_Light::init();
    }
}

magic_extra_field_light();
