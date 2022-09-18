<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

/**
 * RegisterForm is the model behind the register form.
 *
 * @property-read User|null $user
 * 
 */
class RegisterForm extends Model
{
	public $username;
	public $password;
	public $password_repeat;

	public function rules()
	{
		return [
			[['username','password','password_repeat'], 'required'],
			[['username','password'], 'string', 'min' => 4, 'max' => 16],
			['password_repeat','compare','compareAttribute' => 'password']
		];
	}

	public function register()
	{
		$user = new User();

		$user->username = $this->username;
		$user->password = \Yii::$app->security->generatePasswordHash($this->password);
		$user->access_tokens = \Yii::$app->security->generateRandomString();
		$user->auth_key = \Yii::$app->security->generateRandomString();

		if ($user->save()){
			return TRUE;
		} else {
			\Yii::error('Registration failed' . VarDumper::dumpAsString($user->errors));

			return false;
		}
		
	}
}