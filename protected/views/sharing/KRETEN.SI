<?php $this->pageTitle = Yii::app()->name . 'Project ' . CHtml::encode($Project->title) . ' / ' . ' Sharing and Settings'; ?>

<div id="heading">
    <h2>Share this decision with your friends and collegues.</h2>
    <h3><?php echo CHtml::encode(Project::getActive()->title);?></h3>
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
        <li>
            <dl>
                <dt>Privacy settings</dt>
                <dd>
                    <span>Share this decision on</span>
                    <ul id="sns">
                        <li><a id="share_facebook" href="#">Facebook</a></li>
                        <li><a id="share_twitter" href="#">Twitter</a></li>
                        <li><a id="share_digg" href="#">Digg</a></li>
                        <li><a id="share_reddit" href="#">Reddit</a></li>
                        <li><a id="share_stumbleupon" href="#">StumbleUpon</a></li>
                    </ul>
                </dd>
            </dl>
        </li>
    </ul>
    <ul id="content-nav">
        <li><a href="#">How others see your decision</a></li>
    </ul>
</div>
<div id="sidebar"></div>