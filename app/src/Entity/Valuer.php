<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="valuer")
 */

class Valuer
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    /**
     * @var User
     * @ORM\OneToOne(targetEntity="App\Entity\User")
     */
    private $user;
    /**
     * @ORM\Column(type="string")
     */
    private $valuerName;
    /**
     * @ORM\Column(type="string")
     */
    private $phoneNumber;
    /**
     * @ORM\Column(type="string")
     */
    private $email;
    /**
     * @ORM\Column(type="string")
     */
    private $address;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateCreated;

    /**
     * @ORM\Column(type="string")
     */
    private $accountStatus;

    public function __construct()
    {
        /* $date = new \DateTime();
         $this->dateCreated = $date->format('Y-m-d H:I:S');*/

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id): void
    {
        $this->id = $id;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getValuerName()
    {
        return $this->valuerName;
    }

    /**
     * @param mixed $valuerName
     */
    public function setValuerName($valuerName): void
    {
        $this->valuerName = $valuerName;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email): void
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address): void
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @param mixed $dateCreated
     */
    public function setDateCreated($dateCreated): void
    {
        $this->dateCreated = $dateCreated;
    }

    /**
     * @return mixed
     */
    public function getAccountStatus()
    {
        return $this->accountStatus;
    }

    /**
     * @param mixed $accountStatus
     */
    public function setAccountStatus($accountStatus): void
    {
        $this->accountStatus = $accountStatus;
    }




}