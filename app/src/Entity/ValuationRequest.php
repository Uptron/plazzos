<?php


namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="valuations")
 */
class ValuationRequest
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $clientName;
    /**
     * @ORM\Column(type="string")
     */
    private $clientPhone;
    /**
     * @ORM\Column(type="string")
     */
    private $vehicleReg;
    /**
     * @ORM\Column(type="string")
     */
    private $vehicleMake;
    /**
     * @ORM\Column(type="string")
     */
    private $vehicleModel;
    /**
     * @ORM\Column(type="string")
     */
    private $vehicleType;
    /**
     *  @var valuer
     * @ORM\ManyToOne(targetEntity="App\Entity\Valuer")
     */
    private $valuerID;

    /**
     * @var staff
     * @ORM\ManyToOne(targetEntity="App\Entity\Staff")
     */
    private $requester;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateRequested;
    /**
     * @ORM\Column(type="datetime",nullable=true)
     */
    private $dateUpdated;

     /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $approvedBy;

    /**
     * @ORM\Column(type="string")
     */
    private $valuationStatus="Pending";
    /**
     * @ORM\Column(type="string")
     */
    private $logBook;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $comment;

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
    public function getClientName()
    {
        return $this->clientName;
    }

    /**
     * @param mixed $clientName
     */
    public function setClientName($clientName): void
    {
        $this->clientName = $clientName;
    }

    /**
     * @return mixed
     */
    public function getClientPhone()
    {
        return $this->clientPhone;
    }

    /**
     * @param mixed $clientPhone
     */
    public function setClientPhone($clientPhone): void
    {
        $this->clientPhone = $clientPhone;
    }

    /**
     * @return mixed
     */
    public function getVehicleReg()
    {
        return $this->vehicleReg;
    }

    /**
     * @param mixed $vehicleReg
     */
    public function setVehicleReg($vehicleReg): void
    {
        $this->vehicleReg = $vehicleReg;
    }

    /**
     * @return mixed
     */
    public function getVehicleMake()
    {
        return $this->vehicleMake;
    }

    /**
     * @param mixed $vehicleMake
     */
    public function setVehicleMake($vehicleMake): void
    {
        $this->vehicleMake = $vehicleMake;
    }

    /**
     * @return mixed
     */
    public function getVehicleModel()
    {
        return $this->vehicleModel;
    }

    /**
     * @param mixed $vehicleModel
     */
    public function setVehicleModel($vehicleModel): void
    {
        $this->vehicleModel = $vehicleModel;
    }

    /**
     * @return valuer
     */
    public function getValuerID(): valuer
    {
        return $this->valuerID;
    }

    /**
     * @param valuer $valuerID
     */
    public function setValuerID(valuer $valuerID): void
    {
        $this->valuerID = $valuerID;
    }

    /**
     * @return staff
     */
    public function getRequester(): staff
    {
        return $this->requester;
    }

    /**
     * @param staff $requester
     */
    public function setRequester(staff $requester): void
    {
        $this->requester = $requester;
    }

    /**
     * @return mixed
     */
    public function getDateRequested()
    {
        return $this->dateRequested;
    }

    /**
     * @param mixed $dateRequested
     */
    public function setDateRequested($dateRequested): void
    {
        $this->dateRequested = $dateRequested;
    }

    /**
     * @return mixed
     */
    public function getDateUpdated()
    {
        return $this->dateUpdated;
    }

    /**
     * @param mixed $dateUpdated
     */
    public function setDateUpdated($dateUpdated): void
    {
        $this->dateUpdated = $dateUpdated;
    }

    /**
     * @return mixed
     */
    public function getApprovedBy()
    {
        return $this->approvedBy;
    }

    /**
     * @param mixed $approvedBy
     */
    public function setApprovedBy($approvedBy): void
    {
        $this->approvedBy = $approvedBy;
    }

    /**
     * @return string
     */
    public function getValuationStatus(): string
    {
        return $this->valuationStatus;
    }

    /**
     * @param string $valuationStatus
     */
    public function setValuationStatus(string $valuationStatus): void
    {
        $this->valuationStatus = $valuationStatus;
    }

    /**
     * @return mixed
     */
    public function getLogBook()
    {
        return $this->logBook;
    }

    /**
     * @param mixed $logBook
     */
    public function setLogBook($logBook): void
    {
        $this->logBook = $logBook;
    }

    /**
     * @return mixed
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param mixed $comment
     */
    public function setComment($comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return mixed
     */
    public function getVehicleType()
    {
        return $this->vehicleType;
    }

    /**
     * @param mixed $vehicleType
     */
    public function setVehicleType($vehicleType): void
    {
        $this->vehicleType = $vehicleType;
    }


}