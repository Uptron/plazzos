<?php


namespace App\Action;
use App\Entity\ValuationReport;
use App\Entity\ValuationRequest;
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
        $chasis_file = $request->getParam('chasis_file');
        $scanned_report = $request->getParam('scanned_report');
        $log_book = $request->getParam('log_book');
        $status='Completed';
        $valuation_id=$request->getParam('valuation');

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
        $valuationreport->setDateDone(new \DateTime());
        $valuationreport->setStatus($status);


       $this->valuerService->storevaluationreport($valuationreport);
       $this->valuerService->updateValuationrequest($valuation);

       return $response->withRedirect('/valuer/');
    }


}