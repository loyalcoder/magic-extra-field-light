<?php
namespace MagicExtraField\Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use MagicExtraField\Traits\Fields;

/**
 * Input_Text Widget
 * 
 * A custom Elementor widget that adds a text input field with customizable label,
 * placeholder, and styling options.
 *
 * @since 1.0.0
 */
class Input_Text extends \Elementor\Widget_Base {
    use Fields;
    /**
     * Get widget name.
     *
     * Retrieve Input Text widget unique identifier.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'magic_input_text';
    }

    /**
     * Get widget title.
     *
     * Retrieve Input Text widget title displayed in Elementor editor.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Magic Input Text New', 'magic-extra-field');
    }

    /**
     * Get widget icon.
     *
     * Retrieve Input Text widget icon displayed in Elementor editor.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-text-field';
    }

    /**
     * Get widget categories.
     *
     * Retrieve the list of categories the Input Text widget belongs to.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['magic-extra-field'];
    }

    /**
     * Register widget controls.
     *
     * Add input fields to allow the user to customize the widget settings.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'magic-extra-field'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'field_label',
            [
                'label' => esc_html__('Field Label', 'magic-extra-field'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Text Field', 'magic-extra-field'),
            ]
        );

        $this->add_control(
            'placeholder',
            [
                'label' => esc_html__('Placeholder', 'magic-extra-field'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter text here', 'magic-extra-field'),
            ]
        );

        $this->add_control(
            'required',
            [
                'label' => esc_html__('Required', 'magic-extra-field'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magic-extra-field'),
                'label_off' => esc_html__('No', 'magic-extra-field'),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'field_name',
            [
                'label' => esc_html__('Name', 'magic-extra-field'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('input-text-' . $this->get_id(), 'magic-extra-field'),
            ]
        );

        $this->end_controls_section();

        // Style Section
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'magic-extra-field'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .magic-input-text',
            ]
        );

        $this->add_control(
            'input_text_color',
            [
                'label' => esc_html__('Text Color', 'magic-extra-field'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-input-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     *
     * Written in PHP and used to generate the final HTML.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        $filed_args = [];
        $filed_args['type'] = 'text';
        $filed_args['label'] = $settings['field_label'];
        $filed_args['placeholder'] = $settings['placeholder'];
        $filed_args['required'] = $required;
        $filed_args['id'] = 'magic-input-text-' . $this->get_id();
        $filed_args['class'] = 'magic-input-text';
        $filed_args['name'] = $settings['field_name'];
        echo wp_kses(
            $this->general_field( $filed_args ),
            array(
                'input' => array(
                    'type' => array(),
                    'name' => array(),
                    'id' => array(),
                    'class' => array(),
                    'value' => array(),
                    'placeholder' => array(),
                    'required' => array(),
                    'style' => array()
                ),
                'label' => array(
                    'for' => array(),
                    'class' => array()
                ),
                'div' => array(
                    'class' => array(),
                    'id' => array(),
                    'style' => array()
                )
            )
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

