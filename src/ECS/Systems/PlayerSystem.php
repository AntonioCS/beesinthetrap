<?php


namespace App\ECS\Systems;


use App\ECS\AbstractSystem;
use App\ECS\Components\BulletComponent;
use App\ECS\Components\PlayerComponent;
use App\ECS\Components\SquareComponent;
use App\ECS\Components\TransformationComponent;
use App\ECS\SystemInterface;

class PlayerSystem extends AbstractSystem implements SystemInterface
{


    public function update(): void
    {

        $moveBy = 5;
        $entities = $this->entityManager->findByComponents(PlayerComponent::class, TransformationComponent::class);

        foreach ($entities as $e) {
            /** @var TransformationComponent $tComp */
            $tComp = $e->getComponent(TransformationComponent::class);

            //while (($event = poolEvents()) != null) {

            if (hasEvent('KEY_PRESSED_ARROW_LEFT')) {
                if ($tComp->x - $moveBy >= 0) {
                    $tComp->x -= $moveBy;
                }
            }

            if (hasEvent( 'KEY_PRESSED_ARROW_RIGHT')) {
                if ($tComp->totalWidth() + $moveBy <= $this->screenManager->getCols()) {
                    $tComp->x += $moveBy;
                } else {
                    $tComp->x = $this->screenManager->getCols() - $tComp->totalWidth();
                }
            }

            if (hasEvent('KEY_PRESSED_ARROW_UP')) {
                if ($tComp->y > $this->screenManager->getCenterY() + 10) {
                    $tComp->y -= $moveBy;
                }
            }

            if (hasEvent('KEY_PRESSED_ARROW_DOWN')) {
                if ($tComp->totalHeight() <= $this->screenManager->getLines()) {
                    $tComp->y += $moveBy;
                }
            }

            if (hasEvent('KEY_PRESSED_SPACE')) {

                ($this->entityManager->makeEntity())
                    ->addComponents(
                        new BulletComponent(),
                        new TransformationComponent($tComp->x, $tComp->y - 2, 0, 0),
                        new SquareComponent()
                    );
            }
            //}
        }
    }
}
