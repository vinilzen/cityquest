<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Quests',
);

if (Yii::app()->user->name == 'admin' ){
	$this->menu=array(
		array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
		array('label'=>'Управление квестами', 'url'=>array('admin')),
		array('label'=>'Создать новый квест', 'url'=>array('create')),
	);
}
?>

<h1 class="page-header">Квесты</h1>
<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<div class="clearfix"></div>

<hr>
<h2>Вскоре</h2>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProviderSoon,
	'itemView'=>'_view_soon',
)); ?>
