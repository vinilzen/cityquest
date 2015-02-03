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

<h1 class="page-header">Создать квест</h1>

<?php $this->renderPartial('_form', array('model'=>$model, 'cities' => $cities)); ?>