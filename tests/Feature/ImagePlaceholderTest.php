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

    expect(new ImagePlaceholder($params))
        ->width->toEqual(100)
        ->height->toEqual(100)
        ->pos_x->toEqual(0)
        ->pos_y->toEqual(0)
        ->image->toEqual("test.jpg");
});

it('sets default values when not provided', function () {

    $params = [
        'width' => 100,
        'height' => 100,
        'pos_x' => 0,
        'pos_y' => 0,
    ];

    expect(new ImagePlaceholder($params))
        ->crop->toEqual("left");
});
