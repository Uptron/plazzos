<?php
namespace App\Action;

use App\Entity\PaymentLog;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use App\Service\HomeService;
use App\Entity\Merchant;
use App\Entity\Product;
use App\Entity\Payment;
use App\Entity\Group;
use App\Entity\Worker;
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;
use Slim\Http\UploadedFile;
use SpreadsheetReader;
use Spreadsheet_Excel_Reader;
use Slim\Flash\Messages as FlashMessages;


final class HomeAction extends BaseAction
{
    private $view;
    private $logger;
    private $homeService;
    private $entityManager;
    private $flash;

    public function __construct(Twig $view, LoggerInterface $logger, HomeService $homeService,EntityManager $entityManager, FlashMessages $flash) {
        $this->view = $view;
        $this->logger = $logger;
        $this->homeService = $homeService;
        $this->entityManager = $entityManager;
        $this->flash = $flash;
    }

    public function __invoke(Request $request, Response $response, $args)
    {

        $this->view->render($response, 'dashboard.twig');

        return $response;
    }

    /** PAYMENTS **/
    public function initiatePayment(Request $request, Response $response) {

        $merchant = $_SESSION['merchant_id'];

        $products = $this->homeService->fetchProducts();
        $groups = $this->homeService->fetchgroups();

        $this->view->render($response, 'payments/initiate-payment.twig', [
            'products' => $products,
            'groups' => $groups
        ]);
        return $response;
    }
    public function oneWorker(Request $request, Response $response) {

       $merchant = $_SESSION['merchant_id'];

        $products = $this->homeService->fetchProducts();
        $groups = $this->homeService->fetchgroups();

        $this->view->render($response, 'payments/pay-single-worker.twig', [
            'products' => $products,
            'groups' => $groups
        ]);
        return $response;
    }
    public function workerGroups(Request $request, Response $response) {

        // $merchant = $_SESSION['merchant_id'];

        $products = $this->homeService->fetchProducts();
        $groups = $this->homeService->fetchgroups();

        $this->view->render($response, 'payments/pay-workergroup.twig', [
            'products' => $products,
            'groups' => $groups
        ]);
        return $response;
    }
    public function bulkUpload(Request $request, Response $response) {

         $merchant = $_SESSION['merchant_id'];

        $products = $this->homeService->fetchProducts();
        $groups = $this->homeService->fetchgroups();

        $this->view->render($response, 'payments/excel-bulk-payment.twig', [
            'products' => $products,
            'groups' => $groups
        ]);
        return $response;
    }
    public function productPayout(Request $request, Response $response,$args) {

       /* $productID=$this->$request->getParam('product');

        $products=$this->homeService->fetchProduct($productID);

        return $response->withJson( $products);*/
    }

    //Pay Single Worker

    public function paySingleWorker(Request $request, Response $response)
    {
        $first_name= $request->getParam('first_name');
        $last_name= $request->getParam('last_name');
        $middle_name= $request->getParam('middle_name');
        $id_number= $request->getParam('id_number');
        $phone_number= $request->getParam('phone_number');
        $product= $request->getParam('product');
        $worker_amount= $request->getParam('worker_amount');
        $transaction_cost= $request->getParam('transaction_cost');
        $total_payouts= $request->getParam('total_payouts');
        $comments= $request->getParam('comments');
        $initiator=$_SESSION['user'];
        $approver='';
        $date=new \DateTime();
        $status = 'PENDING APPROVAL';
        $totalWorkers=1;
        $refNo=$this->randomDigits("6");
        $type='Single';

        $purpose = $this->homeService->fetchProduct($product);
        $merchantID=$_SESSION['merchant_id'];;
        $merchant=$this->homeService->fetchmerchants($merchantID);

        $payment = new Payment();
        $payment->setMerchantID($merchant);
        $payment->setProduct($purpose);
        $payment->setPaymentType($type);
        $payment->setTotalWorkers($totalWorkers);
        $payment->setAmountPerWorker($worker_amount);
        $payment->setTransactionCost($transaction_cost);
        $payment->setTotalPayout($total_payouts);
        $payment->setCommission($total_payouts);
        $payment->setPaymentDate($date);
        $payment->setInitiatedBy($initiator);
        $payment->setComments($comments);
        $payment->setPaymentStatus($status);

        $log= new PaymentLog();
        $log->setPayment($payment);
        $log->setRefNumber($refNo);
        $log->setFirstName($first_name);
        $log->setMiddleName($middle_name);
        $log->setLastName($last_name);
        $log->setPhoneNumber($phone_number);
        $log->setIdNumber($id_number);
        $log->setInitiatedBy($initiator);
        $log->setAmount($worker_amount);
        $log->setPaymentStatus($status);


        $payments = $this->homeService->storePayment($payment);
        $logs = $this->homeService->storePaymentLog($log);

        return $response->withRedirect('/merchant/');

    }

