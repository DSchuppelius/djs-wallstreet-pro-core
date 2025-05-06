<?php
/*
 * Created on   : Wed Jun 22 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : djs_base.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */
defined('ABSPATH') or die('Hm, Are you ok?');

if(!class_exists('DJS_Base')) {
    abstract class DJS_Base {
        protected $data;

        // @var mixed False when not logged in; WP_User object when logged in
        public $current_user = false;

        // @var obj Add-ons append to this (Akismet, BuddyPress, etc...)
        public $extend;

        // @var array Topic views
        public $views = [];

        // @var array Overloads get_option()
        public $options = [];

        // @var array Overloads get_user_meta()
        public $user_options = [];

        protected $version;
        protected $db_version;

        protected $file;
        protected $basename;
        protected $plugin_dir;
        protected $plugin_url;
        protected $plugin_name;

        protected $includes_dir;
        protected $includes_url;

        // @return plugin|null
        abstract public static function instance();

        /**
         * A dummy constructor to prevent plugin from being loaded more than once.
         *
         * @since DJS_Base (v2.0.4)
         * @see DJS_Base::instance()
         * @see plugin();
         */
        protected function __construct() {
            /* Do nothing here */
        }

        // A dummy magic method to prevent plugin from being cloned
        public function __clone() {
            _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'djs-wallstreet-pro'), '2.1.0');
        }

        // A dummy magic method to prevent plugin from being unserialized
        public function __wakeup() {
            _doing_it_wrong(__FUNCTION__, esc_html__('Cheatin&#8217; huh?', 'djs-wallstreet-pro'), '2.1.0');
        }

        // Magic method for checking the existence of a certain custom field
        public function __isset($key) {
            return isset($this->data[$key]);
        }

        // Magic method for getting plugin variables
        public function __get($key) {
            return isset($this->data[$key]) ? $this->data[$key] : null;
        }

        // Magic method for setting plugin variables
        public function __set($key, $value) {
            $this->data[$key] = $value;
        }

        // Magic method for unsetting plugin variables
        public function __unset($key) {
            if (isset($this->data[$key])) unset($this->data[$key]);
        }

        // Magic method to prevent notices and errors from invalid method calls
        public function __call($name = '', $args = []) {
            unset($name, $args);
            return null;
        }

        // Load plugin textdomain.
        public function load_plugin_textdomain() {
            $path = basename(dirname($this->file)) . "/functions/lang";
            $result = load_plugin_textdomain($this->plugin_name, false, $path);

            if(defined('WP_DEBUG'))
                if (!$result && WP_DEBUG)
                add_action('admin_notices', function() use ($path) {
                    $locale = apply_filters('plugin_locale', get_locale(), $this->plugin_name);

                    echo "<div class='notice'><p>" . sprintf(esc_html__("Could not find language file %s/%s-%s.mo.", $this->plugin_name), $path, $this->plugin_name, $locale) . "</p></div>";
                });
        }

        protected function setup_globals() {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 1);

            /** Versions **********************************************************/
            $this->version = '1.0.0';
            $this->db_version = 'none';

            // Setup some base path and URL information
            $this->file = isset($backtrace[0]['file']) ? $backtrace[0]['file'] : __FILE__;
            $this->basename = apply_filters('djs-wallstreet-pro-extensions_plugin_basenname', plugin_basename($this->file));
            $this->plugin_dir = apply_filters('djs-wallstreet-pro-extensions_plugin_dir_path', plugin_dir_path($this->file));
            $this->plugin_url = apply_filters('djs-wallstreet-pro-extensions_plugin_dir_url', plugin_dir_url($this->file));
            $this->plugin_name = apply_filters('djs-wallstreet-pro-post-types_plugin_name', dirname($this->basename));

            /** Paths *************************************************************/
            $this->includes_dir = apply_filters('djs-wallstreet-pro-extensions_includes_dir', trailingslashit($this->plugin_dir . 'includes'));
            $this->includes_url = apply_filters('djs-wallstreet-pro-extensions_includes_url', trailingslashit($this->plugin_url . 'includes'));
        }
    }
}
?>
