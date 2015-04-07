<?php
/* @var $this PaymentsController */
/* @var $model Payments */
?>
<div class="block">
	<div class="block-title">
		<h2>
			<?=Yii::t('app','Manage Payments')?>
			<small>
				<a href="/payments/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
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