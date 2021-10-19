<?php

namespace GDaisy\Placeholder;

use GDaisy\PlaceholderInterface;
use GDaisy\FilterInterface;

class ImagePlaceholder implements PlaceholderInterface
{
    public int $width;

    public int $height;

    public int $pos_x;

    public int $pos_y;

    public ?string $image;

    public string $crop;

    public ?array $filters;

    public function __construct(array $params = [])
    {
        $this->width = $params['width'] ?? 100;
        $this->height = $params['height'] ?? 100;
        $this->pos_x = $params['pos_x'] ?? 0;
        $this->pos_y = $params['pos_y'] ?? 0;
        $this->image = $params['image'] ?? null;
        $this->crop = $params['crop'] ?? "left";
        $this->filters = $params['filters'] ?? [];
    }

    public function apply($resource, array $params = [])
    {
        if ((is_resource($resource) || $resource instanceOf \GdImage) && is_file($params['image_file'])) {
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

                if ($this->crop === "right") {
                    $copy_x = $this->width - $original_w;
                    $copy_y = $this->height - $original_h;
                }
            }

            $crop = imagecrop($stamp, [ 'x' => $copy_x, 'y' => $copy_y, 'width' => $copy_w, 'height' => $copy_h]);

            //apply filters
            foreach ($this->filters as $filter_class) {
                /** @var FilterInterface $filter */
                $filter = new $filter_class();
                $crop = $filter->apply($crop);
            }

            imagecopyresized(
                $resource,
                $crop,
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