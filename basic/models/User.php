<?php
namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    // For plaintext password comparison, using the "password" column.
    public function validatePassword($password)
    {
        return $this->password === $password;
    }

    public function getId()
    {
        return $this->id;
    }

    // Since your table doesn't have an auth_key column, we can return a static value.
    // Note: This means cookie-based login (rememberMe) won't work as expected.
    public function getAuthKey()
    {
        return 'dummy-auth-key';
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    // Add this method to satisfy IdentityInterface
    public static function findIdentityByAccessToken($token, $type = null)
    {
        // If you're not using access tokens, just return null or throw an exception.
        return null;
    }
}
