<?php
/* @var $this CityController */
/* @var $dataProvider CActiveDataProvider */

?>

<h1><?=Yii::t('app','Cities')?></h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
