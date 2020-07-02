<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class WebSession extends ActiveRecord
{
    public static function tableName()
    {
        return 'web_session';
    }

    public function rules()
    {
        return [];
    }

    public function attributeLabels()
    {
        return [];
    }
}
