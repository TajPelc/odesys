<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($this->Decision->title) . ' / ' . ' Sharing and Settings'; ?>

<div id="heading">
    <h2>Share this decision with your friends and collegues.</h2>
    <h3><?php echo CHtml::encode($this->Decision->title);?></h3>
</div>

<div id="content">
    <ul id="privacy">
        <li>
            <dl>
                <dt>Privacy settings</dt>
                <dd>
                    <form action="" method="post">
                        <fieldset>
                            <label>This decision may be viewed by</label>
                            <select name="privacy_decision">
                                <option value="everyone">Everyone</option>
                                <option value="friends_only">Friends only</option>
                                <option value="only_me">Only me</option>
                            </select>
                        </fieldset>
                    </form>
                </dd>
                <dd>
                    <form action="" method="post">
                        <fieldset>
                            <label>Comments and suggestions may be posted by</label>
                            <select name="privacy_comments">
                                <option value="everyone">Everyone</option>
                                <option value="friends_only">Friends only</option>
                                <option value="only_me">Only me</option>
                            </select>
                        </fieldset>
                    </form>
                </dd>
            </dl>
        </li>
    </ul>
    <ul id="content-nav">
        <li class="prev"><?php echo CHtml::link('Previous', array('/decision/analysis', 'decisionId' => $this->Decision->project_id, 'decisionId' => $this->Decision->project_id, 'label' => $this->Decision->label)); ?></li>
        <li class="next"><a href="#">Publish</a></li>
    </ul>
</div>
<div id="sidebar"></div>