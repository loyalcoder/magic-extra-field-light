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
 * Input_Checkbox Widget
 * 
 * A custom Elementor widget that adds checkbox input fields with customizable labels
 * and styling options.
 *
 * @since 1.0.0
 */
class Input_Checkbox extends \Elementor\Widget_Base {
    use Fields;
    use General_Style_Control;

    public function get_name() {
        return 'magic_input_checkbox_light';
    }

    public function get_title() {
        return esc_html__('Magic Checkbox', 'magic-extra-field-light');
    }

    public function get_icon() {
        return 'eicon-checkbox';
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
        $this->add_control(
            'field_label',
            [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Checkbox Field', 'magic-extra-field-light'),
            ]
        );
        $repeater = new \Elementor\Repeater();

        $repeater->add_control(
            'checkbox_label',
            [
                'label' => esc_html__('Checkbox Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Checkbox Option', 'magic-extra-field-light'),
                'label_block' => true,
            ]
        );

        $repeater->add_control(
            'checkbox_value',
            [
                'label' => esc_html__('Value', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('value', 'magic-extra-field-light'),
            ]
        );

        $repeater->add_control(
            'is_checked',
            [
                'label' => esc_html__('Checked by Default', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magic-extra-field-light'),
                'label_off' => esc_html__('No', 'magic-extra-field-light'),
                'default' => 'no',
            ]
        );

        $this->add_control(
            'checkbox_options',
            [
                'label' => esc_html__('Checkbox Options', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::REPEATER,
                'fields' => $repeater->get_controls(),
                'default' => [
                    [
                        'checkbox_label' => esc_html__('Option 1', 'magic-extra-field-light'),
                        'checkbox_value' => 'option1',
                        'is_checked' => 'no',
                    ],
                    [
                        'checkbox_label' => esc_html__('Option 2', 'magic-extra-field-light'),
                        'checkbox_value' => 'option2',
                        'is_checked' => 'no',
                    ],
                ],
                'title_field' => '{{{ checkbox_label }}}',
            ]
        );

        $this->add_control(
            'field_name',
            [
                'label' => esc_html__('Field Name', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => 'checkbox-group-' . $this->get_id(),
            ]
        );

        $this->add_control(
            'required',
            [
                'label' => esc_html__('Required', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'magic-extra-field-light'),
                'label_off' => esc_html__('No', 'magic-extra-field-light'),
                'default' => 'no',
            ]
        );

        $this->end_controls_section();
        $this->start_controls_section(
            'checkbox_layout_section',
            [
                'label' => esc_html__('Checkbox Layout', 'magic-extra-field-light'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );
        $this->add_control(
            'checkbox_alignment',
            [
                'label' => esc_html__('Alignment', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::CHOOSE,
                'options' => [
                    'vertical' => [
                        'title' => esc_html__('Vertical', 'magic-extra-field-light'),
                        'icon' => 'eicon-v-align-stretch',
                    ],
                    'horizontal' => [
                        'title' => esc_html__('Horizontal', 'magic-extra-field-light'),
                        'icon' => 'eicon-h-align-stretch',
                    ],
                ],
                'default' => 'vertical',
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-checkbox-wrapper' => 'flex-direction: {{VALUE}};',
                ],
                'selectors_dictionary' => [
                    'vertical' => 'column',
                    'horizontal' => 'row',
                ],
            ]
        );
        $this->add_control(
            'checkbox_gap',
            [
                'label' => esc_html__('Gap', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px', 'em', '%'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                    'em' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 0.1,
                    ],
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 10,
                ],
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-checkbox-wrapper' => 'gap: {{SIZE}}{{UNIT}};',
                ],
            ]
        );
        $this->add_control(
            'checkbox_title',
            [
                'label' => esc_html__('Checkbox Title', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::HEADING,
                'separator' => 'before',
            ]
        );
        $this->add_control(
            'checkbox_field_label_color',
            [
                'label' => esc_html__('Color', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-checkbox-label' => 'color: {{VALUE}};',
                ],
            ]
        );
        $this->add_group_control(
            \Elementor\Group_Control_Typography::get_type(),
            [
                'name' => 'checkbox_field_label_typography',
                'label' => esc_html__('Typography', 'magic-extra-field-light'),
                'selector' => '{{WRAPPER}} .magic-extra-field-checkbox-label',
            ]
        );
        $this->add_responsive_control(
            'checkbox_field_label_margin',
            [
                'label' => esc_html__('Margin', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', 'em', '%'],
                'selectors' => [
                    '{{WRAPPER}} .magic-extra-field-checkbox-label' => 'margin: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'default' => [
                    'top' => 0,
                    'right' => 0,
                    'bottom' => 10,
                    'left' => 0,
                    'unit' => 'px',
                    'isLinked' => false,
                ],
            ]
        );
        $this->end_controls_section();
        // checkbox field label style section
        // Label Style Section
        $this->add_label_style_controls('{{WRAPPER}} .magic-extra-field-field label');
        // checkbox style section
        $this->add_checkbox_style_controls('{{WRAPPER}} .magic-checkbox');

    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        ?>
        <div class="magic-extra-field-checkbox-label">
            <?php echo esc_html($settings['field_label']); ?>
        </div>
        <div class="magic-extra-field-checkbox-wrapper flex">
        <?php 
        foreach ($settings['checkbox_options'] as $index => $option) {
            $filed_args = [];
            $filed_args['type'] = 'checkbox';
            $filed_args['label'] = $option['checkbox_label'];
            $filed_args['value'] = $option['checkbox_value'];
            $filed_args['checked'] = $option['is_checked'] === 'yes';
            $filed_args['required'] = $required;
            $filed_args['id'] = 'magic-checkbox-' . $this->get_id() . '-' . $index;
            $filed_args['class'] = 'magic-checkbox';
            $filed_args['name'] = $settings['field_name'] . '[]';
            
            echo wp_kses(
                $this->checkbox_field($filed_args),
                $this->allowed_generate_filed_html()
            );
        }
        ?>
        </div>
        <?php
    }

    protected function content_template() {
        // Add JavaScript template for live preview if needed
    }
}