    //Pay Worker Group
    public function payWorkGroup(Request $request, Response $response) {

        $productId = $request->getParam('product');
        $groupId = $request->getParam('group');
        $amountPerWorker = $request->getParam('worker_amount');
        $totalWorkers = $request->getParam('total_workers');
        $totalPayout = $request->getParam('total_payouts');
        $comments = $request->getParam('comments');
        $transaction_cost= $request->getParam('transaction_cost');
        $initiator=$_SESSION['user'];
        $approver='';
        $date=new \DateTime();
        $status = 'PENDING APPROVAL';
        $type='Workgroup';


        $product = $this->homeService->fetchProduct($productId);
        $group=$this->homeService->fetchgroup($groupId);
        $merchantID= $_SESSION['merchant_id'];

        $merchant=$this->homeService->fetchmerchants($merchantID);


        $payment = new Payment();
        $payment->setMerchantID($merchant);
        $payment->setProduct($product);
        $payment->setGroup($group);
        $payment->setPaymentType($type);
        $payment->setTotalWorkers($totalWorkers);
        $payment->setAmountPerWorker($amountPerWorker);
        $payment->setTransactionCost($transaction_cost);
        $payment->setCommission($transaction_cost);
        $payment->setTotalPayout($totalPayout);
        $payment->setPaymentDate($date);
        $payment->setInitiatedBy($initiator);
        $payment->setComments($comments);
        $payment->setPaymentStatus($status);



        $log = new PaymentLog();
        //Fetch All Workers In Group
        $workers=$this->homeService->fetchgroupWorkers($group);

        foreach($workers as $worker)
        {
            $log->setPayment($payment);
            $log->setRefNumber($this->randomDigits("6"));
            $log->setFirstName($worker->getFirstName());
            $log->setMiddleName($worker->getMiddleName());
            $log->setLastName($worker->getLastName());
            $log->setPhoneNumber($worker->getphoneNumber());
            $log->setIdNumber($worker->getLastName());
            $log->setInitiatedBy($initiator);
            $log->setAmount($amountPerWorker);
            $log->setPaymentStatus($status);

        }

        $payments = $this->homeService->storePayment($payment);
        $logs = $this->homeService->storePaymentLog($log);

        return $response->withRedirect('/merchant/');
    }

