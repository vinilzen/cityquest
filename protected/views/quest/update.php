<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	'Quests'=>array('index'),
	$model->title=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Quest', 'url'=>array('index')),
	array('label'=>'Create Quest', 'url'=>array('create')),
	array('label'=>'View Quest', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Quest', 'url'=>array('admin')),
);
?>

<h1>#<?php echo $model->id; ?> <?php echo $model->title; ?></h1>
<input type="hidden" value="<?php echo $model->id; ?>" id="quest_id">

<!-- Nav tabs -->
<ul class="nav nav-tabs">
  <li class="active"><a href="#times" data-toggle="tab">Времена для записи</a></li>
  <li><a href="#edit" data-toggle="tab">Реадктирование квеста</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
  <div class="tab-pane active" id="times">
    <div id="times-table" style="padding-top:10px;">
    <?
      $times = array('00:00', '01:15', '02:30', '04:00', '05:15', '06:30', 
                    '07:45', '09:00', '10:15', '11:30', '12:45', '14:00', 
                    '15:15', '16:30', '17:45', '19:00', '20:15', '21:30', '22:45');

      $days = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');
      $month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря' );
      $endDate = strtotime( '+14 day' );
      $currDate = strtotime( 'now' );
      $dayArray = array();

      $pricesStr = '';
      $workday = 1;

        function makeDayArray( ){
          $days = array('понедельник', 'вторник', 'среда', 'четверг', 'пятница', 'суббота', 'воскресенье');
          $month = array('января', 'февраля', 'марта', 'апреля', 'мая', 'июня', 'июля', 'августа', 'сентября', 'ноября', 'октября', 'декабря' );
          $endDate = strtotime( '+14 day' );
          $currDate = strtotime( 'now' );
          $dayArray = array();

          do{
            $dayArray[] = array(
              'day_name' => $days[intval(date( 'N' , $currDate ))-1],
              'month_name' => $month[intval(date( 'n' , $currDate ))-1],
              'day' => date( 'j' , $currDate ),
              'date' => date('Ymd', $currDate)
            );
            $currDate = strtotime( '+1 day' , $currDate );
          } while( $currDate<=$endDate );

          return $dayArray;
        }

        $next_2week = makeDayArray(); ?>

          <table class="table">
            <?php foreach ($next_2week as $value) {

              if ( $value['day_name'] == 'суббота' || $value['day_name'] == 'воскресенье')
              {
                $workday = 0;
                $priceAm = Yii::app()->params['price_weekend_AM'];
                $pricePm = Yii::app()->params['price_weekend_PM'];
                // $pricesStr =  '<span class="price"><span>'.$priceAm.' руб.</span></span>'.' <span class="price"><span>'.$pricePm.' руб.</span></span>';

              } else {

                $workday = 1;
                $priceAm = Yii::app()->params['price_workday_AM'];
                $pricePm = Yii::app()->params['price_workday_PM'];

                // $pricesStr =  '<span class="price"><span>'.$priceAm.' руб.</span></span>'.' <span class="price"><span>'.$pricePm.' руб.</span></span>'.' <span class="price"><span>'.$priceAm.' руб.</span></span>';
              }

              ?>
            <tr class="<?php echo $value['day_name'] == 'суббота' || $value['day_name'] == 'воскресенье' ? 'danger' : ''; ?>">
              <td>
                <p class="<?php echo $value['day_name'] == 'суббота' || $value['day_name'] == 'воскресенье' ? 'weekend' : ''; ?>">
                  <strong><?php echo $value['day']; ?> <?php echo $value['month_name']; ?></strong><br><span><?php echo $value['day_name']; ?></span>
                </p>
              </td>
              <td class="text-left">
                <?php foreach ($times as $k=>$time) {
                  $dis = 0;                  
                  $near = 0;
                  if ($time < date('h:i', strtotime( '+3 hours' )) ) $near = 1;
                ?><button type="button" <?

                  if ($workday){
                    if ($k>6 && $k<14) $price = $priceAm;
                    else $price = $pricePm;
                  } else {
                    if ($k<10) $price = $priceAm;
                    else $price = $pricePm;
                  }



                 if (isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) {

                  echo  'data-name="'.$booking[$value['date']][$time]['name'].'" '.
                        'data-phone="'.$booking[$value['date']][$time]['phone'].'" '.
                        'data-price="'.$booking[$value['date']][$time]['price'].'" '.
                        'data-id="'.$booking[$value['date']][$time]['id'].'" '. 
                        'data-comment="'.$booking[$value['date']][$time]['comment'].'"';
                 } else {
                    echo 'data-price="'.$price.'" ';
                 }
                ?>
                    data-toggle="popover"
                    data-title="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?> <?php echo $time; ?>"
                    data-time="<?php echo $time; ?>" 
                    data-ymd="<?php echo $value['date']; ?>" 
                    data-date="<?php echo $value['day']; ?> <?php echo $value['month_name']; ?>" 
                    data-day="<?php echo $value['day_name']; ?>" 
                    class="btn btn-default btn-xs <?php
              
                  if (isset($booking[$value['date']]) && isset($booking[$value['date']][$time]) ) {
                    if ($booking[$value['date']][$time]['status'] == 0)
                      echo ' btn-info';

                    if ($booking[$value['date']][$time]['status'] == 1)
                      echo ' btn-success';

                  }

            if ($workday && $k > 2 && $k < 7 )
                echo ' invisible'; 
          ?>" ><? echo $time; ?><br><small><? echo $price; ?>р.</small></button> <?php } ?>
            <div class="clearfix"></div>
            <? // echo $pricesStr; ?>
          </td>
        </tr>
        <?php } ?>
      </table>
    </div>
  </div>
  <div class="tab-pane" id="edit">
    <?php $this->renderPartial('_form', array('model'=>$model)); ?>
  </div>
</div>


<script id="BookInfWrap" type="text/template">
  <div class="checkBooking" id="BookInf">
    <h3 style="margin-top: 0;" class="pop-row"><%= name %></h3>
    <p class="phoneRow pop-row" id="phoneRow"><strong>Phone</strong>: <span><%= phone %></span></p>
    <form class="form-horizontal pop-row" id="editBookingRow" role="form">
      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputName" placeholder="Ivan">
        </div>
        <div class="col-sm-2">
          <button id="saveBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Сохранить">
            <span class="glyphicon glyphicon-ok"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPhone" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPhone" placeholder="123-456-789">
        </div>
        <div class="col-sm-2">
          <button id="cancelEditBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Отменить">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPrice" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPrice" placeholder="3000">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <textarea type="text" class="form-control input-sm inputComment" placeholder="Дополнительный комментарий"></textarea>
        </div>
      </div>
    </form>
    <form class="form-horizontal pop-row" id="addBookingRow" role="form">
      <div class="form-group">
        <label for="inputName" class="col-sm-2 control-label">Name</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputName" placeholder="Ivan">
        </div>
        <div class="col-sm-2">
          <button id="saveBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Сохранить">
            <span class="glyphicon glyphicon-ok"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPhone" class="col-sm-2 control-label">Phone</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPhone" placeholder="123-456-789">
        </div>
        <div class="col-sm-2">
          <button id="cancelAddBooking" class="btn btn-default btn-sm" data-toggle="tooltip" title="Отменить">
            <span class="glyphicon glyphicon-remove"></span>
          </button>
        </div>
      </div>
      <div class="form-group">
        <label for="inputPrice" class="col-sm-2 control-label">Price</label>
        <div class="col-sm-7">
          <input type="text" class="form-control input-sm inputPrice" value="<%= price %>" placeholder="3000">
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">
          <textarea type="text" class="form-control input-sm inputComment" placeholder="Дополнительный комментарий"></textarea>
        </div>
      </div>
    </form>
    <div class="pop-row" id="confirmRow">
    <p class="text-center">
      <strong>Вы уверены?</strong>
      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Да, Удалить!" id="confirmedDelete">
        <span class="glyphicon glyphicon-ok"></span>
      </button>
      <button class="btn btn-default btn-sm" data-toggle="tooltip" title="Отменить удаление" id="cancelDelete">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
    </p>
    </div>
    <div class="pop-row" id="btnRow">
    <p class="text-center">
      <button class="btn btn-default btn-sm" id="confirmBooking" data-toggle="tooltip" title="Подтвердить бронирование">
        <span class="glyphicon glyphicon-ok"></span>
      </button>
      <button class="btn btn-default btn-sm" id="undoBooking" data-toggle="tooltip" title="Удалить подтверждение">
        <span class="glyphicon glyphicon-pause"></span>
      </button>
      <button class="btn btn-default btn-sm" id="showRemoveBooking" data-toggle="tooltip" title="Удалить бронирование">
        <span class="glyphicon glyphicon-remove"></span>
      </button>
      <button class="btn btn-default btn-sm" id="editBooking" data-toggle="tooltip" title="Редактировать бронирование">
        <span class="glyphicon glyphicon-pencil"></span>
      </button>
    </p>
    </div>
    <div class="pop-row" id="addRow">
      <p class="text-center">
        <strong>Записать вручную</strong>
        <button class="btn btn-default btn-sm" id="addBooking" data-toggle="tooltip" title="Добавить бронирование">
          <span class="glyphicon glyphicon-plus"></span>
        </button>
      </p>
    </div>
  </div>
</script>