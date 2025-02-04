<?php 
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
?>
<div class="magic-extra-field-field">
    <?php if ( ! empty( $args['label'] ) ) : ?>
        <label for="<?php echo esc_attr($args['id']); ?>"><?php echo esc_html($args['label']); ?></label>
    <?php endif; ?>
    <div class="magic-extra-field-field-input">
        <input <?php echo wp_kses_data($this->attr_generate($args)); ?> />
    </div>
</div>