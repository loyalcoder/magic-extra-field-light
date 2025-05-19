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
 * Input_Select Widget
 * 
 * A custom Elementor widget that adds a select input field with customizable label,
 * options, and styling options.
 *
 * @since 1.0.0
 */
class Input_Select extends \Elementor\Widget_Base {
    use Fields;
    use General_Style_Control;

    public function get_name() {
        return 'magic_input_select_light';
    }

    public function get_title() {
        return esc_html__('Magic Input Select', 'magic-extra-field-light');
    }

    public function get_icon() {
        return 'eicon-select';
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
        $content_controls = apply_filters('magic_extra_field_light_input_select_content_controls_before', array());

        // Add default content controls
        $default_content_controls = [
            'field_label' => [
                'label' => esc_html__('Field Label', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Select Field', 'magic-extra-field-light'),
            ],
            'placeholder' => [
                'label' => esc_html__('Placeholder', 'magic-extra-field-light'),
                'type' => \Elementor\Controls_Manager::TEXT,
                'default' => esc_html__('Select an option', 'magic-extra-field-light'),
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
                'default' => esc_html__('input-select-', 'magic-extra-field-light'),
            ],
        ];

        // Create repeater for select options
        $repeater = new \Elementor\Repeater();

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

        // Add select options repeater control
        $default_content_controls['select_options'] = [
            'label' => esc_html__('Select Options', 'magic-extra-field-light'),
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
        $content_controls = apply_filters('magic_extra_field_light_input_select_content_controls_after', $content_controls);

        // Add all content controls
        foreach ($content_controls as $control_id => $control_args) {
            $this->add_control($control_id, $control_args);
        }

        $this->end_controls_section();

        // Label Style Section
        $this->add_label_style_controls('{{WRAPPER}} .magic-extra-field-field label');
        // Select Style Section
        $this->add_input_style_controls('{{WRAPPER}} .magic-input-select');
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $required = $settings['required'] === 'yes' ? 'required' : '';
        
        $filed_args = [];
        $filed_args['type'] = 'select';
        $filed_args['label'] = $settings['field_label'];
        $filed_args['placeholder'] = $settings['placeholder'];
        $filed_args['required'] = $required;
        $filed_args['id'] = 'magic-input-select-' . $this->get_id();
        $filed_args['class'] = 'magic-input-select magic-input';
        $filed_args['name'] = $settings['field_name'];
        
        // Add options
        $filed_args['options'] = [];
        foreach ($settings['select_options'] as $option) {
            $filed_args['options'][$option['option_value']] = $option['option_label'];
        }

        echo wp_kses(
            $this->general_field($filed_args),
            $this->allowed_generate_filed_html()
        );
    }

    protected function content_template() {
        ?>
        <div class="magic-extra-field-field">
            <label>{{{ settings.field_label }}}</label>
            <select class="magic-input-select magic-input" name="{{{ settings.field_name }}}" id="magic-input-select-{{ view.getID() }}" {{{ settings.required === 'yes' ? 'required' : '' }}}>
                <option value="">{{{ settings.placeholder }}}</option>
                <# if (settings.select_options) { #>
                    <# _.each(settings.select_options, function(option) { #>
                        <option value="{{{ option.option_value }}}">{{{ option.option_label }}}</option>
                    <# }); #>
                <# } #>
            </select>
        </div>
        <?php
    }
}
