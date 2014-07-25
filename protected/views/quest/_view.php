<?php
/* @var $this QuestController */
/* @var $data Quest */
?>

<div class="col-xs-12 col-md-6 col-sm-12 col-lg-6 col-xlg-4 item">
  <img alt="Generic placeholder image" class="featurette-image img-responsive" src="/images/q/<?php echo $data->id; ?>.jpg">
  <a class="descr" href="/quest/view?id=<?php echo $data->id; ?>">
      <h2><?php echo CHtml::encode($data->title); ?></h2>
      <p>
        <span>
        	<i class="ico-ppl"></i>
        	<i class="ico-ppl"></i>
        	<i class="ico-ppl noactive"></i>
        	<i class="ico-ppl noactive"></i>2 - 4 игрока</span><span>
        	<i class="ico-loc"></i><?php echo CHtml::encode($data->addres); ?></span>
      </p>
    </a>
</div>


<div class="col-sm-4 col-md-4 hidden">
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



