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
 * Input_Tel Widget
 * 
 * A custom Elementor widget that adds a telephone input field with customizable label,
 * placeholder, and styling options.
 *
 * @since 1.0.0
 */
class Input_Tel extends \Elementor\Widget_Base {
    use Fields;
    use General_Style_Control;

    public function get_name() {
        return 'magic_input_tel_light';
    }

    public function get_title() {
        return esc_html__('Magic Input Tel', 'magic-extra-field-light');
    }

    public function get_icon() {
        return 'eicon-phone';
    }

    public function get_categories() {
        return ['magic-extra-field-light'];
    }

    protected function register_controls() {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'magic-extra-field-light'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $content_controls = apply_filters('magic_extra_field_light_input_tel_content_controls_before', array());

        $default_content_controls = [
            'field_label' => [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Phone Number', 'magic-extra-field-light'),
            ],
            'placeholder' => [
                'label' => esc_html__('Placeholder', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter phone number', 'magic-extra-field-light'),
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
                'default' => 'tel_field',
            ],
            'pattern' => [
                'label' => esc_html__('Pattern', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '[0-9]{3}-[0-9]{3}-[0-9]{4}',
                'description' => esc_html__('Enter a pattern for phone number validation (e.g., [0-9]{3}-[0-9]{3}-[0-9]{4})', 'magic-extra-field-light'),
            ],
        ];

        $content_controls = array_merge($content_controls, $default_content_controls);
        $content_controls = apply_filters('magic_extra_field_light_input_tel_content_controls_after', $content_controls);

        foreach ($content_controls as $control_id => $control_args) {
            $this->add_control($control_id, $control_args);
        }

        $this->end_controls_section();

        $this->add_label_style_controls('{{WRAPPER}} .magic-extra-field-field label');
        $this->add_input_style_controls('{{WRAPPER}} .magic-input-tel');
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $field_id = 'magic_input_' . $this->get_id();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        $filed_args = [];
        $filed_args['type'] = 'tel';
        $filed_args['label'] = $settings['field_label'];
        $filed_args['placeholder'] = $settings['placeholder'];
        $filed_args['required'] = $required;
        $filed_args['id'] = 'magic-input-tel-' . $this->get_id();
        $filed_args['class'] = 'magic-input-tel magic-input';
        $filed_args['name'] = $settings['field_name'];
        $filed_args['pattern'] = $settings['pattern'];
        
        echo wp_kses(
            $this->general_field($filed_args),
            $this->allowed_generate_filed_html()
        );
    }

    protected function content_template() {
        // Template for live preview in Elementor editor
    }
}

