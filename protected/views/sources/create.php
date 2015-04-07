<?php
/* @var $this SourcesController */
/* @var $model Sources */
?>

<div class="block">
	<div class="block-title">
		<h2><?=Yii::t('app','Create Sources')?></h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
	</div>