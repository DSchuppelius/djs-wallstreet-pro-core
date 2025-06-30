<?php
/*
 * Created on   : Mon Jun 30 2025
 * Author       : Daniel Jörg Schuppelius
 * Author Uri   : https://schuppelius.org
 * Filename     : theme_functions.php
 * License      : GNU General Public License v3 or later
 * License Uri  : http://www.gnu.org/licenses/gpl.html
 */

/* -------------------------------------------------------------------------
 * 4a.  Kompatibilitäts-Helper für mehrere Theme-Supports
 * ---------------------------------------------------------------------- */
if ( ! function_exists( 'add_theme_supports' ) ) {
    /**
     * Ruft add_theme_support() mehrfach auf.
     * Akzeptiert sowohl numerische Einträge als auch key => value-Paare.
     *
     * @param array $features
     */
    function add_theme_supports( array $features ) {
        foreach ( $features as $feature => $args ) {
            if ( is_int( $feature ) ) {           // einfacher String
                add_theme_support( $args );
            } else {                              // key => value
                add_theme_support( $feature, $args );
            }
        }
    }
}
