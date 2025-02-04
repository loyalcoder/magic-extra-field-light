<?php
/**
 * Functions file for Magic Extra Field Light plugin
 *
 * This file contains helper functions for the plugin including:
 * - Custom price calculation for WooCommerce cart
 * - Allowed HTML tags configuration for custom fields
 *
 * @package MagicExtraFieldLight
 * @since 1.0.0
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if (!function_exists('add_custom_total_price')) {
    /**
     * Add custom price to cart total
     * 
     * Adds a fixed framed price to each cart item during total calculation
     *
     * @param WC_Cart $cart WooCommerce cart object
     * @return void
     * @since 1.0.0
     */
    add_action('woocommerce_before_calculate_totals', 'add_custom_total_price', 10);
    function add_custom_total_price($cart) {
        if (is_admin() && !defined('DOING_AJAX')) {
            return;
        }

        $framed_price = 10;

        foreach ($cart->get_cart() as $item) {
            $item['data']->set_price($item['data']->get_price() + $framed_price);
        }
    }
}

if (!function_exists('allow_html_for_custom_field')) {
    /**
     * Define allowed HTML tags for custom fields
     * 
     * Returns an array of allowed HTML tags and their attributes
     * for use with wp_kses() function
     *
     * @return array Array of allowed HTML elements and attributes
     * @since 1.0.0
     */
    function allow_html_for_custom_field() {
        return array(
            'a' => array(
                'href' => array(), 'title' => array(), 'target' => array(), 'class' => array(), 'id' => array(), 'style' => array(),
                'rel' => array(), 'download' => array(), 'hreflang' => array(), 'media' => array(), 'type' => array()
            ),
            'abbr' => array('title' => array()),
            'address' => array(),
            'area' => array('alt' => array(), 'coords' => array(), 'href' => array(), 'shape' => array(), 'target' => array()),
            'article' => array('class' => array(), 'id' => array()),
            'aside' => array('class' => array(), 'id' => array()),
            'b' => array(),
            'bdi' => array(),
            'bdo' => array('dir' => array()),
            'br' => array(),
            'button' => array('disabled' => array(), 'name' => array(), 'type' => array(), 'value' => array(), 'class' => array()),
            'caption' => array('align' => array()),
            'code' => array(),
            'col' => array('align' => array(), 'span' => array(), 'width' => array()),
            'colgroup' => array('align' => array(), 'span' => array(), 'width' => array()),
            'data' => array('value' => array()),
            'datalist' => array('id' => array()),
            'dd' => array(),
            'del' => array('datetime' => array()),
            'div' => array('class' => array(), 'id' => array(), 'style' => array()),
            'embed' => array('height' => array(), 'src' => array(), 'type' => array(), 'width' => array()),
            'fieldset' => array('disabled' => array(), 'form' => array(), 'name' => array()),
            'figure' => array(),
            'footer' => array('class' => array(), 'id' => array()),
            'form' => array('action' => array(), 'method' => array(), 'class' => array(), 'id' => array(), 'enctype' => array()),
            'h1' => array('class' => array(), 'id' => array()),
            'h2' => array('class' => array(), 'id' => array()),
            'h3' => array('class' => array(), 'id' => array()),
            'h4' => array('class' => array(), 'id' => array()),
            'h5' => array('class' => array(), 'id' => array()),
            'h6' => array('class' => array(), 'id' => array()),
            'header' => array('class' => array(), 'id' => array()),
            'hr' => array(),
            'i' => array('class' => array(), 'id' => array()),
            'iframe' => array('height' => array(), 'name' => array(), 'sandbox' => array(), 'src' => array(), 'width' => array()),
            'img' => array('alt' => array(), 'height' => array(), 'src' => array(), 'width' => array(), 'class' => array()),
            'input' => array('accept' => array(), 'alt' => array(), 'autocomplete' => array(), 'checked' => array(), 
                'disabled' => array(), 'form' => array(), 'height' => array(), 'list' => array(), 'max' => array(), 
                'maxlength' => array(), 'min' => array(), 'multiple' => array(), 'name' => array(), 'pattern' => array(), 
                'placeholder' => array(), 'readonly' => array(), 'required' => array(), 'size' => array(), 'src' => array(), 
                'step' => array(), 'type' => array(), 'value' => array(), 'width' => array(), 'class' => array(), 'id' => array()
            ),
            'label' => array('for' => array(), 'form' => array(), 'class' => array()),
            'legend' => array(),
            'li' => array('value' => array(), 'class' => array()),
            'link' => array('href' => array(), 'media' => array(), 'rel' => array(), 'type' => array()),
            'main' => array('class' => array(), 'id' => array()),
            'map' => array('name' => array()),
            'nav' => array('class' => array(), 'id' => array()),
            'ol' => array('reversed' => array(), 'start' => array(), 'type' => array(), 'class' => array()),
            'optgroup' => array('disabled' => array(), 'label' => array()),
            'option' => array('disabled' => array(), 'label' => array(), 'selected' => array(), 'value' => array()),
            'output' => array('for' => array(), 'form' => array(), 'name' => array()),
            'p' => array('class' => array(), 'id' => array()),
            'section' => array('class' => array(), 'id' => array()),
            'select' => array('autofocus' => array(), 'disabled' => array(), 'form' => array(), 'multiple' => array(), 
                'name' => array(), 'required' => array(), 'size' => array(), 'class' => array(), 'id' => array()
            ),
            'small' => array(),
            'span' => array('class' => array(), 'id' => array(), 'style' => array()),
            'strong' => array(),
            'style' => array('media' => array(), 'type' => array()),
            'sub' => array(),
            'sup' => array(),
            'textarea' => array('cols' => array(), 'disabled' => array(), 'form' => array(), 'maxlength' => array(), 
                'name' => array(), 'placeholder' => array(), 'readonly' => array(), 'required' => array(), 
                'rows' => array(), 'wrap' => array(), 'class' => array(), 'id' => array()
            ),
            'thead' => array(),
            'ul' => array('class' => array(), 'id' => array()),
            'video' => array('autoplay' => array(), 'controls' => array(), 'height' => array(), 'loop' => array(), 
                'muted' => array(), 'poster' => array(), 'preload' => array(), 'src' => array(), 'width' => array()
            ),
            'wbr' => array(),
        );
    }
}
