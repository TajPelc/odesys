<?php $this->pageTitle = 'odesys | ' . CHtml::encode($this->Decision->title); ?>

<?php if(isset($eval)) { ?>
<script type="text/javascript">
    var Graph = {};
    Graph.Data = <?php echo json_encode($eval); ?>;
</script>
<? } ?>

<section class="content">
    <div id="accordion" class="btcf">
        <div>
            <h1><?php echo CHtml::encode(ucfirst($this->Decision->title)); ?></h1>
            <h2>― A decision model by <b><?php echo CHtml::encode($this->Decision->User->identities[0]->name); ?></b> ―</h2>
            <?php if($this->Decision->description) { ?>
            <div id="description">
                <p><?php echo CHtml::encode(nl2br($this->Decision->description)); ?></p>
            </div>
            <?php }?>
            <?php if(isset($eval)) { ?>
            <p><b>Score graph</b> shows you total scores for your alternatives. The best scoring alternative is at the top, having 100 points. All other alternative's scores are calculated relative to the best scoring alternative.</p>
            <div id="score" class="content">
                <table class="alternatives">
                    <?php foreach($bestAlternatives as $A) { ?>
                    <tr>
                        <td id="<?php echo $A->getPrimaryKey(); ?>"><?php echo CHtml::encode($A->title); ?></td>
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
            <?php } else { ?>
                <h1>Evaluation not yet complete ...</h1>
                <div id="description">
                    <p>The owner of this decision has yet to complete the evaluation process. Please check back at a later time. If you are the owner of this decision, log in and continue the process under your profile.</p>
                </div>
            <?php } ?>
        </div>
        <?php if(isset($eval)) { ?>
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
    <?php } ?>
    <div id="sns" class="btcf">
        <ul>
            <li><a id="share_facebook" target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;t=<?php echo CHtml::encode($this->Decision->title); ?>">Facebook</a></li>
            <li><a id="share_twitter" target="_blank" href="https://twitter.com/share?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;via=ODESYSinfo&amp;text=<?php echo Chtml::encode($this->Decision->title); ?>">Twitter</a></li>
            <li><a id="share_google" target="_blank" href="https://plus.google.com/share?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Google+</a></li>
            <li><a id="share_linkedin" target="_blank" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>&amp;summary=<?php echo CHtml::encode(Common::truncate($this->Decision->description, 115)); ?>&amp;source=odesys">LinkedIn</a></li>
            <li>
                <a id="share_digg" target="_blank" href="http://digg.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Digg</a>
                <span style="display:none"><?php echo CHtml::encode($this->Decision->description); ?></span>
            </li>
            <li><a id="share_reddit" target="_blank" href="http://www.reddit.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Reddit</a></li>
        </ul>
    </div>
</section>