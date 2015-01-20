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
					"u.superuser = 0;";
		
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

            $sql = "SELECT * FROM tbl_quest WHERE status = 2 AND id != ".$r['quest_id'].";";
            $quests = Yii::app()->db->createCommand($sql)->queryAll();
            $list_quests = array();
            if ($quests && count($quests) > 0){
              foreach ($quests as $row) {
                $list_quests[] = '<a href="http://cityquest.ru/quest/view?id='.$row['id'].'">'.$row['title'].'</a>';
              }
            }
            $r['list_quests'] = implode(", ",$list_quests);
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
        $tamplate_name = ($options['result'] <'60:00' ) ? 'result_success' : 'result_notqualify';
        $mail = new YiiMailer($tamplate_name, $options);
        $mail->setFrom(Yii::app()->params['helloEmail'], 'CityQuest');
        // $mail->setTo($options['email']);
        $mail->setTo('marchukilya@gmail.com');
        // $mail->setBcc('marchukilya@gmail.com');
        $mail->setSubject('Ваш результат квеста "'.$options['title'].'": '.$options['result']);

        if ($mail->send()) {
            // Yii::app()->user->setFlash('contact','Thank you for contacting us. We will respond to you as soon as possible.');
            echo 'Mail send to '.$options['email'].'.'."\r\n";
        } else {
            // Yii::app()->user->setFlash('error','Error while sending email: '.$mail->getError());
            echo 'Error while sending email: '.$mail->getError();
            echo "\r\n";
        }
    }
}