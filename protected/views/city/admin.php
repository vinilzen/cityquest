<?php
/* @var $this CityController */
/* @var $model City */

$this->breadcrumbs=array(
	'Cities'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List City', 'url'=>array('index')),
	array('label'=>'Create City', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#city-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div class="block">
	<div class="block-title">
		<h2>
			Управление городами
			<small>
				<a href="/city/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?=CHtml::link('Advanced Search','#',array('class'=>'search-button'))?>
			<div class="search-form" style="display:none">
			<?php $this->renderPartial('_search',array('model'=>$model)); ?>
			</div><!-- search-form -->

			<?php $this->widget('zii.widgets.grid.CGridView', array(
				'id'=>'city-grid',
				'dataProvider'=>$model->search(),
				// 'filter'=>$model,
				'columns'=>array(
					'id',
					'name',
					'active',
					'country',
					'languages',
					array(
						'class'=>'CButtonColumn',
						'template' => '{update} {delete} {view}',
						'htmlOptions' => array('style'=> 'white-space:nowrap;'),
						'buttons'=>array(
							'update' => array(
								'options' => array('class'=>'update btn btn-default btn-xs', 'title'=>'Редактировать'),
								'label' => '<i class="hi hi-pencil"></i>',
								'imageUrl' => false,
							),
							'delete' => array(
								'options' => array('class'=>'delete btn btn-default btn-xs', 'title'=>'Удалить'),
								'label' => '<i class="hi hi-trash"></i>',
								'imageUrl' => false,
							),
							'view' => array(
								'options' => array('class'=>'view btn btn-default btn-xs', 'title'=>'Смотреть'),
								'label' => '<i class="hi hi-eye-open"></i>',
								'imageUrl' => false,
							),
						)
					),
				),
			)); ?>
		</div>
	</div>
</div>
