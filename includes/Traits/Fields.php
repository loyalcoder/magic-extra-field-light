<?php

namespace MagicExtraFieldLight\Traits;

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

/**
 * Fields Trait
 *
 * Handles common field functionality.
 */
trait Fields
{
    /**
     * Generate a general form field
     *
     * @param array $args Field arguments
     * @return string Generated field HTML
     */
    public function general_field($args = [])
    {
        $default_args = [
            'type' => 'text',
            'label' => 'Text Field',
            'name' => 'text_field',
            'value' => '',
            'placeholder' => '',
            'description' => '',
            'required' => false,
            'class' => '',
            'id' => '',
            'style' => '',
        ];
        $args = wp_parse_args($args, $default_args);
        ob_start();
        $include_file = apply_filters(
            'magic_extra_field_light_template_path',
            MAGIC_EXTRA_FIELD_LIGHT_PATH . '/includes/Traits/template/type-' . $args['type'] . '.php',
            $args['type']
        );
        if (file_exists($include_file)) {
            include $include_file;
        }
        return ob_get_clean();
    }
/**
     * Generate a checkbox form field
     *
     * @param array $args Field arguments
     * @return string Generated checkbox field HTML
     */
    public function checkbox_field($args = [])
    {
        $default_args = [
            'type' => 'checkbox',
            'label' => 'Checkbox Field',
            'name' => 'checkbox_field',
            'value' => '1',
            'checked' => false,
            'description' => '',
            'required' => false,
            'class' => '',
            'id' => '',
            'style' => '',
        ];
        $args = wp_parse_args($args, $default_args);
        ob_start();
            $include_file = apply_filters(
                'magic_extra_field_light_template_path',
                MAGIC_EXTRA_FIELD_LIGHT_PATH . '/includes/Traits/template/type-' . $args['type'] . '.php',
                $args['type']
            );
            if (file_exists($include_file)) {
                include $include_file;
            }
        return ob_get_clean();
    }
    /**
     * Generate a select form field
     *
     * @param array $args Field arguments
     * @return string Generated select field HTML
     */
    public function select_field($args = [])
    {
        $default_args = [
            'type' => 'select',
            'label' => 'Select Field',
            'name' => 'select_field',
            'value' => '',
            'placeholder' => '',
            'description' => '',
            'required' => false,
            'class' => '',
        ];
        $args = wp_parse_args($args, $default_args);
        ob_start();
        $include_file = apply_filters(
            'magic_extra_field_light_template_path',
            MAGIC_EXTRA_FIELD_LIGHT_PATH . '/includes/Traits/template/type-' . $args['type'] . '.php',
            $args['type']
        );
        if (file_exists($include_file)) {
            include $include_file;
        }
        return ob_get_clean();
    }


    /**
     * Generate HTML attributes for form fields
     *
     * @param array $args Field attributes
     * @return string Generated HTML attributes
     */
    public function attr_generate($args = [])
    {
        $default_args = [
            'type' => 'text',
            'name' => 'text_field',
        ];
        $args = wp_parse_args($args, $default_args);
        $attr = '';
        foreach ($args as $key => $value) {
            if (empty($value)) {
                continue;
            }

            switch ($key) {
                case 'type':
                    $attr .= ' type="' . esc_attr($value) . '"';
                    break;
                case 'name':
                    $attr .= ' name="' . esc_attr($value) . '"';
                    break;
                case 'value':
                    $attr .= ' value="' . esc_attr($value) . '"';
                    break;
                case 'placeholder':
                    $attr .= ' placeholder="' . esc_attr($value) . '"';
                    break;
                case 'description':
                    $attr .= ' description="' . esc_attr($value) . '"';
                    break;
                case 'required':
                    $attr .= ' required="' . esc_attr($value) . '"';
                    break;
                case 'class':
                    $attr .= ' class="' . esc_attr($value) . '"';
                    break;
                case 'id':
                    $attr .= ' id="' . esc_attr($value) . '"';
                    break;
                case 'style':
                    $attr .= ' style="' . esc_attr($value) . '"';
                    break;
                case 'min':
                    $attr .= ' min="' . esc_attr($value) . '"';
                    break;
                case 'max':
                    $attr .= ' max="' . esc_attr($value) . '"';
                    break;
                case 'step':
                    $attr .= ' step="' . esc_attr($value) . '"';
                    break;
                case 'pattern':
                    $attr .= ' pattern="' . esc_attr($value) . '"';
                    break;
                case 'rows':
                    $attr .= ' rows="' . esc_attr($value) . '"';
                    break;
                case 'cols':
                    $attr .= ' cols="' . esc_attr($value) . '"';
                    break;
                case 'disabled':
                    $attr .= ' disabled="' . esc_attr($value) . '"';
                    break;
            }
        }
        return $attr;
    }

    /**
     * Get allowed HTML elements and attributes for wp_kses
     *
     * @return array Allowed HTML elements and attributes
     */
    public function allowed_generate_filed_html()
    {
        return [
            'input' => [
                'type' => [],
                'name' => [],
                'id' => [],
                'class' => [],
                'value' => [],
                'placeholder' => [],
                'required' => [],
                'style' => [],
                'min' => [],
                'max' => [],
                'step' => [],
                'checked' => [],
                'disabled' => [],
                'pattern' => [],
                'autocomplete' => [],
                'readonly' => []
            ],
            'textarea' => [
                'name' => [],
                'id' => [],
                'class' => [],
                'placeholder' => [],
                'required' => [],
                'style' => [],
                'rows' => [],
                'cols' => [],
                'disabled' => [],
                'readonly' => [],
                'maxlength' => [],
                'wrap' => []
            ],
            'select' => [
                'name' => [],
                'id' => [],
                'class' => [],
                'required' => [],
                'style' => [],
                'disabled' => [],
                'multiple' => [],
                'size' => [],
                'form' => []
            ],
            'option' => [
                'value' => [],
                'selected' => [],
                'disabled' => [],
                'label' => []
            ],
            'optgroup' => [
                'label' => [],
                'disabled' => []
            ],
            'label' => [
                'for' => [],
                'class' => [],
                'form' => []
            ],
            'span' => [
                'class' => [],
                'style' => [],
                'id' => [],
            ],
            'div' => [
                'class' => [],
                'id' => [],
                'style' => [],
                'role' => [],
                'aria-label' => []
            ],
            'fieldset' => [
                'class' => [],
                'id' => [],
                'style' => [],
                'disabled' => [],
                'form' => []
            ],
            'legend' => [
                'class' => [],
                'id' => [],
                'style' => []
            ],
            'radio' => [
                'name' => [],
                'id' => [],
                'class' => [],
                'value' => [],
                'required' => [],
                'style' => [],
                'checked' => [],
                'disabled' => [],
                'form' => []
            ],
            'checkbox' => [
                'name' => [],
                'id' => [],
                'class' => [],
                'value' => [],
                'required' => [],
                'style' => [],
                'checked' => [],
                'disabled' => [],
                'form' => []
            ]
        ];
    }
}
