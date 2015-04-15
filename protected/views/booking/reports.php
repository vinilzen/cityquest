<link rel="stylesheet" type="text/css" href="/css/proui/plugins-3.1.css">
<div class="block">
	<div class="block-title">
		<h2><?=Yii::t('app','Reports')?></h2>
	</div>
	<h3 class="sub-header hide">123</h3>
	<div class="row">
		<div class="col-sm-12">
			<div class="widget">
				<div class="widget-extra">
					<div class="row">
						<? if (count($quests)>0) { ?>
						<form action="" method="post" class="form-horisontal">
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label class="col-md-3 control-label"><?=Yii::t('app','Quests')?></label>
									<div class="col-md-9">
										<? foreach ($quests AS $q) { ?>
										<div class="checkbox">
											<label class="switch switch-success">
												<input type="checkbox" name="quest[<?=$q->id?>]" checked=""><span></span>
											</label>
											<?=$q->title;?>
										</div>
										<? } ?>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6">
								<div class="form-group">
									<label class="col-md-4 control-label" for="example-daterange1">
										
									</label>
									<div class="col-md-8">
										<div class="input-group input-daterange" data-date-format="mm/dd/yyyy">
											<input value="<?=$from?>" type="text" id="example-daterange1" name="from" class="form-control text-center" placeholder="<?=Yii::t('app','From')?>">
											<span class="input-group-addon"><i class="fa fa-angle-right"></i></span>
											<input value="<?=$to?>" type="text" id="example-daterange2" name="to" class="form-control text-center" placeholder="<?=Yii::t('app','To')?>">
										</div>
									</div>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group">
									<?=$message?>
								</div>
							</div>
							<div class="col-xs-12">
								<div class="form-group form-actions">
									<div class="col-xs-12">
										<button type="submit" class="btn btn-sm btn-primary">
											<?=Yii::t('app','Submit')?>
										</button>
									</div>
								</div>
							</div>
						</form>
						<? } else { ?>
							<p>У вас нет доступных квестов</p>
						<? } ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>