    public function bulk_payments(Request $request, Response $response) {
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['excel'];
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        $allowedExts = array("xls", "csv","xlsx");
        //$uploadedFile->file >>>>>>File Path

        if (($uploadedFile->getSize() < 20000000) && in_array($extension, $allowedExts)) {

            if ($uploadedFile->getError() > 0) {
                $msg = "Error: " .$uploadedFile->getError() . "";
            } else {
                // $file = $uploadedFile->getClientFilename();
                $file = $_FILES['excel']['tmp_name'];
                if ($uploadedFile->getSize() > 0) {

                    if ($extension == "xls") {

                        $excel = new Spreadsheet_Excel_Reader;

                        $excel->read($file);
                        $nr_sheets = count($excel->sheets);

                        // gets the number of worksheets
                        $excel_data = '';
                        // to store the the html tables with data of each sheet

                        $fileErr = 0;
                        $Total = 0;
                        $duplR = 0;
                        $inval = 0;
                        $failz = 0;
                        $errrors = 0;
                        for ($i = 0; $i < $nr_sheets; $i++) {
                            $sheet = $excel->sheets[$i];
                            if ($sheet['numRows'] > 0) {

                                $x = 1;
                                while ($x <= $sheet['numRows']) {

                                    $out = array();
                                    for ($y = 1; $y <= 7; $y++) {
                                        $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
                                        $out[] = $cell;
                                    }

                                    $worker_group = $request->getParam('worker_group');
                                    $status ='Active';
                                    $first_name = preg_replace('~\x{00a0}~', '', str_replace(' ', ' ', $out[0]));
                                    $middle_name = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[1]));
                                    $last_name = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[2]));
                                    $phone_number = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[3]));
                                    $id_number = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[4]));
                                    $staff_id = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[5]));


                                    if (!empty($phone_number) || !empty($id_number)) {



                                        $checkdupz=$this->entityManager->getRepository('App\Entity\Worker')->findOneBy(
                                            [
                                                'idNumber' => $id_number,
                                                'phoneNumber'=>$phone_number,
                                                'group'=>$worker_group
                                            ]
                                        );
                                        if (!$checkdupz) {


                                            $group=$this->homeService->fetchgroup($worker_group);
                                            $worker = new Worker();
                                            $worker->setGroup($group);
                                            $worker->setFirstName($first_name);
                                            $worker->setMiddleName( $middle_name);
                                            $worker->setLastName($last_name);
                                            $worker->setPhoneNumber($phone_number);
                                            $worker->setIdNumber($id_number);
                                            $worker->setStaffID($staff_id);
                                            $worker->setCreatedAt(new \DateTime());
                                            $worker->setCreatedBy($_SESSION['user']);
                                            $worker->setUpdatedBy($_SESSION['user']);
                                            $worker->setUpdatedAt(new \DateTime());
                                            $worker->setStatus($status);

                                            $reslti = $this->homeService->storeWorker($worker);

                                            if ($reslti) {
                                                $Total = $Total + 1;
                                            } else {
                                                $failz = $failz + 1;
                                            }
                                        } else {
                                            $duplR = $duplR + 1;
                                        }
                                    } else {
                                        $inval = $inval + 1;
                                    }
                                    $x++;
                                }
                            }
                        }
                        //$msg = '<span style=\"color:blue;font-weight:bold\"><b>'. $Total . '</b> Numbers registered, <b>' . $failz . '</b> Failed, <b>'. $duplR . '</b> Duplicates & <b>' . $inval . '</b> Invalid numbers</span>';

                        // $this->container->flash->addMessage('error',$msg);

                        return $response->withRedirect('/merchant/manage-workers');
                    }
                } else {

                    //Empty File selected
                    //$this->container->flash->addMessage('error','Selected File Is Empty!!!');

                    return $response->withRedirect('/merchant/manage-workers');
                }
            }
        } else {


            //Oversize File
            // $this->container->flash->addMessage('error','Selected File Is Too Big');

            return $response->withRedirect('/merchant/manage-workers');
        }
    }

    public function approvePayment(Request $request, Response $response) {

        $merchant = $_SESSION['merchant_id'];

        $payments = $this->homeService->merchantPayments($merchant);


        $this->view->render($response, 'payments/approve-payment.twig', [
            'payments' => $payments
        ]);
        return $response;
    }

    /** END PAYMENTS **/

    /** MANAGE PRODUCTS **/

    public function fetchProducts(Request $request, Response $response) {

        $merchant = $_SESSION['merchant_id'];

        $products = $this->homeService->fetchProducts($merchant);

        $this->view->render($response, 'products/manage_products.twig', [
            'products' => $products
        ]);
        return $response;
    }

    public function newProduct(Request $request, Response $response) {

        $this->view->render($response, 'products/add-product.twig');
        return $response;
    }

    public function editProduct(Request $request, Response $response, $args) {
        $product = $this->homeService->fetchProduct($args['id']);
        $this->view->render($response, 'products/edit_product.twig', [
            'product' => $product
        ]);
        return $response;
    }

    public function saveProduct(Request $request, Response $response) {

        $name = $request->getParam('product_name');
        $desc = $request->getParam('product_description');
        $status='Active';

        $merchantID=$_SESSION['merchant_id'];

        $merchant=$this->homeService->fetchmerchants($merchantID);

        $product = new Product();
        $product->setMerchantID($merchant);
        $product->setProductName($name);
        $product->setProductDesc($desc);
        $product->setStatus($status);
        $product->setCreatedAt(new \DateTime());
        $product->setCreatedBy($_SESSION['user']);
        $product->setUpdatedBy($_SESSION['user']);
        $product->setUpdatedAt(new \DateTime());

        $products = $this->homeService->storeProduct($product);
        return $response;
    }

    public function updateProduct(Request $request, Response $response, $args) {

        $name = $request->getParam('product_name');
        $desc = $request->getParam('product_description');
        $status=$request->getParam('product_status');
        $id=$request->getParam('product_id');

        $product=$this->homeService->fetchProduct($id);

        $product->setProductName($name);
        $product->setProductDesc($desc);
        $product->setStatus($status);
        $product->setUpdatedBy($_SESSION['user']);
        $product->setUpdatedAt(new \DateTime());

        $products = $this->homeService->storeProduct($product);

        $this->container->flash->addMessage('info','Product has been added successfully');

        return $response->withRedirect('/merchant/manage-products');

    }

  /* END Products */



    /** MANAGE GROUPS **/

    public function fetchgroups(Request $request, Response $response) {

        $merchant = $_SESSION['merchant_id'];

        $groups = $this->homeService->fetchgroups($merchant);

        $this->view->render($response, 'workers/manage_worker_groups.twig', [
            'groups' => $groups
        ]);
        return $response;
    }

    public function newGroup(Request $request, Response $response) {

        $this->view->render($response, 'workers/add_worker_group.twig');
        return $response;
    }


    public function saveGroup(Request $request, Response $response) {
         $group_name = $request->getParam('group_name');
         $group_description = $request->getParam('group_description');
         $status=$request->getParam('status');
         $merchantID=$_SESSION['merchant_id'];

         $merchant=$this->homeService->fetchmerchants($merchantID);

         $group = new Group();
         $group->setMerchant($merchant);
         $group->setGroupName($group_name);
         $group->setDescription($group_description);
         $group->setStatus($status);
         $group->setCreatedAt(new \DateTime());
         $group->setCreatedBy($_SESSION['user']);
         $group->setUpdatedBy($_SESSION['user']);
         $group->setUpdatedAt(new \DateTime());

         $products = $this->homeService->storeGroup($group);

        $response = $response->withRedirect($this->container->router->pathFor('merchant.manage-groups'),303);
        return $response;
    }

    /* END GROUPS */




    /** MANAGE WORKERS **/

    public function fetchworkers(Request $request, Response $response) {

        $merchant = $_SESSION['merchant_id'];

        $workers = $this->homeService->fetchworkers($merchant);

        $this->view->render($response, 'workers/manage_workers.twig', [
            'workers' => $workers
        ]);
        return $response;
    }

    public function newWorker(Request $request, Response $response) {

        $groups = $this->homeService->fetchgroups();
        $this->view->render($response, 'workers/add_worker.twig',
        [
            'groups' => $groups
        ]);
        return $response;
    }


    public function saveWorker(Request $request, Response $response) {
         $worker_group = $request->getParam('worker_group');
         $first_name=$request->getParam('first_name');
         $middle_name=$request->getParam('middle_name');
         $last_name=$request->getParam('last_name');
         $phone_number=$request->getParam('phone_number');
         $id_number=$request->getParam('id_number');
         $staff_id=$request->getParam('staff_id');
         $status ='Active';

         $group=$this->homeService->fetchgroup($worker_group);
         $worker = new Worker();
         $worker->setGroup($group);
         $worker->setFirstName($first_name);
         $worker->setMiddleName( $middle_name);
         $worker->setLastName($last_name);
         $worker->setPhoneNumber($phone_number);
         $worker->setIdNumber($id_number);
         $worker->setStaffID($staff_id);
         $worker->setCreatedAt(new \DateTime());
         $worker->setCreatedBy($_SESSION['user_name']);
         $worker->setUpdatedBy($_SESSION['user_name']);
         $worker->setUpdatedAt(new \DateTime());
         $worker->setStatus($status);

         $products = $this->homeService->storeWorker($worker);

         return $response->withRedirect('/merchant/manage-workers');
    }


    public function worker_bulk_upload(Request $request, Response $response)
    {
        $uploadedFiles = $request->getUploadedFiles();

        $uploadedFile = $uploadedFiles['excel'];
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);

        $allowedExts = array("xls", "csv","xlsx");
        //$uploadedFile->file >>>>>>File Path

        if (($uploadedFile->getSize() < 20000000) && in_array($extension, $allowedExts)) {

            if ($uploadedFile->getError() > 0) {
                $msg = "Error: " .$uploadedFile->getError() . "";
            } else {
               // $file = $uploadedFile->getClientFilename();
                $file = $_FILES['excel']['tmp_name'];
                if ($uploadedFile->getSize() > 0) {

                    if ($extension == "xls") {

                       $excel = new Spreadsheet_Excel_Reader;

                        $excel->read($file);
                        $nr_sheets = count($excel->sheets);

                        // gets the number of worksheets
                        $excel_data = '';
                        // to store the the html tables with data of each sheet

                        $fileErr = 0;
                        $Total = 0;
                        $duplR = 0;
                        $inval = 0;
                        $failz = 0;
                        $errrors = 0;
                        for ($i = 0; $i < $nr_sheets; $i++) {
                            $sheet = $excel->sheets[$i];
                            if ($sheet['numRows'] > 0) {

                                $x = 1;
                                while ($x <= $sheet['numRows']) {

                                    $out = array();
                                    for ($y = 1; $y <= 7; $y++) {
                                        $cell = isset($sheet['cells'][$x][$y]) ? $sheet['cells'][$x][$y] : '';
                                        $out[] = $cell;
                                    }

                                    $worker_group = $request->getParam('worker_group');
                                    $status ='Active';
                                    $first_name = preg_replace('~\x{00a0}~', '', str_replace(' ', ' ', $out[0]));
                                    $middle_name = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[1]));
                                    $last_name = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[2]));
                                    $phone_number = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[3]));
                                    $id_number = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[4]));
                                    $staff_id = preg_replace('~\x{00a0}~', '', str_replace(' ', '', $out[5]));


                                    if (!empty($phone_number) || !empty($id_number)) {



                                        $checkdupz=$this->entityManager->getRepository('App\Entity\Worker')->findOneBy(
                                            [
                                                'idNumber' => $id_number,
                                                'phoneNumber'=>$phone_number,
                                                'group'=>$worker_group
                                            ]
                                        );
                                        if (!$checkdupz) {


                                            $group=$this->homeService->fetchgroup($worker_group);
                                            $worker = new Worker();
                                            $worker->setGroup($group);
                                            $worker->setFirstName($first_name);
                                            $worker->setMiddleName( $middle_name);
                                            $worker->setLastName($last_name);
                                            $worker->setPhoneNumber($phone_number);
                                            $worker->setIdNumber($id_number);
                                            $worker->setStaffID($staff_id);
                                            $worker->setCreatedAt(new \DateTime());
                                            $worker->setCreatedBy($_SESSION['user']);
                                            $worker->setUpdatedBy($_SESSION['user']);
                                            $worker->setUpdatedAt(new \DateTime());
                                            $worker->setStatus($status);

                                            $reslti = $this->homeService->storeWorker($worker);

                                            if ($reslti) {
                                                $Total = $Total + 1;
                                            } else {
                                                $failz = $failz + 1;
                                            }
                                        } else {
                                            $duplR = $duplR + 1;
                                        }
                                    } else {
                                        $inval = $inval + 1;
                                    }
                                    $x++;
                                }
                            }
                        }
                        //$msg = '<span style=\"color:blue;font-weight:bold\"><b>'. $Total . '</b> Numbers registered, <b>' . $failz . '</b> Failed, <b>'. $duplR . '</b> Duplicates & <b>' . $inval . '</b> Invalid numbers</span>';

                       // $this->container->flash->addMessage('error',$msg);

                        return $response->withRedirect('/merchant/manage-workers');
                    }
                } else {

                   //Empty File selected
                    //$this->container->flash->addMessage('error','Selected File Is Empty!!!');

                    return $response->withRedirect('/merchant/manage-workers');
                }
            }
        } else {


          //Oversize File
           // $this->container->flash->addMessage('error','Selected File Is Too Big');

            return $response->withRedirect('/merchant/manage-workers');
        }
    }


    /* END WORKERS */


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
