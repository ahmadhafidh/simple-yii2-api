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
class LoginForm extends Model
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
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors())
        {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password))
                $this->addError($attribute, 'Incorrect username or password.');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        $this->statusCode = 111;
        if ($this->validate())
        {
            if ($this->getUser())
            {
                $this->_user->generateAuthKey();
                $access_token = $this->_user->getAuthKey();
                
                $session = new WebSession();
                $session->id = $access_token;
                $session->user_id = $this->_user->id;
                $session->expire = time() + self::EXPIRE_TIME;
                $session->type = 'api';
                $session->save();
                $this->_user->save();

                Yii::$app->user->login($this->_user, static::EXPIRE_TIME);

                return $access_token;
            }
        }
        
        return false;
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
