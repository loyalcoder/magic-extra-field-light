=== Magic Extra Field Light ===
Contributors: loyalcoder
Tags: woocommerce, elementor, custom fields, product fields
Requires at least: 5.8
Tested up to: 6.9
Stable tag: 1.0.2
Requires PHP: 7.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add custom fields to WooCommerce products using Elementor's interface.

== Description ==

Magic Extra Field Light is a lightweight WordPress plugin that allows you to add custom fields to your WooCommerce products using Elementor's interface. It's perfect for adding text inputs, checkboxes, and other form elements to your product pages.

= Features =

* Add custom fields to WooCommerce products
* Use Elementor's interface to design your fields
* Support for text inputs, checkboxes, and more
* Fields appear in cart and order details
* Lightweight and fast

= Requirements =

* WordPress 5.0 or higher
* WooCommerce 5.0 or higher
* Elementor 3.0 or higher
* PHP 7.4 or higher

== Installation ==

1. Download the plugin zip file
2. Go to WordPress admin panel > Plugins > Add New
3. Click "Upload Plugin" and select the downloaded zip file
4. Click "Install Now" and then "Activate"

== Development Setup ==

= Prerequisites =

* Node.js (v14 or higher)
* npm or yarn
* WordPress development environment
* WooCommerce installed and activated
* Elementor installed and activated

= Installation Steps =

1. Clone the repository:
   ```bash
   git clone https://github.com/loyalcoder/magic-extra-field-light.git
   ```

2. Navigate to the plugin directory:
   ```bash
   cd magic-extra-field-light
   ```

3. Install dependencies:
   ```bash
   npm install
   ```

4. Build the assets:
   ```bash
   npm run build
   ```

= Source Code =

This plugin uses build tools to generate optimized production assets. The source code for all JavaScript and CSS files is available in the following locations:

* **JavaScript Source**: `assets/src/js/` - Contains the original, human-readable JavaScript source files
* **CSS Source**: `assets/src/css/` - Contains the original, human-readable CSS source files
* **Build Configuration**: `webpack.config.js` - Webpack configuration for asset compilation

The compiled/minified assets are located in `assets/dist/` and are generated from the source files using webpack.

= Build Tools =

This plugin uses the following build tools:
* **Webpack**: For bundling and optimizing JavaScript and CSS assets
* **npm**: For dependency management and build scripts

To modify the plugin's frontend or admin interface:
1. Edit the source files in `assets/src/`
2. Run `npm run build` to compile changes
3. Test your modifications

The source code is also available on GitHub: https://github.com/loyalcoder/magic-extra-field-light

== Changelog ==

= 1.0.2 =
* Security: Added capability checks to AJAX handlers.
* Security: Improved input sanitization and unslashing for all request data.
* Security: Escaped style attributes in admin templates.
* Compatibility: Tested up to WordPress 6.9.
* Code: WordPress coding standards (PHPCS/WPCS) and prefixed global variables.

= 1.0.1 =
* Bug fixes and improvements.

= 1.0.0 =
* Initial release.

== Upgrade Notice ==

= 1.0.2 =
Security and compatibility update. Recommended for all users. Tested with WordPress 6.9.

