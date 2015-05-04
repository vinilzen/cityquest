<?php
/* @var $this DiscountsController */
/* @var $model Discounts */

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#discounts-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="block">
	<div class="block-title">
		<h2>
			<? if (Yii::app()->getModule("user")->user()->superuser == 1) { ?>
			<?=Yii::t('app','Manage Discounts')?>
			<small>
				<a href="/discounts/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
			<? } else { ?>
				<?=Yii::t('app','Discounts')?>
			<? }  ?>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<? 

			if (Yii::app()->getModule("user")->user()->superuser == 1) {
				$style = 'white-space:nowrap;text-align:right;';
			} else {
				$style = 'display:none;';
			}

			$this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'city-grid',
				'dataProvider'=>$model->search(),
				'cssFile'=>'',
				'htmlOptions'=>array('class'=>'table-responsive'),
				'itemsCssClass' => 'table table-striped table-responsive',
				'columns'=>array(
					'id',
					'key',
					'name',
					'amount',
					'till_what_time',
					array(
						'class'=>'CButtonColumn',
						'template' => '{update} {delete}',
						'htmlOptions' => array('style'=> $style),
						'buttons'=>array(
							'update' => array(
								'options' => array('class'=>'update btn btn-default btn-xs', 'title'=>'Редактировать'),
								'label' => '<i class="hi hi-pencil"></i>',
								'imageUrl' => false,
							),
							'delete' => array(
								'options' => array('class'=>'delete btn btn-default btn-danger btn-xs', 'title'=>'Удалить'),
								'label' => '<i class="hi hi-trash"></i>',
								'imageUrl' => false,
							),
						)
					),
				),
			)); ?>
		</div>
	</div>
</div>
