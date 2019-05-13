<?php

namespace App\ECS;


class Entity
{
    /**
     * @var ComponentInterface[]
     */
    private $components;

    public function addComponents(ComponentInterface ...$components) : ?ComponentInterface
    {
        foreach ($components as $c) {
            $this->components[] = $c;
        }

        if (count($components) == 1) {
            return $components[0];
        }

        return null;
    }

    public function getComponent(string $componentType) : ?ComponentInterface
    {
        foreach ($this->components as $component) {
            if (is_a($component, $componentType)) {
                return $component;
            }
        }

        return null;
    }

    public function hasComponents(...$componentTypes) : bool
    {
        $total = count($componentTypes);
        $totalHas = 0;

        foreach ($this->components as $component) {
            foreach ($componentTypes as $type) {
                if (is_a($component, $type)) {
                    $totalHas++;
                    break;
                }
            }
        }

        return $total === $totalHas;
    }


}
