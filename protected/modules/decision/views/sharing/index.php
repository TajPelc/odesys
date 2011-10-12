<?php $this->pageTitle = CHtml::encode($this->Decision->title) . ' | ' . ' Sharing and Settings'; ?>

<div id="heading">
    <h2>Get opinions on this decision from your friends and collegues.</h2>
    <a id="helpButton" href="#">Help</a>
    <?php if($this->Decision->isPublished()){ ?><h3><?php echo CHtml::link('Back to report<span>&nbsp;</span>', CHtml::encode($this->publicLink)); ?></h3><?php } ?>
    <div id="help" style="display: none;">
        <h3>Need some help?</h3>
        <ul>
            <li>
                <dl>
                    <dt>Think</dt>
                    <dd>Lorem ipsum dolor sit amet</dd>
                </dl>
            </li>
            <li>
                <dl>
                    <dt>Random Examples</dt>
                    <dd>Lorem ipsum dolor sit amet</dd>
                </dl>
            </li>
        </ul>
        <span class="helpClose">&nbsp;</span>
        <div id="helpEnd"></div>
    </div>
</div>

<div id="content">
    <form action="" method="post">
        <div>
            <?php if(!empty($errors)) { ?>
                <?php foreach($errors['description'] as $E) { ?>
                    <div class="error"><p><?php echo $E; ?></p></div>
                <?php }?>
            <?php }?>
            <label class="author" for="comment_new">Present your decision to your friends in a few sentances:</label>
            <textarea name="description_new" id="comment_new" rows="5" cols="63"><?php echo $this->Decision->description; ?></textarea>

            <dl>
                <dt><label class="alternative" for="preff_alt">Which alternative do you prefer?</label></dt>
                <dd>
                    <select name="preff_alt" id="preff_alt">
                    <?php $i = 0; ?>
                    <?php foreach($this->DecisionModel->findByWeightedScore() as $A) { ?>
                        <option value="<?php echo $A->alternative_id; ?>"<?php echo ($A->getPrimaryKey() === $this->DecisionModel->preferred_alternative || (!(bool)$this->DecisionModel->preferred_alternative && $i++ == 0) ? 'selected="selected"' : ''); ?>><?php echo CHtml::encode($A->title); ?></option>
                    <?php }?>
                    </select>
                    <a class="selectBox selectBox-dropdown" title="">
                        <span class="selectBox-label">------</span>
                        <span class="selectBox-arrow"></span>
                    </a>
                </dd>
            </dl>
            <dl>
                <dt><label>This decision may be viewed by</label></dt>
                <dd>
                    <select name="privacy_decision">
                        <option value="<?php echo Decision::PRIVACY_EVERYONE; ?>"<?php if($this->Decision->view_privacy == Decision::PRIVACY_EVERYONE){ ?> selected="selected"<?php } ?>>Everyone</option>
                        <option value="<?php echo Decision::PRIVACY_FRIENDS; ?>"<?php if($this->Decision->view_privacy == Decision::PRIVACY_FRIENDS){ ?> selected="selected"<?php } ?>>Friends only</option>
                        <option value="<?php echo Decision::PRIVACY_ME; ?>"<?php if($this->Decision->view_privacy == Decision::PRIVACY_ME){ ?> selected="selected"<?php } ?>>Only me</option>
                    </select>
                    <a class="selectBox selectBox-dropdown" title="">
                    <span class="selectBox-label">------</span>
                    <span class="selectBox-arrow"></span>
                    </a>
                </dd>
            </dl>
            <dl class="l">
                <dt><label>Opinions and suggestions may be posted by</label></dt>
                <dd>
                    <select name="privacy_comments">
                        <option value="<?php echo Decision::PRIVACY_EVERYONE; ?>"<?php if($this->Decision->opinion_privacy == Decision::PRIVACY_EVERYONE){ ?> selected="selected"<?php } ?>>Everyone</option>
                        <option value="<?php echo Decision::PRIVACY_FRIENDS; ?>"<?php if($this->Decision->opinion_privacy == Decision::PRIVACY_FRIENDS){ ?> selected="selected"<?php } ?>>Friends only</option>
                        <option value="<?php echo Decision::PRIVACY_ME; ?>"<?php if($this->Decision->opinion_privacy == Decision::PRIVACY_ME){ ?> selected="selected"<?php } ?>>Only me</option>
                    </select>
                    <a class="selectBox selectBox-dropdown" title="">
                    <span class="selectBox-label">------</span>
                    <span class="selectBox-arrow"></span>
                    </a>
                </dd>
            </dl>
            <div class="last"></div>
        </div>
        <ul id="content-nav">
            <li class="prev"><?php echo CHtml::link('Previous<span class="doors">&nbsp;</span>', array('/decision/analysis', 'decisionId' => $this->Decision->decision_id, 'decisionId' => $this->Decision->decision_id, 'label' => $this->Decision->label)); ?></li>
            <?php if($this->Decision->isPublished()) { ?>
                <li class="next"><input class="button" type="submit" name="publish" value="Update" /></li>
            <?php } else { ?>
                <li class="next"><input class="button" type="submit" name="publish" value="Publish" /></li>
            <?php }?>
        </ul>
    </form>
</div>
<div id="sidebar" class="help">
    <h4>What’s next?</h4>
    <p>This is the last step of the decision modelling phase. Your decision will be presented to your social circle.</p>
    <p>They will be able to see your alternatives, your criteria, how you have evaluated each alternative and which alternative do you prefer.</p>
    <p class="l">Be sure to write a few words about your decision so others may give you opinions on your decision.</p>
    <div class="last"></div>
</div>
