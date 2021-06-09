<?php

namespace GDaisy;

class Util
{
    public static function downloadImage($url): string
    {
        $file_contents = file_get_contents($url);

        $file_path = sys_get_temp_dir() . DIRECTORY_SEPARATOR . basename($url);

        $image = fopen($file_path, "w+");
        fwrite($image, $file_contents);
        fclose($image);

        return $file_path;
    }

    public static function root(): string
    {
        return __DIR__ . '/../';
    }

    public static function getColor($resource, string $color)
    {
        str_replace('#', '', $color);
        $color_r = hexdec(substr($color, 0, 2));
        $color_g = hexdec(substr($color, 2, 2));
        $color_b = hexdec(substr($color, 4, 2));

        return imagecolorallocate($resource, $color_r, $color_g, $color_b);
    }
}