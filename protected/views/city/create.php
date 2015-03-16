<?php
/* @var $this CityController */
/* @var $model City */

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Manage City', 'url'=>array('admin')),
);
?>
<div class="block">
	<div class="block-title">
		<h2>
			Добавить город
			<small>
				<a href="/city/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?=$this->renderPartial('_form', array('model'=>$model))?>
		</div>
		<div class="col-sm-12">&nbsp;</div>
	</div>
</div>