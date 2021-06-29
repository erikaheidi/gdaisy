<?php

namespace GDaisy\Filter;

use GDaisy\FilterInterface;
use GDaisy\Mask;
use GDaisy\Util;

class Circle implements FilterInterface
{
    public function apply($resource)
    {
        $mask = new Mask(imagesx($resource), imagesy($resource));
        return $mask->punch($resource, Mask::MASK_CIRCLE);
    }
}