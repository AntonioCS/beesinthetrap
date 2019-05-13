<?php

namespace App\ECS;


class EntityManager
{
    /**
     * @var Entity[]
     */
    private $entities;

    public function makeEntity() : Entity
    {
        $e = new Entity();
        $this->entities[] = $e;

        return $e;
    }

    /**
     * @param mixed ...$components
     * @return Entity[]
     */
    public function findByComponents(...$components) : array
    {
        $entities = [];

        foreach ($this->entities as $e) {
            if ($e->hasComponents(...$components)) {
                $entities[] = $e;
            }
        }

        return $entities;
    }

    public function remove(Entity $e) : void
    {
        foreach ($this->entities as $k => $localE) {
            if ($localE === $e) {
                unset($this->entities[$k]);
                break;
            }
        }
    }
}
