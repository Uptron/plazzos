<?php


namespace App\Service;
use App\Entity\Valuation;

use Doctrine\ORM\EntityManager;

class ValuerService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    /*
     * GROUPS
     *
     */


    public function fetchvaluations($valuer = null)
    {
        if($valuer == null) {

            $valuations= $this->entityManager->getRepository('App\Entity\Valuation')->findAll();
            return $valuations;
        }
        else{
            $valuations = $this->entityManager->getRepository('App\Entity\Valuation')->findBy(
                [
                    'valuer' => $valuer
                ]
            );
            return $valuations;
        }

    }

    function fetchvaluation($id=null)
    {
        if ($id == null)
        {
            $valuations= $this->entityManager->getRepository('App\Entity\Valuation')->findAll();

            return  $valuations;
        }
        else{
            $valuations = $this->entityManager->getRepository('App\Entity\Valuation')->findOneBy(
                [
                    'id' => $id
                ]
            );
            return $valuations;
        }

    }

    function updateValuation(Valuation $valuation)
    {
        $this->entityManager->persist($valuation);
        $this->entityManager->flush();
        return true;
    }

}