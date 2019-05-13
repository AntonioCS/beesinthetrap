<?php


namespace App\ECS\Systems;


use App\ECS\AbstractSystem;
use App\ECS\Components\BulletComponent;
use App\ECS\Components\TransformationComponent;
use App\ECS\SystemInterface;

class BulletSystem extends AbstractSystem implements SystemInterface
{


    public function update(): void
    {
        $w = 2;
        $h = 2;
        $entities = $this->entityManager->findByComponents(BulletComponent::class, TransformationComponent::class);

        foreach ($entities as $e) {

            /** @var TransformationComponent $tComp */
            $tComp = $e->getComponent(TransformationComponent::class);
            /** @var BulletComponent $bComp */
            $bComp = $e->getComponent(BulletComponent::class);

            if ($tComp->y < 0) {
                $this->entityManager->remove($e);
            }
            else {

                if ($tComp->w == 0 || $tComp->h == 0) {
                    $tComp->w = $w;
                    $tComp->h = $h;
                }

                $tComp->y -= $bComp->speed;
            }
        }
    }
}
