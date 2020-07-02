<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class Logout extends Model
{
    const EXPIRE_TIME = 604800; //token expiration time, 7 days valid

    public $username;
    public $password;
    public $rememberMe = true;
    public $statusCode;

    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            
        ];
    }

   

    public function logout()
    {
        $this->statusCode = 111;
        $this->_user->auth_key = null;
        $this->_user->save();
        Yii::$app->user->logout($this->_user);
       
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false)
            $this->_user = User::findByUsername($this->username);

        return $this->_user;
    }
}
