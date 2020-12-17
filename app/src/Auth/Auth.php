<?php


namespace App\Auth;
use Doctrine\ORM\EntityManager;

class Auth
{
    private $entityManager;

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;

    }

    public function user()
    {
        $user= $this->entityManager->getRepository("App\Entity\User")->findOneBy([
            'id' => $_SESSION['user'],
        ]);

        return $user;
    }
    public function valuer()
    {
        $valuer= $this->entityManager->getRepository("App\Entity\Valuer")->findOneBy([
            'user' =>$this->user()->getId()
        ]);
        if($valuer)
        {
            return $valuer;
        }
        else{
            return false;
        }

    }

    public function check()
    {
       return isset($_SESSION['user']);
    }

    public function attempt($email,$password)
    {
        $user= $this->entityManager->getRepository("App\Entity\User")->findOneBy([
            'email' => $email,
        ]);

        if(!$user)
        {
          return false;
        }

        if(password_verify($password,$user->getPassword()))
        {
            $_SESSION['user']=$user->getId();
            $_SESSION['username']=$user->getUserName();
            //Get Valuer ID
            $valuer= $this->entityManager->getRepository("App\Entity\Valuer")->findOneBy([
                'user' =>$user->getId()
            ]);
            $_SESSION['valuer_id']=$valuer->getId();
            $_SESSION['valuer_name']=$valuer->getValuerName;
            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}