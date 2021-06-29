<?php

namespace GDaisy\Filter;

use GDaisy\FilterInterface;
use GDaisy\Util;

class Rounded implements FilterInterface
{
    public function apply($resource)
    {
        //apply roundness effect
        $mask = imagecreatetruecolor(imagesx($resource), imagesy($resource));
        $mask_bg = Util::getColor($mask,'00b140');
        $mask_circle = Util::getColor($mask, '000000');

        imagefill($mask, 0, 0, $mask_bg);

        $radius = 40;
        $diameter = $radius * 2;

        //draws cross-shape
        imagefilledrectangle($mask, 0, $radius, imagesx($resource), imagesy($resource) - $radius, $mask_circle);
        imagefilledrectangle($mask, $radius, 0, imagesx($resource) - $radius, imagesy($resource), $mask_circle);

        //draws rounded corners
        imagefilledellipse($mask, $radius, $radius, $diameter, $diameter, $mask_circle);
        imagefilledellipse($mask, $radius, imagesy($resource) - $radius, $diameter, $diameter, $mask_circle);
        imagefilledellipse($mask, imagesx($resource) - $radius, imagesy($resource) - $radius, $diameter, $diameter, $mask_circle);
        imagefilledellipse($mask, imagesx($resource) - $radius, $radius, $diameter, $diameter, $mask_circle);

        //apply transparency
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