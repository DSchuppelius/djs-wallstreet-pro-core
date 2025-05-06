<?php
/*
 * Created on   : Wed Jun 22 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : djs_setup.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */
defined('ABSPATH') or die('Hm, Are you ok?');

require_once "djs_base.php";

if(!class_exists('DJS_Setup')) {
    abstract class DJS_Setup extends DJS_Base {
        protected array $current_data;

        public function get($key) {
            $result = null;

            if (array_diff($this->data, $this->get_initial_setup()) != []) {
                $this->load_current_setup();
            }

            if (array_key_exists($key, $this->current_data)) {
                if(is_bool($this->__get($key))) {
                    $result = sanitize_boolean_field($this->current_data[$key]);
                } else {
                    $result = $this->current_data[$key];
                }
            } else {
                $result = $this->__get($key);
            }

            return $result;
        }

        // @return initial_setup|null
        abstract protected function get_initial_setup();
        abstract protected function get_translated_setup();

        protected function load_current_setup() {
            $this->data = $this->get_initial_setup();
            $this->current_data = $this->get_current_setup();
            if (did_action('init')) {
                $this->apply_translations();
            } else {
                add_action('init', [$this, 'apply_translations']);
            }
        }

        public function apply_translations() {
            if ($this->translations_applied) return;

            $translations = $this->get_translated_setup();

            foreach ($translations as $key => $value) {
                if (isset($this->data[$key])) {
                    $this->data[$key] = $value;
                }
                if (isset($this->current_data[$key])) {
                    $this->current_data[$key] = $value;
                }
            }

            $this->translations_applied = true;
        }

        public function get_current_setup() {
            return wp_parse_args(get_option("wallstreet_pro_options", []), $this->data);
        }
    }
}
?>
