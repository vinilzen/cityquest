<div class="block">
	<div class="block-title">
		<h2><?="#".$model->id.' '.$model->username?></h2>
	</div>
	<div class="row">
		<div class="col-sm-12">
			<?=$this->renderPartial('_form', array(
					'model'=>$model,
					'quests'=>$quests,
					'quests_obj'=>$quests_obj,
					'cities'=>$cities,
				))?>
		</div>
	</div>
</div>