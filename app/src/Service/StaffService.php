<?php


namespace App\Service;


use Doctrine\ORM\EntityManager;

class staffService
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
}