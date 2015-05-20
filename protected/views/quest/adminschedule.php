<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */  ?>

<script type="text/javascript">
	var user_name = '<?=!Yii::app()->user->isGuest ? Yii::app()->getModule("user")->user()->username : ''?>',
		hash = '<?=$arr_hash?>',
		city_id = '<?=Yii::app()->getModule("user")->user()->city_id?>',
		user_phone = '<?=!Yii::app()->user->isGuest ? Yii::app()->getModule("user")->user()->phone : ''?>';
</script>

<?	
	$days = Yii::app()->params['days'];
	$days_short = Yii::app()->params['days_short'];
    $month = Yii::app()->params['month'];
    $month_f = Yii::app()->params['month_f'];

	$selectedDate = strtotime('now');

	$offset = 20;
	$start = 0;
	$prev = -1*$offset;
	$next = $offset;

	if (isset($_GET['d'])) {
		$start = (int)$_GET['d'];
		$prev = ((int)$_GET['d']/$offset - 1)*$offset;
		$next = $prev + 2*$offset;
	}

	for ($i=$start-1; $i<$start+$offset; $i++) {
		$currDate = strtotime( '+'.$i.' day' );

		if ($ymd == date('Ymd', $currDate)) {
			$selectedDate = $currDate;
		}
	}
	$today_holiday = 0;
	if (date('w', $selectedDate) == 0 || date('w', $selectedDate) == 6 || in_array(date('Ymd', $selectedDate), $holidays)){
		$today_holiday = 1;
	}
