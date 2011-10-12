<?php $this->pageTitle=CHtml::encode($this->Decision->title); ?>
<?php if($this->DecisionModel instanceof DecisionModel) { ?>
<div id="heading">
    <h1>A decision model by <?php echo CHtml::encode($this->Decision->User->name); ?></h1>
</div>
<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>
<div id="content">
    <div id="score">
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
    <!-- >a href="#" id="detailed_comparison" class="button">Open detailed comparison<span>&nbsp;</span></a-->
    <div id="about">
        <?php echo CHtml::image('https://graph.facebook.com/' . $this->Decision->User->facebook_id . '/picture?type=square');?>

        <dl>
            <dt><?php echo CHtml::encode($this->Decision->User->name); ?><span class="timestamp"><?php echo date('F jS, Y \a\t H:i', strtotime($this->Decision->last_edit)); ?></span></dt>
            <dd><?php echo nl2br(CHtml::encode($this->Decision->description)); ?></dd>
        </dl>
    </div>

    <div id="abacon">
    </div>

    <h2>Opinions and comments</h2>
    <div id="opinions">
        <ul class="comments">
            <?php if($enableComments) { ?>
                <li class="new">
                    <?php echo CHtml::image('https://graph.facebook.com/' . Yii::app()->user->facebook_id . '/picture');?>
                    <div>
                        <form method="post" action="">
                            <fieldset>
                                <label class="author" for="comment_new">Share your opinion:</label>
                                <div class="textarea">
                                    <textarea name="comment_new" id="comment_new" rows="5" cols="63"></textarea>
                                    <div class="last"></div>
                                </div>
                                <input type="submit" name="comment_save" value="Share" />
                            </fieldset>
                        </form>
                        <span class="last">&nbsp;</span>
                    </div>
                </li>
            <?php }?>
            <?php foreach($this->Decision->getAllOpinions() as $Opinion) { ?>
                <?php $this->renderPartial('_opinion', array('Opinion' => $Opinion))?>
            <?php } ?>
        </ul>
        <a href="#" id="comments_more" class="button">Show more opinions<span>&nbsp;</span></a>
    </div>
</div>
<div id="sidebar">
    <?php if($this->Decision->isOwner(Yii::app()->user->id)) { ?>
    <div class="edit">
        <h4>Edit this decision</h4>
        <ul>
            <li><?php echo CHtml::link('Alternatives', array('/decision/alternatives', 'decisionId' => $this->Decision->getPrimaryKey(), 'label' => $this->Decision->label)); ?></li>
            <li><?php echo CHtml::link('Criteria', array('/decision/criteria', 'decisionId' => $this->Decision->getPrimaryKey(), 'label' => $this->Decision->label)); ?></li>
            <li><?php echo CHtml::link('Evaluation', array('/decision/evaluation', 'decisionId' => $this->Decision->getPrimaryKey(), 'label' => $this->Decision->label)); ?></li>
            <li><?php echo CHtml::link('Analysis', array('/decision/analysis', 'decisionId' => $this->Decision->getPrimaryKey(), 'label' => $this->Decision->label)); ?></li>
            <li><?php echo CHtml::link('Sharing', array('/decision/sharing', 'decisionId' => $this->Decision->getPrimaryKey(), 'label' => $this->Decision->label)); ?></li>
        </ul>
        <div class="last"></div>
    </div>
    <?php } ?>
    <div class="help">
        <h4>This decision is available to:</h4>
        <p><b><?php echo $this->Decision->getViewPrivacyLabel(); ?></b></p>
        <?php if(!$this->Decision->isPrivate()){ ?>
        <h4>Share on:</h4>
        <ul id="sns">
            <?php if(($this->Decision->isOwner(Yii::app()->user->id) && $this->Decision->isFriendsOnly()) || $this->Decision->isPublic()){ ?>
                <li>
                    <a id="share_facebook" target="_blank" href="https://www.facebook.com/sharer.php?u=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;t=<?php echo CHtml::encode($this->Decision->title); ?>">Facebook</a>
                </li>
            <?php } ?>
            <?php if($this->Decision->isPublic()) { ?>
                <li><a id="share_twitter" target="_blank" href="https://twitter.com/share?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;via=ODESYSinfo">Twitter</a></li>
                <li>
                    <a id="share_digg" target="_blank" href="http://digg.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Digg</a>
                    <span style="display:none"><?php echo $this->Decision->description; ?></span>
                </li>
                <li><a id="share_reddit" target="_blank" href="http://www.reddit.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>">Reddit</a></li>
            <?php } ?>
        </ul>
        <?php } ?>
        <div class="last"></div>
    </div>
    <div class="help">
        <h4><?php echo CHtml::encode($this->Decision->User->first_name); ?>'s preference</h4>
        <p><b><?php echo CHtml::encode($this->DecisionModel->getPreferredAlternative()->title); ?></b></p>
        <h4>Highest scoring alternative</h4>
        <p><b><?php echo CHtml::encode($first->title);?> by <?php echo $difference; ?> points</b></p>
        <h4>Decision overview:</h4>
        <ul>
            <li><span>No. alternatives</span><em><?php echo $this->DecisionModel->no_alternatives; ?></em></li>
            <li><span>No. criteria</span><em><?php echo $this->DecisionModel->no_criteria; ?></em></li>
            <li><span>No. opinions</span><em><?php echo $this->Decision->opinionCount; ?></em></li>
        </ul>
        <div class="last"></div>
    </div>
</div>
<?php } else { ?>
<div id="content">
    <h2>This decision is not yet published.</h2>
    <p>Please wait until the owner finishes building the decision model.</p>
</div>
<?php }?>
