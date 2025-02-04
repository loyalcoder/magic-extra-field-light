<?php

namespace MagicExtraField;

/**
 * Admin class
 */
class Admin
{
    /**
     * Initialize admin class
     *
     * @since 1.0.0
     * @return void
     */
    public function __construct() 
    {
        new Admin\Menu();
        // CMB2 example and custom fields
        // new Admin\CMB2_Sample();
        // new Library\CMB2\CMB2_Switch_Button();
        // new Library\CMB2\PW_CMB2_Field_Select2();
        // End CMB2 example and custom fields
        add_action('admin_notices', [$this, 'admin_notice']);
    }

    public function admin_notice()
    {
        $get_current_screen = get_current_screen();        
        if (isset($get_current_screen->post_type) && $get_current_screen->post_type !== 'magic_ef_builder') {
            return;
        }
       ?>
        <div class="popup">
            <div class="popup-content">
                <span class="close">&times;</span>
                <div class="popup-content-inner">
                    <h2>Hello World</h2>
                    <form class="magic-ef-form">
                        <div class="form-group">
                            <label for="post_title"><?php echo esc_html__('Title', 'magic-extra-field'); ?></label>
                            <input type="text" id="post_title" name="post_title" class="regular-text" required>
                        </div>

                        <div class="form-group">
                            <div class="magic-ef-toggle">
                                <label class="switch">
                                    <input type="checkbox" name="is_active" id="is_active">
                                    <span class="slider round"></span>
                                </label>
                                <span class="magic-ef-toggle-text"><?php echo esc_html__('Active', 'magic-extra-field'); ?></span>
                            </div>
                        </div>

                        <div class="magic-ef-display-options" style="display: none;">
                            <div class="form-group">
                                <label for="display_type"><?php echo esc_html__('Display Type', 'magic-extra-field'); ?></label>
                                <select name="display_type" id="display_type">
                                    <option value="all"><?php echo esc_html__('All Products', 'magic-extra-field'); ?></option>
                                    <option value="specific"><?php echo esc_html__('Specific Products', 'magic-extra-field'); ?></option>
                                    <option value="taxonomy"><?php echo esc_html__('By Taxonomy', 'magic-extra-field'); ?></option>
                                </select>
                            </div>

                            <div id="specific_products" style="display: none;">
                                <div class="form-group">
                                    <label for="selected_products"><?php echo esc_html__('Select Products', 'magic-extra-field'); ?></label>
                                    <select name="selected_products[]" id="selected_products" class="magic-ef-product-select" multiple="multiple">
                                        <?php
                                        $products = wc_get_products(['status' => 'publish', 'limit' => -1]);
                                        foreach ($products as $product) {
                                            printf(
                                                '<option value="%s">%s</option>',
                                                esc_attr($product->get_id()),
                                                esc_html($product->get_name())
                                            );
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div id="taxonomy_options" style="display: none;">
                                <div class="form-group">
                                    <label for="taxonomy"><?php echo esc_html__('Select Taxonomy', 'magic-extra-field'); ?></label>
                                    <select name="taxonomy" id="taxonomy" class="magic-ef-taxonomy-select">
                                        <option value="product_cat"><?php echo esc_html__('Product Category', 'magic-extra-field'); ?></option>
                                        <option value="product_tag"><?php echo esc_html__('Product Tag', 'magic-extra-field'); ?></option>
                                    </select>
                                </div>
                                
                                <div id="terms_selection" style="display: none;">
                                    <div class="form-group">
                                        <label for="terms"><?php echo esc_html__('Select Terms', 'magic-extra-field'); ?></label>
                                        <select name="terms[]" class="magic-ef-term-select" multiple="multiple"></select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="button button-primary"><?php echo esc_html__('Save', 'magic-extra-field'); ?></button>
                            <a href="<?php echo esc_url(admin_url('post.php?action=elementor&post=')); ?>" class="button button-secondary" target="_blank">
                                <?php echo esc_html__('Edit with Elementor', 'magic-extra-field'); ?>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
       <?php 
    }
}
