<p align="center">
  <img src="https://user-images.githubusercontent.com/293241/121391345-8cb16480-c94e-11eb-9f86-1449e81034cc.png" alt="gdaisy logo">
  </p>
  
# gdaisy

An image templating system based on PHP-GD to dynamically generate image banners and covers.

## Installation

### 1. Require `erikaheidi/gdaisy` in your project using Composer:

```shell
composer require erikaheidi/gdaisy
```

### 2. Once it's installed, you can run the default script to generate an example cover based on meta tags.

Gdaisy comes with a little example script that generates a header image adequately sized for Twitter, based on a default template. The `vendor/bin/gdaisy generate` script expects the URL to fetch as first parameter and the output path as second parameter, as follows:

```shell
./vendor/bin/gdaisy generate https://www.digitalocean.com/community/tutorials/how-to-set-up-visual-studio-code-for-php-projects output.png
```

This will generate the following image:

<p align="center">
  <img src="https://user-images.githubusercontent.com/293241/121399169-77403880-c956-11eb-8aba-f2383e260ef0.png" alt="gdaisy generated cover image">
  </p>

The example generation script is defined in `vendor/erikaheidi/gdaisy/bin/gdaisy`, and the default template is defined in `vendor/erikaheidi/gdaisy/resources/templates/article_preview.json`. You can use those as base to build your own image templates, using differet content sources.

