<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "users".
 *
 * @property int $id
 * @property string $username
 * @property string|null $email
 * @property string|null $password
 * @property string|null $auth_key
 * @property string|null $role
 * @property int|null $status 0 = inactive, 1 = active
 * @property string|null $verification_token
 * @property string|null $password_reset_token
 * @property string|null $created_date
 * @property int|null $created_by
 * @property string|null $created_by_name
 * @property string $updated_date
 * @property int|null $updated_by
 * @property string|null $updated_by_name
 * @property int|null $login_failed
 * @property string|null $last_login_attempt
 * @property string|null $penalty_time
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const SUPERADMIN_ROLE = 'superadmin';
    const ADMIN_ROLE = 'admin';

    public $password_new;
    public $password_confirm;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => 0],
            [['username','email', 'role'], 'required'],
            [['role'], 'string'],
            [['status', 'created_by', 'updated_by', 'login_failed', 'kejaksaan_id'], 'integer'],
            [['created_date', 'updated_date', 'last_login_attempt', 'penalty_time'], 'safe'],
            [['username', 'verification_token', 'password_reset_token'], 'string', 'max' => 256],
            [['email', 'auth_key'], 'string', 'max' => 100],
            [['password', 'created_by_name', 'updated_by_name'], 'string', 'max' => 255],
            [['password_new', 'password_confirm'], 'string', 'max' => 255, 'min' => 8],
            [['password_new', 'password_confirm'], 
                'match',
                'pattern' => '/^.*(?=.*\d)(?=.*[\W])(?=.*[0-9])(?=.*[a-z])(?=.*[A-Z]).*$/',
                'message' => Yii::t("app","Password must fullfill following criteria : One Uppercase, One Symbol and One Number")
            ],
            [['password_confirm'],
                'compare',
                'compareAttribute' => 'password_new',
                'message' => Yii::t("app","Passwords do not match")
            ],
            ['role', 'checkRole'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t("app","This username has already been taken")],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => Yii::t("app","This email has already been taken")],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
            'auth_key' => 'Auth Key',
            'role' => 'Role',
            'status' => 'Status',
            'verification_token' => 'Verification Token',
            'password_reset_token' => 'Password Reset Token',
            'created_date' => 'Created Date',
            'created_by' => 'Created By',
            'created_by_name' => 'Created By Name',
            'updated_date' => 'Updated Date',
            'updated_by' => 'Updated By',
            'updated_by_name' => 'Updated By Name',
            'login_failed' => 'Login Failed',
            'last_login_attempt' => 'Last Login Attempt',
            'penalty_time' => 'Penalty Time',
            'password_new' => 'Password',
        ];
    }

    public function checkRole($attribute)
    {
        if (!$this->hasErrors())
        {
            if ($this->role != 'superadmin' && empty($this->kejaksaan_id))
                $this->addError('kejaksaan_id', 'Harap pilih kejaksaan');
        }
    }
    
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::find()->where(['username' => $username, 'status' => self::STATUS_ACTIVE])->orWhere(['email' => $username, 'status' => self::STATUS_ACTIVE])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    public function generateEmailVerificationToken()
    {
        $this->verification_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getKejaksaan()
    {
        return $this->hasOne(MasterKejaksaan::class, ['id' => 'kejaksaan_id']);
    }

    public function getUserForgotPassword()
    {
        return $this->hasOne(UserForgotPassword::class, ['user_id' => 'id']);
    }

    public static function getRoleList()
    {
        return [
            ['id' => self::SUPERADMIN_ROLE, 'name' => 'Superadmin'],
            ['id' => self::ADMIN_ROLE, 'name' => 'Admin'],
        ];
    }

    public static function getStatusList()
    {
        return [
            ['id' => self::STATUS_ACTIVE, 'name' => 'Activate'],
            ['id' => self::STATUS_INACTIVE, 'name' => 'Inactivate'],
        ];
    }

    public static function getRoleAsArray()
    {
        $getRoles = AuthItemChild::find()->where([
            'AND',
            ['LIKE', 'child', '%_permission', false],
            ['NOT LIKE', 'parent', '%_permission', false]
        ])->all();

        $roles = [];
        foreach ($getRoles as $role)
        {
            $roles[] = $role->parent;
        }

        return $roles;
    }

    public function getAuthAssignment()
    {
        return $this->hasOne(AuthAssignment::class,['user_id' => 'id']);
    }

    public static function authorization($header_auth)
    {
        $creds = self::findByAuthKey($header_auth);

        return $creds ?: false;
    }

    public static function findByAuthKey($auth_key)
    {
        $credential = self::findOne([
            'auth_key' => $auth_key,
            'status' => '1'
        ]);

        return $credential ?: false;
    }
}
