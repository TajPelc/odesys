<?php $this->pageTitle=CHtml::encode($this->Decision->title); ?>
<div id="heading">
    <h2><?php echo CHtml::encode($this->Decision->title); ?></h2>
</div>
<?php if($this->DecisionModel instanceof DecisionModel) { ?>
<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>
<div id="content">
    <h2>About the decision</h2>
    <div id="about">
        <ul class="comments small">
            <li>
                <?php echo CHtml::image('https://graph.facebook.com/' . $this->Decision->User->facebook_id . '/picture?type=large');?>
                <div>
                    <span class="author"><?php echo Fb::singleton()->getInfo($this->Decision->User->facebook_id, 'name'); ?> says:</span>
                    <span class="timestamp">April 5th, 18:13</span>
                    <p><?php echo nl2br(CHtml::encode($this->Decision->description)); ?></p>
                    <span class="last">&nbsp;</span>
                </div>
            </li>
        </ul>
    </div>

    <h2>Score for alternatives</h2>
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

    <div id="abacon">
    </div>

    <h2>Opinions and comments</h2>
    <div id="opinions">
        <ul class="comments">
            <li class="new">
                <?php echo CHtml::image('https://graph.facebook.com/' . Yii::app()->user->facebook_id . '/picture?type=large');?>
                <div>
                    <form method="post" action="">
                        <fieldset>
                            <label class="author" for="comment_new">Share your opinion:</label>
                            <textarea name="comment_new" id="comment_new" rows="5" cols="63"></textarea>
                            <input type="submit" name="comment_save" value="Share" />
                        </fieldset>
                    </form>
                    <span class="last">&nbsp;</span>
                </div>
            </li>
            <?php foreach($this->Decision->opinions as $Opinion) { ?>
            <li>
                <?php echo CHtml::image('https://graph.facebook.com/' . Yii::app()->user->facebook_id . '/picture?type=large'); ?>
                <div>
                    <span class="author"><?php echo Fb::singleton()->getInfo($Opinion->User->facebook_id, 'name'); ?> says:</span>
                    <span class="timestamp"><?php echo date('F jS, H:i'); ?></span>
                    <p><?php echo nl2br(CHtml::encode($Opinion->opinion)); ?></p>
                    <span class="last">&nbsp;</span>
                </div>
            </li>
            <?php } ?>
        </ul>
        <a href="#" id="comments_more" class="button">Show more opinions<span>&nbsp;</span></a>
    </div>
</div>
<div id="sidebar">
    <?php if($this->Decision->rel_user_id == Yii::app()->user->id) { ?>
    <div class="help">
        <h4>View the decision model:</h4>
        <ul class="dm">
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
        <h4>Share on:</h4>
        <ul id="sns">
            <li><a id="share_facebook" href="#">Facebook</a></li>
            <li><a id="share_twitter" href="#">Twitter</a></li>
            <li><a id="share_digg" href="#">Digg</a></li>
            <li><a id="share_reddit" href="#">Reddit</a></li>
            <li><a id="share_stumbleupon" href="#">StumbleUpon</a></li>
        </ul>
        <div class="last"></div>
    </div>
    <div class="help">
        <h4>Decision overview:</h4>
        <ul class="do">
            <li><span>No. alternatives</span><em><?php echo $this->DecisionModel->no_alternatives; ?></em></li>
            <li><span>No. criteria</span><em><?php echo $this->DecisionModel->no_criteria; ?></em></li>
            <li><span>No. opinions</span><em><?php // echo $this->DecisionModel->no_opinions; ?>Meny</em></li>
        </ul>
        <div class="last"></div>
    </div>
    <div class="help">
        <h4>Best scored alternative:</h4>
        <p class="l"><b><?php echo CHtml::encode($first->title);?> by <?php echo $difference; ?>%</b></p>
        <div class="last"></div>
    </div>
    <div class="help">
        <h4>Frenk Ten prefers</h4>
        <p><b><?php echo CHtml::encode($this->DecisionModel->getPreferredAlternative()->title); ?></b></p>
        <h4>out of</h4>
        <p><?php echo Common::implodeArrayOfObjects($this->DecisionModel->alternatives, 'title'); ?></p>
        <h4>when considering</h4>
        <p><?php echo Common::implodeArrayOfObjects($this->DecisionModel->criteria, 'title'); ?></p>
        <div class="last"></div>
    </div>
</div>
<?php } else { ?>
<div id="content">
    <h2>This decision is not yet published.</h2>
    <p>Please wait until the owner finishes building the decision model.</p>
</div>
<?php }?>
