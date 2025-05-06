<?php
/*
Plugin Name: DJS-Wallstreet-Pro Core
Plugin URI: https://github.com/DSchuppelius/djs-wallstreet-pro-core
Update URI: https://github.com/DSchuppelius/djs-wallstreet-pro-post-types/releases/latest/
Description: Core plugin for DJS-Wallstreet-Pro theme and extensions. Provides shared functionalities and the DJS_Base class.
Version: 1.0.0
Author: Daniel Jörg Schuppelius
Author URI: https://schuppelius.org
License: GNU General Public License v3 or later
License URI: http://www.gnu.org/licenses/gpl.html
Text Domain: djs-wallstreet-pro-core
Domain Path: /languages/
*/
defined('ABSPATH') or die('Hm, Are you ok?');

require_once "functions.php";
require_once "create_mu_plugin.php";

if (!class_exists('DJS_Wallstreet_Pro_Core')) {
    final class DJS_Wallstreet_Pro_Core extends DJS_Base {
        private static $instance = null;

        // @return plugin|null
        public static function instance() {
            // Store the instance locally to avoid private static replication

            // Only run these methods if they haven't been ran previously
            if (null === static::$instance) {
                static::$instance = new DJS_Wallstreet_Pro_Core();
                static::$instance->setup_globals();

                add_action('plugins_loaded', [static::$instance, 'load_plugin_textdomain']);
            }

            // Always return the instance
            return static::$instance;
        }

        protected function setup_globals() {
            parent::setup_globals();
            /** Versions **********************************************************/
            $this->version = '1.0.0';
        }
    }
}

DJS_Wallstreet_Pro_Core::instance();

// Beim Aktivieren des Plugins das MU-Plugin erstellen
register_activation_hook(__FILE__, 'djs_create_mu_plugin');
// Beim Deaktivieren des Plugins das MU-Plugin entfernen
register_deactivation_hook(__FILE__, function () {
    $mu_plugin_file = WP_CONTENT_DIR . '/mu-plugins/djs-core-loader.php';
    if (file_exists($mu_plugin_file)) {
        unlink($mu_plugin_file);
    }
});
