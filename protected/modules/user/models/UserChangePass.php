<?php
/**
 * UserChangePassword class.
 * UserChangePassword is the data structure for keeping
 * user change password form data. It is used by the 'changepassword' action of 'UserController'.
 */
class UserChangePass extends CFormModel {
	public $password;
	public $oldpassword;
	public $verifyPassword;
	
	public function rules() {
		return array(
			array('password, oldpassword, verifyPassword', 'required'),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('oldpassword', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
			array('verifyPassword', 'compare', 'compareAttribute'=>'password', 'message' => UserModule::t("Retype Password is incorrect.")),
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'password'=>UserModule::t("password"),
			'oldpassword'=> 'Старый пароль',
			'verifyPassword'=>UserModule::t("Retype Password"),
		);
	}
} 