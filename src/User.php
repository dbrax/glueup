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

        return $result;
    }


    public function loginUser($email, $password)
    {
        $params = array(
            'email'      => array('value' => $email),
            'passphrase' => array('value' => md5($password))
        );

        $result = GlueUp::post('user/session', $params);

        return $result;
    }
    public function keepUserLogginedIn($token,)
    {
        $redirect_url = '/my/profile/';
        $timestamp    = time();
        $result = Glueup::get('user/redirect/token?new_broker=php_' . Glueup::$API_account . '&timestamp=' . $timestamp . '&redirect_url=' . $redirect_url, $token);

        return $result;
    }
}
