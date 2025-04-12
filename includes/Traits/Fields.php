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
   public function general_field( $args = [] )
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
    $args = wp_parse_args( $args, $default_args );
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
   public function select_field( $args = [] )
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
    $args = wp_parse_args( $args, $default_args );
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
   public function attr_generate( $args = [] )
   {
    $default_args = [
        'type' => 'text',
        'name' => 'text_field',
    ];
    $args = wp_parse_args( $args, $default_args );
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
        }
    }
    return $attr;   
   }
   public function allowed_generate_filed_html( )
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
            'step' => []
        ],
        'label' => [
            'for' => [],
            'class' => []
        ],
        'div' => [
            'class' => [],
            'id' => [],
            'style' => []
        ]
    ];
   }
}
