<?php
namespace app\models;

use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $username;
    public $password;
    public $rememberMe = true;
    private $_user = false;

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['rememberMe', 'boolean'],
            ['password', 'validatePassword'],
        ];
    }

    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user || !is_object($user) || $user->password !== $this->password) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }
    

    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            if ($user instanceof \yii\web\IdentityInterface) {
                return Yii::$app->user->login($user, $this->rememberMe ? 3600 * 24 * 30 : 0);
            }
        }
        return false;
    }
    


    protected function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
