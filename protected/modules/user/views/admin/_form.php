<div class="col-sm-6">
	<div class="form">

	<?php echo CHtml::beginForm('','post',array('enctype'=>'multipart/form-data', 'class'=>'form-horizontal')); ?>

		<?php echo CHtml::errorSummary(array($model)); ?>

		<div class="form-group">
			<div class="my_form_label col-sm-5"></div>
			<div class="my_form_control col-sm-7 ">
				<span class="note">
					<?php echo UserModule::t('Fields with <span class="required">*</span> are required.'); ?>
				</span>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'name',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeTextField($model,'username',array('class'=>'form-control', 'maxlength'=>20)); ?>
				<?php echo CHtml::error($model,'username'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'password',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activePasswordField($model,'password',array('class'=>'form-control', 'maxlength'=>128)); ?>
				<?php echo CHtml::error($model,'password'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'phone',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeTextField($model,'phone',array('class'=>'form-control', 'maxlength'=>18)); ?>
				<?php echo CHtml::error($model,'phone'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'username',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeTextField($model,'email',array('class'=>'form-control', 'maxlength'=>128)); ?>
				<?php echo CHtml::error($model,'email'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'superuser',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeDropDownList($model,'superuser',User::itemAlias('AdminStatus'),array('class'=>'form-control')); ?>
				<?php echo CHtml::error($model,'superuser'); ?>
			</div>
		</div>

		<div class="form-group">
			<?php echo CHtml::activeLabelEx($model,'status',array('class'=>'control-label my_form_label col-sm-5')); ?>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::activeDropDownList($model,'status',User::itemAlias('UserStatus'),array('class'=>'form-control')); ?>
				<?php echo CHtml::error($model,'status'); ?>
			</div>
		</div>

		<? if ($model->superuser == 2) { ?>

			<div class="form-group set_moderator_quests">
				<?=CHtml::activeLabelEx($model,'quests',array('class'=>'control-label my_form_label col-sm-5'))?>
				<!-- <div class="my_form_control col-sm-7 ">
					<?php echo CHtml::checkBoxList('User[quests][]', explode(',', $model->quests), $quests); ?>
					<?php echo CHtml::error($model,'quests'); ?>
				</div> -->
				<? $user_quests_array = explode(',', $model->quests); ?>
				<div class="my_form_control col-sm-7 ">
					<ul class="list-unstyled">
					<? foreach ($cities as $city) {
						$quests_str = '';

						foreach ($quests_obj as $quest) {
							if ($quest->city_id == $city->id) {
								$checked = '';
								if (in_array($quest->id, $user_quests_array)){
									$checked = 'checked';
								}
								$quests_str .= '<li>';
								$quests_str .=  '<input value="'.$quest->id.'" id="User_quests_'.$quest->id.'" type="checkbox" '.
												'name="User[quests][]" data-city="'.$city->id.'" '.$checked.'> ';
								$quests_str .=  '<label for="User_quests_'.$quest->id.'">'.$quest->title.''.
												'</label>';
								$quests_str .= '</li>';
							}
						}

						$dis = '';
						if ($quests_str == '') {
							$dis = 'disabled="disabled"';
						}
						echo '<li>'.
								'<input value="'.$city->id.'" id="City_'.$city->id.'" '.$dis.' type="checkbox" name="City"> '.
								'<label for="City_'.$city->id.'">'.$city->name.'</label>'.
								' <span style="cursor:pointer;font-size: 16px;line-height: 1;color:blue;padding-bottom: 3px;" class="show_qs btn btn-default btn-xs" data-city="'.$city->id.'">+</span>';

						if ($quests_str != '') {
							echo '<ul class="list-unstyled city-list-'.$city->id.'" style="padding-left:10px; overflow:hidden; height:0;">'.$quests_str.'</ul>';
						}

						echo '</li>';
					} ?>
					</ul>
				</div>
			</div>
		<?php } ?>


		<? if ($model->superuser == 3) { ?>
			<div class="form-group set_moderator_quests">
				<?=CHtml::activeLabelEx($model,'locations',array('class'=>'control-label my_form_label col-sm-5'))?>
				<? $user_locations_array = explode(',', $model->locations); ?>
				<div class="my_form_control col-sm-7 ">
					<ul class="list-unstyled">
					<? foreach ($locations_obj as $location) {

						$checked = (in_array($location->id, $user_locations_array)) ? 'checked' : '';

						echo
						'<li>'.
							'<input value="'.$location->id.'" id="User_locations_'.$location->id.'" type="checkbox" '.
								'name="User[locations][]" '.$checked.'> '.
							'<label for="User_locations_'.$location->id.'">'.$location->name.'</label>'.
						'</li>';

					} ?>
					</ul>
				</div>
			</div>				
		<? } ?>

		<div class="form-group buttons">
			<div class="my_form_label col-sm-5"></div>
			<div class="my_form_control col-sm-7 ">
				<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Сохранить', array('class'=>'btn btn-default')); ?>
			</div>
		</div>


	<?php echo CHtml::endForm(); ?>

	</div>
</div>