<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "ref_error_codes".
 *
 * @property string $code
 * @property string $message
 * @property string messageID
 * @property string $description
 */
class RefErrorCodes extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ref_error_codes';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'code' => Yii::t('app', 'Response Code'),
            'message' => Yii::t('app', 'Message EN'),
            'messageID' => Yii::t('app', 'Message ID'),
            'description' => Yii::t('app', 'Description'),
        ];
    }
}
