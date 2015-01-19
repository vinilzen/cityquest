<?php

class SendCommand extends CConsoleCommand {
	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic send <params>

DESCRIPTION
  This command send mails for user 

PARAMETERS

   The file can be placed anywhere and must be a valid PHP script which
   returns an array of name-value pairs. Each name-value pair represents
   a configuration option.

   The following options are available:

   - 123
   - qwe

EOD;
	}

    public function run($args)
    {
    	$args = array_flip($args);

    	$date = date('Ymd', mktime(0, 0, 0, date("m")  , date("d")-1, date("Y")));
    	$sql = "SELECT DISTINCT q.title, u.email, u.username, b.result, b.quest_id ".
    			"FROM tbl_users AS u ".
					"JOIN tbl_booking AS b ON b.competitor_id = u.id ".
					"JOIN tbl_quest AS q ON b.quest_id = q.id ".
				"WHERE ".
					"b.date = ".$date." AND ".
					"u.superuser = 0 AND ".
					"b.result < '60:00';";
		
    	$list = Yii::app()->db->createCommand($sql)->queryAll();
    	
    	if (isset($args['print'])){
	    	if ($list) {
	    		foreach ($list as $r) {
	    			echo "#".$r['quest_id']." ".$r['title']."	|	".$r['email']."		|	".$r['result']."\r\n";
	    		}
	    		echo "\r\nCount: ".count($list)."\r\n";
	    	}
	    	else
	    		echo "null!\r\n";
    	} else {
    		if ($list){
    			foreach ($list as $r) {
    				$this->sendYiiMail($r);
    			}
    		}
    	}
    }

    private function toMail($options)
    {
    	echo "Send Mail:\r\n";
    	var_dump($options);
    	echo "\r\n";
    }

    /**
  	* Send mail method
    * Use: $this->sendMail('marchukilya@gmail.com', 'Sub', 'Msg'); 
  	*/
  	public static function sendMail($email,$subject,$message)
    {
  		$helloEmail = Yii::app()->params['helloEmail'];
  		$headers = "MIME-Version: 1.0\r\nFrom: CityQuest <$helloEmail>\r\nReply-To: $helloEmail\r\nContent-Type: text/html; charset=utf-8";
  		$message = wordwrap($message, 70);
  		$message = str_replace("\n.", "\n..", $message);
  		return mail($email,"=?UTF-8?B?".base64_encode($subject)."?=",$message,$headers);
  	}

    public static function sendYiiMail($options)
    {
        // 'result' - template from /protected/views/mail/
        $mail = new YiiMailer('result', $options);
        $mail->setFrom(Yii::app()->params['helloEmail'], 'CityQuest Info');
        $mail->setTo('marchukilya@gmail.com');
        $mail->setSubject('Ваш результат в "'.$options['title'].'": '.$options['result']);

        if ($mail->send()) {
            // Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
            echo 'Thank you for contacting us ('.$options['email'].'). We will respond to you as soon as possible.'."\r\n"; 
        } else {
            // Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
            echo 'Error while sending email: '.$mail->getError();
            echo "\r\n";
        }
        die;
    }
}