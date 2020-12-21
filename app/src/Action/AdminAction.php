<?php

namespace App\Action;

use App\Entity\User;
use App\Entity\UsersGroup;
use App\Entity\Valuer;
use App\Entity\Staff;
use App\Service\AdminService;
use Respect\Validation\Validator as v;
use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Doctrine\ORM\EntityManager;

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
    /* VALUATIONS*/
    public function valuationrequests(Request $request, Response $response) {
        $valuations = $this->adminService->fetchvaluations();
        $this->view->render($response, 'valuations/manage-valuations-admin.twig', [
            'valuations' => $valuations
        ]);
    }

    /* START OF USERS*/
    public function newUser(Request $request, Response $response) {
        $groups = $this->adminService->fetchgroups();
        $this->view->render($response, 'users/add-user.twig',
            [
                'groups' => $groups
            ]);
        return $response;
    }

    public function saveuser(Request $request, Response $response) {


        $first_name=$request->getParam('first_name');
        $middle_name=$request->getParam('middle_name');
        $last_name=$request->getParam('last_name');
        $email=$request->getParam('email');
        $group=$request->getParam('group');
        $username=$request->getParam('username');
        $password=$request->getParam('password');
        $confirmation=$request->getParam('confirm_password');
        $status='Active';

        $user=new User();
        $user->setFirstName($first_name);
        $user->setMiddlename($middle_name);
        $user->setLastName($last_name);
        $user->setEmail($email);
        $user->setUserName($username);
        $user->setPassword(password_hash($password,PASSWORD_DEFAULT));
        $user->setAccountCreatedAt(new \DateTime());

        $save = $this->adminService->storeUser($user);
        return $response->withRedirect('/admin/manage-users');


    }

    public function fetchusers(Request $request, Response $response) {
        $users = $this->adminService->fetchusers();
        $this->view->render($response, 'users/manage-users.twig', [
            'users' => $users
        ]);
    }
    public function newgroup(Request $request, Response $response) {

        $this->view->render($response, 'users/add-group.twig');
        return $response;
    }

    public function savegroup(Request $request, Response $response) {


        $name=$request->getParam('group_name');
        $status='Active';

        $group=new UsersGroup();
        $group->setName($name);

        $save = $this->adminService->storeGroup($group);
        return $response->withRedirect('/admin/add-group');


    }
    /* START OF VALUERS*/

    public function fetchValuers(Request $request, Response $response) {
        $valuers = $this->adminService->fetchvaluers();
        $this->view->render($response, 'valuers/manage_valuers.twig', [
            'valuers' => $valuers
        ]);
    }

    public function newValuer(Request $request, Response $response) {
        $this->view->render($response, 'valuers/create_valuer.twig');
        return $response;
    }

    public function saveValuer(Request $request, Response $response) {
        $valuer_name = $request->getParam('valuer_name');
        $valuer_email = $request->getParam('valuer_email');
        $valuer_address = $request->getParam('valuer_address');
        $valuer_phone = $request->getParam('valuer_phone');
        $valuer_username = $request->getParam('valuer_username');
        $password = $request->getParam('password');
        $confirm_password = $request->getParam('confirm_password');
        $status='Active';
        $group=$this->adminService->fetchgroup('Valuer');

        $user=new User();
        $user->setFirstName($valuer_name);
        $user->setEmail($valuer_email);
        $user->setUserName($valuer_username);
        $user->setPassword(password_hash($password,PASSWORD_DEFAULT));
        $user->setAccountCreatedAt(new \DateTime());
        $user->setGroup($group);


        $valuer = new Valuer();
        $valuer->setValuerName($valuer_name);
        $valuer->setPhoneNumber($valuer_phone);
        $valuer->setEmail($valuer_email);
        $valuer->setAddress($valuer_address);
        $valuer->setDateCreated(new \DateTime());
        $valuer->setAccountStatus($status);
        $valuer->setUser($user);


        $users = $this->adminService->storeUser($user);
        $valuers = $this->adminService->storeValuer($valuer);



        return $response->withRedirect('/admin/manage-valuers');
    }

    public function editValuer(Request $request, Response $response, $args) {
        $valuer_details = $this->adminService->fetchOneTaskType($args['id']);
        $this->view->render($response, 'tasktype/edit_valuer.twig', [
            'valuerdetails' => $valuer_details
        ]);
        return $response;
    }



    /* START OF staff*/

    public function fetchstaff(Request $request, Response $response) {
        $staffs = $this->adminService->fetchstaff();
        $this->view->render($response, 'staff/manage_staff.twig', [
            'staffs' => $staffs
        ]);
    }

    public function newstaff(Request $request, Response $response) {

        $groups = $this->adminService->fetchgroups();
        $this->view->render($response, 'staff/create_staff.twig',
            [
                'groups' => $groups
            ]);
        return $response;

    }

    public function savestaff(Request $request, Response $response) {
        $first_name=$request->getParam('first_name');
        $middle_name=$request->getParam('middle_name');
        $last_name=$request->getParam('last_name');
        $email=$request->getParam('email');
        $group=$request->getParam('group');
        $department=$request->getParam('department');
        $username=$request->getParam('username');
        $password=$request->getParam('password');
        $confirmation=$request->getParam('confirm_password');
        $status='Active';
        $groupie = $this->adminService->fetchgroups($group);



        $user=new User();
        $user->setFirstName($first_name);
        $user->setMiddlename($middle_name);
        $user->setLastName($last_name);
        $user->setEmail($email);
        $user->setUserName($username);
        $user->setGroup($groupie);
        $user->setPassword(password_hash($password,PASSWORD_DEFAULT));
        $user->setAccountCreatedAt(new \DateTime());


        $staff=new Staff();
        $staff->setFirstName($first_name);
        $staff->setMiddlename($middle_name);
        $staff->setLastName($last_name);
        $staff->setEmail($email);
        $staff->setDepartment($department);
        $staff->setUser($user);
        $staff->setDateAdded(new \DateTime());
        $staff->setLastUpdated(new \DateTime());
        $staff->setStatus($status);



        $users = $this->adminService->storeUser($user);
        $valuers = $this->adminService->storeStaff($staff);



        return $response->withRedirect('/admin/manage-staff');
    }

    public function editStaff(Request $request, Response $response, $args) {
        $staff_details = $this->adminService->fetchOneTaskType($args['id']);
        $this->view->render($response, 'staff/edit_staff.twig', [
            'staffdetails' => $staff_details
        ]);
        return $response;
    }

}
