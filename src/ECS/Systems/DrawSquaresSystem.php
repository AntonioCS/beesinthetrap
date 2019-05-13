<?php

namespace App\ECS\Systems;


use App\ECS\Components\SquareComponent;
use App\ECS\Components\TransformationComponent;
use App\ECS\AbstractSystem;
use App\ECS\SystemInterface;

class DrawSquaresSystem extends AbstractSystem implements SystemInterface
{
    public function update() : void
    {
        $entities = $this->entityManager->findByComponents(TransformationComponent::class, SquareComponent::class);

        foreach ($entities as $e) {
            /** @var TransformationComponent $tComp */
            $tComp = $e->getComponent(TransformationComponent::class);
            $y = $tComp->y;
            $yEnd = $tComp->y + $tComp->h;

            $this->screenManager->write($tComp->x, $y,str_repeat('_', $tComp->w));
            $y++;

            while ($y < $yEnd) {
                $text = '|' . str_repeat(' ', $tComp->w - 1) . '|';

                $this->screenManager->write($tComp->x, $y, $text);
                $y++;
            }

            $this->screenManager->write($tComp->x, $y, str_repeat('¯', $tComp->w));
        }

    }
}
