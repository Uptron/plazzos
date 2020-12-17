<?php


namespace App\Service;


use App\AbstractEntityManagerResource;
use App\Entity\Merchant;

use Doctrine\ORM\EntityManager;

class AdminService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function fetchmerchants($id = null)
    {
        if ($id == null)
        {
            $merchant = $this->entityManager->getRepository('App\Entity\Merchant')->findAll();
            return $merchant;
        }
        else
            {

                $merchant = $this->entityManager->getRepository('App\Entity\Merchant')->findOneBy(
                    [
                        'id' => $id
                    ]
                );


            if ($merchant) {
                return $merchant;
            }
        }
        return false;
    }

    function storeMerchant(Merchant $merchant)
    {
        $this->entityManager->persist($merchant);
        $this->entityManager->flush();
        return true;
    }

}