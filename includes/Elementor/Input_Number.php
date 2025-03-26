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
 * Input_Number Widget
 * 
 * A custom Elementor widget that adds a number input field with customizable label,
 * placeholder, min/max values and styling options.
 *
 * @since 1.0.0
 */
class Input_Number extends \Elementor\Widget_Base {
    use Fields;

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
        $this->start_controls_section(
            'style_section',
            [
                'label' => esc_html__('Style', 'magic-extra-field-light'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'label_heading',
            [
                'label' => esc_html__('Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::HEADING,
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'label_typography',
                'selector' => '{{WRAPPER}} .magic-field-label',
            ]
        );

        $this->add_control(
            'label_color',
            [
                'label' => esc_html__('Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-field-label' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'input_heading',
            [
                'label' => esc_html__('Input', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'input_typography',
                'selector' => '{{WRAPPER}} .magic-input-number',
            ]
        );

        $this->add_group_control(
            Group_Control_Background::get_type(),
            [
                'name' => 'input_background',
                'selector' => '{{WRAPPER}} .magic-input-number',
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'input_border',
                'selector' => '{{WRAPPER}} .magic-input-number',
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'input_box_shadow',
                'selector' => '{{WRAPPER}} .magic-input-number',
            ]
        );

        $this->add_control(
            'input_border_radius',
            [
                'label' => esc_html__('Border Radius', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'selectors' => [
                    '{{WRAPPER}} .magic-input-number' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'input_padding',
            [
                'label' => esc_html__('Padding', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .magic-input-number' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();
        
        $field_id = 'magic_input_' . $this->get_id();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        
        ?>
        <div class="magic-input-wrapper">
            <?php if (!empty($settings['field_label'])) : ?>
                <label class="magic-field-label" for="<?php echo esc_attr($field_id); ?>">
                    <?php echo esc_html($settings['field_label']); ?>
                    <?php if ($required) : ?>
                        <span class="required">*</span>
                    <?php endif; ?>
                </label>
            <?php endif; ?>
            
            <input 
                type="number" 
                id="<?php echo esc_attr($field_id); ?>"
                class="magic-input-number"
                name="<?php echo esc_attr($settings['field_name']); ?>"
                placeholder="<?php echo esc_attr($settings['placeholder']); ?>"
                min="<?php echo esc_attr($settings['min_value']); ?>"
                max="<?php echo esc_attr($settings['max_value']); ?>"
                step="<?php echo esc_attr($settings['step']); ?>"
                <?php echo esc_attr($required); ?>
            >
        </div>
        <?php
    }
}
