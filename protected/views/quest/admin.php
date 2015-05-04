<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	'Quests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#quest-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});");
?>


<div class="block">
	<div class="block-title">
		<h2>
			Управление квестами
			<small>
				<a href="/quest/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/proui/f-main-3.1.css" />
			<div class="row" id="sortable">
				<? if (count($models)>0) {
					foreach ($models AS $q) {

						if ($q->status==1)
							$status = Yii::t('app','Draft');
						else if ($q->status==2)
							$status = Yii::t('app','Active');
						else if ($q->status==3)
							$status = Yii::t('app','In development');

						/* echo '<div class="col-xs-12 col-sm-6 col-lg-4 sortable_quest" data-id="'.$q->id.'" id="quest_'.$q->id.'">'.
								'<div class="widget ">'.
									'<div class="widget-extra themed-background">'.
										'<h4 class="widget-content-light"><strong>'.$q->title.'</strong>&nbsp;'.
											'<span style="font-size:.6em;">('.$status.')</span>'.
										'</h4>'.
									'</div>'.
									'<div class="widget-extra-full">'.
											'<img src="/images/q/'.$q->id.'.jpg" class="img-responsive" style="max-height:180px;">'.
											'<div class="caption">'.
												'<p></p>'.
												'<p style="overflow: hidden;height: 40px;">'.$q->content.'</p>'.
												'<p><a href="/quest/update?id='.$q->id.'" class="btn btn-primary btn-sm" role="button">Редактировать</a></p>'.
											'</div>'.
									'</div>'.
								'</div>'.
							'</div>';*/

						echo '<div class="col-xs-12 col-sm-6 col-lg-4 portfolio-item animation-fadeInQuick sortable_quest" data-id="'.$q->id.'" id="quest_'.$q->id.'">'.
								'<a href="/quest/update?id='.$q->id.'" class="widget " title="Редактировать">'.
									'<img src="/images/'.$q->cover.'" class="img-responsive">'.
									'<span class="portfolio-item-info"><strong>'.$q->title.'</strong>'.
										'<em class="pull-right">'.$status.'</em>'.
									'</span>'.
								'</a>'.
							'</div>';
					} ?>
					<script>
						$(function() {
							$( "#sortable" ).sortable({
								update:function(event, ui){
					        		var sort_result = {};
					        		sort_result['sort'] = {};

									$('.sortable_quest').each(function(k,v){
										sort_result['sort'][$(v).attr('data-id')] = k;
									});

									$.post('/quest/sort', sort_result, function(result){
										console.log(result);
									});
								}
							});
							$( "#sortable" ).disableSelection();
						});
					</script>
				<? } else  echo "<h2>В выбранном городе нет квестов</h2>"; ?>
			</div>
		</div>
	</div>
</div>
