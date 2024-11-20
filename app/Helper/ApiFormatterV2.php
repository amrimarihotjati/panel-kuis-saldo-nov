<?php

namespace App\Helper;

class ApiFormatterV2 {

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

    public static $STATUS_EXT_REINPUT_EMAIL = 2020;
    public static $STATUS_EXT_WAIT_CLAIM = 2021;

    public static $STATUS_CLAIM_POINT_KAGET_NEXT_TASK = 2030;
    public static $STATUS_CLAIM_POINT_KAGET_CONTINUE_TASK = 2031;
    public static $STATUS_CLAIM_POINT_KAGET_FINISHED_TASK = 2032;


    public static $MESSAGE_REDIRECT= "APPLICATION REDIRECTED";
    public static $MESSAGE_MAINTANANCE= "APPLICATION IS MAINTANANCE";
    public static $MESSAGE_APP_UPDATE= "APPLICATION NEW VERSION DETECTED";
    public static $MESSAGE_NORMAL= "APPLICATION DATA FETCHED";
    public static $MESSAGE_RETRY = "Harap login ulang";

    public static $MESSAGE_EXT_REINPUT_EMAIL = "Harap masukan alamat email yang terdaftar!";
    public static $MESSAGE_EXT_WAIT_CLAIM = "Harap tunggu waktu claim selanjutnya!";

    public static $MESSAGE_CLAIM_POINT_KAGET_NEXT_TASK = "Tugas telah berhasil silahkan lanjutkan tugas berikutnya!";
    public static $MESSAGE_CLAIM_POINT_KAGET_FINISHED_TASK = "Selamat tugas kamu telah selesai!";
    public static $MESSAGE_CLAIM_POINT_KAGET_CONTINUE_TASK = "Selamat tugas kamu telah selesai silahkan lanjutkan tugas berikutnya!";

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

    public static function createApiExtReinputEmail($message = null, $data = null)
    {
        self::$response['meta']['status'] = self::$STATUS_EXT_REINPUT_EMAIL;
        self::$response['meta']['message'] = self::$MESSAGE_EXT_REINPUT_EMAIL;
        self::$response['data'] = $data;
        return response()->json(self::$response);
    }

    public static function createApiExtWaitingClaim($message = null, $data = null)
    {
        self::$response['meta']['status'] = self::$STATUS_EXT_WAIT_CLAIM;
        self::$response['meta']['message'] = self::$MESSAGE_EXT_WAIT_CLAIM;
        self::$response['data'] = $data;
        return response()->json(self::$response);
    }

    public static function createApiPointKagetTaskNext($message = null, $data = null)
    {
        self::$response['meta']['status'] = self::$STATUS_CLAIM_POINT_KAGET_NEXT_TASK;
        self::$response['meta']['message'] = self::$MESSAGE_CLAIM_POINT_KAGET_NEXT_TASK;
        self::$response['data'] = $data;
        return response()->json(self::$response);
    }

    public static function createApiPointKagetTaskContinue($message = null, $data = null)
    {
        self::$response['meta']['status'] = self::$STATUS_CLAIM_POINT_KAGET_CONTINUE_TASK;
        self::$response['meta']['message'] = self::$MESSAGE_CLAIM_POINT_KAGET_CONTINUE_TASK;
        self::$response['data'] = $data;
        return response()->json(self::$response);
    }

    public static function createApiPointKagetTaskFinish($message = null, $data = null)
    {
        self::$response['meta']['status'] = self::$STATUS_CLAIM_POINT_KAGET_FINISHED_TASK;
        self::$response['meta']['message'] = self::$MESSAGE_CLAIM_POINT_KAGET_FINISHED_TASK;
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
