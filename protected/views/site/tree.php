<h2>TreeView</h2>

<?php $this->widget('CTreeView',
	array(
		'data'=>$data,
		'animated'=>'normal',
		'collapsed'=>true,
		'htmlOptions'=>array('class'=>'treeview-gray'))); ?>

<h2>TreeView Async</h2>

<?php $this->widget('CTreeView',
	array(
		'url'=>array('treeFill'),
		'animated'=>'normal',
		'htmlOptions'=>array('class'=>'treeview-red'))); ?>
