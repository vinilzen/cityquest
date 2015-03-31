<div class="block">
	<div class="block-title">
		<h2>
			<?php echo UserModule::t("Manage Users"); ?>
			<small>
				<a href="/user/admin/create"><i class="hi hi-plus" aria-hidden="true"></i></a>
			</small>
		</h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
<? 
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});	
$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array('model'=>$model)); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
    // 'rowCssClassExpression'=>'(($data->superuser==2) ? "info":"").(($data->superuser==1) ? "danger":"")',
    'pagerCssClass'=>'dataTables_paginate paging_bootstrap',
    'pager'=>array(
    	'htmlOptions'=>array(
    		'class'=>'pagination pagination-sm remove-margin',
    	),
    	'lastPageLabel'=>'>>',
    	'firstPageLabel'=>'<<',
    	'nextPageLabel'=>'>',
    	'prevPageLabel'=>'<',
    	'header'=>'',
    	'selectedPageCssClass'=>'active'
    ),
	'htmlOptions'=>array(
		'class'=>'table-responsive',
    	'style'=>'margin-bottom:20px;'
    ),
    'filter'=>$model,
	'cssFile'=>'',
	'itemsCssClass' => 'table table-striped',
	'columns'=>array(
		array(
			'name' => 'id',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
			'filter'=>'',
		),
		array(
			'name' => 'username',
			'type'=>'raw',
			'value' => 'CHtml::link(CHtml::encode($data->username),array("admin/view","id"=>$data->id));',
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
			'filter'=>'',
		),
		array(
			'name' => 'lastvisit',
			'value' => '(($data->lastvisit)?date("d.m.Y H:i:s",$data->lastvisit):UserModule::t("Not visited"))',
			'filter'=>'',
		),
		array(
			'name'=>'superuser',
			'value'=>'CHtml::link(
					CHtml::encode( User::itemAlias("AdminStatus",$data->superuser) ),
					"#",
					array("class"=>"label label-".(($data->superuser==1)?"danger":(($data->superuser==2)?"info":"success")))
				)',
			// 'value'=>'User::itemAlias("AdminStatus",$data->superuser)',
			'filter'=>'',
			'type'=>'raw',
		),
		array(
			'class'=>'CButtonColumn',
			'template' => '{update} {delete} {viewfb} {viewvk}',
			'htmlOptions' => array('style'=> 'white-space:nowrap;'),
			'buttons'=>array(
				'update' => array(
					'options' => array('class'=>'update btn btn-default btn-xs', 'title'=>'Редактировать'),
					'label' => '<i class="hi hi-pencil"></i>',
					'imageUrl' => false,
				),
				'delete' => array(
					'options' => array('class'=>'delete btn btn-danger btn-default btn-xs', 'title'=>'Удалить'),
					'label' => '<i class="hi hi-trash"></i>',
					'imageUrl' => false,
				),
				'viewfb' => array(
					'options' => array('class'=> 'view btn btn-default btn-xs', 'title'=>'Профиль в Facebook', 'target' => '_blank'),
					'label' => '<svg  style="width:14px; height:14px;top: 2px;position: relative;" height="12px" id="Layer_1" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="12px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="social_x5F_3"><g><ellipse cx="255.672" cy="255.758" rx="256" ry="255.828" style="fill:#6D85B4;"/><path d="M255.672,511.586c141.386,0,256-114.537,256-255.828c0-68.754-27.191-131.121-71.346-177.09    L76.119,438.054C122.328,483.511,185.71,511.586,255.672,511.586z" style="fill:#5B6F98;"/><path d="M290.145,83.166c-84.496,18.465-83.43,82.326-83.43,82.326v35.205v47.589h-50.322v78.681h50.322    l-0.351,181.258c15.854,3.068,32.209,3.705,48.958,3.705c18.486,0,36.501-0.981,53.878-4.703l0.351-180.26h76.482l7.447-78.681    H309.55v-47.589c0-63.119,85.994-32.084,85.994-32.084l11.551-79.703C407.096,88.91,349.416,70.259,290.145,83.166z" style="fill:#FFFFFF;"/><g><path d="M206.715,326.967l-0.352,179.834c15.959,3.115,32.435,4.785,49.309,4.785     c18.363,0,36.261-1.973,53.528-5.644l0.351-178.977h76.482l7.447-78.681H309.55v-40.573L188.695,326.966L206.715,326.967     L206.715,326.967z" style="fill:#F1F2F2;"/><path d="M356.825,161.064c19.98,0.792,38.72,7.549,38.72,7.549l7.737-53.395L356.825,161.064z" style="fill:#F1F2F2;"/></g></g></g><g id="Layer_1_1_"/></svg>',
					'imageUrl' => false,
					'url' => 'CHtml::normalizeUrl($data->fb_link)',
					'visible' => '$data->fb_link != ""'
									),
				'viewvk' => array(
					'options' => array('class'=>'btn btn-default btn-xs', 'title'=>'Профиль в VK', 'target' => '_blank'),
					'label' => '<svg style="width:14px; height:14px;top: 2px;position: relative;" enable-background="new 0 0 512 512" id="Layer_1" version="1.1" viewBox="0 0 512 512" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M256,512C114.6,512,0,397.4,0,256C0,114.6,114.6,0,256,0c141.4,0,256,114.6,256,256  C512,397.4,397.4,512,256,512z" fill="#4C75A3"/><g id="Layer_1_1_"/><path d="M256,512c141.4,0,256-114.6,256-256c0-68.2-26.7-130-70.1-175.9L77.7,439.7C123.8,484.4,186.7,512,256,512z" fill="#466C96"/><path d="M282.6,212.5c0,8,0,16,0,24.1c0,1.3,0,2.6,0.2,3.9c0.7,5.2,1.2,11.1,6.9,13.1c5.2,1.8,8.6-2.9,11.6-6.3  c14.5-16.4,24.7-35.4,33.4-55.3c1.8-4.1,3.4-8.2,5.2-12.4c1.9-4.4,5-6.6,10-6.5c17.4,0.1,34.7,0,52.1,0.1c1.8,0,3.7,0.3,5.5,0.8  c7,1.7,8.8,4.8,6.8,11.8c-2.6,9.5-7.9,17.6-13.3,25.7c-9.2,13.8-19.8,26.6-29.6,40c-11.7,16-11.4,20,3,33.5  c12,11.2,24,22.4,33.7,35.8c2.4,3.3,4.6,6.8,6.1,10.6c2.2,5.9,0.5,10.3-5.1,12.9c-3.2,1.5-6.6,2.3-10.3,2.3  c-14.6-0.1-29.1,0.1-43.7,0c-9.8,0-17.6-4.7-24.2-11.3c-6.1-6-11.6-12.6-17.4-18.9c-3.2-3.4-6.3-6.9-10.3-9.4  c-6.3-4-11.8-2.7-15.4,3.9c-3.7,6.7-4.5,14.2-4.8,21.6c-0.5,10.8-3.9,13.6-14.9,14.2c-23.8,1.2-46.4-2.7-67.2-14.8  c-17.8-10.4-31.5-24.9-43.6-41.2c-23.9-32.4-42.2-68-58.7-104.7c-3.7-8.2-0.9-12.6,8.2-12.8c14.9-0.3,29.9-0.2,44.8,0  c6.1,0.1,10.4,3.1,12.8,9c8.1,19.7,17.8,38.6,30,56.1c3.6,5.2,7.3,10.5,12.6,14.1c5.4,3.7,9.4,2.4,12-3.6c1.8-4.4,2.4-9,2.8-13.6  c1.1-13.2,1-26.5-0.7-39.6c-1.2-8.9-6-14.8-15-16.5c-4.6-0.9-3.6-2.6-1.5-5c3.7-4.3,8.8-6.4,14.2-7c17.4-2.2,34.9-2.9,52.3,0.5  c8.3,1.6,10.7,4.8,12,13.2C284.6,191.3,282.2,201.9,282.6,212.5z" fill="#FCFDFD"/><path d="M334.7,192c-8.7,19.9-19,38.9-33.4,55.3c-3,3.4-6.3,8.1-11.6,6.3c-5.7-2-6.2-7.8-6.9-13.1  c-0.1-1-0.2-2.1-0.2-3.1l-90.2,89.1c2.7,1.9,5.5,3.7,8.4,5.5c20.8,12.2,43.4,16,67.2,14.8c11-0.5,14.4-3.4,14.9-14.2  c0.3-7.5,1.2-14.9,4.8-21.6c3.6-6.6,9.1-7.9,15.4-3.9c4,2.5,7.1,6,10.3,9.4c5.8,6.3,11.3,12.9,17.4,18.9  c6.6,6.6,14.4,11.3,24.2,11.3c14.6,0,29.1-0.1,43.7,0c3.6,0,7-0.8,10.3-2.3c5.6-2.6,7.3-7.1,5.1-12.9c-1.4-3.9-3.7-7.3-6.1-10.6  c-9.6-13.4-21.7-24.6-33.7-35.8c-14.4-13.5-14.8-17.5-3-33.5c9.8-13.4,20.5-26.2,29.6-40c5.4-8.1,10.7-16.2,13.3-25.7  c2-7,0.1-10.2-6.8-11.8c-1.8-0.4-3.7-0.8-5.5-0.8c-17.4-0.1-34.7,0.1-52.1-0.1c-0.8,0-1.6,0.1-2.3,0.2l-8.5,8.4  C337.6,185.1,336.2,188.6,334.7,192z" fill="#F1F2F2"/></svg>',
					'imageUrl' => false,
					'url' => 'CHtml::normalizeUrl("http://vk.com/id".$data->vk_id)',
					'visible' => '(int)$data->vk_id > 0'
				),
			)
		),
	),
)); ?>
