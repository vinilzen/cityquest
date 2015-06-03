        <div class="col-sm-10 col-sm-offset-1">
          
          <? $month_array = array(
              '01'=>'январь',
              '02'=>'февраль',
              '03'=>'март',
              '04'=>'апрель',
              '05'=>'май',
              '06'=>'июнь',
              '07'=>'июль',
              '08'=>'август',
              '09'=>'сентябрь',
              '10'=>'октябрь',
              '11'=>'ноябрь',
              '12'=>'декабрь',
            ); ?>
          <div class="text-center btn-group-month" role="group">
          <? foreach ($month_array as $key => $value){
              if ($key == date('m')) {
                echo '<a href="#month_'.$key.'" data-month="'.$key.'" class="btn-month btn btn-xs btn-link active">'.$value.'</a>';
              } else {
                $disabled = '';
                if ($key != '05' && $key != '06') $disabled = ' disabled';
                echo '<a href="#month_'.$key.'" data-month="'.$key.'" class="btn-month btn btn-xs btn-link'.$disabled.'">'.$value.'</a>';
              }
          } ?>
          </div>
          <div class="clearfix"></div>
          <div class="tab-content">
            <div class="month-pane" id="month_05">
            <? foreach ($bookings_winner_array AS $date) { ?>
              
              <? foreach ($date AS $b) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                  <a href="/result/<?=$b->id?>" class="thumbnail thumbnail-transp">
                    <img class="img-responsive" src="/images/winner_photo/<?=$b->winner_photo?>" alt="">
                    <div class="caption">
                      <p>
                        <span class="pull-left">
                          <i class="icon icon-alarm"></i>
                          <?=$b->result?>
                        </span>
                        <?  
                          $year = substr($b->date, 0, 4);
                          $month = substr($b->date, 4,2);
                          $day = (int)(substr($b->date, -2));

                          $month_array = array(
                            '01'=>'января',
                            '02'=>'февраля',
                            '03'=>'марта',
                            '04'=>'апреля',
                            '05'=>'мая',
                            '06'=>'июня',
                            '07'=>'июля',
                            '08'=>'августа',
                            '09'=>'сентября',
                            '10'=>'октября',
                            '11'=>'ноября',
                            '12'=>'декабря',
                          );
                          
                        ?>
                        <span class="pull-right">
                          <i class="glyphicon glyphicon-calendar"></i>
                          <?=$day; ?> <?=$month_array[$month]?> <?=$year?>
                        </span>
                      </p>
                    </div>
                  </a>
                </div>
              <? } ?>

            <? } ?>
            </div>

            <div class="month-pane active" id="month_06">

            <? foreach ($bookings_winner_array_jun AS $date) { ?>
              
              <? foreach ($date AS $b) { ?>
                <div class="col-sm-6 col-md-4 col-lg-3">
                  <a href="/result/<?=$b->id?>" class="thumbnail thumbnail-transp">
                    <img class="img-responsive" src="/images/winner_photo/<?=$b->winner_photo?>" alt="">
                    <div class="caption">
                      <p>
                        <span class="pull-left">
                          <i class="icon icon-alarm"></i>
                          <?=$b->result?>
                        </span>
                        <?  
                          $year = substr($b->date, 0, 4);
                          $month = substr($b->date, 4,2);
                          $day = (int)(substr($b->date, -2));

                          $month_array = array(
                            '01'=>'января',
                            '02'=>'февраля',
                            '03'=>'марта',
                            '04'=>'апреля',
                            '05'=>'мая',
                            '06'=>'июня',
                            '07'=>'июля',
                            '08'=>'августа',
                            '09'=>'сентября',
                            '10'=>'октября',
                            '11'=>'ноября',
                            '12'=>'декабря',
                          );
                          
                        ?>
                        <span class="pull-right">
                          <i class="glyphicon glyphicon-calendar"></i>
                          <?=$day; ?> <?=$month_array[$month]?> <?=$year?>
                        </span>
                      </p>
                    </div>
                  </a>
                </div>
              <? } ?>

            <? } ?>
            </div>
          </div>
        </div>