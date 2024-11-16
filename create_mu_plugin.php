<?php
/*
 * Created on   : Fri Oct 15 2024
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : create_mu_plugin.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */

function djs_create_mu_plugin() {
    $my_plugin = DJS_CORE_PLUGIN . '/core.php';
    $mu_plugin_dir = WP_CONTENT_DIR . '/mu-plugins/';
    $mu_plugin_file = $mu_plugin_dir . 'djs-core-loader.php';

    if (!is_dir($mu_plugin_dir)) {
        mkdir($mu_plugin_dir, 0755, true);
    }

    $mu_plugin_code = <<<PHP
<?php
/**
 * Loader for DJS-Wallstreet-Pro-Core
 */

if (defined('ABSPATH')) {
    require_once WP_PLUGIN_DIR . '/{$my_plugin}';
}
PHP;

    if (!file_exists($mu_plugin_file) || file_get_contents($mu_plugin_file) !== $mu_plugin_code) {
        error_log('DJS-Wallstreet-Pro-Core MU-Plugin created');
        file_put_contents($mu_plugin_file, $mu_plugin_code);
    }
}