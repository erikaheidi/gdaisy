<?php

namespace GDaisy;

interface PlaceholderInterface
{
    public function __construct(array $params = []);

    public function apply($resource, array $params = []);
}