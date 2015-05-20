<?php
/* @var $this LocationController */
/* @var $model Location */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List Location', 'url'=>array('index')),
	array('label'=>'Manage Location', 'url'=>array('admin')),
);
?>

<div class="block">
	<div class="block-title">
		<h2>
			<?=Yii::t('app','Create')?> <?=Yii::t('app','Location')?>
			<small>
				<a href="/city/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?=$this->renderPartial('_form', 
				array(
					'model'=>$model,
					'cities'=>$cities,
				)
			)?>
		</div>
		<div class="col-sm-12">&nbsp;</div>
	</div>
</div>