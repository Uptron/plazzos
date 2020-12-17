<?php
/**
 * Created by PhpStorm.
 * User: nganga
 * Date: 11/22/19
 * Time: 12:31 PM
 */

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\User;
use App\Service\PasswordService;
use Respect\Validation\Validator as v;

use Doctrine\ORM\EntityManager;

class PasswordAction extends BaseAction
{
    private $view;
    private $logger;
    private $passwordService;
    private $apis;

    public function __construct(Twig $view, LoggerInterface $logger, PasswordService $passwordService, $apis) {
        $this->view = $view;
        $this->logger = $logger;
        $this->passwordService = $passwordService;
        $this->apis = $apis;
    }

    public function getChangePassword(Request $request,Response $response)
    {
        $this->container->view->render($response,'auth/password/change.twig');
        return $response;
    }
    public function postChangePassword(Request $request,Response $response)
    {
        $validation = $this->container->validator->validate($request,[
            'old_password'=>v::noWhitespace()->notEmpty()->matchesPassword($this->container->auth->user()->password),
            'password'=>v::noWhitespace()->notEmpty(),

        ]);

        if($validation->failed())
        {
            return $response->withRedirect('/auth/password/change');
        }

        $user= $this->container->entityManager->getRepository('App\Entity\User')->findOneBy(
            [
                'id' => $_SESSION['user']
            ]
        );

        $user->setPassword(password_hash($request->getParam('password'),PASSWORD_DEFAULT));
        $this->container->em->persist($user);

        $this->container->flash->addMessage('info','Your Password has been updated. Log In to continue');
        return $response->withRedirect('/logout');
    }

}