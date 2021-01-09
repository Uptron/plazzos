<?php


namespace App\Action;
use App\Entity\ValuationReport;
use App\Entity\ValuationRequest;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use App\Service\valuerService;
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;
use Slim\Http\UploadedFile;
use Slim\Flash\Messages as FlashMessages;



class ValuerAction extends BaseAction
{
    private $view;
    private $logger;
    private $valuerService;
    private $entityManager;
    private $flash;


    public function __construct(Twig $view, LoggerInterface $logger, valuerService  $valuerService,EntityManager $entityManager, FlashMessages $flash) {
        $this->view = $view;
        $this->logger = $logger;
        $this->valuerService = $valuerService;
        $this->entityManager = $entityManager;
        $this->flash = $flash;
    }
    public function __invoke(Request $request, Response $response, $args) {

        $this->view->render($response, 'valuer-dashboard.twig');
        return $response;
    }

    /* START OF VALUATIONS*/
    public function fetchvaluationrequests(Request $request, Response $response) {

        $valuer = $this->valuerService->fetchValuer($_SESSION['user']);
        $valuations = $this->valuerService->fetchvaluations($valuer);

        $this->view->render($response, 'valuers/valuer-requests.twig', [
            'valuations' => $valuations
        ]);
        return $response;
    }
    public function fetchcompletedrequests(Request $request, Response $response) {

        $valuer = $this->valuerService->fetchValuer($_SESSION['user']);
        $valuations = $this->valuerService->fetchclosedvaluations($valuer);

        $this->view->render($response, 'valuers/completed-requests.twig', [
            'valuations' => $valuations
        ]);
        return $response;
    }

