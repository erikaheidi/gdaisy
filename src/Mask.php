<?php


namespace GDaisy;


class Mask
{
    public $mask;
    public $color;
    public $bg_color;
    public int $width;
    public int $height;

    const MASK_CIRCLE = 1;
    const MASK_ROUNDED = 2;

    public function __construct($width, $height)
    {
        $this->width = $width;
        $this->height = $height;
    }

    public function punch($image_resource, $mask_type = self::MASK_ROUNDED)
    {
        $mask = $this->getMask($mask_type);

        imagecopyresampled($image_resource, $mask, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);

        //creates new copy to apply new transparency mask
        $masked = imagecreatetruecolor($this->width, $this->height);
        imagecopyresampled($masked, $image_resource, 0, 0, 0, 0, $this->width, $this->height, $this->width, $this->height);
        imagecolortransparent($masked, $this->bg_color);
        if ($masked) {
            $image_resource = $masked;
        }

        return $image_resource;
    }

    public function getMaskResource()
    {
        if (!$this->mask) {
            $this->mask = imagecreatetruecolor($this->width,  $this->height);
            imagealphablending($this->mask, false);

            $this->color = imagecolorallocatealpha($this->mask, 255, 0, 255, 127);
            $this->bg_color = Util::getColor($this->mask,'00b140');
        }

        return $this->mask;
    }

    public function getMask($mask_type = self::MASK_ROUNDED)
    {
        if ($mask_type == self::MASK_CIRCLE) {
            return $this->getMaskCircle();
        } else {
            return $this->getMaskRound();
        }
    }

    public function getMaskCircle()
    {
        $mask = $this->getMaskResource();

        imagefill($mask, 0, 0, $this->bg_color);
        imagefilledellipse($mask, $this->width / 2, $this->height / 2, $this->width, $this->height, $this->color);
        imagecolortransparent($mask, $this->color);

        return $mask;
    }

    public function getMaskRound()
    {
        $mask = $this->getMaskResource();

        $radius = 40;
        $diameter = $radius * 2;

        //draws cross-shape
        imagefilledrectangle($mask, 0, $radius, $this->width, $this->height - $radius, $this->color);
        imagefilledrectangle($mask, $radius, 0, $this->width - $radius, $this->height, $this->color);

        //draws rounded corners
        imagefilledellipse($mask, $radius, $radius, $diameter, $diameter, $this->color);
        imagefilledellipse($mask, $radius, $this->height - $radius, $diameter, $diameter, $this->color);
        imagefilledellipse($mask, $this->width - $radius, $this->height - $radius, $diameter, $diameter, $this->color);
        imagefilledellipse($mask, $this->width - $radius, $radius, $diameter, $diameter, $this->color);

        return $mask;
    }
}