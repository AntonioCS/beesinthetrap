<?php


namespace App\ECS\Components;


use App\ECS\ComponentInterface;

class BulletCollidableComponent implements ComponentInterface
{
    public $hitDamage;

    public function __construct(int $hitDamage)
    {
        $this->hitDamage = $hitDamage;
    }

}
