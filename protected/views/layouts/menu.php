<li class="hidden hidden-lg">
	<a id="close_top_menu" type="button">
		<span aria-hidden="true">×</span><span class="sr-only">Close</span>
	</a>
</li>

<li class="<? if (Yii::app()->request->url == '/') echo ' active '; ?>">
	<a href="/">Квесты</a>
</li>


<!-- <li class="<? if (strpos(Yii::app()->request->url, '/quest/schedule/ymd/') === 0 ) echo ' active '; ?>"><a href="/quest/schedule/ymd/">Расписание</a></li> -->

<li class="<? if (Yii::app()->request->url == '/rules') echo ' active '; ?>">
	<a href="/rules">Правила</a>
</li>

<li class="<? if (Yii::app()->request->url == '/giftcard') echo ' active '; ?>">
  <a href="/giftcard">Подарочная карта </a>
</li>

<li class="<? if (Yii::app()->request->url == '/franchise') echo ' active '; ?>">
  <a href="/franchise">Франшиза </a>
</li>


<li class="<? if (Yii::app()->request->url == '/contact') echo ' active '; ?>">
	<a href="/contact">Контакты</a>
</li>

<? if (Yii::app()->getModule('user')->isAdmin()) { ?>
	<li style="margin:0;">
		<a href="/quest/adminschedule/ymd" style="opacity: 1;" title="Панель администратора">
			<i style="font-size: 18px;" class="glyphicon glyphicon-cog"></i>
		</a>
	</li>
<? } else if (Yii::app()->getModule('user')->isModerator()) { ?>
	<li style="margin:0;">
		<a href="/quest/adminschedule/ymd" style="opacity: 1;" title="Панель модератора">
			<i style="font-size: 18px;" class="glyphicon glyphicon-cog"></i>
		</a>
	</li>
<? } ?>