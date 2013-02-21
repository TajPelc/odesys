<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Analysis'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>

<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>

<section class="content">
<div id="accordion" class="btcf">
    <div>
        <h1><b>Frenk Ten</b>, here are results of your analysis</h1>
        <h2>― <?php echo ucfirst($this->Decision->title); ?> ―</h2>
        <?php if(!$description) { ?>
        <form method="post" action="">
            <p>Please take a moment to write a short description of your decision. Text you enter will serve as a guidline for people that will check out your decision model, don't let them wander in the dark.</p>
            <textarea></textarea>
            <div>
                <input name="save" type="submit" value="Save description">
            </div>
        </form>
        <?php } else {?>
        <div id="description">
            <p><?php echo nl2br($description); ?></p>
            <a href="#">Edit</a>
        </div>
        <form method="post" action="" style="display:none;">
            <p>Edit your description and click save.</p>
            <textarea><?php echo $description; ?></textarea>
            <div>
                <input name="save" type="submit" value="Save description">
            </div>
        </form>
        <?php }?>
        <p><b>Score graph</b> shows you total scores for your alternatives. The best scoring alternative is at the top, having 100 points. All other alternative's scores are calculated relative to the best scoring alternative.</p>
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
        <p>This is <b>Detailed comparison graph</b> which shows alternative profiles based on your evaluation. By comparing the data points at each criteria you are able to see how each alternative compares to others. You can add or remove alternatives from the graph. Do you still think the first one is the best?</p>
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
<div id="sns" class="btcf">
    <ul>
        <li><a id="share_facebook" target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;t=<?php echo CHtml::encode($this->Decision->title); ?>">Facebook</a></li>
        <li><a id="share_twitter" target="_blank" href="https://twitter.com/share?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;via=ODESYSinfo&amp;text=<?php echo Chtml::encode($this->Decision->title); ?>">Twitter</a></li>
        <li><a id="share_google" target="_blank" href="https://plus.google.com/share?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Google+</a></li>
        <li>
            <a id="share_digg" target="_blank" href="http://digg.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Digg</a>
            <span style="display:none"><?php echo CHtml::encode($this->Decision->description); ?></span>
        </li>
        <li><a id="share_reddit" target="_blank" href="http://www.reddit.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Reddit</a></li>
    </ul>
</div>
<h2>Which one do I choose?</h2>
<p>This is the hard part. Although the first alternative is usually the best, it's not a general rule. Use the detailed comparison below to see how they really compare.</p>
<h2>Changed your mind?</h2>
<p>You may return to modify criteria, alternatives or evaluation at any time.</p>
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

<?php } else { ?>
<div id="description">
    <p><?php echo nl2br($description); ?></p>
    <a href="#">Edit</a>
</div>
<form method="post" action="" style="display:none;">
    <p>Edit your description and click save.</p>
    <textarea><?php echo $description; ?></textarea>
    <div>
        <input name="save" type="submit" value="Save description">
    </div>
</form>
<?php }?>