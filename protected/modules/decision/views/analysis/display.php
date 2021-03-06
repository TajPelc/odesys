<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Analysis'; ?>

<?php if(!Yii::app()->request->isAjaxRequest) { ?>

<script type="text/javascript">
var Graph = {};
Graph.Data = <?php echo json_encode($eval); ?>;
</script>

<section class="content">
<div id="accordion" class="btcf">
    <div>
        <h1><b><?php echo Yii::app()->user->getFirstName(); ?></b>, here are results of your analysis</h1>
        <h2>― <?php echo CHtml::encode(ucfirst($this->Decision->title)); ?> ―</h2>
        <?php if($decisionTitleNotice) { ?><div id="notice"><p>We have all gone through a rough period at some point in our lives, but odesys is not the right tool to help you make such a decision. We firmly believe you will feel better again.</p><p>For now, please read <a href="http://www.helpguide.org/mental/suicide_help.htm" rel="external">how to deal with suicidal thoughts and feelings</a>. We are <a href="/site/contact/" title="contact us">here</a> if you need us.</p></div><?php } ?>
        <?php if(!$description) { ?>
        <form method="post" action="">
            <p>Please take a moment to write a few sentences about your decision. Why do you consider these alternatives? What factors did you consider and why? Have you changed your mind now that you have seen the results of the analysis?
            <?php if($this->Decision->isPublic()) { ?>
                The text you enter here will help people viewing this decision understand what it is about and get an idea about your way of thinking.
            <?php } else { ?>
                Because this decision is private, only you will be able to see this description. You can change the view privacy for this decision in your profile.</p>
            <?php } ?>
            </p>
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
        <p>Additinally you can pick your <b>favorite</b> alternative by clicking on it on the Score graph.</p>
        <div id="score" class="content">
            <table class="alternatives">
                <?php foreach($bestAlternatives as $A) { ?>
                <tr>
                    <td class="fav<?php echo ($preferred === $A->getPrimaryKey() ? ' selected' : '')?>"></td>
                    <td class="name" id="<?php echo $A->getPrimaryKey(); ?>"><?php echo CHtml::encode($A->title); ?></td>
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
        <span><input type="checkbox" id="weights" value="disable"> <label for="weights">Disable internal weights (treat all criteria as equally important)</label></span>
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
                <li id="alternative_<?php echo $A->alternative_id; ?>"><span class="color" style="background-color: <?php echo $A->color; ?>">&nbsp;</span><?php echo CHtml::encode(Common::truncate($A->title, 32)); ?><span class="remove" onclick="void(0)">X</span></li>
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
<?php if($this->Decision->isPublic()) { ?>
<div id="sns" class="btcf">
    <ul>
        <li><a id="share_facebook" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://www.facebook.com/sharer.php?u=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;t=<?php echo CHtml::encode($this->Decision->title); ?>">Facebook</a></li>
        <li><a id="share_twitter" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://twitter.com/share?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;via=DecisionTool&amp;text=<?php echo Chtml::encode($this->Decision->title); ?>">Twitter</a></li>
        <li><a id="share_google" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://plus.google.com/share?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Google+</a></li>
        <li><a id="share_linkedin" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>&amp;summary=<?php echo CHtml::encode(Common::truncate($this->Decision->description, 115)); ?>&amp;source=odesys">LinkedIn</a></li>
        <li>
            <a id="share_digg" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800');return false;" href="http://digg.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>">Digg</a>
            <span style="display:none"><?php echo CHtml::encode($this->Decision->description); ?></span>
        </li>
        <li><a id="share_reddit" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://www.reddit.com/submit?url=<?php echo Yii::app()->request->hostInfo; ?><?php echo CHtml::encode('/decision/'. $this->Decision->decision_id . '-' . $this->Decision->label . '.html'); ?>&amp;title=<?php echo CHtml::encode($this->Decision->title); ?>&amp;text=<?php echo CHtml::encode(Common::truncate($this->Decision->description, 115)); ?>">Reddit</a></li>
    </ul>
</div>
<?php } ?>
<h2>How to interpret the results?</h2>
<p>These results are product of using the weighted average method. Please read our <a href="/blog/" title="Blog | odesys">blog</a> to learn what does that mean and how you should interpret your charts and numbers.</p>
<h2>Which one do I choose?</h2>
<p>This is the hard part. Although the first alternative is usually the best, it's not a general rule. Use the detailed comparison to see how they really compare.</p>
<?php if($this->Decision->isPublic()) { ?>
<p>You may also share this decision with your friends or other social circles. This model will help other people get a sense of your decision problem. We strongly encourage you to <b>write</b> a <b>description before sharing</b> this decision. Sharing is easy, just copy the link in your browser or click on one of the icons above.</p>
<?php } else { ?>
<p>If you change this decision's privacy to public, you will be able to share it with your friends and other circles, hence receive additional feedback about your decision model. Why not try it? It might make you decision making a lot easier.</p>
<?php } ?>
<h2>Changed your mind?</h2>
<p>You may always return to previous steps to modify or add alternatives and factors. You may also change the evaluation at any time.</p>
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