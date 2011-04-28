<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($this->Decision->title) . ' / ' . ' Sharing and Settings'; ?>

<div id="heading">
    <h2>Share this decision with your friends and collegues.</h2>
    <h3><?php echo CHtml::encode($this->Decision->title);?></h3>
</div>

<div id="content">
    <form action="" method="post">
        <label class="author" for="comment_new">Description:</label>
        <textarea name="description_new" id="comment_new" rows="5" cols="63"></textarea>
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
                    </dd>
                    <dd>
                        <label>Comments and suggestions may be posted by</label>
                        <select name="privacy_comments">
                            <option value="everyone">Everyone</option>
                            <option value="friends_only">Friends only</option>
                            <option value="only_me">Only me</option>
                        </select>
                    </dd>
                </dl>
            </li>
        </ul>
        <ul id="content-nav">
            <li class="prev"><?php echo CHtml::link('Previous', array('/decision/analysis', 'decisionId' => $this->Decision->project_id, 'decisionId' => $this->Decision->project_id, 'label' => $this->Decision->label)); ?></li>
            <li class="next"><input type="submit" name="publish" value="Publish" /></li>
        </ul>
    </form>
</div>
<div id="sidebar"></div>