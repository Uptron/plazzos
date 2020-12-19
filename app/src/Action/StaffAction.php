<?php


namespace App\Action;


use App\Service\ValuerService;
use Doctrine\ORM\EntityManager;
use Psr\Log\LoggerInterface;
use Slim\Flash\Messages as FlashMessages;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Views\Twig;

class staffAction extends BaseAction
{
    public function __construct(Twig $view, LoggerInterface $logger, staffService  $staffService,EntityManager $entityManager, FlashMessages $flash) {
        $this->view = $view;
        $this->logger = $logger;
        $this->staffService = $staffService;
        $this->entityManager = $entityManager;
        $this->flash = $flash;
    }
    public function __invoke(Request $request, Response $response, $args) {

        $this->view->render($response, 'dashboard.twig');
        return $response;
    }
}