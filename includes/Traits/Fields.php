<?php

namespace MagicExtraField\Traits;

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
      
      $include_file = MAGIC_EXTRA_FIELD_DIR_PATH . 'includes/Traits/template/type-' . $args['type'] . '.php';
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
    $html = '<div class="magic-extra-field-field">';
    $html .= '<div class="magic-extra-field-field-label">';
    $html .= '<label for="' . esc_attr($args['name']) . '">' . esc_html($args['label']) . '</label>';
    $html .= '</div>';
    $html .= '<div class="magic-extra-field-field-input">';
    $html .= '</div>';
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
        }
    }

    return $attr;   
   }
}
