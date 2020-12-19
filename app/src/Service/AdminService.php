<?php


namespace App\Service;


use App\AbstractEntityManagerResource;
use App\Entity\UsersGroup;
use App\Entity\User;
use App\Entity\Valuer;

use Doctrine\ORM\EntityManager;

class AdminService
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    //fetch users
    function fetchusers($id=null)
    {
        if ($id == null)
        {
            $users = $this->entityManager->getRepository('App\Entity\User')->findAll();

            return  $users;
        }
        else{
            $users = $this->entityManager->getRepository('App\Entity\User')->findOneBy(
                [
                    'id' => $id
                ]
            );
            return $users;
        }

    }
//Store User
    function storeUser(User $user)
    {

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return true;
    }
//store group
    function storeGroup(UsersGroup $group)
    {

        $this->entityManager->persist($group);
        $this->entityManager->flush();

        return true;
    }

    //Store Valuer
    function storeValuer(Valuer $valuer)
    {

        $this->entityManager->persist($valuer);
        $this->entityManager->flush();

        return true;
    }
    //Fetch Valuers
    function fetchvaluers($id=null)
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
//Fetch User Groups
    public function fetchgroups()
    {
            $groups = $this->entityManager->getRepository('App\Entity\UsersGroup')->findAll();
            return $groups;
    }
//fetch group by name
    function fetchgroup($name=null)
    {
        if ($name == null)
        {
            $groups = $this->entityManager->getRepository('App\Entity\UsersGroup')->findAll();

            return  $groups;
        }
        else{
            $groups = $this->entityManager->getRepository('App\Entity\UsersGroup')->findOneBy(
                [
                    'name' => $name
                ]
            );
            return $groups;
        }

    }
}