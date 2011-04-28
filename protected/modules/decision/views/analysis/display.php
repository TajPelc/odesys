<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>

<div id="heading">
    <h2>Compare alternatives to find which one is best suited for you.</h2>
    <a id="helpButton" href="#">Help</a>
    <h3><?php echo CHtml::encode($this->Decision->title);?></h3>
    <div id="help" style="display: none;">
        <h3>Need some help?</h3>
        <ul>
            <li>
                <dl>
                    <dt>A note on scores</dt>
                    <dd>This graph shows you score values for all your alternatives. Best scoring alternative is at the top, having 100 points. All other alternative's scores are displayed relative to the winning alternative.</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>But which one is best?</dt>
                    <dd>This is the hard part. Although the first alternative is usually the best, it's not a general rule. Use the detailed comparison below to see how they really compare.</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>About the detailed comparison</dt>
                    <dd>This graph shows alternative profiles. You should be seeing how each alternative compares to others at each criteria. Do you still think the first one is the best?</dd>
                </dl>
            </li>
        </ul>
        <div id="helpEnd"></div>
    </div>
</div>

<div id="accordion">
    <h3>Results</h3>
    <div>
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
    </div>
    <h3>Detailed comparison</h3>
    <div>
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
        <div id="abacon-sidebar" class="sidebar">
            <form method="post" action="">
                <fieldset>
                    <select name="legend">
                        <?php foreach($Alternatives as $A) { ?>
                            <option value="<?php echo $A->alternative_id; ?>"><?php echo CHtml::encode(Common::truncate($A->title, 32)); ?></option>
                        <?php }?>
                    </select>
                    <a class="selectBox selectBox-dropdown" style="display: inline-block; width: 232px; -moz-user-select: none;" title="" tabindex="0">
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
    </div>
</div>
<ul id="content-nav">
    <li class="prev"><?php echo CHtml::link('Previous', array('/decision/evaluation', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label, 'pageNr' => $this->DecisionModel->no_criteria-1)); ?></li>
    <li class="next<?php echo (!$this->DecisionModel->checkAnalysisComplete() ? ' disabled' : ''); ?>"><?php echo ($this->DecisionModel->checkAnalysisComplete() ? CHtml::link('Next', array('/decision/sharing', 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)) : '<span>Next</span>'); ?></li>
</ul>
