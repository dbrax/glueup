<?php

namespace Epmnzava\Glueup;

class Glueup
{
    public static $API_version    = '1.0';
    public static $API_endpoint   = 'https://api.glueup.com/v2/';
    public  $API_tenant;
    public  $API_orgID;
    public  $API_account;
    public  $API_privatekey;

    private static $DEBUG_MODE    = false;

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

    public static function get($operation, $token = '')
    {
        return self::doCall('get', $operation, '', $token);
    }

    public static function post($operation, $params = '', $token = '')
    {
        return self::doCall('post', $operation, $params, $token);
    }

    public static function put($operation, $params = '', $token = '')
    {
        return self::doCall('put', $operation, $params, $token);
    }

    public static function delete($operation, $params = '', $token = '')
    {
        return self::doCall('delete', $operation, $params, $token);
    }

    private static function doCall($method, $operation, $params = '', $token = '')
    {
        $timer = self::$DEBUG_MODE ? microtime(true) : 0;
        $curl  = curl_init();

        curl_setopt($curl, CURLOPT_URL, self::$API_endpoint . $operation);

        switch (strtolower($method)) {
            case 'post':
                curl_setopt($curl, CURLOPT_POST, 1);
                break;
            case 'put':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'PUT');
                break;
            case 'delete':
                curl_setopt($curl, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        $ts   = time() * 1000;
        $hash = strtoupper($method) . self::$API_account . self::$API_version . $ts;
        $d    = hash_hmac('sha256', $hash, self::$API_privatekey);
        $a    = 'a:d=' . $d . ';v=' . self::$API_version . ';k=' . self::$API_account . ';ts=' . $ts;

        $arrHeader = array('Accept:application/json', 'Cache-Control:no-cache', 'tenantId:' . self::$API_tenant, $a);

        if ($params != '') {
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($params));
            $arrHeader[] = 'Content-type:application/json;charset=UTF-8';
        }

        if ($token != '') {
            $arrHeader[] = 'token:' . $token;
        }

        curl_setopt($curl, CURLOPT_HTTPHEADER, $arrHeader);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

        $execResult = curl_exec($curl);
        $info       = curl_getinfo($curl);

        $return = array('code' => $info['http_code'], 'data' => json_decode($execResult, true));

        curl_close($curl);

        if (self::$DEBUG_MODE) {
            error_log('-------------------- ' . strtoupper($method) . ': ' . $operation . ' in ' . ((microtime(true) - $timer) * 1000) . 'ms --------------------');
            error_log('RESULT: ' . json_encode($return));
            if ($params != '') {
                error_log('PARAMS: ' . json_encode($params));
            }
        }

        return $return;
    }
}
