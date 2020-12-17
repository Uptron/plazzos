<?php
/**
 * Created by PhpStorm.
 * User: nganga
 * Date: 11/21/19
 * Time: 10:02 AM
 */

namespace App\Middleware;


class Middleware
{
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }
}