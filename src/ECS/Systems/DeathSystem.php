<?php


namespace App\ECS\Systems;


use App\ECS\AbstractSystem;
use App\ECS\Components\HealthComponent;
use App\ECS\SystemInterface;

class DeathSystem extends AbstractSystem implements SystemInterface
{

    public function update(): void
    {
        $entities = $this->entityManager->findByComponents(HealthComponent::class);

        foreach ($entities as $e) {
            /** @var HealthComponent $hCom */
            $hCom = $e->getComponent(HealthComponent::class);

            if ($hCom->health <= 0) {
                $this->entityManager->remove($e);
            }
        }
    }
}
