<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */

class User
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="string")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="UsersGroup")
     */
    private $group;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $middlename;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string")
     */
    private $userName;

    /**
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $accountCreatedAt;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $accountUpdateAt;

    /**
     * @ORM\Column(type="string")
     */
    private $status="Active";

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
     * @return mixed
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
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
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return mixed
     */
    public function getMiddlename()
    {
        return $this->middlename;
    }

    /**
     * @param mixed $middlename
     */
    public function setMiddlename($middlename): void
    {
        $this->middlename = $middlename;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param mixed $lastName
     */
    public function setLastName($lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->userName;
    }

    /**
     * @param mixed $userName
     */
    public function setUserName($userName): void
    {
        $this->userName = $userName;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     */
    public function setPassword($password): void
    {
        $this->password = $password;
    }

    /**
     * @return mixed
     */
    public function getAccountCreatedAt()
    {
        return $this->accountCreatedAt;
    }

    /**
     * @param mixed $accountCreatedAt
     */
    public function setAccountCreatedAt($accountCreatedAt): void
    {
        $this->accountCreatedAt = $accountCreatedAt;
    }

    /**
     * @return mixed
     */
    public function getAccountUpdateAt()
    {
        return $this->accountUpdateAt;
    }

    /**
     * @param mixed $accountUpdateAt
     */
    public function setAccountUpdateAt($accountUpdateAt): void
    {
        $this->accountUpdateAt = $accountUpdateAt;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): void
    {
        $this->status = $status;
    }



}