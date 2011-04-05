<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Evaluation'; ?>
<div id="content">
    <?php if(count($Project->alternatives) > 1 && count($Project->criteria) > 1) { ?>
        <p>Fill out the statements by moving the sliders to the appropriate location.</p>
        <?php echo $this->renderPartial('_form', array('eval' => $eval, 'sortType' => $sortType)); ?>
        <?php //echo CHtml::link('Continue', array('results/display'), array('class' => 'button right', 'id' => 'continue')); ?>
    <?php } else { ?>
        <h2>Criteria or alternatives missing</h2>
        <p>In order to perform an evaluation you must define between two (2) and ten (10) criteria, and between two (2) and ten (10) alternatvies. Once you have done so, return to this page for evaluation.</p>
    <?php }?>
</div>