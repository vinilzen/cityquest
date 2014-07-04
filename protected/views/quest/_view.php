<?php
/* @var $this QuestController */
/* @var $data Quest */
?>

<div class="col-sm-4 col-md-4">
	<div class="view thumbnail">
		<img src="/images/q/<?php echo $data->id; ?>.jpg" alt="...">
		<div class="caption">
	        <h3><?php echo CHtml::link(CHtml::encode($data->title), array('view', 'id'=>$data->id)); ?></h3>

	        <p>
	        	<span><?php echo CHtml::encode($data->content); ?></span><br />
				
				
				<b><?php echo CHtml::encode($data->getAttributeLabel('addres')); ?>:</b> <?php echo CHtml::encode($data->addres); ?>
				<br />
				<b><?php echo CHtml::encode($data->getAttributeLabel('metro')); ?>:</b>	<?php echo CHtml::encode($data->metro); ?><br />
				
	<!-- 			<b><?php echo CHtml::encode($data->getAttributeLabel('times')); ?>:</b>
				<?php echo CHtml::encode($data->times); ?>
				<br /> -->

				<b><?php echo CHtml::encode($data->getAttributeLabel('status')); ?>:</b>
				<?php
				switch ($data->status) {
					case 3:
						$status_value = 'Вскоре';
						break;
					case 2:
						$status_value = 'Активен';
						break;
					default:
						$status_value = 'Черновик';
						break;
				}
				echo CHtml::encode($status_value); ?>
			</p>
	     </div>
	</div>
</div>



