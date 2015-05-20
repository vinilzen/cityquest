<?php

class WebUser extends CWebUser {
    public function init()
    {
        $conf = Yii::app()->session->cookieParams;
        $this->identityCookie = array(
            'path' => $conf['path'],
            'domain' => $conf['domain'],
        );

        parent::init();
    }

	public function login($identity,$duration=0)
	{
		$id=$identity->getId();
		$states=$identity->getPersistentStates();
			
		// print_r($states); die;

		if($this->beforeLogin($id,$states,false))
		{
			$this->changeIdentity($id,$identity->getName(),$states);

			if($duration>0)
			{
				if($this->allowAutoLogin){

					$this->saveToCookie($duration);
				} else
					throw new CException(Yii::t('yii','{class}.allowAutoLogin must be set true in order to use cookie-based authentication.',
						array('{class}'=>get_class($this))));
			}


			if ($this->absoluteAuthTimeout)
				$this->setState(self::AUTH_ABSOLUTE_TIMEOUT_VAR, time()+$this->absoluteAuthTimeout);

/*			echo $id;
			echo "\r\n";
			print_r(Yii::app()->getRequest()->getCookies());

			die;*/
			
			$this->afterLogin(false);
		}
		return !$this->getIsGuest();
	}

	protected function saveToCookie($duration)
	{
		$app=Yii::app();

		$cookie=$this->createIdentityCookie($this->getStateKeyPrefix());

		$cookie->expire=time()+$duration;
		$data=array(
			$this->getId(),
			$this->getName(),
			$duration,
			$this->saveIdentityStates(),
		);
		$cookie->value=$app->getSecurityManager()->hashData(serialize($data));
		$cookie->httpOnly = true;

		$app->getRequest()->getCookies()->add($cookie->name,$cookie);
	}
}