<?php

namespace app\controllers;

use Yii;
use yii\rest\Controller;

class BaseController extends Controller
{
    use RestAuth;

    public function beforeAction($action)
    {
        if (!parent::beforeAction($action))
            return false;

        return true;
    }
}
