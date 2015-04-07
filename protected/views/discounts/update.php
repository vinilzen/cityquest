<?php
/* @var $this DiscountsController */
/* @var $model Discounts */

?>

<div class="block">
	<div class="block-title">
		<h2>
			<?=Yii::t('app','Update Discounts')?> "<?=$model->name?>"
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php $this->renderPartial('_form', array('model'=>$model)); ?>
		</div>
		<div class="col-sm-12">&nbsp;</div>
	</div>
</div>
