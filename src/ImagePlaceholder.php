<?php

namespace GDaisy;

class ImagePlaceholder implements PlaceholderInterface
{
    public int $width;

    public int $height;

    public int $pos_x;

    public int $pos_y;

    public ?string $image;

    public string $crop;

    public function __construct(array $params = [])
    {
        $this->width = $params['width'];
        $this->height = $params['height'];
        $this->pos_x = $params['pos_x'];
        $this->pos_y = $params['pos_y'];
        $this->image = $params['image'] ?? null;
        $this->crop = $params['crop'] ?? "left";
    }

    public function apply($resource, array $params = [])
    {
        if (is_resource($resource) && is_file($params['image_file'])) {
            $stamp = $this->getImageResource($params['image_file']);
            $info = getimagesize($params['image_file']);

            $original_w = $info[0];
            $original_h = $info[1];

            $copy_w = $original_w;
            $copy_h = $original_h;

            $copy_x = 0;
            $copy_y = 0;

            if ($this->width / $this->height != $original_w / $original_h) {
                if ($copy_h < $copy_w) {
                    $copy_w = ($this->width * $copy_h) / $this->height;
                } else {
                    $copy_h = ($original_h * $copy_w) / $original_w;
                }

                if ($this->crop === "center") {
                    $copy_x = ($original_w / 2) - ($this->width / 2);
                    $copy_y = ($original_h / 2) - ($this->height / 2);
                }
            }

            imagecopyresized(
                $resource,
                $stamp,
                $this->pos_x,
                $this->pos_y,
                $copy_x,
                $copy_y,
                $this->width,
                $this->height,
                $copy_w,
                $copy_h
            );
        }
    }

    public function getImageResource(string $image_file)
    {
        $info = getimagesize($image_file);
        $extension = image_type_to_extension($info[2]);

        if (strtolower($extension) == '.png') {
            return imagecreatefrompng($image_file);
        }

        if (strtolower($extension) == '.jpeg' OR strtolower($extension) == '.jpg') {
            return imagecreatefromjpeg($image_file);
        }

        if (strtolower($extension) == '.gif') {
            return imagecreatefromgif($image_file);
        }

        return null;
    }
}