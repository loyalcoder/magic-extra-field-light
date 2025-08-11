<?php

/**
 * Template for select field type
 *
 * This template handles the rendering of a select dropdown field with optional label.
 * It uses the attr_generate() method to build the select attributes.
 *
 * @package MagicExtraFieldLight
 * @since 1.0.0
 *
 * @param array $args {
 *     Array of field arguments.
 *     @type string $id          Field ID attribute
 *     @type string $label       Field label text
 *     @type string $type        Field type (select)
 *     @type string $name        Field name attribute
 *     @type string $value       Selected value
 *     @type string $placeholder Field placeholder text
 *     @type bool   $required    Whether field is required
 *     @type string $class       CSS classes
 *     @type array  $options     Array of options (key => label pairs)
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
        <label for="<?php echo esc_attr($args['id']); ?>" class="magic-extra-field-light-d-block magic-field-label">
            <?php echo esc_html($args['label']); ?>
            <?php if ($args['required']) : ?>
                <span class="magic-extra-field-required">*</span>
            <?php endif; ?>
        </label>
    <?php endif; ?>
    <div class="magic-extra-field-field-input">
        <select <?php echo wp_kses_data($this->attr_generate($args)); ?>>
            <?php if (! empty($args['placeholder'])) : ?>
                <option value=""><?php echo esc_html($args['placeholder']); ?></option>
            <?php endif; ?>
            <?php if (! empty($args['options'])) : ?>
                <?php foreach ($args['options'] as $value => $label) : ?>
                    <option value="<?php echo esc_attr($value); ?>" <?php selected($value, $args['value']); ?>><?php echo esc_html($label); ?></option>
                <?php endforeach; ?>
            <?php endif; ?>
        </select>
    </div>
</div>