<?php
namespace MagicExtraFieldLight\Elementor;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
use Elementor\Controls_Manager;
use Elementor\Group_Control_Typography;
use Elementor\Widget_Base;
use MagicExtraFieldLight\Traits\Fields;
use Elementor\Group_Control_Background;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

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
        return 'magic_input_text_light';
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
        return esc_html__('Magic Input Text New', 'magic-extra-field-light');
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
        $content_controls = apply_filters('magic_extra_field_light_input_text_content_controls_before', array());

        // Add default content controls
        $default_content_controls = [
            'field_label' => [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Text Field', 'magic-extra-field-light'),
            ],
            'placeholder' => [
                'label' => esc_html__('Placeholder', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Enter text here', 'magic-extra-field-light'),
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
                'default' => esc_html__('input-text-' . $this->get_id(), 'magic-extra-field-light'),
            ]
        ];

        // Merge and filter all content controls
        $content_controls = array_merge($content_controls, $default_content_controls);
        $content_controls = apply_filters('magic_extra_field_light_input_text_content_controls_after', $content_controls);

        // Add all content controls
        foreach ($content_controls as $control_id => $control_args) {
            $this->add_control($control_id, $control_args);
        }

        $this->end_controls_section();

        // Label Style Section
        $this->start_controls_section(
            'label_style_section',
            [
                'label' => esc_html__('Label Style', 'magic-extra-field-light'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .magic-extra-field-field label',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-field label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'label_margin',
            [
                'label' => esc_html__('Margin', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-field label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();

        // Input Style Section
        $this->start_controls_section(
            'input_style_section',
            [
                'label' => esc_html__('Input Style', 'magic-extra-field-light'),
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
            'input_color',
            [
                'label' => esc_html__('Text Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-input-text' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'placeholder_color',
            [
                'label' => esc_html__('Placeholder Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-input-text::placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .magic-input-text::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .magic-input-text::-moz-placeholder' => 'color: {{VALUE}};',
                    '{{WRAPPER}} .magic-input-text:-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'input_background',
                'label' => esc_html__('Background', 'magic-extra-field-light'),
                'types' => ['classic', 'gradient'],
                'selector' => '{{WRAPPER}} .magic-input-text',
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .magic-input-text' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'input_margin',
            [
                'label' => esc_html__('Margin', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .magic-input-text' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs('input_border_tabs');

        // Normal Tab
        $this->start_controls_tab(
            'input_border_normal_tab',
            [
                'label' => esc_html__('Normal', 'magic-extra-field-light'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'label' => esc_html__('Border', 'magic-extra-field-light'),
                'selector' => '{{WRAPPER}} .magic-input-text',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow',
                'label' => esc_html__('Box Shadow', 'magic-extra-field-light'),
                'selector' => '{{WRAPPER}} .magic-input-text',
            ]
        );

        $this->end_controls_tab();

        // Focus Tab
        $this->start_controls_tab(
            'input_border_focus_tab',
            [
                'label' => esc_html__('Focus', 'magic-extra-field-light'),
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'input_border_focus',
                'label' => esc_html__('Border', 'magic-extra-field-light'),
                'selector' => '{{WRAPPER}} .magic-input-text:focus',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow_focus',
                'label' => esc_html__('Box Shadow', 'magic-extra-field-light'),
                'selector' => '{{WRAPPER}} .magic-input-text:focus',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
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
        $filed_args['type'] = 'text';
        $filed_args['label'] = $settings['field_label']; 
        $filed_args['placeholder'] = $settings['placeholder'];
        $filed_args['required'] = $required;
        $filed_args['id'] = 'magic-input-text-' . $this->get_id();
        $filed_args['class'] = 'magic-input-text magic-input';
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
