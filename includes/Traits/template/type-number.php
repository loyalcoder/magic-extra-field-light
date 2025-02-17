<?php
/**
 * Template for text field type
 *
 * This template handles the rendering of a text input field with optional label.
 * It uses the attr_generate() method to build the input attributes.
 *
 * @package MagicExtraFieldLight
 * @since 1.0.0
 *
 * @param array $args {
 *     Array of field arguments.
 *     @type string $id          Field ID attribute
 *     @type string $label       Field label text
 *     @type string $type        Field type (text)
 *     @type string $name        Field name attribute
 *     @type string $value       Field value
 *     @type string $placeholder Field placeholder text
 *     @type bool   $required    Whether field is required
 *     @type string $class       CSS classes
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="magic-extra-field-field">
    <?php if ( ! empty( $args['label'] ) ) : ?>
        <label for="<?php echo esc_attr($args['id']); ?>"><?php echo esc_html($args['label']); ?></label>
    <?php endif; ?>
    <div class="magic-extra-field-field-input">
        <input <?php echo wp_kses_data($this->attr_generate($args)); ?> value="<?php echo isset($args['value']) ? esc_attr($args['value']) : ''; ?>"  min="<?php echo isset($args['min']) ? esc_attr($args['min']) : '0'; ?>"
/>
    </div>
</div>