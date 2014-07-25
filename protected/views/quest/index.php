<?php
/* @var $this QuestController */
/* @var $dataProvider CActiveDataProvider */

if (Yii::app()->user->name == 'admin' ){
	$this->menu=array(
		array('label'=>'Сводная таблица', 'url'=>array('quest/adminschedule/ymd')),
		array('label'=>'Управление квестами', 'url'=>array('admin')),
		array('label'=>'Создать новый квест', 'url'=>array('create')),
	);
}


Yii::import('zii.widgets.CListView');

class PlainCListView extends CListView
{
	public function renderItems()
	{
	    $data=$this->dataProvider->getData();
	    if(($n=count($data))>0)
	    {
	        $owner=$this->getOwner();
	        $render=$owner instanceof CController ? 'renderPartial' : 'render';
	        $j=0;
	        foreach($data as $i=>$item)
	        {
	            $data=$this->viewData;
	            $data['index']=$i;
	            $data['data']=$item;
	            $data['widget']=$this;
	            $owner->$render($this->itemView,$data);
	            if($j++ < $n-1)
	                echo $this->separator;
	        }

	    } else $this->renderEmptyText();
	}
}

?>

<?php $this->widget('zii.widgets.PlainCListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view'
)); ?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProviderSoon,
	'itemView'=>'_view_soon',
	'summaryText'=>'',
    'enablePagination' => false,
    'enableSorting' => false,
	'template'   => '{items}'
)); ?>