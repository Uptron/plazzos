<?php
/**
 * Created by PhpStorm.
 * User: nganga
 * Date: 11/21/19
 * Time: 9:26 AM
 */

namespace App\Middleware;


use Slim\Http\Request;
use Slim\Http\Response;

class AuthenticationMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next) {
        if (!$this->container->auth->check()) {
            $this->container->flash->addMessage('error', 'Please login to continue');
            return $response->withRedirect($this->container->router->pathFor('auth.login'));
        }
        $response = $next($request, $response);
        return $response;
    }
}