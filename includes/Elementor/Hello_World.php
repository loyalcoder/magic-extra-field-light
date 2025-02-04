<?php

namespace MagicExtraField\Elementor;

use Elementor\Controls_Manager;
use Elementor\Widget_Base;

if (!defined('ABSPATH')) {
    exit;
}

/**
 * Hello World Widget
 *
 * Elementor widget for displaying a hello world message.
 *
 * @since 1.0.0
 */
class Hello_World extends Widget_Base
{
    /**
     * Get widget name
     *
     * @since 1.0.0
     * @return string Widget name
     */
    public function get_name()
    {
        return 'magic_extra_field_hello_world';
    }

    /**
     * Get widget title
     *
     * @since 1.0.0
     * @return string Widget title
     */
    public function get_title()
    {
        return esc_html__('Hello World', 'magic-extra-field');
    }

    /**
     * Get widget icon
     *
     * @since 1.0.0
     * @return string Widget icon
     */
    public function get_icon()
    {
        return 'eicon-search-results';
    }

    /**
     * Get widget categories
     *
     * @since 1.0.0
     * @return array Widget categories
     */
    public function get_categories()
    {
        return ['magic-extra-field'];
    }

    /**
     * Get script dependencies
     *
     * @since 1.0.0
     * @return array Script dependencies
     */
    public function get_script_depends()
    {
        return ['magic-extra-field-script'];
    }

    /**
     * Register widget controls
     *
     * @since 1.0.0
     * @return void
     */
    protected function register_controls()
    {
        $this->register_content_controls();
        $this->register_style_controls();
    }

    /**
     * Register content controls
     *
     * @since 1.0.0
     * @return void
     */
    protected function register_content_controls()
    {
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Content', 'magic-extra-field'),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'title',
            [
                'label' => esc_html__('Title', 'magic-extra-field'),
                'type' => Controls_Manager::TEXT,
                'default' => esc_html__('Hello World', 'magic-extra-field'),
                'label_block' => true,
                'dynamic' => [
                    'active' => true,
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Register style controls
     *
     * @since 1.0.0
     * @return void
     */
    protected function register_style_controls()
    {
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'magic-extra-field'),
                'tab' => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'min_height',
            [
                'label' => esc_html__('Min Height', 'magic-extra-field'),
                'type' => Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 1000,
                        'step' => 1,
                    ],
                ],
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-hello-world' => 'min-height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'background_color',
            [
                'label' => esc_html__('Background Color', 'magic-extra-field'),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-hello-world' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'padding',
            [
                'label' => esc_html__('Padding', 'magic-extra-field'),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em'],
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-hello-world' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output
     *
     * @since 1.0.0
     * @return void
     */
    protected function render()
    {
        $settings = $this->get_settings_for_display();
        include MAGIC_EXTRA_FIELD_PATH . '/templates/elementor/hello-world.php';
    }

    /**
     * Render plain content
     *
     * @since 1.0.0
     * @return void
     */
    public function render_plain_content()
    {
        // Render plain content
    }

    /**
     * Content template
     *
     * @since 1.0.0
     * @return void
     */
    protected function content_template()
    {
        // Content template
    }
}
