<?php
/**
 * Template for textarea field type
 *
 * This template handles the rendering of a textarea field with optional label.
 * It uses the attr_generate() method to build the textarea attributes.
 *
 * @package MagicExtraFieldLight
 * @since 1.0.0
 *
 * @param array $args {
 *     Array of field arguments.
 *     @type string $id          Field ID attribute
 *     @type string $label       Field label text
 *     @type string $type        Field type (textarea)
 *     @type string $name        Field name attribute
 *     @type string $value       Field value
 *     @type string $placeholder Field placeholder text
 *     @type bool   $required    Whether field is required
 *     @type string $class       CSS classes
 *     @type int    $rows        Number of rows (optional)
 *     @type int    $cols        Number of columns (optional)
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
        <?php 
            unset($args['type']);
            
        ?>
        <textarea <?php echo wp_kses_data($this->attr_generate($args)); ?>><?php echo esc_textarea($args['value'] ?? ''); ?></textarea>
    </div>
</div>