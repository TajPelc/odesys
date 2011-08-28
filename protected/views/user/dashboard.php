<div id="content">
    <div id="heading">
        <h2>Dashboard - Decision Feed</h2>
    </div>
    <ul>
        <li class="new">
            <img src="https://fbcdn-profile-a.akamaihd.net/hprofile-ak-snc4/260658_1362051067_369722_q.jpg" title="Frenk Ten" alt="Frenk Ten" />
            <div>
                <h3><a href="#">Frenk Ten</a> - today 13.00</h3>
                <p>published a decision: <a href="#">"Buying a car"</a> to <b>everyone</b>.</p>
            </div>
        </li>
        <li>
            <img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/23088_1037539823_5285_q.jpg" title="Taj Pelc" alt="Taj Pelc" />
            <div>
                <h3><a href="#">Taj Pelc</a> - today 12.34</h3>
                <p>posted a <a href="#">comment</a> on your decision: <a href="#">Tig ol' Bitties"</a>.</p>
                <blockquote>We care?</blockquote>
            </div>
        </li>
        <li>
            <img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/211944_100001775212279_7119928_q.jpg" title="Rosa Salmela" alt="Rosa Salmela" />
            <div>
                <h3><a href="#">Rosa Salmela</a> - today 12.12</h3>
                <p>posted a <a href="#">comment</a> on your decision: <a href="#">Tig ol' Bitties"</a>.</p>
                <blockquote>OMG!!! I am never hanging with you guys again! PERVERTS!</blockquote>
            </div>
        </li>
        <li>
            <img src="http://profile.ak.fbcdn.net/hprofile-ak-snc4/186124_100002179114423_3234182_q.jpg" title="Margaryta Ruzhytskaya" alt="Margaryta Ruzhytskaya" />
            <div>
                <h3><a href="#">Margaryta Ruzhytskaya</a> - today 12.02</h3>
                <p>posted a <a href="#">comment</a> on your decision: <a href="#">Tig ol' Bitties"</a>.</p>
                <blockquote>Wanna motorboat these?</blockquote>
            </div>
        </li>
    </ul>
    <a class="button" href="#">Show more<span>&nbsp;</span></a>
    <!--dl class="recentDecisions">
        <dt>My latest decisions</dt>
        <dd>
            <table>
                <tr>
                    <th>Title</th>
                    <th>Last modified</th>
                    <th>No. comments</th>
                    <th>Participants</th>
                </tr>
                <?php foreach($Decisions as $D) { ?>
                <tr>
                    <?php if($D->isPublished()) { ?>
                        <td><?php echo CHtml::link(CHtml::encode($D->title), '/decision/'. $D->decision_id . '-' . $D->label . '.html'); ?></td>
                    <?php } else { ?>
                        <td><?php echo CHtml::link(CHtml::encode($D->title), array('/decision/sharing', 'decisionId' => $D->decision_id, 'label' => $D->label)); ?></td>
                    <?php }?>
                    <td><?php echo date('d.m.Y', strtotime($D->last_edit)); ?></td>
                    <td>0</td>
                    <td>1</td>
                </tr>
                <?php } ?>
            </table>
            <?php echo CHtml::link('View all', array('/project/list')); ?>
        </dd>
    </dl>
    <dl class="statistics">
        <dt>Statistics</dt>
        <dd class="first">Total number of decisions: <b><?php echo count($User->decisions); ?></b></dd>
        <dd>Number of comments from your social circle: <b>0</b></dd>
        <dd>Number of people participating on your projects: <b>0</b></dd>
    </dl>
    <dl class="profile">
        <dt>My profile</dt>
        <dd class="first"><a href="#">Privacy</a></dd>
        <dd><a href="#">Settings</a></dd>
    </dl-->
</div>
<div id="sidebar">
    <div class="edit">
        <h4>Dashboard Options:</h4>
        <ul>
            <li><?php echo CHtml::link('Decision Feed', array('user/dashboard')); ?></li>
            <li><?php echo CHtml::link('Decision History', array('project/list')); ?></li>
            <li><a href="#">Statistics</a></li>
            <li><a href="#">Profile Settings</a></li>
        </ul>
        <div class="last"></div>
    </div>
</div>