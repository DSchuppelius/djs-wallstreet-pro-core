<?php
/*
 * Created on   : Thu Sep 29 2022
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : plugin_sanitizer.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */

if (!function_exists("remove_umlaut")) {
    function remove_umlaut($str) {
        return str_replace(["Ä", "Ö", "Ü", "ä", "ö", "ü", "ß"], ["Ae", "Oe", "Ue", "ae", "oe", "ue", "ss"], $str);
    }
}

if (!function_exists("strip_comments")) {
    function strip_comments($str) {
        return preg_replace('/<!--(.|\s)*?-->/', '', $str);
    }
}

if (!function_exists("strip_all")) {
    function strip_all($str) {
        $result = preg_replace(' (\[.*?\])', '', $str);

        $result = strip_tags($result);
        $result = strip_comments($result);
        $result = strip_shortcodes($result);

        return $result;
    }
}

if (!function_exists("sanitize_link_field")) {
    function sanitize_link_field($str) {
        $result = strip_comments($str);
        $result = strip_tags($result, "<a>");
        preg_match_all('/<a[^>]+href=([\'"])(?<href>.+?)\1[^>]*>/i', $result, $link_results);

        if(!empty($link_results))
            if(array_key_exists('href', $link_results))
                foreach($link_results['href'] as $link_result)
                    $result = str_replace($link_result, esc_url($link_result), $result);

        return $result;
    }
}

if (!function_exists("sanitize_boolean_field")) {
    function sanitize_boolean_field($str) {
        return filter_var(trim($str), FILTER_VALIDATE_BOOLEAN);
    }
}
?>
