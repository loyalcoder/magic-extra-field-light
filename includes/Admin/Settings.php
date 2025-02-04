<?php

namespace MagicExtraField\Admin;

use MagicExtraField\Traits\Test;

/**
 * Handle settings
 */
class Settings
{
    use Test;

    /**
     * Setting page template handle
     *
     * @since 1.0.0
     * @return void
     */
    public function settings_page()
    {
        $template = __DIR__ . '/views/settings.php';

        if (file_exists($template)) {
            include $template;
        }
    }

    /**
     * Report handler
     *
     * @since 1.0.0
     * @return void
     */
    public function report_page()
    {
        $template = __DIR__ . '/views/report.php';

        if (file_exists($template)) {
            include $template;
        }
    }
}
