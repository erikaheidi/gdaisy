<?php

use GDaisy\TextPlaceholder;

it('creates text placeholder and stores coordinates ', function () {

    $params = [
        'pos_x' => 0,
        'pos_y' => 0,
        'size' => 30,
        'color' => '000000'
    ];

    expect(new TextPlaceholder($params))
        ->pos_x->toEqual(0)
        ->pos_y->toEqual(0)
        ->size->toEqual(30)
        ->color->toEqual('000000');
});

it('sets up default values when not provided', function () {

    $params = [
        'pos_x' => 0,
        'pos_y' => 0,
        'size' => 30,
        'color' => '000000'
    ];

    $placeholder = new TextPlaceholder($params);

    expect($placeholder->align)->toEqual('left');
});
