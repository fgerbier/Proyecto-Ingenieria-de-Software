<?php

namespace App\Helpers;

class SvgHelper
{
    public static function inline($icon, $class = '')
    {
        $path = public_path('icons/' . $icon . '.svg');

        if (!file_exists($path)) {
            return "<!-- SVG not found: {$icon} -->";
        }

        $svgContent = file_get_contents($path);

        if ($class) {
            // Si ya tiene class, se reemplaza
            if (preg_match('/<svg[^>]*class=["\']([^"\']*)["\']/', $svgContent)) {
                $svgContent = preg_replace(
                    '/(<svg[^>]*class=["\'])([^"\']*)(["\'])/',
                    '$1' . $class . ' $2$3',
                    $svgContent
                );
            } else {
                // Si no tiene class, se agrega
                $svgContent = preg_replace(
                    '/<svg/',
                    '<svg class="' . $class . '"',
                    $svgContent,
                    1 // Solo la primera coincidencia
                );
            }
        }

        return $svgContent;
    }
}
