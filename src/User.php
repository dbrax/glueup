<?php

namespace Epmnzava\Glueup;

class User
{

    public function __construct()
    {
    }

    public function createUser($firstName, $lastName, $email, $password, $language, $isOrgOptin = true)
    {
        $params = array(
            'givenName'  => $firstName,
            'familyName' => $lastName,
            'email'      => array('value' => $email),
            'passphrase' => array('value' => md5($password)),
            'language'   => array('code' => $language),
            'isOrgOptin' => true,
        );



        $result = Glueup::post('user', $params);

        return $result;
    }


    public function subscribeUser($firstName, $lastName, $email)
    {
        $params = array(
            'organizationId' => Glueup::$API_orgID,
            'givenName'      => $firstName,
            'familyName'     => $lastName,
            'emailAddress'   => array('value' => $email),
        );

        $result = Glueup::put('subscription/subscribeList', $params);
    }
}
