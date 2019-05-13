<?php


namespace App\ECS\Systems;


use App\ECS\AbstractSystem;
use App\ECS\Components\EnemyComponent;
use App\ECS\Components\TransformationComponent;
use App\ECS\Entity;
use App\ECS\SystemInterface;

class EnemySystem extends AbstractSystem implements SystemInterface
{

    public function update(): void
    {
        $entities = $this->entityManager->findByComponents(EnemyComponent::class, TransformationComponent::class);


        /** @var Entity $e */
        foreach ($entities as $e) {
            /** @var TransformationComponent $tComp */
            $tComp = $e->getComponent(TransformationComponent::class);
            /** @var EnemyComponent $eneComp */
            $eneComp = $e->getComponent(EnemyComponent::class);
            $moveBy = $eneComp->moveBy;

            if ($eneComp->goLeft) {
                if ($tComp->x <= 0) {
                    $tComp->x = 0;
                    $eneComp->goLeft = false;
                }
                else {
                    $x = $tComp->x;
                    if ($x - $moveBy >= 0) {
                        $tComp->x -= $moveBy;
                    }
                    else {
                        $tComp->x = 0;
                    }
                }
            }
            else {
                if ($tComp->totalWidth() + $moveBy >= $this->screenManager->getCols()) {
                    $eneComp->goLeft = true;
                }else {
                    $tComp->x += $moveBy;
                }
            }
        }


    }
}
