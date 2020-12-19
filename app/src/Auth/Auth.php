<?php


namespace App\Auth;
use App\Entity\User;
use App\Entity\Merchant;
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
    public function merchant()
    {
        $merchant= $this->entityManager->getRepository("App\Entity\Merchant")->findOneBy([
            'user' =>$this->user()->getId()
        ]);
        if($merchant)
        {
            return $merchant;
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
            $_SESSION['usergroup']=$user->getGroup();
            return true;
        }

        return false;
    }

    public function logout()
    {
        unset($_SESSION['user']);
    }
}