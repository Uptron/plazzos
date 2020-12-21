<?php


namespace App\Service;


use App\Entity\ValuationRequest;
use App\Entity\Valuer;

use Doctrine\ORM\EntityManager;


class StaffService
{

    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    //Fetch Valuers
    function fetchvaluers($id)
    {
        if ($id == null)
        {
            $valuers = $this->entityManager->getRepository('App\Entity\Valuer')->findAll();

            return  $valuers;
        }
        else{
            $valuers = $this->entityManager->getRepository('App\Entity\Valuer')->findOneBy(
                [
                    'id' => $id
                ]
            );
            return $valuers;
        }

    }
    //fetch user
    function fetchStaff($user)
    {

            $staff = $this->entityManager->getRepository('App\Entity\Staff')->findOneBy(
                [
                    'user' => $user
                ]
            );
            return $staff;


    }
    //Fetch valuation requests for staff
    function fetchstaffvaluations($staff)
    {

            $valuations = $this->entityManager->getRepository('App\Entity\ValuationRequest')->findBy(
                [
                    'requester' => $staff
                ]
            );
            return $valuations;


    }
    //save Valuation Request
    function storeValuationRequest(ValuationRequest  $valuation)
    {
        $this->entityManager->persist($valuation);
        $this->entityManager->flush();

        return true;
    }
}