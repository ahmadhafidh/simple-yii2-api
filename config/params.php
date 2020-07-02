<?php

Yii::setAlias('@command', dirname(__DIR__));

return [
    'debug' => true,
    'lang' => 'ID',

    'user.passwordResetTokenExpire' => 3600,
    'adminEmail' => 'admin@example.com',
    'senderEmail' => 'no-reply@bayartilang.com',
    'senderName' => 'Tilang Online Kejaksaan',

    // ECOLL
    'secret_key' => '781aab615cd3c78fe10052df6a361c67',
    'createbilling' => "createbilling",
    'client_id' => "90001",
    'prefix' => "988",
    'billing_type' => "c",
];
