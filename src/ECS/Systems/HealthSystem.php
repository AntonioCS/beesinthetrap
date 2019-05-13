<?php

namespace App\ECS\Systems;


use App\ECS\AbstractSystem;
use App\ECS\Components\HealthComponent;
use App\ECS\Components\TransformationComponent;
use App\ECS\SystemInterface;

class HealthSystem extends AbstractSystem implements SystemInterface
{

    public function update(): void
    {
        $entities = $this->entityManager->findByComponents(HealthComponent::class, TransformationComponent::class);

        foreach ($entities as $e) {
            /** @var TransformationComponent $tComp */
            $tComp = $e->getComponent(TransformationComponent::class);

            /** @var HealthComponent $hComp */
            $hComp = $e->getComponent(HealthComponent::class);

            $this->screenManager->write(
                $tComp->x+1,
                $tComp->y + 1,
                $hComp->health
            );
        }
    }
}
