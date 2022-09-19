<?php

namespace Epmnzava\Glueup;

use Epmnzava\Glueup\User;

class Glueup
{

    public  $API_tenant;
    public  $API_orgID;
    public  $API_account;
    public  $API_privatekey;
    public function __construct($API_tenant, $API_orgID, $API_account, $API_privatekey)
    {
        $this->API_tenant = $API_tenant;
        $this->API_orgID = $API_orgID;
        $this->API_account = $API_account;
        $this->API_privatekey = $API_privatekey;
    }

    public function createUser($firstName, $lastName, $email, $password, $language, $isOrgOptin = true)
    {

        $user = new User;
        return  $user->create($firstName, $lastName, $email, $password, $language, $isOrgOptin = true);
    }

    public function subscribeUser($firstName, $lastName, $email)
    {
        $user = new User;
        return $user->subscribe($firstName, $lastName, $email);
    }

    public function keepUserLogginedIn($token)
    {
        $user = new User;
        return $user->maintainUserLogginedIn($token);
    }


    public function loginUser($email, $password)
    {

        $user = new User;
        return $user->login($email, $password);
    }
}