?>
<div class="block">
	<div class="block-title">
		<h2 data-toggle="tooltip" data-placement="left" title="<? echo $today_holiday ? 'Выходной' : 'Рабочий'; ?> день">
			Квесты на <? echo date('d', $selectedDate); ?> <? echo $month[date('n', $selectedDate)-1]; ?> <? echo date('Y', $selectedDate); ?>
			<span	class="hi hi-star<? echo $today_holiday ? '' : '-empty'; ?> setHoliday"
					data-holiday="<? echo $today_holiday; ?>" 
					style="cursor:pointer;" data-toggle="tooltip" 
					data-date="<? echo date('Ymd', $selectedDate) ?>"
					title="<? echo $today_holiday ? 'Сделать рабочим' : 'Сделать выходным'; ?>"></span>
		</h2>
	</div>
	<h3 class="sub-header hide"><?=$month_f[date('n', $selectedDate)-1]?></h3>
	<div class="row">
		<div class="col-sm-12">
			<div class="widget">
				<div class="widget-extra">
					<div class="row">
						<div class="col-sm-12" style="padding-top:15px; position:relative; ">
							<?
								$start = 0;
								$prev = -1*$offset;
								$next = $offset;

								if (isset($_GET['d'])) {
									$start = (int)$_GET['d'];
									$prev = ((int)$_GET['d']/$offset - 1)*$offset;
									$next = $prev + 2*$offset;
								}
							?>
							<a href="/quest/adminschedule/ymd/?d=<?=$prev?>"
								class="btn btn-link btn-arrow btn-arrow-left" 
								title="<?=$offset?> дней назад">
								<i class="hi hi-chevron-left"></i>
							</a>
							<div class="table-responsive table-responsive-date">
								<div class="btn-group btn-group-justified date_line">
									<?
									for ($i=$start-1; $i<$start+$offset; $i++) {
										$currDate = strtotime( '+'.$i.' day' );

										// выбранная дата
										$disabled = '';
										$disabled_class = '';

										// weekend
										$weekend = '';
										$holiday = 0;
										if ($ymd == date('Ymd', $currDate)) {
											$disabled = ' disabled="disabled"';
											$selectedDate = $currDate;
											$disabled_class = ' btn-success ';
										} else {
											if (date('w', $currDate) == 0 || date('w', $currDate) == 6 || in_array(date('Ymd', $currDate), $holidays)){
												$holiday = 1;
												$weekend = ' btn-warning';
											}			
										}

										// сегодня 
										$active = '';
										if (date('Ymd', $currDate) === date('Ymd', strtotime('now')))
											$active = ' active';


										$style="";
										$title="";
										$badge = '<span class="badge" style=" margin-top:3px; font-size: 13px;font-family: \'Open Sans\';font-weight: normal;">0</span>';
										if (isset($twoweek_bookings_arr[date('Ymd', $currDate)])) {
											$title = '(Всего броней - '.count($twoweek_bookings_arr[date('Ymd', $currDate)]).')';
											$badge = '<span class="badge" style=" margin-top:3px; font-size: 13px;font-family: \'Open Sans\';font-weight: normal;">'.count($twoweek_bookings_arr[date('Ymd', $currDate)]).'</span>';
										}

										if (date('w', $currDate) == 0 || date('w', $currDate) == 6){
											echo '<a data-container="body" data-toggle="tooltip" title="'.date('d M Y', $currDate).' '.$title.'" '.
													'href="/quest/adminschedule/ymd/'.date('Ymd', $currDate).'?d='.$start.'" type="button" 
														class="text-center btn btn-default'.$active.$weekend.$disabled_class.'" '.$disabled.'>'.
														'<span style="display:block;line-height:1;">'.date('d', $currDate).'</span>'.
														'<small style="display:block;line-height:1;">'.$days_short[date('N', $currDate)-1].'</small>'.
														'<small style="display:block;line-height:1;">'.mb_substr($month[date('n', $currDate)-1],0,6).'</small>'.
														$badge.
												 '</a>';
										} else {
											echo '<a '.$style.' data-container="body" data-toggle="tooltip" title="'.date('d M Y', $currDate).' '.$title.'" '.
													'href="/quest/adminschedule/ymd/'.date('Ymd', $currDate).'?d='.$start.'" type="button" 
														class="text-center btn btn-default'.$active.$weekend.$disabled_class.'" '.$disabled.'>'.
														'<span style="display:block;line-height:1;">'.date('d', $currDate).'</span>'.
														'<small style="display:block;line-height:1;">'.$days_short[date('N', $currDate)-1].'</small>'.
														'<small style="display:block;line-height:1;">'.mb_substr($month[date('n', $currDate)-1],0,6).'</small>'.
														$badge.
												 '</a>';
										}
									}
								?>
								</div>
							</div>
							<a href="/quest/adminschedule/ymd/?d=<?=$next?>"
								class="btn btn-link btn-arrow btn-arrow-right"
								title="<?=$offset?> дней вперед">
								<i class="hi hi-chevron-right"></i>
							</a>
							<hr>
							<style> .table>tbody>tr>td { padding:8px 1px; } </style>
							<div id="times-table" class="table-responsive">
								<? if (count($quests)>0) {
									foreach ($quests as $quest) {

										if (isset($quest['q']->times) && is_numeric($quest['q']->times) && isset(Yii::app()->params['times'][(int)$quest['q']->times]))
											$times = Yii::app()->params['times'][(int)$quest['q']->times];
										else 
											$times = Yii::app()->params['times'][1];

										echo '<table class="table"><tr><td style="width:100px;" id="q_id_'.$quest['q']->id.'" >'.$quest['q']->title.'</td>';

										if (date('w', $selectedDate) == 0 || date('w', $selectedDate) == 6 || in_array(date('Ymd', $selectedDate), $holidays))
											$workday = 0;
										else
											$workday = 1;

								        if (!$workday) {
											$priceAm = $quest['q']->price_weekend_am;
											$pricePm = $quest['q']->price_weekend_pm;
								        } else {
											$priceAm = $quest['q']->price_am;
											$pricePm = $quest['q']->price_pm;
								        }

								        $promo_day = 0;
								        if ( isset(  $quest['promo_days'][date('Ymd', $selectedDate)] ) ) {
								        	$priceAm = $quest['promo_days'][date('Ymd', $selectedDate)]->price_am;
								        	$pricePm = $quest['promo_days'][date('Ymd', $selectedDate)]->price_pm;
								        	$promo_day = 1;
								        }

										foreach ($times as $k=>$time) {

								            if ($workday){
								              if ($k>6 && $k<14) $price = $priceAm;
								              else $price = $pricePm;
								              if ($quest['q']->id == 15 ){
							                    if ($k<7) $price = $priceAm;
							                    else $price = $pricePm;
							                    
							                    if ($k<1) $price = $pricePm;
							                  }
								            } else {

								              if ($k<10) $price = $priceAm;
								              else $price = $pricePm;

								            }

											$dis = '';
											$data = '';
								      		$additionalClass = '';

											if ( isset($quest['bookings'][$time]) ) {

												if ($quest['bookings'][$time]->status == 0)
													$additionalClass = 'btn-info btn-gr';

												if ($quest['bookings'][$time]->status == 1){	
													$additionalClass = ' btn-info';
												}

												$competitor_id = isset($quest['bookings'][$time]->competitor) ? $quest['bookings'][$time]->competitor->id : 0;
												$competitor_fb_id = isset($quest['bookings'][$time]->competitor) ? $quest['bookings'][$time]->competitor->fb_id : 0;
												$competitor_vk_id = isset($quest['bookings'][$time]->competitor) ? $quest['bookings'][$time]->competitor->vk_id : 0;

												$data = ' data-id="'.$quest['bookings'][$time]->id.'" '.
														'data-status="'.$quest['bookings'][$time]->status.'" '.
														'data-price="'.$quest['bookings'][$time]->price.'" '.
														'data-phone="'.$quest['bookings'][$time]->phone.'" '.
														'data-result="'.$quest['bookings'][$time]->result.'" '.

														'data-payment="'.$quest['bookings'][$time]->payment.'" '.
														'data-source="'.$quest['bookings'][$time]->source.'" '.
														'data-discount="'.$quest['bookings'][$time]->discount.'" '.

														'data-comment="'.$quest['bookings'][$time]->comment.'" '.
														'data-affiliate="'.$quest['bookings'][$time]->affiliate.'" '.
														'data-user-id="'. $competitor_id .'" '.
														'data-fb-id="'. $competitor_fb_id .'" '.
														'data-vk-id="'. $competitor_vk_id .'" '.
														'data-winner-photo="'. $quest['bookings'][$time]->winner_photo .'" '.
														'data-name="'.$quest['bookings'][$time]->name.'" ';

												if ($quest['bookings'][$time]->result != 0 && 
													$quest['bookings'][$time]->result != '0' && 
													$quest['bookings'][$time]->result != '00' && 
													$quest['bookings'][$time]->result != ' ' && 
													$quest['bookings'][$time]->result != '')
												{
													$additionalClass = ' btn-success';
												} else {
													if (
														(	
															$time < date('H:i', strtotime( '+0 hours' )) && 
															$quest['bookings'][$time]->date == date('Ymd', strtotime( '+0 hours' ))
														)
														|| 
														$quest['bookings'][$time]->date < date('Ymd', strtotime( '+0 hours' ))

													) {
														$additionalClass = '  btn-info btn-danger ';
													}
												}

												if ($quest['bookings'][$time]->name == 'CQ') {
													$additionalClass = '  btn-gray ';
												}

											} else {
												$data = ' data-price="'.$price.'" ';
											}

									        $invisible = '';
									        if ($workday && $k > 2 && $k < 7 && $quest['q']->id!=15) $invisible = ' hidden';

									        ?>

											<td>
												<button style="position:relative;" data-toggle="popover"  
								            		data-title="<?=date('d',$selectedDate)?> <?=$month[date('n', $selectedDate)-1]?> <?php echo $time; ?>"
												    data-time="<?=$time?>" 
										            data-ymd="<?=$ymd?>" 
										            data-quest="<?=$quest['q']->id?>" 
										            data-date="<?=date('d',$selectedDate)?> <?=date('M', $selectedDate)?>" 
										            data-day="<?=$days[date('w',$selectedDate)]?>" 
													class="btn btn-default btn-xs <?=($invisible.$additionalClass)?>" <?=($dis.$data)?>>
													<?=$time?><br><small><?=($promo_day)?'<i class="fa fa-exclamation"></i> ':''?><?=$price?>р.</small>
													<? if (isset($quest['bookings'][$time]) && $quest['bookings'][$time]->winner_photo != '')
														echo '<i style="position:absolute; font-size:7px; bottom:0; right:0;" class="fa fa-camera"></i>'; ?>
												</button>
											</td>

											<?
										}

										echo '</tr></table>';
									}
								} else {
									echo '<p>Квесты не найдены</p>';
								} ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


	</div>
</div>

<!-- Modal -->
<div class="modal" id="addBookModal" tabindex="-1" role="dialog" aria-labelledby="addBookModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <h4 class="modal-title" id="myModalLabel"></h4>
      </div>
      <div class="modal-body"></div>
    </div>
  </div>
</div>

<script  type="text/javascript">
	var adminschedule = 1;
</script>
<? include('popover.php'); ?>