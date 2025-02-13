<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$is_active = get_post_meta($post_id, '_magic_ef_is_active', true);
$display_type = get_post_meta($post_id, '_magic_ef_display_type', true);
$selected_products = get_post_meta($post_id, '_magic_ef_selected_products', true);
$selected_taxonomy = get_post_meta($post_id, '_magic_ef_selected_taxonomy', true);
$selected_terms = get_post_meta($post_id, '_magic_ef_selected_terms', true);
$post_title = get_the_title($post_id);
?>
<div class="magic-ef-options-wrapper">
    <div class="header-wrapper">
        <h2><?php echo esc_html($post_title); ?></h2>
        <hr>
    </div>
    <div class="magic-ef-toggle-wrapper">
        <label class="magic-ef-toggle">
            <input type="checkbox" name="is_active" value="1" <?php checked($is_active, '1'); ?>>
            <span class="slider round"></span>
            <span class="magic-ef-toggle-text"><?php esc_html_e('Active', 'magic-extra-field-light'); ?></span>
        </label>
    </div>

    <div class="magic-ef-display-options" style="display: <?php echo $is_active ? 'block' : 'none'; ?>">
        <p>
            <label for="display_type"><?php esc_html_e('Display Type:', 'magic-extra-field-light'); ?></label>
            <select name="display_type" id="display_type">
                <option value="all" <?php selected($display_type, 'all'); ?>><?php esc_html_e('All Products', 'magic-extra-field-light'); ?></option>
                <option value="specific" <?php selected($display_type, 'specific'); ?>><?php esc_html_e('Specific Products', 'magic-extra-field-light'); ?></option>
                <option value="taxonomy" <?php selected($display_type, 'taxonomy'); ?>><?php esc_html_e('By Taxonomy', 'magic-extra-field-light'); ?></option>
            </select>
        </p>

        <div id="specific_products" style="display: <?php echo $display_type === 'specific' ? 'block' : 'none'; ?>">
            <p>
                <label><?php esc_html_e('Select Products:', 'magic-extra-field-light'); ?></label>
                <select name="selected_products[]" multiple class="magic-ef-product-select" style="width: 100%">
                    <?php
                    // Display selected products first
                    if (!empty($selected_products)) {
                        foreach ($selected_products as $product_id) {
                            $product = wc_get_product($product_id);
                            if ($product) {
                                echo '<option value="' . esc_attr($product_id) . '" selected>' . esc_html($product->get_name()) . '</option>';
                            }
                        }
                    }
                    // Display all other products
                    foreach ($products as $product) {
                        if (!in_array($product->get_id(), (array)$selected_products)) {
                            echo '<option value="' . esc_attr($product->get_id()) . '">' . esc_html($product->get_name()) . '</option>';
                        }
                    }
                    ?>
                </select>
            </p>
        </div>

        <div id="taxonomy_options" style="display: <?php echo $display_type === 'taxonomy' ? 'block' : 'none'; ?>">
            <p>
                <label for="selected_taxonomy"><?php esc_html_e('Select Taxonomy:', 'magic-extra-field-light'); ?></label>
                <select name="selected_taxonomy" id="selected_taxonomy">
                    <option value=""><?php esc_html_e('Select a taxonomy', 'magic-extra-field-light'); ?></option>
                    <?php
                    $excluded_taxonomies = array(
                        'pa_*', // Product attributes
                        'product_visibility',
                        'product_shipping_class', 
                        'pa_color',
                        'pa_size'
                    );
                    foreach ($taxonomies as $taxonomy) {
                        // Skip excluded taxonomies
                        if (in_array($taxonomy->name, $excluded_taxonomies) || preg_match('/^pa_/', $taxonomy->name)) {
                            continue;
                        }
                        echo '<option value="' . esc_attr($taxonomy->name) . '" ' . selected($selected_taxonomy, $taxonomy->name, false) . '>' . esc_html($taxonomy->label) . '</option>';
                    }
                    ?>
                </select>
            </p>

            <div id="terms_selection" style="display: <?php echo !empty($selected_taxonomy) ? 'block' : 'none'; ?>">
                <p>
                    <label><?php esc_html_e('Select Terms:', 'magic-extra-field-light'); ?></label>
                    <select name="selected_terms[]" multiple class="magic-ef-term-select" style="width: 100%">
                        <?php
                        if (!empty($selected_taxonomy)) {
                            // Get all terms for the selected taxonomy
                            $terms = get_terms([
                                'taxonomy' => $selected_taxonomy,
                                'hide_empty' => false
                            ]);

                            // Display selected terms first
                            if (!empty($selected_terms)) {
                                foreach ($selected_terms as $term_id) {
                                    $term = get_term($term_id, $selected_taxonomy);
                                    if ($term && !is_wp_error($term)) {
                                        echo '<option value="' . esc_attr($term_id) . '" selected>' . esc_html($term->name) . '</option>';
                                    }
                                }
                            }

                            // Display all other terms
                            foreach ($terms as $term) {
                                if (!in_array($term->term_id, (array)$selected_terms)) {
                                    echo '<option value="' . esc_attr($term->term_id) . '">' . esc_html($term->name) . '</option>';
                                }
                            }
                        }
                        ?>
                    </select>
                </p>
            </div>
        </div>
    </div>
    
    <div class="magic-ef-button-wrapper" style="margin-top: 20px; text-align: right;">
        <button type="submit" class="button button-secondary" id="magic-ef-save" disabled data-post-id="<?php echo esc_attr($post_id); ?>">
            <?php echo esc_html__('Save', 'magic-extra-field-light'); ?>
        </button>
        <a href="<?php echo esc_url(add_query_arg('action', 'elementor', get_edit_post_link($post_id))); ?>" class="button button-primary" id="magic-ef-edit-elementor" target="_blank">
            <?php echo esc_html__('Edit with Elementor', 'magic-extra-field-light'); ?>
        </a>
        <div class="show-response"></div>
    </div>
</div>