<?php


namespace App\Service;
use App\AbstractEntityManagerResource;
use App\Entity\Merchant;
use App\Entity\Payment;
use App\Entity\PaymentLog;
use App\Entity\Product;
use App\Entity\Group;
use App\Entity\Worker;
use App\Entity\Wallet;

use Doctrine\ORM\EntityManager;

class HomeService
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

    /*
     * PAYMENTS
     *
     */

    public function fetchPayments($id = null)
    {
        if ($id == null)
        {
            $payment = $this->entityManager->getRepository('App\Entity\Payment')->findAll();
            return $payment;
        }
        else
        {

            $payment = $this->entityManager->getRepository('App\Entity\Payment')->findOneBy(
                [
                    'id' => $id
                ]
            );


            if ($payment) {
                return $payment;
            }
        }
        return false;
    }

    public function merchantPayments($id = null)
    {
        if ($id == null)
        {
            $payment = $this->entityManager->getRepository('App\Entity\Payment')->findAll();
            return $payment;
        }
        else
        {

            $payment = $this->entityManager->getRepository('App\Entity\Payment')->findOneBy(
                [
                    'merchantID' => $id
                ]
            );


            if ($payment) {
                return $payment;
            }
        }
        return false;
    }

    function storePayment(Payment $payment)
    {
        $this->entityManager->persist($payment);
        $this->entityManager->flush();
        return true;
    }
    function storePaymentLog(PaymentLog $log)
    {
        $this->entityManager->persist($log);
        $this->entityManager->flush();
        return true;
    }




   /*
    * PRODUCTS
    *
    */


    public function fetchProducts($merchant = null)
    {

           if($merchant == null) {
               $products = $this->entityManager->getRepository('App\Entity\Product')->findAll();
               return $products;
           }
           else{
               $products = $this->entityManager->getRepository('App\Entity\Product')->findBy(
                   [
                       'merchantID' => $merchant
                   ]
               );
               return $products;
           }

    }

    function fetchProduct($id=null)
    {
        if ($id == null)
        {
            $products = $this->entityManager->getRepository('App\Entity\Product')->findAll();

            return  $products;
        }
        else{
            $products = $this->entityManager->getRepository('App\Entity\Product')->findOneBy(
                [
                    'id' => $id
                ]
            );
            return $products;
        }

    }

    function storeProduct(Product $product)
    {
        $this->entityManager->persist($product);
        $this->entityManager->flush();
        return true;
    }

    /*
     * GROUPS
     *
     */


    public function fetchgroups($merchant = null)
    {
        if($merchant == null) {

            $groups = $this->entityManager->getRepository('App\Entity\Group')->findAll();
            return $groups;
        }
        else{
            $groups = $this->entityManager->getRepository('App\Entity\Group')->findBy(
                [
                    'merchant' => $merchant
                ]
            );
            return $groups;
        }

    }

    function fetchgroup($id=null)
    {
        if ($id == null)
        {
            $groups = $this->entityManager->getRepository('App\Entity\Group')->findAll();

            return  $groups;
        }
        else{
            $groups = $this->entityManager->getRepository('App\Entity\Group')->findOneBy(
                [
                    'id' => $id
                ]
            );
            return $groups;
        }

    }

    function storeGroup(Group $group)
    {
        $this->entityManager->persist($group);
        $this->entityManager->flush();
        return true;
    }


   /*
   * GROUPS
   *
   */


    public function fetchworkers($id = null)
    {

        $merchant= $_SESSION['merchant_id'];
        $workers = $this->entityManager->getRepository('App\Entity\Worker')->findBy(
            [
                'merchantID' => $merchant
            ]
        );
        return $workers;


    }

    function fetchworker($id=null)
    {
        if ($id == null)
        {
            $workers = $this->entityManager->getRepository('App\Entity\Worker')->findAll();

            return  $workers;
        }
        else{
            $workers = $this->entityManager->getRepository('App\Entity\Worker')->findOneBy(
                [
                    'id' => $id
                ]
            );
            return $workers;
        }

    }


  function fetchgroupWorkers($group=null)
{
    if ($group == null)
    {
        $workers = $this->entityManager->getRepository('App\Entity\Worker')->findAll();

        return  $workers;
    }
    else{
        $workers = $this->entityManager->getRepository('App\Entity\Worker')->findBy(
            [
                'group' => $group
            ]
        );
        return $workers;
    }
}


    function storeWorker(Worker $worker)
    {
        $this->entityManager->persist($worker);
        $this->entityManager->flush();
        return true;
    }



    /*
     *
     * Custom Functions
     */

    /**
     * @param $length
     * @return string
     * Generate a Random Code given the number of digits
     */
    private function randomDigits($length)
    {
        $numbers = range(0, 9);
        shuffle($numbers);
        for ($i = 0; $i < $length; $i++) {
            global $digits;
            $digits .= $numbers[$i];
        }

        return $digits;
    }


}