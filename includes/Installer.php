<?php

namespace MagicExtraFieldLight;

/**
 * Installer class handles plugin installation and version management
 * 
 * @package MagicExtraFieldLight
 * @since 1.0.0
 */
class Installer
{
    /**
     * Initialize class functions
     * 
     * Runs required installation and upgrade routines
     *
     * @since 1.0.0
     * @return void
     */
    public function run()
    {
        $this->add_version();
    }

    /**
     * Store plugin installation and version information
     * 
     * Stores the initial installation timestamp if not already set
     * Updates the plugin version number in options table
     *
     * @since 1.0.0
     * @return void
     */
    public function add_version()
    {
        $installed = get_option('magic_extra_field_light_installed');

        if (!$installed) {
            update_option('magic_extra_field_light_installed', time());
        }

        update_option('magic_extra_field_light_version', MAGIC_EXTRA_FIELD_LIGHT_VERSION);
    }
}
