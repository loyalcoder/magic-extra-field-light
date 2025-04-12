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
 * Input_Number Widget
 * 
 * A custom Elementor widget that adds a number input field with customizable label,
 * placeholder, min/max values and styling options.
 *
 * @since 1.0.0
 */
class Input_Number extends \Elementor\Widget_Base {
    use Fields;
    use General_Style_Control;
    /**
     * Get widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'magic_input_number_light';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Magic Input Number', 'magic-extra-field-light');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-number-field';
    }

    /**
     * Get widget categories.
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

        $content_controls = apply_filters('magic_extra_field_light_input_number_content_controls_before', array());

        $default_content_controls = [
            'field_label' => [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Number Field', 'magic-extra-field-light'),
            ],
            'placeholder' => [
                'label' => esc_html__('Placeholder', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter number', 'magic-extra-field-light'),
            ],
            'min_value' => [
                'label' => esc_html__('Minimum Value', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 0,
            ],
            'max_value' => [
                'label' => esc_html__('Maximum Value', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 100,
            ],
            'step' => [
                'label' => esc_html__('Step', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::NUMBER,
                'default' => 1,
                'min' => 0.1,
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
                'default' => 'number_field',
            ],
        ];

        $content_controls = array_merge($content_controls, $default_content_controls);
        $content_controls = apply_filters('magic_extra_field_light_input_number_content_controls_after', $content_controls);

        foreach ($content_controls as $control_id => $control_args) {
            $this->add_control($control_id, $control_args);
        }

        $this->end_controls_section();

        // Style Section
        $this->add_label_style_controls('{{WRAPPER}} .magic-extra-field-field label');
        $this->add_input_style_controls('{{WRAPPER}} .magic-input-number');
    }

    /**
     * Render widget output on the frontend.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $field_id                  = 'magic_input_' . $this->get_id();
        $required                  = $settings['required'] === 'yes' ? 'required' : '';
        $filed_args                = [];
        $filed_args['type']        = 'number';
        $filed_args['label']       = $settings['field_label'];
        $filed_args['placeholder'] = $settings['placeholder'];
        $filed_args['required']    = $required;
        $filed_args['id']          = 'magic-input-number-' . $this->get_id();
        $filed_args['class']       = 'magic-input-number magic-input';
        $filed_args['name']        = $settings['field_name'];
        $filed_args['min']         = $settings['min_value'];
        $filed_args['max']         = $settings['max_value'];
        $filed_args['step']        = $settings['step'];
        echo wp_kses(
            $this->general_field( $filed_args ),
            $this->allowed_generate_filed_html()
        );
    }
}
