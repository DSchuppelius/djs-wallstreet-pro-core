<?php
if ( ! function_exists( 'is_dark_color' ) ) {
    /**
     * very simple luminance check – TRUE ⇒ dunkel
     */
    function is_dark_color( string $hex ): bool {
        $hex = ltrim( $hex, '#' );             // rrggbb
        [$r,$g,$b] = [
            hexdec( substr( $hex, 0, 2 ) ),
            hexdec( substr( $hex, 2, 2 ) ),
            hexdec( substr( $hex, 4, 2 ) ),
        ];
        // Perceived luminance nach ITU-R
        $luminance = ( 0.2126 * $r + 0.7152 * $g + 0.0722 * $b ) / 255;
        return $luminance < 0.55;              // Schwellwert anpassbar
    }
}
