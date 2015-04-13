<?php
/* @var $this QuestController */
/* @var $model Quest */
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