<?php
/**
 * Created by PhpStorm.
 * User: nganga
 * Date: 11/22/19
 * Time: 12:31 PM
 */

namespace App\Action;

use App\Entity\Valuer;
use Slim\Http\Request;
use Slim\Http\Response;
use App\Entity\User;
use App\Entity\Merchant;
use Respect\Validation\Validator as v;

use Doctrine\ORM\EntityManager;

class AuthenticationAction extends BaseAction
{

    public function __invoke(Request $request, Response $response, $args)
    {

        $this->container->view->render($response, 'auth/login.twig');

        return $response;
    }
  public function getSignIn(Request $request,Response $response)
  {
    $this->container->view->render($response,'auth/login.twig');
    return $response;
  }
    public function postSignIn(Request $request,Response $response)
    {
       $auth=$this->container->auth->attempt(
           $request->getParam('email'),
           $request->getParam('password')
       );

      if(!$auth)
      {
          $this->container->flash->addMessage('error','Wrong credentials.Could not login');

          return $response->withRedirect('/auth/login');
      }
      //Admin
        if($_SESSION['usergroup']=='Admin')
        {
            return $response->withRedirect('/admin/');
        }
    //staff
        else if($_SESSION['usergroup']=='Staff')
        {
            return $response->withRedirect('/staff/');
        }
    //Valuer
        else if($_SESSION['usergroup']=='Valuer')
        {
            return $response->withRedirect('/valuer/');
        }

    }
    public function getSignup(Request $request,Response $response){

        $this->container->view->render($response, 'auth/signup.twig');

        return $response;

    }

    public function postSignup(Request $request,Response $response){

        $validation = $this->container->validator->validate($request,[
            'merchant_name'=>v::notEmpty(),
            'phone_number'=>v::noWhitespace()->notEmpty(),
            'physical_address'=>v::notEmpty(),
            'email'=>v::noWhitespace()->notEmpty()->Email(),
            'username'=>v::noWhitespace()->notEmpty(),
            'password'=>v::noWhitespace()->notEmpty(),
            'confirm_password'=>v::noWhitespace()->notEmpty(),
        ]);

        if($validation->failed())
        {
            $this->container->flash->addMessage('error','Validation Errors Found');

            return $response->withRedirect('/auth/signup');
        }

        $merchant_name=$request->getParam('merchant_name');
        $phone_number=$request->getParam('phone_number');
        $address=$request->getParam('physical_address');
        $email=$request->getParam('email');
        $username=$request->getParam('username');
        $password=$request->getParam('password');
        $confirmation=$request->getParam('confirm_password');
        $status='Active';

        $user=new User();
        $user->setEmail($email);
        $user->setUserName($username);
        $user->setPassword(password_hash($password,PASSWORD_DEFAULT));
        $user->setAccountCreatedAt(new \DateTime());

        $merchant = new Merchant();
        $merchant->setMerchantName($merchant_name);
        $merchant->setUser($user);
        $merchant->setPhoneNumber($phone_number);
        $merchant->setEmail($email);
        $merchant->setAddress($address);
        $merchant->setDateCreated(new \DateTime());
        $merchant->setAccountStatus($status);

        $this->container->em->persist($user);
        $this->container->em->persist($merchant);
        $this->container->em->flush();

        $this->container->flash->addMessage('info','Your Jilipe account has been created successfully. Log In to continue');
        return $response->withRedirect('/auth/login');
    }


    public function logout(Request $request,Response $response){

        $this->container->auth->logout();

        return $response->withRedirect('/auth/login');

    }
}