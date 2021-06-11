<p align="center">
  <img src="https://user-images.githubusercontent.com/293241/121391345-8cb16480-c94e-11eb-9f86-1449e81034cc.png" alt="gdaisy logo">
  </p>
  
# gdaisy

A highly experimental image templating system based on PHP-GD to dynamically generate image banners and covers.

## Installation

### 1. Require `erikaheidi/gdaisy` in your project using Composer:

```shell
composer require erikaheidi/gdaisy
```

### 2. Once it's installed, you can run the default script to generate an example cover based on meta tags.

Gdaisy comes with an example script that generates a header image adequately sized for Twitter, based on a default template. The `vendor/bin/gdaisy generate` script expects the URL to fetch as first parameter and the output path as second parameter, as follows:

```shell
./vendor/bin/gdaisy generate https://www.digitalocean.com/community/tutorials/how-to-set-up-visual-studio-code-for-php-projects output.png
```

This will generate the following image:

<p align="center">
  <img src="https://user-images.githubusercontent.com/293241/121399169-77403880-c956-11eb-8aba-f2383e260ef0.png" alt="gdaisy generated cover image">
  </p>

The example generation script is defined in `vendor/erikaheidi/gdaisy/bin/gdaisy`.

## Creating Templates

Consider the following `basic.json` template example:

```json
{
  "width": 600,
  "height": 600,
  "background": "FFFFFF",
  "elements": {
    "title": {
      "type": "text",
      "properties": {
        "pos_x": 50,
        "pos_y": 20,
        "size": 30,
        "color": "666666",
        "max_width": 500,
        "align": "center"
      }
    },
    "thumbnail": {
      "type": "image",
      "properties": {
        "pos_x": 50,
        "pos_y": 50,
        "width": 500,
        "height": 500
      }
    }
  }
}
```

This template has two elements: `title` (type `text`) and `thumbnail` (type `image`).

**Template Properties:**

- `width`: Resulting image width
- `height`: Resulting image height
- `background`: Resulting image background

**Text Properties:**

- `pos_x`: X coordinate (bottom left X coordinate for the base of text)
- `pos_y`: Y coordinate (botom left Y coordinate for the base of text)
- `size`: Text size
- `color`: Text Color (hex)
- `max_width` (optional): Maximum text width - text will be broken down into multiple lines when set
- `align` (optional): Text align, possible values are `left`(default), `center`, or `right`.
- `font`: path to font file (ttf)

**Image Properties:**

- `pos_x`: X coordinate (top left corner) where the image will be applied
- `pos_y`: Y coordinate (top left corner) where the image will be applied,
- `width`: width (will proportially resize to fit)
- `height`: height (will proportially resize to fit)
- `image_file` (optional): when set, will use this image, otherwise you'll have to provide this as parameter when applying the template
- `crop` (optional): when set to `center`, will resize-crop while centering the image. Default is `left`, can also be set to `right`.

Following, a PHP script to generate a new image based on the example template:

```php
<?php

use GDaisy\Template;

require __DIR__. '/vendor/autoload.php';

$template = Template::create(__DIR__ . '/resources/templates/basic.json');

$template->apply("thumbnail", [
    "image_file" => __DIR__ . '/resources/images/gdaisy.png'
])->apply("title", [
    "text" => "generated with gdaisy"
]);

$template->write('output.png');
echo "Finished.\n";
```

