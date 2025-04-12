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
 * Input_Password Widget
 * 
 * A custom Elementor widget that adds a password input field with customizable label,
 * placeholder, and styling options.
 *
 * @since 1.0.0
 */
class Input_Password extends \Elementor\Widget_Base {
    use Fields;
    use General_Style_Control;
    /**
     * Get widget name.
     *
     * Retrieve Input Password widget unique identifier.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'magic_input_password_light';
    }

    /**
     * Get widget title.
     *
     * Retrieve Input Password widget title displayed in Elementor editor.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Magic Input Password', 'magic-extra-field-light');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Input Password widget icon displayed in Elementor editor.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-lock-user';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Input Password widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['magic-extra-field-light'];
    }
    public function get_style_depends() {
        return ['magic-extra-field-light-style'];
    }

    /**
     * Register widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     * Includes filters to allow other plugins to extend the controls.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'magic-extra-field-light'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        // Allow filtering of content controls before adding defaults
        $content_controls = apply_filters('magic_extra_field_light_input_password_content_controls_before', array());

        // Add default content controls
        $default_content_controls = [
            'field_label' => [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Password Field', 'magic-extra-field-light'),
            ],
            'placeholder' => [
                'label' => esc_html__('Placeholder', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter password', 'magic-extra-field-light'),
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
                'default' => esc_html__('input-password-' . $this->get_id(), 'magic-extra-field-light'),
            ]
        ];

        // Merge and filter all content controls
        $content_controls = array_merge($content_controls, $default_content_controls);
        $content_controls = apply_filters('magic_extra_field_light_input_password_content_controls_after', $content_controls);

        // Add all content controls
        foreach ($content_controls as $control_id => $control_args) {
            $this->add_control($control_id, $control_args);
        }

        $this->end_controls_section();

        // Label Style Section
        $this->add_label_style_controls('{{WRAPPER}} .magic-extra-field-field label');
        // Input Style Section
        $this->add_input_style_controls('{{WRAPPER}} .magic-input-password');
    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     * Applies proper escaping and sanitization to output.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        $filed_args = [];
        $filed_args['type'] = 'password';
        $filed_args['label'] = $settings['field_label']; 
        $filed_args['placeholder'] = $settings['placeholder'];
        $filed_args['required'] = $required;
        $filed_args['id'] = 'magic-input-password-' . $this->get_id();
        $filed_args['class'] = 'magic-input-password magic-input';
        $filed_args['name'] = $settings['field_name'];
        echo wp_kses(
            $this->general_field( $filed_args ),
            $this->allowed_generate_filed_html()
        );
    }

    /**
     * Render widget output in the editor.
     *
     * Written as a JavaScript template and used to generate the live preview.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function content_template() {
       
    }
}
