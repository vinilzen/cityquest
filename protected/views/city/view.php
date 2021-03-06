<?php
/* @var $this CityController */
/* @var $model City */

?>

<h1>View City #<?php echo $model->id; ?></h1>

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'active',
		'country',
		'languages',
		'subdomain',
		'tel',
		'addres',
		'giftcard_text',
		'franchise_text',
		'giftcard_mail',
		'contact_mail',
		'booking_alert_mail',
		'vk_link',
		'fb_link',
		'instagram_link',
	),
)); ?>
