<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class SessionService
{
    private $session;


    public function __construct()
    {
        $this->session = new Session();
        $this->session->getFlashBag()->add('notice', 'Profile updated');
    }

}