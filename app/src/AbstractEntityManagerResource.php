<?php


namespace App;


use Doctrine\ORM\EntityManager;

class AbstractEntityManagerResource
{
    protected $entityManager=null;

    /**
     * AbstractEntityManagerResource constructor.
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager=$entityManager;
    }
}