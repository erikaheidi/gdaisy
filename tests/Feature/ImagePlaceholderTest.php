<?php

use GDaisy\ImagePlaceholder;

it('creates placeholder and stores coordinates', function () {

    $params = [
        'width' => 100,
        'height' => 100,
        'pos_x' => 0,
        'pos_y' => 0,
        'image' => "test.jpg",
    ];

    $placeholder = new ImagePlaceholder($params);

    expect($placeholder->width)->toEqual(100);
    expect($placeholder->height)->toEqual(100);
    expect($placeholder->pos_x)->toEqual(0);
    expect($placeholder->pos_y)->toEqual(0);
    expect($placeholder->image)->toEqual("test.jpg");
});