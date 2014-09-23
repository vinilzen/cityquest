
<h1><?php echo UserModule::t("Manage Users"); ?></h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(UserModule::t('Create User'),array('create')),
		),
	));
?>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$dataProvider,
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("admin/view","id"=>$data->id))',
		),
		array(
			'name' => 'phone',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->phone), "tel:".$data->phone)',
		),
		array(
			'name'=>'email',
			'type'=>'raw',
			'value'=>'CHtml::link(CHtml::encode($data->email), "mailto:".$data->email)',
		),
		array(
			'name' => 'createtime',
			'value' => 'date("d.m.Y H:i:s",$data->createtime)',
		),
		array(
			'name' => 'lastvisit',
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
		),
		array(
			'name'=>'status',
			'value'=>'User::itemAlias("UserStatus",$data->status)',
		),
		array(
			'name'=>'superuser',
			'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{view} {update} {delete}',
			'htmlOptions' => array('style'=> 'white-space:nowrap;'),
			'buttons'=>array(
				'view' => array(
					'options' => array('class'=>'view btn btn-default btn-xs', 'title'=>'Смотреть'),
					'label' => '<i class="glyphicon glyphicon-eye-open"></i>',
					'imageUrl' => false,
				),
				'update' => array(
					'options' => array('class'=>'update btn btn-default btn-xs', 'title'=>'Редактировать'),
					'label' => '<i class="glyphicon glyphicon-pencil"></i>',
					'imageUrl' => false,
				),
				'delete' => array(
					'options' => array('class'=>'delete btn btn-default btn-xs', 'title'=>'Удалить'),
					'label' => '<i class="glyphicon glyphicon-trash"></i>',
					'imageUrl' => false,
				)
			)
		),
	),
)); ?>
