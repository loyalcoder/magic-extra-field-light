<?php
/**
 * Template for checkbox field type
 *
 * This template handles the rendering of checkbox input fields with optional label.
 * It uses the attr_generate() method to build the input attributes.
 *
 * @package MagicExtraFieldLight
 * @since 1.0.0
 *
 * @param array $args {
 *     Array of field arguments.
 *     @type string $id          Field ID attribute
 *     @type string $label       Field label text
 *     @type string $type        Field type (checkbox)
 *     @type string $name        Field name attribute
 *     @type string $value       Field value
 *     @type bool   $checked     Whether checkbox is checked
 *     @type bool   $required    Whether field is required
 *     @type string $class       CSS classes
 * }
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
$parent_class = ['magic-extra-field-field'];
$parent_class[] = $args['type'] ? $args['type'] : '';
?>
<div class="<?php echo esc_attr(join(' ', $parent_class)); ?>">
    <div class="magic-extra-field-field-input">
        <input 
            type="checkbox"
            id="<?php echo esc_attr($args['id']); ?>"
            name="<?php echo esc_attr($args['name']); ?>"
            value="<?php echo esc_attr($args['value']); ?>"
            <?php checked($args['checked'], true); ?>
            <?php echo $args['required'] ? 'required' : ''; ?>
            class="<?php echo esc_attr($args['class']); ?>"
        />
        <?php if ( ! empty( $args['label'] ) ) : ?>
            <label for="<?php echo esc_attr($args['id']); ?>"><?php echo esc_html($args['label']); ?></label>
        <?php endif; ?>
    </div>
</div>