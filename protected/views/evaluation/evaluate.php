<?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Evaluation'; ?>
<h1>Evaluation</h1>
<?php if(count($Project->alternatives) > 1 && count($Project->criteria) > 1) { ?>
<p>Evaluate each alternative by defined criteria. Just move the sliders to the positions that best describe the actual value. You may return here at any time to modify these values.</p>
<?php echo $this->renderPartial('_form', array('eval' => $eval, 'sortType' => $sortType)); ?>
<?php } else { ?>
<h2>Criteria or alternatives missing</h2>
<p>In order to perform an evaluation you must define between two (2) and ten (10) criteria, and between two (2) and ten (10) alternatvies. Once you have done so, return to this page for evaluation.</p>
<?php }?>