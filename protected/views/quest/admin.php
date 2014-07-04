<?php
/* @var $this QuestController */
/* @var $model Quest */

$this->breadcrumbs=array(
	'Quests'=>array('index'),
	'Manage',
);

$this->menu=array(
	array('label'=>'List Quest', 'url'=>array('index')),
	array('label'=>'Create Quest', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$('#quest-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Quests</h1>

<div class="row" id="sortable">
	<? foreach ($models AS $q) {

	echo '<div class="col-sm-4 col-md-4 sortable_quest" data-id="'.$q->id.'" id="quest_'.$q->id.'">'.
			'<div class="thumbnail">'.
				'<img src="/images/q/'.$q->id.'.jpg" class="img-responsive" style="max-height:220px;">'.
				'<div class="caption">'.
					'<h3>'.$q->title.'</h3>'.
					'<p style="overflow: hidden;height: 40px;">'.$q->content.'</p>'.
					'<p><a href="/quest/update?id='.$q->id.'" class="btn btn-primary" role="button">Edit</a></p>'.
				'</div>'.
			'</div>'.
		'</div>';
	}?>
<script>
	$(function() {
		$( "#sortable" ).sortable({
			update:function(event, ui){
        		var sort_result = {};
        		sort_result['sort'] = {};

				$('.sortable_quest').each(function(k,v){
					sort_result['sort'][$(v).attr('data-id')] = k;
				});

				console.log(sort_result);

				$.post('/quest/sort', sort_result, function(result){

					console.log(result);

				});
			}
		});
		$( "#sortable" ).disableSelection();
	});
</script>
</div>

<hr>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'quest-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'title',
		'content',
		'addres',
		'metro',
		'times',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
