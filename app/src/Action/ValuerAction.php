<?php


namespace App\Action;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use App\Service\ValuerService;
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;
use Slim\Http\UploadedFile;
use SpreadsheetReader;
use Spreadsheet_Excel_Reader;
use Slim\Flash\Messages as FlashMessages;

class ValuerAction extends BaseAction
{
    public function __construct(Twig $view, LoggerInterface $logger, ValuerService  $valuerService,EntityManager $entityManager, FlashMessages $flash) {
        $this->view = $view;
        $this->logger = $logger;
        $this->valuerService = $valuerService;
        $this->entityManager = $entityManager;
        $this->flash = $flash;
    }
    public function __invoke(Request $request, Response $response, $args) {

        $this->view->render($response, 'dashboard.twig');
        return $response;
    }

    /* START OF VATIONS*/
    public function fetchvaluationrequests(Request $request, Response $response) {

        $valuer = $_SESSION['valuer_id'];

        $valuations = $this->valuerService->fetchvaluations($valuer);

        $this->view->render($response, 'valuations/valuer_requests.twig', [
            'valuations' => $valuations
        ]);
        return $response;
    }



}