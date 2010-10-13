<?php $this->pageTitle = Yii::app()->name . ' / ' . CHtml::encode($Project->title) . ' / ' . ' Evaluation'; ?>
<h1>Evaluation</h1>
<?php if(count($Project->alternatives) > 1 && count($Project->criteria) > 1) { ?>
    <?php echo CHtml::link((($sortType == 'criteria') ? 'Group by alternatives' : 'Group by criteria'), array('evaluation/evaluate'), array('class' => 'button', 'id' => (($sortType == 'criteria') ? 'sortByAlternatives' : 'sortByCriteria'))); ?>
    <?php echo $this->renderPartial('_form', array('eval' => $eval, 'sortType' => $sortType)); ?>
    <?php echo CHtml::link('Continue', array('evaluation/evaluate'), array('class' => 'button right', 'id' => 'continue')); ?>
<?php } else { ?>
    <h2>Criteria or alternatives missing</h2>
    <p>In order to perform an evaluation you must define between two (2) and ten (10) criteria, and between two (2) and ten (10) alternatvies. Once you have done so, return to this page for evaluation.</p>
<?php }?>