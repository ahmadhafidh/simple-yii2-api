<?php

namespace app\controllers;

use Yii;
use app\models\LoginForm;
use yii\web\HttpException;

class AuthController extends BaseController
{
    public function actionLogin()
    {
        $model = new LoginForm();

        if(!isset(Yii::$app->request->bodyParams['username'])) {
            return Yii::$app->message->base(Yii::$app->message::REQUEST_FAILED);
        }
        if(!isset(Yii::$app->request->bodyParams['password'])) {
            return Yii::$app->message->base(Yii::$app->message::REQUEST_FAILED);
        }
        $headers = Yii::$app->request->headers;
        if (!$headers->has('x-api-key')) {
            return Yii::$app->message->base(Yii::$app->message::INTERNAL_ERROR);
        }
        if (!$headers->has('Content-Type')) {
            return Yii::$app->message->base(Yii::$app->message::INTERNAL_ERROR);
        }

        if($model->load(Yii::$app->request->bodyParams, '')  && $model->login())
        {
            // die(var_dump('<pre>', Yii::$app->user->identity));
            $query = new yii\db\Query;
            $query->select('name')
            ->from('master_kejaksaan')
            ->where(['id'=>Yii::$app->user->identity->kejaksaan_id]);
            $data = [
                "user_id"=>Yii::$app->user->identity->id,
                "username"=>Yii::$app->user->identity->username,
                "kejaksaan_id"=>Yii::$app->user->identity->kejaksaan_id,
                "kejaksaan_name"=>$query->scalar(),
                "role"=>Yii::$app->user->identity->role,
                "token"=>Yii::$app->user->identity->auth_key
            ];
            return Yii::$app->message->base(Yii::$app->message::SUCCESS, $data);
        } else {
            return Yii::$app->message->base(Yii::$app->message::DATA_NOT_FOUND);
        }

        return Yii::$app->message->base(Yii::$app->message::LOGIN_FAILED);
    }
    
    public function actionLogout()
    {
        $model = new LogoutForm();
        $headers = Yii::$app->request->headers;
        if (!$headers->has('x-api-key')) {
            return Yii::$app->message->base(Yii::$app->message::INTERNAL_ERROR);
        }
        if (!$headers->has('Content-Type')) {
            return Yii::$app->message->base(Yii::$app->message::INTERNAL_ERROR);
        }
        if($model->load(Yii::$app->request->bodyParams, '')  && $model->logout())
        {
            $data = [];
            return Yii::$app->message->base(Yii::$app->message::SUCCESS, $data);
        }

        return Yii::$app->message->base(Yii::$app->message::LOGOUT_FAILED);
    }

}
