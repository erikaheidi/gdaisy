<?php

use GDaisy\ImagePlaceholder;
use GDaisy\Template;

it('creates template', function () {

    $template = new Template("gdaisy");

    expect($template->name)->toEqual("gdaisy");
});

it('adds placeholder and stores coordinates', function () {
    $params = [
        'width' => 100,
        'height' => 100,
        'pos_x' => 0,
        'pos_y' => 0,
        'image' => "test.jpg",
    ];

    $placeholder = new ImagePlaceholder($params);
    $template = new Template("test");
    $template->addPlaceholder("test-key", $placeholder);

    expect($template->placeholders)->toHaveCount(1);

    expect($template->getPlaceholder("test-key"))
        ->width->toEqual(100)
        ->height->toEqual(100)
        ->pos_x->toEqual(0)
        ->pos_y->toEqual(0)
        ->image->toEqual("test.jpg");
});

it('loads json templates', function () {
    $template = Template::create(__DIR__ . '/../../tests/Resources/cover_basic.json');

    expect($template->getPlaceholder("author"))
        ->width->toEqual(150)
        ->height->toEqual(150)
        ->image->toBeNull();
});
