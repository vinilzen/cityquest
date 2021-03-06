<?php
/* @var $this LocationController */
/* @var $model Location */

$this->breadcrumbs=array(
	'Locations'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Location', 'url'=>array('index')),
	array('label'=>'Create Location', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#location-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="block">
	<div class="block-title">
		<h2>
			<?=Yii::t('app','Locations')?> 
			<small>
				<a href="/location/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'city-grid',
				'dataProvider'=>$model->search(),
				'cssFile'=>'',
				'htmlOptions'=>array('class'=>'table-responsive'),
				'itemsCssClass' => 'table table-striped table-responsive',
				'columns'=>array(
					'id',
					'name',
					'tel',
					'notification_email',
					'metro',
					'address',
					'address_additional',
					'city_id',
					array(
						'class'=>'CButtonColumn',
						'template' => '{update} {delete}',
						'htmlOptions' => array('style'=> 'white-space:nowrap;text-align:right;'),
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