    public function submitvaluation(Request $request, Response $response)
    {
        $insurance_company = $request->getParam('insurance_company');
        $policy_number = $request->getParam('policy_number');
        $expiry_date = $request->getParam('expiry_date');
        $color = $request->getParam('color');
        $yom = $request->getParam('yom');
        $reg_date = $request->getParam('reg_date');
        $engine_no = $request->getParam('engine_no');
        $chasis_no = $request->getParam('chasis_no');
        $engine_rating = $request->getParam('engine_rating');
        $odometer_reading = $request->getParam('odometer_reading');
        $serial_no = $request->getParam('serial_no');
        $anti_theft = $request->getParam('anti_theft');
        $windscreen = $request->getParam('windscreen');
        $audio = $request->getParam('audio');
        $alarm = $request->getParam('alarm');
        $examiner_opinion = $request->getParam('examiner_opinion');
        $forced_sale_value = $request->getParam('forced_sale_value');
        $bodywork = $request->getParam('bodywork');
        $mechanical = $request->getParam('mechanical');
        $steering_and_suspension = $request->getParam('steering_and_suspension');
        $braking_system = $request->getParam('braking_system');
        $electrical_system = $request->getParam('electrical_system');
        $wheels = $request->getParam('wheels');
        $added_equipment = $request->getParam('added_equipment');
        $remarks = $request->getParam('remarks');
        $special_remarks = $request->getParam('special_remarks');
        $modifications_noted = $request->getParam('modifications_noted');
        $general_condition = $request->getParam('general_condition');
        $status='Completed';
        $valuation_id=$request->getParam('valuation');
/*
        $uploadedFiles = $request->getUploadedFiles();

        // Chasis
        $chasis_file = $uploadedFiles['chasis_file'];

        if (empty($chasis_file)) {
            throw new Exception('No file has been send');
        }
        if ($chasis_file->getError() === UPLOAD_ERR_OK) {

            $chasis_upload =$this->moveUploadedFile('../uploads/', $chasis_file);
            $response->write('uploaded ' . $chasis_upload . '<br/>');

        }
        //Log Book
        $log_book = $uploadedFiles['log_book'];

        if (empty($log_book)) {
            throw new Exception('No file has been send');
        }
        if ($log_book->getError() === UPLOAD_ERR_OK) {

            $logbook =$this->moveUploadedFile('../uploads/', $log_book);
            $response->write('uploaded ' . $logbook . '<br/>');

        }
        //Scanned Report
        $scanned_report = $uploadedFiles['scanned_report'];

        if (empty($chasis_file)) {
            throw new Exception('No file has been send');
        }
        if ($scanned_report->getError() === UPLOAD_ERR_OK) {

            $scannedreport =$this->moveUploadedFile('../uploads/', $scanned_report);
            $response->write('uploaded ' . $scannedreport . '<br/>');

        }
*/
        $valuer = $this->valuerService->fetchValuer($_SESSION['user']);
        $valuation = $this->valuerService->fetchvaluation($valuation_id);

        $valuation->setvaluationStatus($status);
        $valuation->setdateUpdated(new \DateTime());

        $valuationreport=new ValuationReport();
        $valuationreport->setValuer($valuer);
        $valuationreport->setValuation($valuation);
        $valuationreport->setInsuranceCo($insurance_company);
        $valuationreport->setPolicyNo($policy_number);
        $valuationreport->setExpiryDate($expiry_date);
        $valuationreport->setColor($color);
        $valuationreport->setYom($yom);
        $valuationreport->setRegDate($reg_date);
        $valuationreport->setEngineNo($engine_no);
        $valuationreport->setChassisNo($chasis_no);
        $valuationreport->setEngineRating($engine_rating);
        $valuationreport->setOdometerReading($odometer_reading);
        $valuationreport->setSerialNo($serial_no);
        $valuationreport->setAntiTheft($anti_theft);
        $valuationreport->setWindscreenValue($windscreen);
        $valuationreport->setAudiosystemValue($audio);
        $valuationreport->setAudiosystemValue($alarm);
        $valuationreport->setExaminersOpinion($examiner_opinion);
        $valuationreport->setForcedsaleValue($forced_sale_value);
        $valuationreport->setBodywork($bodywork);
        $valuationreport->setMechanical($mechanical);
        $valuationreport->setSteeringandsuspension($steering_and_suspension);
        $valuationreport->setBrakingsystem($braking_system);
        $valuationreport->setElectricalsystem($electrical_system);
        $valuationreport->setWheels($wheels);
        $valuationreport->setAddedequipment($added_equipment);
        $valuationreport->setRemarks($remarks);
        $valuationreport->setSpecialremarks($special_remarks);
        $valuationreport->setModificationsnoted($modifications_noted);
        $valuationreport->setGeneralcondition($general_condition);
        /*$valuationreport->setEngineattachment($chasis_upload);
        $valuationreport->setLogbookattachment($logbook);
        $valuationreport->setReportattachment($scannedreport);*/
        $valuationreport->setDateDone(new \DateTime());
        $valuationreport->setStatus($status);

        $update=$this->valuerService->updateValuationrequest($valuation);
        $save=$this->valuerService->storevaluationreport($valuationreport);



       //Send Email Alert
        if($save)
        {
            $body='Greetings<br> Vehicle valuation has been completed successfully.';
            //Send email to Valuer
            $mail = new PHPMailer(true);

            try {
                //Server settings
                $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                $mail->isSMTP();                                            // Send using SMTP

                $mail->Host="smtp.gmail.com";
                $mail->Port=587;
                $mail->SMTPSecure="tls";
                $mail->SMTPAuth=true;
                $mail->Username="valuations@mwananchicredit.com";
                $mail->Password="Mwana@2021credit";

                //Recipients
                $mail->setFrom('valuations@mwananchicredit.com', 'Mwananchi Credit');
                $mail->addAddress($valuer->getEmail(),$valuer->getValuerName());     // Add a recipient
                $mail->addCC('uptronafrica@gmail.com');

                // Content
                $mail->isHTML(true);                                  // Set email format to HTML
                $mail->Subject = 'Vehicle Valuation Request';
                $mail->Body    = $body;
                $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                $mail->send();

            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }

       return $response->withRedirect('/valuer/');
    }

    public function moveUploadedFile($directory, UploadedFile $uploadedFile)
    {
        $extension = pathinfo($uploadedFile->getClientFilename(), PATHINFO_EXTENSION);
        $basename = bin2hex(random_bytes(8)); // see http://php.net/manual/en/function.random-bytes.php
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}