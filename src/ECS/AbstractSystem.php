<?php


namespace App\ECS;


use App\ScreenManager;

class AbstractSystem
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var ScreenManager
     */
    protected $screenManager;


    public function __construct(EntityManager $entityManager, ScreenManager $screenManager)
    {
        $this->entityManager = $entityManager;
        $this->screenManager = $screenManager;
    }
}
