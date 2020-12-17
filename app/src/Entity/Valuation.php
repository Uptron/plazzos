<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="valuations")
 */
class Valuation
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="valuer")
     */
    private $valuerID;

    /**
     * @var Agent
     * @ORM\ManyToOne(targetEntity="App\Entity\Agent")
     */
    private $requester;

    /**
     * @var Customer
     * @ORM\ManyToOne(targetEntity="App\Entity\customer")
     */
    private $customer;

    /**
     * @ORM\Column(type="string")
     */
    private $vehicleRegNo;
    /**
     * @ORM\Column(type="string")
     */
    private $make;
    /**
     * @ORM\Column(type="string")
     */
    private $model;
    /**
     * @ORM\Column(type="string")
     */
    private $color;
    /**
     * @ORM\Column(type="string")
     */
    private $chasisNo;
    /**
     * @ORM\Column(type="string")
     */
    private $yom;


    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRequested;

       /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $approvedBy;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $comments;
    /**
     * @ORM\Column(type="string")
     */
    private $valuationStatus;


}