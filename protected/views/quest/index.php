<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

$this->breadcrumbs=array(
	'Quests',
);

if (Yii::app()->user->name == 'admin' ){
	$this->menu=array(
		array('label'=>'Create Quest', 'url'=>array('create')),
		array('label'=>'Manage Quest', 'url'=>array('admin')),
	);
}
?>

<h1>Quests</h1>
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
