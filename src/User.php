<?php

namespace Epmnzava\Glueup;

class User extends Glueup
{







    public function create($firstName, $lastName, $email, $password, $language, $isOrgOptin = true)
    {
        $params = array(
            'givenName'  => $firstName,
            'familyName' => $lastName,
            'email'      => array('value' => $email),
            'passphrase' => array('value' => md5($password)),
            'language'   => array('code' => $language),
            'isOrgOptin' => true,
        );



        $result = $this->post('user', $params);

        return $result;
    }


    public function subscribe($firstName, $lastName, $email)
    {
        $params = array(
            'organizationId' => $this->API_orgID,
            'givenName'      => $firstName,
            'familyName'     => $lastName,
            'emailAddress'   => array('value' => $email),
        );

        $result = $this->put('subscription/subscribeList', $params);

        return $result;
    }


    public function login($email, $password)
    {
        $params = array(
            'email'      => array('value' => $email),
            'passphrase' => array('value' => md5($password))
        );

        $result = $this->post('user/session', $params);

        return $result;
    }
    public function maintainUserLogginedIn($token)
    {
        $redirect_url = '/my/profile/';
        $timestamp    = time();
        $result = $this->get('user/redirect/token?new_broker=php_' . $this->API_account . '&timestamp=' . $timestamp . '&redirect_url=' . $redirect_url, $token);

        return $result;
    }
}
