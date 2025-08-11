<?php

/**
 * Template for radio field type
 *
 * This template handles the rendering of radio input fields with optional label.
 * It uses the attr_generate() method to build the input attributes.
 *
 * @package MagicExtraFieldLight
 * @since 1.0.0
 *
 * @param array $args {
 *     Array of field arguments.
 *     @type string $id          Field ID attribute
 *     @type string $label       Field label text
 *     @type string $type        Field type (radio)
 *     @type string $name        Field name attribute
 *     @type string $value       Field value
 *     @type array  $options     Radio options array
 *     @type bool   $required    Whether field is required
 *     @type string $class       CSS classes
 * }
 */

if (! defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
$parent_class = ['magic-extra-field-field'];
$parent_class[] = $args['type'] ? $args['type'] : '';
?>
<div class="<?php echo esc_attr(join(' ', $parent_class)); ?>">
    <?php if (! empty($args['label'])) : ?>
        <label class="magic-extra-field-light-d-block magic-field-label">
            <?php echo esc_html($args['label']); ?>
            <?php if ($args['required']) : ?>
                <span class="magic-extra-field-required">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>
    <div class="magic-extra-field-field-input">
        <?php if (! empty($args['options'])) : ?>
            <?php foreach ($args['options'] as $option) : ?>
                <div class="magic-extra-field-radio-option">
                    <input
                        type="radio"
                        id="<?php echo esc_attr($args['id'] . '-' . $option['option_value']); ?>"
                        name="<?php echo esc_attr($args['name']); ?>"
                        value="<?php echo esc_attr($option['option_value']); ?>"
                        <?php checked($args['value'], $option['option_value']); ?>
                        <?php echo $args['required'] ? 'required' : ''; ?>
                        class="magic-input-radio" />
                    <label for="<?php echo esc_attr($args['id'] . '-' . $option['option_value']); ?>">
                        <?php echo esc_html($option['option_label']); ?>
                    </label>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>