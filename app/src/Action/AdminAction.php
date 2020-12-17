<?php

namespace App\Action;

use App\Entity\Merchant;
use App\Service\AdminService;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class AdminAction
{
    private $view;
    private $logger;
    private $adminService;
    private $apis;

    public function __construct(Twig $view, LoggerInterface $logger, AdminService $adminService, $apis) {
        $this->view = $view;
        $this->logger = $logger;
        $this->adminService = $adminService;
        $this->apis = $apis;
    }

    public function __invoke(Request $request, Response $response, $args) {

        $this->view->render($response, 'dashboard.twig');
        return $response;
    }


    /* START OF MERCHANTS*/

    public function fetchMerchants(Request $request, Response $response) {
        $merchants = $this->adminService->fetchmerchants();
        $this->view->render($response, 'merchants/manage_merchants.twig', [
            'merchants' => $merchants
        ]);
    }

    public function newMerchant(Request $request, Response $response) {
        $this->view->render($response, 'merchants/create_merchant.twig');
        return $response;
    }

    public function saveMerchant(Request $request, Response $response) {
        $merchant_name = $request->getParam('merchant_name');
        $merchant_email = $request->getParam('merchant_email');
        $merchant_address = $request->getParam('merchant_address');
        $merchant_phone = $request->getParam('merchant_phone');
        $merchant_username = $request->getParam('merchant_username');
        $password = $request->getParam('password');
        $confirm_password = $request->getParam('confirm_password');
        $status='Active';

        $merchant = new Merchant();
        $merchant->setMerchantName($merchant_name);
        $merchant->setPhoneNumber($merchant_phone);
        $merchant->setEmail($merchant_email);
        $merchant->setAddress($merchant_address);
        $merchant->setDateCreated(new \DateTime());
        $merchant->setAccountStatus($status);

        $merchants = $this->adminService->storeMerchant($merchant);
        return $response->withRedirect('/admin/manage-merchants');
    }

    public function editMerchant(Request $request, Response $response, $args) {
        $task_details = $this->adminService->fetchOneTaskType($args['id']);
        $this->view->render($response, 'tasktype/edit_tasktype.twig', [
            'taskdetails' => $task_details
        ]);
        return $response;
    }

    public function updateTaskType(Request $request, Response $response, $args) {
        $name = $request->getParam('name');
        $duration = $request->getParam('duration');

        $task_type = $this->adminService->fetchOneTaskType($args['id']);

        $task_type->setTaskName($name);
        $task_type->setDuration($duration);
        $this->adminService->storeTaskType($task_type);

        return $response->withRedirect('/admin/task-types');
    }
}
