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

class ApiAuthenticationMiddleware extends Middleware
{
    public function __invoke(Request $request, Response $response, $next) {
        $apiKey = $request->getHeader('Authorization');

        if (!$this->container->auth->authenticateApiKey($apiKey)) {
            return $response->withStatus(401,'You are not allowed to do that');
        }
        $response = $next($request, $response);
        return $response;
    }
}