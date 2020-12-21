<?php
namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="valuation_reports")
 */
class ValuationReport
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    /**
     *  @var valuer
     * @ORM\ManyToOne(targetEntity="App\Entity\Valuer")
     */
    private $valuer;
    /**
     *  @var $valuation
     * @ORM\OneToOne(targetEntity="App\Entity\ValuationRequest")
     */
    private $valuation;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $insuranceCo;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $policyNo;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $expiryDate;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $color;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $yom;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $engineNo;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $chassisNo;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $odometerReading;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $regDate;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $engineRating;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $serialNo;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $antiTheft;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $windscreenValue;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $audiosystemValue;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $alarmsystemValue;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $examinersOpinion;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $forcedsaleValue;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $bodywork;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $mechanical;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $steeringandsuspension;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $brakingsystem;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $electricalsystem;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $wheels;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $addedequipment;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $remarks;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $modificationsnoted;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $specialremarks;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $generalcondition;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $engineattachment;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $logbookattachment;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $reportattachment;
    /**
     * @ORM\Column(type="datetime")
     */
    private $dateDone;
    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $status;

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
     * @return valuer
     */
    public function getValuer(): valuer
    {
        return $this->valuer;
    }

    /**
     * @param valuer $valuer
     */
    public function setValuer(valuer $valuer): void
    {
        $this->valuer = $valuer;
    }

    /**
     * @return mixed
     */
    public function getValuation()
    {
        return $this->valuation;
    }

    /**
     * @param mixed $valuation
     */
    public function setValuation($valuation): void
    {
        $this->valuation = $valuation;
    }

    /**
     * @return mixed
     */
    public function getInsuranceCo()
    {
        return $this->insuranceCo;
    }

    /**
     * @param mixed $insuranceCo
     */
    public function setInsuranceCo($insuranceCo): void
    {
        $this->insuranceCo = $insuranceCo;
    }

    /**
     * @return mixed
     */
    public function getPolicyNo()
    {
        return $this->policyNo;
    }

    /**
     * @param mixed $policyNo
     */
    public function setPolicyNo($policyNo): void
    {
        $this->policyNo = $policyNo;
    }

    /**
     * @return mixed
     */
    public function getExpiryDate()
    {
        return $this->expiryDate;
    }

    /**
     * @param mixed $expiryDate
     */
    public function setExpiryDate($expiryDate): void
    {
        $this->expiryDate = $expiryDate;
    }

    /**
     * @return mixed
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param mixed $color
     */
    public function setColor($color): void
    {
        $this->color = $color;
    }

    /**
     * @return mixed
     */
    public function getYom()
    {
        return $this->yom;
    }

    /**
     * @param mixed $yom
     */
    public function setYom($yom): void
    {
        $this->yom = $yom;
    }

    /**
     * @return mixed
     */
    public function getEngineNo()
    {
        return $this->engineNo;
    }

    /**
     * @param mixed $engineNo
     */
    public function setEngineNo($engineNo): void
    {
        $this->engineNo = $engineNo;
    }

    /**
     * @return mixed
     */
    public function getChassisNo()
    {
        return $this->chassisNo;
    }

    /**
     * @param mixed $chassisNo
     */
    public function setChassisNo($chassisNo): void
    {
        $this->chassisNo = $chassisNo;
    }

    /**
     * @return mixed
     */
    public function getOdometerReading()
    {
        return $this->odometerReading;
    }

    /**
     * @param mixed $odometerReading
     */
    public function setOdometerReading($odometerReading): void
    {
        $this->odometerReading = $odometerReading;
    }

    /**
     * @return mixed
     */
    public function getRegDate()
    {
        return $this->regDate;
    }

    /**
     * @param mixed $regDate
     */
    public function setRegDate($regDate): void
    {
        $this->regDate = $regDate;
    }

    /**
     * @return mixed
     */
    public function getEngineRating()
    {
        return $this->engineRating;
    }

    /**
     * @param mixed $engineRating
     */
    public function setEngineRating($engineRating): void
    {
        $this->engineRating = $engineRating;
    }

    /**
     * @return mixed
     */
    public function getSerialNo()
    {
        return $this->serialNo;
    }

    /**
     * @param mixed $serialNo
     */
    public function setSerialNo($serialNo): void
    {
        $this->serialNo = $serialNo;
    }

    /**
     * @return mixed
     */
    public function getAntiTheft()
    {
        return $this->antiTheft;
    }

    /**
     * @param mixed $antiTheft
     */
    public function setAntiTheft($antiTheft): void
    {
        $this->antiTheft = $antiTheft;
    }

    /**
     * @return mixed
     */
    public function getWindscreenValue()
    {
        return $this->windscreenValue;
    }

    /**
     * @param mixed $windscreenValue
     */
    public function setWindscreenValue($windscreenValue): void
    {
        $this->windscreenValue = $windscreenValue;
    }

    /**
     * @return mixed
     */
    public function getAudiosystemValue()
    {
        return $this->audiosystemValue;
    }

    /**
     * @param mixed $audiosystemValue
     */
    public function setAudiosystemValue($audiosystemValue): void
    {
        $this->audiosystemValue = $audiosystemValue;
    }

    /**
     * @return mixed
     */
    public function getAlarmsystemValue()
    {
        return $this->alarmsystemValue;
    }

    /**
     * @param mixed $alarmsystemValue
     */
    public function setAlarmsystemValue($alarmsystemValue): void
    {
        $this->alarmsystemValue = $alarmsystemValue;
    }

    /**
     * @return mixed
     */
    public function getExaminersOpinion()
    {
        return $this->examinersOpinion;
    }

    /**
     * @param mixed $examinersOpinion
     */
    public function setExaminersOpinion($examinersOpinion): void
    {
        $this->examinersOpinion = $examinersOpinion;
    }

    /**
     * @return mixed
     */
    public function getForcedsaleValue()
    {
        return $this->forcedsaleValue;
    }

    /**
     * @param mixed $forcedsaleValue
     */
    public function setForcedsaleValue($forcedsaleValue): void
    {
        $this->forcedsaleValue = $forcedsaleValue;
    }

    /**
     * @return mixed
     */
    public function getBodywork()
    {
        return $this->bodywork;
    }

    /**
     * @param mixed $bodywork
     */
    public function setBodywork($bodywork): void
    {
        $this->bodywork = $bodywork;
    }

    /**
     * @return mixed
     */
    public function getMechanical()
    {
        return $this->mechanical;
    }

    /**
     * @param mixed $mechanical
     */
    public function setMechanical($mechanical): void
    {
        $this->mechanical = $mechanical;
    }

    /**
     * @return mixed
     */
    public function getSteeringandsuspension()
    {
        return $this->steeringandsuspension;
    }

    /**
     * @param mixed $steeringandsuspension
     */
    public function setSteeringandsuspension($steeringandsuspension): void
    {
        $this->steeringandsuspension = $steeringandsuspension;
    }

    /**
     * @return mixed
     */
    public function getBrakingsystem()
    {
        return $this->brakingsystem;
    }

    /**
     * @param mixed $brakingsystem
     */
    public function setBrakingsystem($brakingsystem): void
    {
        $this->brakingsystem = $brakingsystem;
    }

    /**
     * @return mixed
     */
    public function getElectricalsystem()
    {
        return $this->electricalsystem;
    }

    /**
     * @param mixed $electricalsystem
     */
    public function setElectricalsystem($electricalsystem): void
    {
        $this->electricalsystem = $electricalsystem;
    }

    /**
     * @return mixed
     */
    public function getWheels()
    {
        return $this->wheels;
    }

    /**
     * @param mixed $wheels
     */
    public function setWheels($wheels): void
    {
        $this->wheels = $wheels;
    }

    /**
     * @return mixed
     */
    public function getAddedequipment()
    {
        return $this->addedequipment;
    }

    /**
     * @param mixed $addedequipment
     */
    public function setAddedequipment($addedequipment): void
    {
        $this->addedequipment = $addedequipment;
    }

    /**
     * @return mixed
     */
    public function getRemarks()
    {
        return $this->remarks;
    }

    /**
     * @param mixed $remarks
     */
    public function setRemarks($remarks): void
    {
        $this->remarks = $remarks;
    }

    /**
     * @return mixed
     */
    public function getModificationsnoted()
    {
        return $this->modificationsnoted;
    }

    /**
     * @param mixed $modificationsnoted
     */
    public function setModificationsnoted($modificationsnoted): void
    {
        $this->modificationsnoted = $modificationsnoted;
    }

    /**
     * @return mixed
     */
    public function getSpecialremarks()
    {
        return $this->specialremarks;
    }

    /**
     * @param mixed $specialremarks
     */
    public function setSpecialremarks($specialremarks): void
    {
        $this->specialremarks = $specialremarks;
    }

    /**
     * @return mixed
     */
    public function getGeneralcondition()
    {
        return $this->generalcondition;
    }

    /**
     * @param mixed $generalcondition
     */
    public function setGeneralcondition($generalcondition): void
    {
        $this->generalcondition = $generalcondition;
    }

    /**
     * @return mixed
     */
    public function getEngineattachment()
    {
        return $this->engineattachment;
    }

    /**
     * @param mixed $engineattachment
     */
    public function setEngineattachment($engineattachment): void
    {
        $this->engineattachment = $engineattachment;
    }

    /**
     * @return mixed
     */
    public function getLogbookattachment()
    {
        return $this->logbookattachment;
    }

    /**
     * @param mixed $logbookattachment
     */
    public function setLogbookattachment($logbookattachment): void
    {
        $this->logbookattachment = $logbookattachment;
    }

    /**
     * @return mixed
     */
    public function getReportattachment()
    {
        return $this->reportattachment;
    }

    /**
     * @param mixed $reportattachment
     */
    public function setReportattachment($reportattachment): void
    {
        $this->reportattachment = $reportattachment;
    }

    /**
     * @return mixed
     */
    public function getDateDone()
    {
        return $this->dateDone;
    }

    /**
     * @param mixed $dateDone
     */
    public function setDateDone($dateDone): void
    {
        $this->dateDone = $dateDone;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }


}