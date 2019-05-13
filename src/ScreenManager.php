<?php


namespace App;


class ScreenManager
{
    private $cols;
    private $lines;
    private $centerX;
    private $centerY;


    public function __construct()
    {

        $this->cols = exec('tput cols');
        $this->lines = exec('tput lines');
        $this->centerX = $this->cols / 2;
        $this->centerY = $this->lines / 2;
    }

    public function write(int $x, int $y, string $data) : void
    {
        if ($x < 0 || $y < 0) {
            return;
        }

        system(sprintf('tput cup %d %d', $y, $x));
        echo $data;
    }

    public function clear() : void
    {
        $y = 0;

        while ($y < $this->lines) {
            $this->write(0, $y++, str_repeat(' ', $this->cols));
        }
    }

    public function getCols() : int
    {
        return $this->cols;
    }

    public function getLines() : int
    {
        return $this->lines;
    }

    public function getCenterX() : int
    {
        return $this->centerX;
    }

    public function getCenterY() : int
    {
        return $this->centerY;
    }


}
