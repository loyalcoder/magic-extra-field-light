<?php
/**
 * Template for password field type
 *
 * This template handles the rendering of a password input field with optional label.
 * It uses the attr_generate() method to build the input attributes.
 *
 * @package MagicExtraFieldLight
 * @since 1.0.0
 *
 * @param array $args {
 *     Array of field arguments.
 *     @type string $id          Field ID attribute
 *     @type string $label       Field label text
 *     @type string $type        Field type (password)
 *     @type string $name        Field name attribute
 *     @type string $value       Field value
 *     @type string $placeholder Field placeholder text
 *     @type bool   $required    Whether field is required
 *     @type string $class       CSS classes
 *     @type bool   $show_password Whether to show password toggle button
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$parent_class = ['magic-extra-field-field'];
$parent_class[] = $args['type'] ? $args['type'] : '';
?>
<div class="<?php echo esc_attr(join(' ', $parent_class)); ?>">
    <?php if ( ! empty( $args['label'] ) ) : ?>
        <label for="<?php echo esc_attr($args['id']); ?>" class="magic-extra-field-light-d-block"><?php echo esc_html($args['label']); ?></label>
    <?php endif; ?>
    <div class="magic-extra-field-field-input">
        <input <?php echo wp_kses_data($this->attr_generate($args)); ?> />
        <?php if ( ! empty( $args['show_password'] ) ) : ?>
            <button type="button" class="magic-extra-field-toggle-password" aria-label="<?php echo esc_attr__('Show password', 'magic-extra-field-light'); ?>">
                <span class="dashicons dashicons-visibility"></span>
            </button>
        <?php endif; ?>
    </div>
</div>