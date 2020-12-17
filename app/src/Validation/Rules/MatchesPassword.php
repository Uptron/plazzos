<?php


namespace App\Validation\Rules;
use Respect\Validation\Rules\AbstractRule;
use App\Entity\User;

class MatchesPassword
{
    protected $password;

    public function __construct($password)
    {
        $this->password=$password;
    }

    public function validate($input)
    {
  return password_verify($input,$this->password);
    }
}