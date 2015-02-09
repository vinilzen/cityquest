

<h1>
	<?php echo UserModule::t('View User').' "'.$model->username.'"'; ?>
	<small>
		<a href="/user/admin/create">
			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
		</a>
	</small>
</h1>

<?php echo $this->renderPartial('_menu', array(
		'list'=> array(
			CHtml::link(UserModule::t('Update User'),array('update','id'=>$model->id)),
		),
	)); 


	$attributes = array(
		'id',
		'username',
	);
	
	if ($model->superuser == 2){
		array_push($attributes,
			'password',
			'email',
			'activkey',
			'phone',
			array(
				'name' => 'createtime',
				'value' => date("d.m.Y H:i:s",$model->createtime),
			),
			array(
				'name' => 'lastvisit',
				'value' => (($model->lastvisit)?date("d.m.Y H:i:s",$model->lastvisit):UserModule::t("Not visited")),
			),
			array(
				'name' => 'superuser',
				'value' => User::itemAlias("AdminStatus",$model->superuser),
			),
			array(
				'name' => 'status',
				'value' => User::itemAlias("UserStatus",$model->status),
			),
			array(
				'name' => 'quests',
				'value' => User::listQuests($quests),
			)
		);
	} else {

		array_push($attributes,
			'password',
			'email',
			'activkey',
			'phone',
			array(
				'name' => 'createtime',
				'value' => date("d.m.Y H:i:s",$model->createtime),
			),
			array(
				'name' => 'lastvisit',
				'value' => (($model->lastvisit)?date("d.m.Y H:i:s",$model->lastvisit):UserModule::t("Not visited")),
			),
			array(
				'name' => 'superuser',
				'value' => User::itemAlias("AdminStatus",$model->superuser),
			),
			array(
				'name' => 'status',
				'value' => User::itemAlias("UserStatus",$model->status),
			)
		);
	
	}
	$this->widget('zii.widgets.CDetailView', array(
		'data'=>$model,
		'attributes'=>$attributes,
	));
	

?>

<div class="panel panel-default">
  <div class="panel-heading">
    <h3 class="panel-title">Бронирования пользователя</h3>
  </div>
  <div class="panel-body">
	<div class="container-fluid">
	  <ul class="nav nav-tabs" role="tablist">
	      <li class="active"><a href="#next_books" role="tab" data-toggle="tab">Активные квесты</a></li>
	      <li><a href="#prev_books" role="tab" data-toggle="tab">Прошедшие квесты</a></li>
	  </ul>
	  <div class="tab-content">
	    <div class="tab-pane" id="prev_books">

	      <? if (isset($bookings_old) && count($bookings_old)>0) foreach($bookings_old AS $book) { ?> 

	      <div class="row ModalBook" id="row_book_<? echo $book->id; ?>">
	        <div class="col-sm-6 col-xs-12">
	          <a class="descr" href="/quest/view?id=<? echo $book->quest->id; ?>" target="_blank">
	              <h2><? echo $book->quest->title; ?></h2>
	            </a>
	        </div>
	        <div class="col-sm-6 col-xs-12 shad">
	          <div class="text-center">
	            <p>
	              <?
	                $week=array(0=>"Воскресенье", "Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
	                $st = substr($book->date, -4, 2).'/'.substr($book->date, -2, 2).'/'.substr($book->date, 0, 4);
	                $time = strtotime($st);
	                echo $week[date('w',$time)];
	               ?> 
	              <? echo substr($book->date, -2, 2); ?>.<? echo substr($book->date, -4, 2); ?> в <? echo $book->time; ?>
					<br>
	            <? echo $book->price; ?> руб. - 
	            <!-- <div class="btn btn-default btn-success">ПОдтвержден<i class="glyphicon glyphicon-ok"></i></div> -->
	            <? if ($book->result == '00:00' || $book->result == '60' || $book->result == '0' || $book->result == '00' || $book->result == '') { ?>
	              <span>Квест не пройден</span>
	            <? } else { ?>
	              <span>Результат <? echo $book->result ?></span>
	            <? } ?>
	            </p>
	          </div>
	        </div>
	      </div>
	      <div class="row" id="row_fade_<? echo $book->id; ?>"><div class="col-xs-12"><hr class="fadeOut p10"></div></div>

	      <? } else {  echo 'Пусто'; } ?>      
	    </div>
	    <div class="tab-pane active" id="next_books">

	      <? if (isset($bookings) && count($bookings)>0) foreach($bookings AS $book) { ?> 

	      <div class="row ModalBook" id="row_book_<? echo $book->id; ?>">
	        <div class="col-sm-6 col-xs-12">
	          <a class="descr" href="/quest/view?id=<? echo $book->quest->id; ?>" target="_blank">
	              <h2><? echo $book->quest->title; ?></h2>
	            </a>
	        </div>
	        <div class="col-sm-6 col-xs-12 shad">
	          <div class="text-center">
	            <h3>Предстоящий квест</h3>
	            <p>
	              <?
	                $week=array(0=>"Воскресенье", "Понедельник","Вторник","Среда","Четверг","Пятница","Суббота");
	                $st = substr($book->date, -4, 2).'/'.substr($book->date, -2, 2).'/'.substr($book->date, 0, 4);
	                $time = strtotime($st);
					echo $week[date('w',$time)]; ?> <? echo substr($book->date, -2, 2); ?>.<? echo substr($book->date, -4, 2); ?> в <? echo $book->time;
				  ?>
					<br>
	              <? echo $book->price; ?> руб.
	            	- <span>Подтвержден</span>
	            </p>
	          </div>
	        </div>
	      </div>
	      <div class="row" id="row_fade_<? echo $book->id; ?>"><div class="col-xs-12"><hr class="fadeOut p10"></div></div>

	      <? } else {  echo 'Пусто'; } ?>   

	    </div>
	  </div>
	</div>
  </div>
</div>
