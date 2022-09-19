<?php

namespace Epmnzava\Glueup;

use Epmnzava\Glueup\User;

class Glueup
{



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
