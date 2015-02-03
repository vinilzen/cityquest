<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	'Quests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
	// array('label'=>'Управление квестами', 'url'=>array('admin')),
	// array('label'=>'Создать новый квест', 'url'=>array('create')),
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
});
");
?>

<h1 class="page-header">
	Управление квестами
	<small>
		<a href="/quest/create">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</a>
	</small>
</h1>

<?php
	echo CHtml::dropDownList(
		'cities',
		$selected_city,
		CHtml::listData($cities, 'id', 'name'),
		array(
			'onchange'=>'window.location.href = "/quest/admin?selected_city="+this.value;'
		)
	);
?>

<div class="row" id="sortable">
	<? if (count($models)>0) {
		foreach ($models AS $q) {
			echo '<div class="col-sm-6 col-md-4 col-lg-3 sortable_quest" data-id="'.$q->id.'" id="quest_'.$q->id.'">'.
					'<div class="thumbnail">'.
						'<img src="/images/q/'.$q->id.'.jpg" class="img-responsive" style="max-height:180px;">'.
						'<div class="caption">'.
							'<h4 style="max-height: 37px; height: 37px; overflow: hidden;">'.$q->title.'</h4>'.
							'<p style="overflow: hidden;height: 40px;">'.$q->content.'</p>'.
							'<p><a href="/quest/update?id='.$q->id.'" class="btn btn-primary btn-sm" role="button">Редактировать</a></p>'.
						'</div>'.
					'</div>'.
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
