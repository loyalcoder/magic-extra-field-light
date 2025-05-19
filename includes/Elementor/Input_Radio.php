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
 * Input_Radio Widget
 * 
 * A custom Elementor widget that adds a radio input field with customizable label,
 * options, and styling options.
 *
 * @since 1.0.0
 */
class Input_Radio extends \Elementor\Widget_Base {
    use Fields;
    use General_Style_Control;

    public function get_name() {
        return 'magic_input_radio_light';
    }

    public function get_title() {
        return esc_html__('Magic Input Radio', 'magic-extra-field-light');
    }

    public function get_icon() {
        return 'eicon-radio';
    }

    public function get_categories() {
        return ['magic-extra-field-light'];
    }

    public function get_style_depends() {
        return ['magic-extra-field-light-style'];
    }

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
        $content_controls = apply_filters('magic_extra_field_light_input_radio_content_controls_before', array());

        // Add default content controls
        $default_content_controls = [
            'field_label' => [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Radio Field', 'magic-extra-field-light'),
            ],
            'field_name' => [
                'label' => esc_html__('Name', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('input-radio-', 'magic-extra-field-light'),
            ],
            'required' => [
                'label' => esc_html__('Required', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magic-extra-field-light'),
                'label_off' => esc_html__('No', 'magic-extra-field-light'),
                'default' => 'no',
            ],
        ];

        // Create repeater instance
        $repeater = new \Elementor\Repeater();

        // Add repeater controls
        $repeater->add_control(
            'option_label',
            [
                'label' => esc_html__('Option Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Option', 'magic-extra-field-light'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'option_value',
            [
                'label' => esc_html__('Option Value', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => '',
                'label_block' => true,
            ]
        );

        // Add radio options repeater control
        $default_content_controls['radio_options'] = [
            'label' => esc_html__('Radio Options', 'magic-extra-field-light'),
            'type' => \Elementor\Controls_Manager::REPEATER,
            'fields' => $repeater->get_controls(),
            'default' => [
                [
                    'option_label' => esc_html__('Option 1', 'magic-extra-field-light'),
                    'option_value' => 'option1',
                ],
                [
                    'option_label' => esc_html__('Option 2', 'magic-extra-field-light'),
                    'option_value' => 'option2',
                ],
            ],
            'title_field' => '{{{ option_label }}}',
        ];

        // Merge and filter all content controls
        $content_controls = array_merge($content_controls, $default_content_controls);
        $content_controls = apply_filters('magic_extra_field_light_input_radio_content_controls_after', $content_controls);

        // Add all content controls
        foreach ($content_controls as $control_id => $control_args) {
            $this->add_control($control_id, $control_args);
        }

        $this->end_controls_section();

        // Label Style Section
        $this->add_label_style_controls('{{WRAPPER}} .magic-extra-field-field label');
        // Radio Style Section
        // Radio Style Section
        $this->start_controls_section(
            'radio_style_section',
            [
                'label' => esc_html__('Radio Style', 'magic-extra-field-light'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'radio_size',
            [
                'label' => esc_html__('Size', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                    'rem' => [
                        'min' => 1,
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .magic-input-radio' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'radio_label_color',
            [
                'label' => esc_html__('Label Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-radio-option label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'radio_label_typography',
                'label' => esc_html__('Label Typography', 'magic-extra-field-light'),
                'selector' => '{{WRAPPER}} .magic-extra-field-radio-option label',
            ]
        );
        $this->add_responsive_control(
            'radio_label_margin',
            [
                'label' => esc_html__('Label Margin', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', 'rem', '%'],
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-radio-option label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'radio_layout',
            [
                'label' => esc_html__('Layout', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'column' => [
                        'title' => esc_html__('Vertical', 'magic-extra-field-light'),
                        'icon' => 'eicon-v-align-stretch',
                    ],
                    'row' => [
                        'title' => esc_html__('Horizontal', 'magic-extra-field-light'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'default' => 'column',
                'toggle' => true,
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-field-input' => 'display: flex; flex-direction: {{VALUE}}; flex-wrap: wrap;',
                ],
            ]
        );
        $this->add_responsive_control(
            'radio_spacing',
            [
                'label' => esc_html__('Spacing', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', 'rem'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 50,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                    'rem' => [
                        'min' => 0,
                        'max' => 5,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-field-input' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        $filed_args = [];
        $filed_args['type'] = 'radio';
        $filed_args['label'] = $settings['field_label'];
        $filed_args['required'] = $required;
        $filed_args['id'] = 'magic-input-radio-' . $this->get_id();
        $filed_args['class'] = 'magic-input-radio magic-input';
        $filed_args['name'] = $settings['field_name'];
        $filed_args['options'] = $settings['radio_options'];
        
        echo wp_kses(
            $this->general_field($filed_args),
            $this->allowed_generate_filed_html()
        );
    }

    protected function content_template() {
        // Add live preview template if needed
    }
}
