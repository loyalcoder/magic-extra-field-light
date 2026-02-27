<?php
// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

$magic_ef_post_id       = $post_id;
$magic_ef_products      = isset($products) ? $products : array();
$magic_ef_taxonomies    = isset($taxonomies) ? $taxonomies : array();
$magic_ef_is_active     = get_post_meta($magic_ef_post_id, '_magic_ef_is_active', true);
$magic_ef_display_type  = get_post_meta($magic_ef_post_id, '_magic_ef_display_type', true);
$magic_ef_selected_products  = get_post_meta($magic_ef_post_id, '_magic_ef_selected_products', true);
$magic_ef_selected_taxonomy = get_post_meta($magic_ef_post_id, '_magic_ef_selected_taxonomy', true);
$magic_ef_selected_terms    = get_post_meta($magic_ef_post_id, '_magic_ef_selected_terms', true);
$magic_ef_post_title    = get_the_title($magic_ef_post_id);
?>
<div class="magic-ef-options-wrapper">
    <div class="header-wrapper">
        <h2><?php echo esc_html($magic_ef_post_title); ?></h2>
        <hr>
    </div>
    <div class="magic-ef-toggle-wrapper">
        <label class="magic-ef-toggle">
            <input type="checkbox" name="is_active" value="1" <?php checked($magic_ef_is_active, '1'); ?>>
            <span class="slider round"></span>
            <span class="magic-ef-toggle-text"><?php esc_html_e('Active', 'magic-extra-field-light'); ?></span>
        </label>
    </div>

    <div class="magic-ef-display-options" style="display: <?php echo esc_attr($magic_ef_is_active ? 'block' : 'none'); ?>">
        <p>
            <label for="display_type"><?php esc_html_e('Display Type:', 'magic-extra-field-light'); ?></label>
            <select name="display_type" id="display_type">
                <option value="all" <?php selected($magic_ef_display_type, 'all'); ?>><?php esc_html_e('All Products', 'magic-extra-field-light'); ?></option>
                <option value="specific" <?php selected($magic_ef_display_type, 'specific'); ?>><?php esc_html_e('Specific Products', 'magic-extra-field-light'); ?></option>
                <option value="taxonomy" <?php selected($magic_ef_display_type, 'taxonomy'); ?>><?php esc_html_e('By Taxonomy', 'magic-extra-field-light'); ?></option>
            </select>
        </p>

        <div id="specific_products" style="display: <?php echo esc_attr($magic_ef_display_type === 'specific' ? 'block' : 'none'); ?>">
            <p>
                <label><?php esc_html_e('Select Products:', 'magic-extra-field-light'); ?></label>
                <select name="selected_products[]" multiple class="magic-ef-product-select" style="width: 100%">
                    <?php
                    // Display selected products first
                    if (!empty($magic_ef_selected_products)) {
                        foreach ($magic_ef_selected_products as $magic_ef_product_id) {
                            $magic_ef_product = wc_get_product($magic_ef_product_id);
                            if ($magic_ef_product) {
                                echo '<option value="' . esc_attr($magic_ef_product_id) . '" selected>' . esc_html($magic_ef_product->get_name()) . '</option>';
                            }
                        }
                    }
                    // Display all other products
                    foreach ($magic_ef_products as $magic_ef_product) {
                        if (!in_array($magic_ef_product->get_id(), (array)$magic_ef_selected_products)) {
                            echo '<option value="' . esc_attr($magic_ef_product->get_id()) . '">' . esc_html($magic_ef_product->get_name()) . '</option>';
                        }
                    }
                    ?>
                </select>
            </p>
        </div>

        <div id="taxonomy_options" style="display: <?php echo esc_attr($magic_ef_display_type === 'taxonomy' ? 'block' : 'none'); ?>">
            <p>
                <label for="selected_taxonomy"><?php esc_html_e('Select Taxonomy:', 'magic-extra-field-light'); ?></label>
                <select name="selected_taxonomy" id="selected_taxonomy">
                    <option value=""><?php esc_html_e('Select a taxonomy', 'magic-extra-field-light'); ?></option>
                    <?php
                    $magic_ef_excluded_taxonomies = array(
                        'pa_*', // Product attributes
                        'product_visibility',
                        'product_shipping_class',
                        'pa_color',
                        'pa_size'
                    );
                    foreach ($magic_ef_taxonomies as $magic_ef_taxonomy) {
                        // Skip excluded taxonomies
                        if (in_array($magic_ef_taxonomy->name, $magic_ef_excluded_taxonomies) || preg_match('/^pa_/', $magic_ef_taxonomy->name)) {
                            continue;
                        }
                        echo '<option value="' . esc_attr($magic_ef_taxonomy->name) . '" ' . selected($magic_ef_selected_taxonomy, $magic_ef_taxonomy->name, false) . '>' . esc_html($magic_ef_taxonomy->label) . '</option>';
                    }
                    ?>
                </select>
            </p>

            <div id="terms_selection" style="display: <?php echo esc_attr(!empty($magic_ef_selected_taxonomy) ? 'block' : 'none'); ?>">
                <p>
                    <label><?php esc_html_e('Select Terms:', 'magic-extra-field-light'); ?></label>
                    <select name="selected_terms[]" multiple class="magic-ef-term-select" style="width: 100%">
                        <?php
                        if (!empty($magic_ef_selected_taxonomy)) {
                            // Get all terms for the selected taxonomy
                            $magic_ef_terms = get_terms([
                                'taxonomy' => $magic_ef_selected_taxonomy,
                                'hide_empty' => false
                            ]);

                            // Display selected terms first
                            if (!empty($magic_ef_selected_terms)) {
                                foreach ($magic_ef_selected_terms as $magic_ef_term_id) {
                                    $magic_ef_term = get_term($magic_ef_term_id, $magic_ef_selected_taxonomy);
                                    if ($magic_ef_term && !is_wp_error($magic_ef_term)) {
                                        echo '<option value="' . esc_attr($magic_ef_term_id) . '" selected>' . esc_html($magic_ef_term->name) . '</option>';
                                    }
                                }
                            }

                            // Display all other terms
                            foreach ($magic_ef_terms as $magic_ef_term) {
                                if (!in_array($magic_ef_term->term_id, (array)$magic_ef_selected_terms)) {
                                    echo '<option value="' . esc_attr($magic_ef_term->term_id) . '">' . esc_html($magic_ef_term->name) . '</option>';
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
        <button type="submit" class="button button-secondary" id="magic-ef-save" disabled data-post-id="<?php echo esc_attr($magic_ef_post_id); ?>">
            <?php echo esc_html__('Save', 'magic-extra-field-light'); ?>
        </button>
        <a href="<?php echo esc_url(add_query_arg('action', 'elementor', get_edit_post_link($magic_ef_post_id, 'raw') ?: admin_url('edit.php?post_type=magic_ef_builder'))); ?>" class="button button-primary" id="magic-ef-edit-elementor" target="_blank">
            <?php echo esc_html__('Edit with Elementor', 'magic-extra-field-light'); ?>
        </a>
        <div class="show-response"></div>
    </div>
</div>