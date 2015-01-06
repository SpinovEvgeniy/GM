<?php

namespace app\models;

use Yii;
use app\models\Files;

/**
 * This is the model class for table "users".
 *
 * @property integer $id
 * @property string $login
 * @property string $password
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{

    private $accessToken;
    private $authKey;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['login', 'password'], 'required'],
            [['login', 'password'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'login' => 'Login',
            'password' => 'Password',
        ];
    }

    /**
     * Finds an identity by the given ID.
     *
     * @param string|integer $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @param string $authKey
     * @return boolean if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);
            } else {
                if ($_POST['User']['password']) {
                    $this->password = Yii::$app->getSecurity()->generatePasswordHash($this->password);;
                }
            }

            return true;
        } 
        return false;        
    }

    public function validatePassword($password) {
        return Yii::$app->getSecurity()->validatePassword($password, $this->password);
    }

    public static function findIdentityByLogin($login)
    {
        return static::findOne(['login' => $login]);
    }

    public function getFiles() {
        return $this->hasMany(Files::className(), ['id_users' => 'id']);
    }

}
