<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	'Quests'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
	array('label'=>'Управление квестами', 'url'=>array('admin')),
	array('label'=>'Список квестов', 'url'=>array('index')),
);
?>

<div class="block">
	<div class="block-title">
		<h2>Создать квест</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php $this->renderPartial('_form', array('model'=>$model, 'cities' => $cities)); ?>
		</div>
	</div>