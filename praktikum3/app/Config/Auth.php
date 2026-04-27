<?php

namespace Config;

use Myth\Auth\Config\Auth as AuthConfig;

class Auth extends AuthConfig
{
    /**
     * ---------------------------------------------------------------
     * Require Confirmation Registration via Email
     * ---------------------------------------------------------------
     */
    public $requireActivation = null;
}
