<?php

namespace App\Helpers;

class ColorHelper
{
    /**
     * @param string $string
     * @return string
     */
    public static function stringToColor(string $string, int $minBrightness = 80, int $spec = 10): string
    {
        $hash = md5($string); 
        $rgb = [
            hexdec(substr($hash, 0, 2)), 
            hexdec(substr($hash, 2, 2)),
            hexdec(substr($hash, 4, 2)), 
        ];

        for ($i = 0; $i < 3; $i++) {
            if ($rgb[$i] < $minBrightness) {
                $rgb[$i] += $minBrightness;
            }
            if ($rgb[$i] > 255) {
                 $rgb[$i] = 255;
            }
        }
        if (array_sum($rgb) / 3 < 100) { 
            for ($i = 0; $i < 3; $i++) $rgb[$i] = min(255, $rgb[$i] + 50);
        } elseif (array_sum($rgb) / 3 > 190) { 
             for ($i = 0; $i < 3; $i++) $rgb[$i] = max(0, $rgb[$i] - 50);
        }


        return sprintf('#%02x%02x%02x', $rgb[0], $rgb[1], $rgb[2]);
    }
}