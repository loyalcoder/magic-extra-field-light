<?php
namespace MagicExtraFieldLight\Traits;

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}

trait General_Style_Control {
    /**
     * Add label style controls
     *
     * @param string $selector CSS selector for the label
     * @return void
     */
    protected function add_label_style_controls($selector = '{{WRAPPER}} .magic-extra-field-field label') {
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
                'selector' => $selector,
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Label Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'color: {{VALUE}};',
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
                    $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Add input style controls
     *
     * @param string $selector CSS selector for the input
     * @return void
     */
    protected function add_input_style_controls($selector = '{{WRAPPER}} .magic-input-text') {
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
                'selector' => $selector,
            ]
        );

        $this->add_control(
            'input_color',
            [
                'label' => esc_html__('Text Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    $selector => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'placeholder_color',
            [
                'label' => esc_html__('Placeholder Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    $selector . '::placeholder' => 'color: {{VALUE}};',
                    $selector . '::-webkit-input-placeholder' => 'color: {{VALUE}};',
                    $selector . '::-moz-placeholder' => 'color: {{VALUE}};',
                    $selector . ':-ms-input-placeholder' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Background::get_type(),
            [
                'name' => 'input_background',
                'label' => esc_html__('Background', 'magic-extra-field-light'),
                'types' => ['classic', 'gradient'],
                'selector' => $selector,
            ]
        );

        $this->add_responsive_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    $selector => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                    $selector => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
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
                'selector' => $selector,
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow',
                'label' => esc_html__('Box Shadow', 'magic-extra-field-light'),
                'selector' => $selector,
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
                'selector' => $selector . ':focus',
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow_focus',
                'label' => esc_html__('Box Shadow', 'magic-extra-field-light'),
                'selector' => $selector . ':focus',
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();

        $this->end_controls_section();
    }
    /**
     * Add checkbox style controls
     *
     * @param string $selector CSS selector for the checkbox
     * @return void
     */
    protected function add_checkbox_style_controls($selector = '{{WRAPPER}} .magic-input-checkbox') {
                // Style controls
                $this->start_controls_section(
                    'style_section',
                    [
                        'label' => esc_html__( 'Checkbox Style', 'magic-extra-field-light' ),
                        'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                    ]
                );
                $this->add_control(
                    'checkbox_border_color',
                    [
                        'label' => esc_html__('Border Color', 'magic-extra-field-light'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            $selector . ' + label:before' => 'border-color: {{VALUE}} !important;',
                        ],
                    ]
                );
                $this->add_control(
                    'checkbox_checked_bg_color',
                    [
                        'label' => esc_html__('Checked Background Color', 'magic-extra-field-light'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            $selector . ':checked + label:after' => 'background-color: {{VALUE}} !important;',
                            $selector . ':checked + label:before' => 'border-color: {{VALUE}} !important;',
                        ],
                    ]
                );

                $this->add_control(
                    'checkbox_checked_border_color',
                    [
                        'label' => esc_html__('Checked Border Color', 'magic-extra-field-light'),
                        'type' => \Elementor\Controls_Manager::COLOR,
                        'selectors' => [
                            $selector . ':checked + label:after' => 'border-color: {{VALUE}} !important;',
                        ],
                    ]
                );
                
                
                $this->end_controls_section();
    }
}

