<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($this->Decision->title) . ' / ' . ' Sharing and Settings'; ?>

<div id="heading">
    <h2>Get opinions on this decision from your friends and collegues.</h2>
    <h3><?php echo CHtml::encode($this->Decision->title);?></h3>
</div>

<div id="content">
    <h3>About this decision</h3>
    <form action="" method="post">
        <div>
            <label class="author" for="comment_new">Present your decision to your friends in a few sentances::</label>
            <textarea name="description_new" id="comment_new" rows="5" cols="63"></textarea>
            <label class="alternative" for="preff_alt">Which alternative do you prefer?:</label>
            <select name="preff_alt" id="preff_alt">
                <option value="alternative_1">alternative_1</option>
                <option value="alternative_2">alternative_2 with a very long name u see?</option>
                <option value="alternative_3">alternative_3</option>
            </select>
            <a class="selectBox selectBox-dropdown" title="">
                <span class="selectBox-label">------</span>
                <span class="selectBox-arrow"></span>
            </a>
            <div class="last"></div>
        </div>
        <ul id="privacy">
            <li>
                <dl>
                    <dt>Privacy settings</dt>
                    <dd>
                        <label>This decision may be viewed by</label>
                        <select name="privacy_decision">
                            <option value="everyone">Everyone</option>
                            <option value="friends_only">Friends only</option>
                            <option value="only_me">Only me</option>
                        </select>
                        <a class="selectBox selectBox-dropdown" title="">
                            <span class="selectBox-label">------</span>
                            <span class="selectBox-arrow"></span>
                        </a>
                    </dd>
                    <dd>
                        <label>Comments and suggestions may be posted by</label>
                        <select name="privacy_comments">
                            <option value="everyone">Everyone</option>
                            <option value="friends_only">Friends only</option>
                            <option value="only_me">Only me</option>
                        </select>
                        <a class="selectBox selectBox-dropdown" title="">
                            <span class="selectBox-label">------</span>
                            <span class="selectBox-arrow"></span>
                        </a>
                    </dd>
                </dl>
            </li>
        </ul>
        <ul id="content-nav">
            <li class="prev"><?php echo CHtml::link('Previous', array('/decision/analysis', 'decisionId' => $this->Decision->project_id, 'decisionId' => $this->Decision->project_id, 'label' => $this->Decision->label)); ?></li>
            <li class="next"><input class="button" type="submit" name="publish" value="Publish" /></li>
        </ul>
    </form>
</div>
<div id="sidebar"></div>