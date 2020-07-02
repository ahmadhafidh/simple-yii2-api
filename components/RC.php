<?php

namespace app\components;

use Yii;
use yii\base\Component;
use app\models\RefErrorCodes;

class RC extends Component
{
    const SUCCESS = '000';
    const LOGIN_FAILED = '111';
    const INVALID_API_KEY = '112';
    const DATA_NOT_FOUND = '404';
    const INTERNAL_ERROR  = '500';
    const REQUEST_FAILED = '600';
    // internal use to maintenance system / shutdown all API
    const INVALID_PARAM = '901';
    const TEST = '999';

    public static function base($code, $data = null)
    {
        $message = self::getMessage($code);
        if ($data) {
            return array(
                'status' => $code,
                'message' => $message,
                'data' => $data
            );
        }

        return array(
            'status' => $code,
            'message' => $message,
            'data' => ''
        );
    }

    private static function getMessage($code)
    {
        $message = 'Terjadi kesalahan';
        if ($msg = RefErrorCodes::findOne($code)) {
            if (strtoupper(\Yii::$app->params['lang']) == 'ID') {
                $message = $msg->messageID;
            } else {
                $message = $msg->message;
            }
        } 

        return $message;
    }
}
