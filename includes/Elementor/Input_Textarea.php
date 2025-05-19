<?php
namespace MagicExtraFieldLight\Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use MagicExtraFieldLight\Traits\Fields;
use MagicExtraFieldLight\Traits\General_Style_Control;

/**
 * Input_Textarea Widget
 * 
 * A custom Elementor widget that adds a textarea field with customizable label,
 * placeholder, and styling options.
 *
 * @since 1.0.0
 */
class Input_Textarea extends \Elementor\Widget_Base {
    use Fields;
    use General_Style_Control;
    
    public function get_name() {
        return 'magic_input_textarea_light';
    }

    public function get_title() {
        return esc_html__('Magic Input Textarea', 'magic-extra-field-light');
    }

    public function get_icon() {
        return 'eicon-text-area';
    }

    public function get_categories() {
        return ['magic-extra-field-light'];
    }

    public function get_style_depends() {
        return ['magic-extra-field-light-style'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'magic-extra-field-light'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $content_controls = apply_filters('magic_extra_field_light_input_textarea_content_controls_before', array());

        $default_content_controls = [
            'field_label' => [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Textarea Field', 'magic-extra-field-light'),
            ],
            'placeholder' => [
                'label' => esc_html__('Placeholder', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter your message here', 'magic-extra-field-light'),
            ],
            'value' => [
                'label' => esc_html__('Default Value', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXTAREA,
                'default' => '',
            ],
            'rows' => [
                'label' => esc_html__('Rows', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 1,
                'max' => 50,
                'default' => 5,
            ],
            'cols' => [
                'label' => esc_html__('Columns', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'min' => 5,
                'max' => 100,
                'default' => 50,
            ],
            'required' => [
                'label' => esc_html__('Required', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magic-extra-field-light'),
                'label_off' => esc_html__('No', 'magic-extra-field-light'),
                'default' => 'no',
            ],
            'field_name' => [
                'label' => esc_html__('Name', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('input-textarea-', 'magic-extra-field-light'),
            ]
        ];

        $content_controls = array_merge($content_controls, $default_content_controls);
        $content_controls = apply_filters('magic_extra_field_light_input_textarea_content_controls_after', $content_controls);

        foreach ($content_controls as $control_id => $control_args) {
            $this->add_control($control_id, $control_args);
        }

        $this->end_controls_section();

        $this->add_label_style_controls('{{WRAPPER}} .magic-extra-field-field label');
        $this->add_input_style_controls('{{WRAPPER}} .magic-input-textarea');
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        $filed_args = [];
        $filed_args['type'] = 'textarea';
        $filed_args['label'] = $settings['field_label']; 
        $filed_args['placeholder'] = $settings['placeholder'];
        $filed_args['required'] = $required;
        $filed_args['id'] = 'magic-input-textarea-' . $this->get_id();
        $filed_args['class'] = 'magic-input-textarea magic-input';
        $filed_args['name'] = $settings['field_name'];
        $filed_args['rows'] = $settings['rows'];
        $filed_args['cols'] = $settings['cols'];
        $filed_args['value'] = $settings['value'];
        echo wp_kses(
            $this->general_field( $filed_args ),
            $this->allowed_generate_filed_html()
        );
    }

    protected function content_template() {
       
    }
}
