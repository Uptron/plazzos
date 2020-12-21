<?php


namespace App\Service;
use App\Entity\ValuationReport;
use App\Entity\ValuationRequest;
use App\Entity\Valuer;

use Doctrine\ORM\EntityManager;

class ValuerService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    //fetch user
    function fetchValuer($user)
    {

        $valuer = $this->entityManager->getRepository('App\Entity\Valuer')->findOneBy(
            [
                'user' => $user
            ]
        );
        return $valuer;


    }
    public function fetchvaluations($valuer = null)
    {
        if($valuer == null) {

            $valuations= $this->entityManager->getRepository('App\Entity\ValuationRequest')->findAll();
            return $valuations;
        }
        else{
            $valuations = $this->entityManager->getRepository('App\Entity\ValuationRequest')->findBy(
                [
                    'valuerID' => $valuer,
                    'valuationStatus'=>'Pending'
                ]
            );
            return $valuations;
        }

    }
    public function fetchclosedvaluations($valuer = null)
    {
        if($valuer == null) {

            $valuations= $this->entityManager->getRepository('App\Entity\ValuationRequest')->findAll();
            return $valuations;
        }
        else{
            $valuations = $this->entityManager->getRepository('App\Entity\ValuationRequest')->findBy(
                [
                    'valuerID' => $valuer,
                    'valuationStatus'=>'Completed'
                ]
            );
            return $valuations;
        }

    }

    function fetchvaluation($id=null)
    {
        if ($id == null)
        {
            $valuations= $this->entityManager->getRepository('App\Entity\ValuationRequest')->findAll();

            return  $valuations;
        }
        else{
            $valuations = $this->entityManager->getRepository('App\Entity\ValuationRequest')->findOneBy(
                [
                    'id' => $id
                ]
            );
            return $valuations;
        }

    }

    function updateValuationrequest(ValuationRequest $valuation)
    {
        $this->entityManager->persist($valuation);
        $this->entityManager->flush();
        return true;
    }
    function storevaluationreport(ValuationReport $valuation)
    {
        $this->entityManager->persist($valuation);
        $this->entityManager->flush();
        return true;
    }

}