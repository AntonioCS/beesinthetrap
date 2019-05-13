<?php


namespace App\ECS\Components;


use App\ECS\ComponentInterface;

class EnemyComponent implements ComponentInterface
{
    public $goLeft = false;
    public $moveBy = 0;

    public function __construct(int $moveBy = 10)
    {
        $this->moveBy = $moveBy;
    }
}
