<?php

namespace App\ECS\Components;


use App\ECS\ComponentInterface;

class HealthComponent implements ComponentInterface
{
    public $health = 0;

    public function __construct(int $health = 100)
    {
        $this->health = $health;
    }
}
