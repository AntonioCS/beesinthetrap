<?php


namespace App\ECS\Systems;


use App\ECS\AbstractSystem;
use App\ECS\Components\BulletCollidableComponent;
use App\ECS\Components\BulletComponent;
use App\ECS\Components\HealthComponent;
use App\ECS\Components\TransformationComponent;
use App\ECS\SystemInterface;

class BulletCollidableSystem extends AbstractSystem implements SystemInterface
{

    public function update(): void
    {
        $bullets = $this->entityManager->findByComponents(BulletComponent::class, TransformationComponent::class);
        $entities = $this->entityManager->findByComponents(
            BulletCollidableComponent::class,
            TransformationComponent::class,
            HealthComponent::class
        );

        foreach ($bullets as $b) {
            $bTComp = $b->getComponent(TransformationComponent::class);

            foreach ($entities as $e) {
                $tComp = $e->getComponent(TransformationComponent::class);

                if ($this->hasCollided($bTComp, $tComp)) {
                    /** @var BulletCollidableComponent $bColComp */
                    $bColComp = $e->getComponent(BulletCollidableComponent::class);
                    /** @var HealthComponent $hComp */
                    $hComp = $e->getComponent(HealthComponent::class);

                    $this->entityManager->remove($b);

                    $hComp->health -= $bColComp->hitDamage;
                }
            }
        }

    }

    private function hasCollided(TransformationComponent $rect1, TransformationComponent $rect2)
    {
        return ($rect1->x < $rect2->x + $rect2->w &&
            $rect1->x + $rect1->w > $rect2->x &&
            $rect1->y < $rect2->y + $rect2->h &&
            $rect1->y + $rect1->h > $rect2->y);
    }
}
