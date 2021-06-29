<?php

namespace GDaisy\Filter;

use GDaisy\FilterInterface;
use GDaisy\Util;

class Circle implements FilterInterface
{
    public function apply($resource)
    {
        //apply roundness effect
        $mask = imagecreatetruecolor(imagesx($resource), imagesy($resource));
        $mask_bg = Util::getColor($mask,'00b140');
        $mask_circle = Util::getColor($mask, '000000');
        imagefill($mask, 0, 0, $mask_bg);
        imagefilledellipse($mask, imagesx($resource) / 2, imagesy($resource) / 2, imagesx($resource), imagesy($resource), $mask_circle);
        imagecolortransparent($mask, $mask_circle);
        imagecopyresampled($resource, $mask, 0, 0, 0, 0, imagesx($resource), imagesy($resource), imagesx($resource), imagesy($resource));

        //creates new copy to apply new transparency mask
        $rounded = imagecreatetruecolor(imagesx($resource), imagesy($resource));
        imagecopyresampled($rounded, $resource, 0, 0, 0, 0, imagesx($resource), imagesy($resource), imagesx($resource), imagesy($resource));
        imagecolortransparent($rounded, $mask_bg);
        if ($rounded) {
            $resource = $rounded;
        }

        return $resource;
    }
}