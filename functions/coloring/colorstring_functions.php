<?php

if ( ! function_exists( 'maybe_hex_prefix' ) ) {
    /**
     * Präfixt einen Hex‑String mit „#“; liefert #000000 bei leerem Input.
     */
    function maybe_hex_prefix(?string $color): string {
        if (empty($color)) {
            return '#000000';
        }
        return str_starts_with($color, '#') ? $color : '#' . $color;
    }
}

function get_rgba_color(?string $hex, float $alpha = 1, string $reduce = '#000000', string $add = '#000000'): string {
    $hex = maybe_hex_prefix($hex);
    [$r,$g,$b] = sscanf($hex, '#%02x%02x%02x');
    [$rr,$rg,$rb] = sscanf(maybe_hex_prefix($reduce), '#%02x%02x%02x');
    [$ar,$ag,$ab] = sscanf(maybe_hex_prefix($add),    '#%02x%02x%02x');
    return sprintf('rgba(%d,%d,%d,%1.2f)', $r - $rr + $ar, $g - $rg + $ag, $b - $rb + $ab, $alpha);
}

function the_rgba(?string $hex, float $alpha = 1): void {
    echo get_rgba_color($hex, $alpha);
}

function the_reduced_rgba(?string $hex, float $alpha = 1, string $reduce = '#321928'): void {
    echo get_rgba_color($hex, $alpha, $reduce);
}

function the_additional_rgba(?string $hex, float $alpha = 1, string $add = '#101010'): void {
    echo get_rgba_color($hex, $alpha, '#000000', $add);
}
