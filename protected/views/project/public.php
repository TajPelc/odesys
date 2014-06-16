<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ', a decision model by ' . CHtml::encode($this->Decision->User->getName()) . ' | odesys'; ?>

<?php Yii::app()->clientScript->registerMetaTag(CHtml::encode($this->Decision->description) . ' | odesys', NULL, NULL, array('property'=>'description')); ?>

<?php Yii::app()->clientScript->registerMetaTag(CHtml::encode(ucfirst($this->Decision->title)), NULL, NULL, array('property'=>'og:title')); ?>
<?php Yii::app()->clientScript->registerMetaTag('en_US', NULL, NULL, array('property'=>'og:locale')); ?>
<?php Yii::app()->clientScript->registerMetaTag(CHtml::encode($this->Decision->description) . ' | odesys', NULL, NULL, array('property'=>'og:description')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL() . $this->Decision->getPublicLink(), NULL, NULL, array('property'=>'og:url')); ?>
<?php Yii::app()->clientScript->registerMetaTag(CHtml::encode($this->Decision->title) . ', a decision model by ' . CHtml::encode($this->Decision->User->getName()) . ' | odesys', NULL, NULL, array('property'=>'og:site_name')); ?>
<?php Yii::app()->clientScript->registerMetaTag('website', NULL, NULL, array('property'=>'og:type')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL() . '/images/logo_big.png', NULL, NULL, array('property'=>'og:image')); ?>

<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, Common::getBaseURL() . $this->Decision->getPublicLink(), NULL, array('rel'=>'canonical')); ?>
<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, 'https://plus.google.com/112275384094460979880/', NULL, array('rel'=>'publisher')); ?>


<?php if(isset($eval)) { ?>
<script type="text/javascript">
    var Graph = {};
    Graph.Data = <?php echo json_encode($eval); ?>;
</script>
<?php } ?>

<section class="content">
    <div id="accordion" class="btcf">
        <div>
            <h1><?php echo CHtml::encode(ucfirst($this->Decision->title)); ?></h1>
            <h2>― A decision model by <b><?php echo CHtml::encode($this->Decision->User->getName()); ?></b> ―</h2>
            <?php if($this->Decision->description) { ?>
            <div id="description">
                <p><?php echo nl2br(CHtml::encode($this->Decision->description)); ?></p>
            </div>
            <?php }?>
            <?php if(isset($eval)) { ?>
            <p><b>Score graph</b> shows you total scores for your alternatives. The best scoring alternative is at the top, having 100 points. All other alternative's scores are calculated relative to the best scoring alternative.</p>
            <div id="score" class="content">
                <table class="alternatives">
                    <?php foreach($bestAlternatives as $A) { ?>
                    <tr class="public">
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
</section>