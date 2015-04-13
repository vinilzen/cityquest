<li class="hidden hidden-lg">
	<a id="close_top_menu">
		<span aria-hidden="true">×</span><span class="sr-only">Close</span>
	</a>
</li>

<li class="<? if (Yii::app()->request->url == '/') echo ' active '; ?>">
	<a href="/">Квесты</a>
</li>

<li class="<? if (Yii::app()->request->url == '/rules') echo ' active '; ?>">
	<a href="/rules"><?=Yii::t('app','Rules')?></a>
</li>

<li class="<? if (Yii::app()->request->url == '/giftcard') echo ' active '; ?>">
  <a href="/giftcard"><?=Yii::t('app','Gift Card')?></a>
</li>

<li class="<? if (Yii::app()->request->url == '/franchise') echo ' active '; ?>">
  <a href="/franchise"><?=Yii::t('app','Franchise')?></a>
</li>


<li class="<? if (Yii::app()->request->url == '/contact') echo ' active '; ?>">
	<a href="/contact"><?=Yii::t('app','Contacts')?></a>
</li>

<? if (Yii::app()->getModule('user')->isAdmin()) { ?>
	<li style="margin:0;">
		<a href="/quest/adminschedule/ymd" style="opacity: 1;" title="<?=Yii::t('app','Admin panel')?>">
			<i style="font-size: 18px;" class="glyphicon glyphicon-cog"></i>
		</a>
	</li>
<? } else if (Yii::app()->getModule('user')->isModerator()) { ?>
	<li style="margin:0;">
		<a href="/quest/adminschedule/ymd" style="opacity: 1;" title="<?=Yii::t('app','Moderator panel')?>">
			<i style="font-size: 18px;" class="glyphicon glyphicon-cog"></i>
		</a>
	</li>
<? } ?>