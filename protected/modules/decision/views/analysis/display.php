<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Analysis'; ?>

<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>

<section class="content">
<div id="accordion">
    <div>
        <h1>Results</h1>
        <p>This graph shows you total scores. The best scoring alternative is at the top, having 100 points. All other alternative's scores are calculated relative to the best scoring alternative.</p>
        <div class="sidebar help">
            <h2>Which one do I choose?</h2>
            <p>This is the hard part. Although the first alternative is usually the best, it's not a general rule. Use the detailed comparison below to see how they really compare.</p>
            <h2>Changed your mind?</h2>
            <p class="l">You may return to modify criteria, alternatives or evaluation at any time.</p>
            <div class="last"></div>
        </div>
        <div id="score" class="content">
            <table class="alternatives">
                <?php foreach($bestAlternatives as $A) { ?>
                <tr>
                    <td><?php echo CHtml::encode($A->title); ?></td>
                </tr>
                <?php }?>
            </table>
            <table class="scale">
                <tr>
                    <td>0</td>
                    <td>10</td>
                    <td>20</td>
                    <td>30</td>
                    <td>40</td>
                    <td>50</td>
                    <td>60</td>
                    <td>70</td>
                    <td>80</td>
                    <td>90</td>
                    <td>100</td>
                </tr>
            </table>
        </div>
            <p><b><?php echo CHtml::encode($first->title); ?></b> scores the highest with a lead of <b><?php echo $difference; ?> points</b> compared to <b><?php  echo CHtml::encode($second->title); ?></b></p>
    </div>
    <div>
    <h1>Detailed comparison</h1>
    <p>This graph shows alternative profiles based on your evaluation. By comparing the data points at each criteria you are able to see how each alternative compares to others. You can add or remove alternatives from the graph. Do you still think the first one is the best?</p>
        <div id="abacon-sidebar" class="sidebar">
            <form method="post" action="">
                <fieldset>
                    <select name="legend">
                        <?php foreach($Alternatives as $A) { ?>
                            <option value="<?php echo $A->alternative_id; ?>"><?php echo CHtml::encode(Common::truncate($A->title, 32)); ?></option>
                        <?php }?>
                    </select>
                    <a class="selectBox selectBox-dropdown" style="display: inline-block;" title="" tabindex="0">
                        <span class="selectBox-label">Draw more alternatives</span>
                        <span class="selectBox-arrow"></span>
                    </a>
                </fieldset>
            </form>
            <ul class="legend">
                <?php $i = 0; ?>
                <?php foreach($bestAlternatives as $A) {?>
                    <li id="alternative_<?php echo $A->alternative_id; ?>"><span class="color" style="background-color: <?php echo $A->color; ?>">&nbsp;</span><?php echo CHtml::encode(Common::truncate($A->title, 32)); ?><span class="remove">X</span></li>
                    <?php if($i == 1) break; ?>
                    <?php $i++;?>
                <?php }?>
            </ul>
        </div>
        <div id="abacon" class="content">
            <table class="criteria">
            <?php foreach($this->DecisionModel->findCriteriaByPriority() as $Criteria) { ?>
                <tr>
                    <td><?php echo CHtml::encode($Criteria->title); ?></td>
                </tr>
            <?php }?>
            </table>
            <table class="scale">
                <tr>
                    <td>0</td>
                    <td>10</td>
                    <td>20</td>
                    <td>30</td>
                    <td>40</td>
                    <td>50</td>
                    <td>60</td>
                    <td>70</td>
                    <td>80</td>
                    <td>90</td>
                    <td>100</td>
                </tr>
            </table>
        </div>
    </div>
</div>
<ul id="content-nav">
    <li class="prev"><?php echo CHtml::link('Previous', array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label, 'pageNr' => $this->DecisionModel->no_criteria-1)); ?></li>
    <?php if(Yii::app()->user->isGuest) { ?>
        <li class="next"><a href="/" title="Close this decision">Close<span class="doors">&nbsp;</span></a></li>
    <?php } else { ?>
        <li class="next"><?php echo CHtml::link('Close', array('/user/profile/')) ?></li>
    <?php } ?>
    <!-- li class="next<?php echo (!$this->DecisionModel->checkAnalysisComplete() ? ' disabled' : ''); ?>"><?php echo ($this->DecisionModel->checkAnalysisComplete() ? CHtml::link('Next', array('/decision/sharing', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)) : '<span>Close</span>'); ?></li -->
</ul>
</section>