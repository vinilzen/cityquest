<?php $this->beginContent('/layouts/main'); ?>

<div class="row">
	<div class="col-sm-12">

	</div>
</div>
<div class="row">
	<!-- <div class="col-sm-12"> -->
		<!-- <div id="sidebar"> -->
			<?php // if(!Yii::app()->user->isGuest) $this->widget('UserMenu'); ?>
			<?php // $this->widget('TagCloud', array( 'maxTags'=>Yii::app()->params['tagCloudCount'], )); ?>
			<?php // $this->widget('RecentComments', array( 'maxComments'=>Yii::app()->params['recentCommentCount'], )); ?>
		<!-- </div> -->
	<!-- </div> -->

	<div class="col-sm-12">
		<?php echo $content; ?>
	</div>
</div>
<?php $this->endContent(); ?>