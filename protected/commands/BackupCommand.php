<?php

class BackupCommand extends CConsoleCommand {
	public function getHelp()
	{
		return <<<EOD
USAGE
  yiic backup <params>

DESCRIPTION
  This command backup users and bookings

PARAMETERS

   The file can be placed anywhere and must be a valid PHP script which
   returns an array of name-value pairs. Each name-value pair represents
   a configuration option.

   The following options are available:

   - 123
   - qwe

EOD;
	}

  public function run($args) {
    $args = array_flip($args);
    $folder = '../runtime/';

    if (isset($args['tbl_users']) || isset($args['tbl_booking'])) {

        if (isset($args['tbl_users'])) {
          $dbt = 'tbl_users';
        } elseif (isset($args['tbl_booking'])) {
          $dbt = 'tbl_booking';
        }

        $sql = "SELECT * FROM ".$dbt; 
        
        $table = Yii::app()->db->createCommand($sql)->queryAll();
        if ($table) {
          $json_str = '';
          foreach ($table as $row) {
            $json_str .= json_encode($row, JSON_UNESCAPED_UNICODE)."\r\n";
          }
          $path = $folder.$dbt.'.json';
          file_put_contents($path, $json_str);

          echo 'save table '.$dbt.' to '.$path."\r\n";

          $this->sendYiiMail(array(
             'dbt'=>$dbt,
             'path'=>$path
          ));

          die;

        } else {
          echo 'empty table '.$dbt;
          die;
        }
    } else {

      $sql = "SELECT * FROM tbl_users"; 
      $users = Yii::app()->db->createCommand($sql)->queryAll();
      if ($users) {
        $json_str = '';
        foreach ($users as $row) {
          $json_str .= json_encode($row, JSON_UNESCAPED_UNICODE)."\r\n";
        }
        $path1 = $folder.'tbl_users.json';
        file_put_contents($path1, $json_str);
      }

      $sql = "SELECT * FROM tbl_booking"; 
      $bookings = Yii::app()->db->createCommand($sql)->queryAll();
      if ($bookings) {
        $json_str = '';
        foreach ($bookings as $row) {
          $json_str .= json_encode($row, JSON_UNESCAPED_UNICODE)."\r\n";
        }
        $path2 = $folder.'tbl_booking.json';
        file_put_contents($path2, $json_str);
      }

        $this->sendYiiMail(array(
           'dbt1'=>'tbl_users',
           'dbt2'=>'tbl_booking',
           'path1'=>$path1,
           'path2'=>$path2,
           'both'=>1
        ));
        die;
    }

    echo 'error';
    die;
  }


    public static function sendYiiMail($options)
    {
      $mail = new YiiMailer();
      $mail->clearLayout();
      $mail->setFrom(Yii::app()->params['helloEmail'], 'CityQuest');
      $mail->setTo('marchukilya@gmail.com');
      $mail->setCc('ilya@cityquest.ru');
      $mail->setBody('Database backup');

      if (isset($options['both'])){

        $mail->setSubject('Backup CityQuest '.$options['dbt1']." and ".$options['dbt2']);
        $mail->setAttachment(array(
          $options['path1']=>$options['dbt1'].'.json',
          $options['path2']=>$options['dbt2'].'.json',
        ));
      } else {

        $mail->setSubject('Backup CityQuest '.$options['dbt']);
        $mail->setAttachment(array(
          $options['path']=>$options['dbt'].'.json'
        ));
      }

      if ($mail->send()) {
          echo "Mail send \r\n";
      } else {
          echo 'Error while sending email: '.$mail->getError();
          echo "\r\n";
      }
    }
}