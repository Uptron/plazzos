<?php
/**
 * Created by PhpStorm.
 * User: nganga
 * Date: 11/21/19
 * Time: 10:02 AM
 */

namespace App\Action;


class BaseAction
{
    protected $container;

    public function __construct($container) {
        $this->container = $container;
    }
}