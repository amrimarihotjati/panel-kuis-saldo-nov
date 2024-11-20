<?php

namespace App\Helper;

class ApiFormatter {

    protected static $response = [
        'meta' => [
            'status' => null,
            'message' => null,
        ],
        'data' => null,
    ];

    public static $SUCCESS_MESSAGE = "SUCCESS";
    public static $FAILED_MESSAGE = "FAILED";

    public static $SUCCESS_CODE = 2004;
    public static $FAILED_CODE = 5004;

    public static $DENIED_CODE = 4000;
    public static $DATA_REQUIRED_CODE = 4004;

    public static $STATUS_REDIRECT = 2001;
    public static $STATUS_MAINTANANCE = 2002;
    public static $STATUS_UPDATE = 2003;
    public static $STATUS_NORMAL= 2004;

    public static $STATUS_LOGIN_RETRY = 2005;

    public static $MESSAGE_REDIRECT= "APPLICATION REDIRECTED";
    public static $MESSAGE_MAINTANANCE= "APPLICATION IS MAINTANANCE";
    public static $MESSAGE_APP_UPDATE= "APPLICATION NEW VERSION DETECTED";
    public static $MESSAGE_NORMAL= "APPLICATION DATA FETCHED";
    public static $MESSAGE_RETRY = "Harap login ulang";

    public static function createApiSuccess($message = null, $data = null)
    {
        self::$response['meta']['status'] = self::$SUCCESS_CODE;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;
        return response()->json(self::$response);
    }

    public static function createApiFailed($message = null, $data = null)
    {
        self::$response['meta']['status'] = self::$FAILED_CODE;
        self::$response['meta']['message'] = $message;
        self::$response['data'] = $data;
        return response()->json(self::$response);
    }

    public static function createApiLoginRetry()
    {
        self::$response['meta']['status'] = self::$STATUS_LOGIN_RETRY;
        self::$response['meta']['message'] = self::$MESSAGE_RETRY;
        self::$response['data'] = null;
        return response()->json(self::$response);
    }

    public static function createApiRedirectApp($redirectUrl = null)
    {
        self::$response['meta']['status'] = self::$STATUS_REDIRECT;
        self::$response['meta']['message'] = self::$MESSAGE_REDIRECT;
        self::$response['meta']['redirectUrl'] = $redirectUrl;
        self::$response['data'] = null;
        return response()->json(self::$response);
    }

    public static function createApiMaintanance($maintananceMessage = null)
    {
        self::$response['meta']['status'] = self::$STATUS_MAINTANANCE;
        self::$response['meta']['message'] = self::$MESSAGE_MAINTANANCE;
        self::$response['meta']['maintananceMessage'] = $maintananceMessage;
        self::$response['data'] = null;
        return response()->json(self::$response);
    }

    public static function createApiUpdateApp()
    {
        self::$response['meta']['status'] = self::$STATUS_UPDATE;
        self::$response['meta']['message'] = self::$MESSAGE_APP_UPDATE;
        self::$response['data'] = null;
        return response()->json(self::$response);
    }

    public static function createApiNormal()
    {
        self::$response['meta']['status'] = self::$STATUS_NORMAL;
        self::$response['meta']['message'] = self::$MESSAGE_NORMAL;
        self::$response['data'] = null;
        return response()->json(self::$response);
    }

}
