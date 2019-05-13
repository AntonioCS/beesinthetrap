<?php


namespace App\ECS\Components;


use App\ECS\ComponentInterface;

class TransformationComponent implements ComponentInterface
{
    public $x;
    public $y;
    public $w;
    public $h;

    public function __construct(int $x, int $y, int $w, int $h)
    {
        $this->x = $x;
        $this->y = $y;
        $this->w = $w;
        $this->h = $h;
    }

    public function totalWidth() : int
    {
        return $this->x + $this->w;
    }

    public function totalHeight() : int
    {
        return $this->y + $this->h;
    }
}
