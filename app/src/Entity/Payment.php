<?php


namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="payments")
 */

class Payment
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id",type="string")
     * @ORM\GeneratedValue(strategy="UUID")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Merchant")
     */
    private $merchantID;

    /**
     * @var Product
     * @ORM\ManyToOne(targetEntity="App\Entity\Product")
     */
    private $product;

    /**
     * @var Group
     * @ORM\ManyToOne(targetEntity="Group")
     */
    private $group;
    /**
     * @ORM\Column(type="string")
     */
    private $paymentType;

    /**
     * @ORM\Column(type="integer")
     */
    private $totalWorkers;

    /**
     * @ORM\Column(type="decimal")
     */
    private $amountPerWorker;
    /**
     * @ORM\Column(type="decimal")
     */
    private $transactionCost;
    /**
     * @ORM\Column(type="decimal")
     */
    private $commission;
    /**
     * @ORM\Column(type="decimal")
     */
    private $totalPayout;

    /**
     * @ORM\Column(type="datetime")
     */
    private $paymentDate;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $initiatedBy;

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
    private $paymentStatus;

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
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getMerchantID()
    {
        return $this->merchantID;
    }

    /**
     * @param mixed $merchantID
     */
    public function setMerchantID($merchantID)
    {
        $this->merchantID = $merchantID;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return Group
     */
    public function getGroup(): Group
    {
        return $this->group;
    }

    /**
     * @param Group $group
     */
    public function setGroup(Group $group)
    {
        $this->group = $group;
    }

    /**
     * @return mixed
     */
    public function getPaymentType()
    {
        return $this->paymentType;
    }

    /**
     * @param mixed $paymentType
     */
    public function setPaymentType($paymentType)
    {
        $this->paymentType = $paymentType;
    }

    /**
     * @return mixed
     */
    public function getTotalWorkers()
    {
        return $this->totalWorkers;
    }

    /**
     * @param mixed $totalWorkers
     */
    public function setTotalWorkers($totalWorkers)
    {
        $this->totalWorkers = $totalWorkers;
    }

    /**
     * @return mixed
     */
    public function getAmountPerWorker()
    {
        return $this->amountPerWorker;
    }

    /**
     * @param mixed $amountPerWorker
     */
    public function setAmountPerWorker($amountPerWorker)
    {
        $this->amountPerWorker = $amountPerWorker;
    }

    /**
     * @return mixed
     */
    public function getTransactionCost()
    {
        return $this->transactionCost;
    }

    /**
     * @param mixed $transactionCost
     */
    public function setTransactionCost($transactionCost)
    {
        $this->transactionCost = $transactionCost;
    }

    /**
     * @return mixed
     */
    public function getCommission()
    {
        return $this->commission;
    }

    /**
     * @param mixed $commission
     */
    public function setCommission($commission)
    {
        $this->commission = $commission;
    }

    /**
     * @return mixed
     */
    public function getTotalPayout()
    {
        return $this->totalPayout;
    }

    /**
     * @param mixed $totalPayout
     */
    public function setTotalPayout($totalPayout)
    {
        $this->totalPayout = $totalPayout;
    }

    /**
     * @return mixed
     */
    public function getPaymentDate()
    {
        return $this->paymentDate;
    }

    /**
     * @param mixed $paymentDate
     */
    public function setPaymentDate($paymentDate)
    {
        $this->paymentDate = $paymentDate;
    }

    /**
     * @return mixed
     */
    public function getInitiatedBy()
    {
        return $this->initiatedBy;
    }

    /**
     * @param mixed $initiatedBy
     */
    public function setInitiatedBy($initiatedBy)
    {
        $this->initiatedBy = $initiatedBy;
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
    public function setApprovedBy($approvedBy)
    {
        $this->approvedBy = $approvedBy;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

    /**
     * @return mixed
     */
    public function getPaymentStatus()
    {
        return $this->paymentStatus;
    }

    /**
     * @param mixed $paymentStatus
     */
    public function setPaymentStatus($paymentStatus)
    {
        $this->paymentStatus = $paymentStatus;
    }



}