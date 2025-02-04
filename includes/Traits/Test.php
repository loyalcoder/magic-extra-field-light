<?php

namespace MagicExtraField\Traits;

/**
 * Test Trait
 */
trait Test
{
    /**
     * Check for name
     *
     * @since 1.0.0
     * @return string
     */
    public function get_name(): string 
    {
        return esc_html__('Roman Ul Ferdosh', 'magic-extra-field');
    }
}
