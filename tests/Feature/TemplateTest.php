<?php

use GDaisy\ImagePlaceholder;
use GDaisy\Template;

it('creates template', function () {

    $template = new Template("gdaisy");

    expect($template->name)->toEqual("gdaisy");
});

it('creates placeholder and stores coordinates', function () {
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

    $tpl_placeholder = $template->getPlaceholder("test-key");
    expect($tpl_placeholder->width)->toEqual(100);
    expect($tpl_placeholder->height)->toEqual(100);
    expect($tpl_placeholder->pos_x)->toEqual(0);
    expect($tpl_placeholder->pos_y)->toEqual(0);
    expect($tpl_placeholder->image)->toEqual("test.jpg");
});

it('loads json templates', function () {
    $template = Template::create(__DIR__ . '/../../tests/Resources/cover_basic.json');

    $tpl_placeholder = $template->getPlaceholder("author");
    expect($tpl_placeholder->width)->toEqual(150);
    expect($tpl_placeholder->height)->toEqual(150);
    expect($tpl_placeholder->image)->toBeNull();
});