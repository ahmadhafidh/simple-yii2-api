<?php

namespace app\controllers;

use yii\base\Component;
use yii\filters\AccessControl;
use yii\filters\auth\HttpHeaderAuth;
use yii\helpers\ArrayHelper;

trait RestAuth
{
    public function behaviors()
    {
        $parentBehaviors = $this instanceof Component ? parent::behaviors() : [];

        return ArrayHelper::merge($parentBehaviors, [
            'authenticator' => [
                'class' => HttpHeaderAuth::class,
                'header' => 'x-api-key',
                'except'=> ['login'],
            ],
            'access' => [
                'class' => AccessControl::class,
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['login'],
                        'allow' => true,
                        'roles' => ['@', '?']
                    ],
                ],
                
            ],
        ]);
    }

    /**
     * @return Auth|IdentityInterface
     */
    protected function getUser()
    {
        return \Yii::$app->user->identity;
    }

    /**
     * @return User $kejaksaan_id
     */
    protected function getKejaksaanId()
    {
        return $this->getMember()->kejaksaan_id;
    }
}
