<?php $this->pageTitle='[Article] TITLE | odesys'; ?>

<?php Yii::app()->clientScript->registerMetaTag('DESCRIPTION', NULL, NULL, array('property'=>'description')); ?>

<?php Yii::app()->clientScript->registerMetaTag('[Article] TITLE', NULL, NULL, array('property'=>'og:title')); ?>
<?php Yii::app()->clientScript->registerMetaTag('en_US', NULL, NULL, array('property'=>'og:locale')); ?>
<?php Yii::app()->clientScript->registerMetaTag('DESCRIPTION', NULL, NULL, array('property'=>'og:description')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL() . Yii::app()->request->requestUri, NULL, NULL, array('property'=>'og:url')); ?>
<?php Yii::app()->clientScript->registerMetaTag('blog post', NULL, NULL, array('property'=>'og:site_name')); ?>
<?php Yii::app()->clientScript->registerMetaTag('website', NULL, NULL, array('property'=>'og:type')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL() . '/images/logo_big.png', NULL, NULL, array('property'=>'og:image')); ?>

<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, Common::getBaseURL() . Yii::app()->request->requestUri, NULL, array('rel'=>'canonical')); ?>
<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, 'https://plus.google.com/112275384094460979880/', NULL, array('rel'=>'publisher')); ?>

<nav>
    <div>
        <?php echo CHtml::link('Home', Yii::app()->homeUrl, array('title'=>'odesys // helping you decide')); ?> / <?php echo CHtml::link('Blog', array('/blog'), array('title'=>'Blog')); ?> / TITLE
    </div>
</nav>
<section class="content">
    <article>
        <header>
            <h1>TITLE</h1>
            <p>― Posted by AUTHOR on Mar 22th, 2013 ―</p>
        </header>
        <div>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla lacinia tempor commodo. Sed justo tellus, dapibus et dignissim eleifend, feugiat consequat erat. Aliquam sit amet arcu sit amet metus gravida dignissim. Vivamus sed nulla vel turpis egestas imperdiet non id leo. Vivamus pulvinar elementum erat. Vivamus tincidunt fringilla nisi, sed tempus arcu mattis sed. Suspendisse potenti. Curabitur vel ante nunc. Etiam at est quam, consectetur placerat lacus. Etiam ut semper lacus. Donec eu dui risus, luctus elementum purus. In quis justo quis erat convallis volutpat at nec tortor. Pellentesque a nibh at ligula egestas semper eget vel massa. Nunc sodales sagittis bibendum. Suspendisse turpis odio, aliquam nec luctus et, auctor non purus. Aenean ut nibh in dui egestas blandit quis ut tortor. </p>
        </div>
    </article>
    <div id="sns" class="btcf">
        <ul>
            <li><a id="share_facebook" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://www.facebook.com/sharer.php?u=<?php echo Yii::app()->request->hostInfo . Yii::app()->request->requestUri; ?>&amp;t=<?php echo CHtml::encode('[Article] TITLE | odesys'); ?>">Facebook</a></li>
            <li><a id="share_twitter" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://twitter.com/share?url=<?php echo Yii::app()->request->hostInfo . Yii::app()->request->requestUri; ?>&amp;via=DecisionTool&amp;text=<?php echo CHtml::encode('[Article] TITLE | odesys'); ?>">Twitter</a></li>
            <li><a id="share_google" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="https://plus.google.com/share?url=<?php echo Yii::app()->request->hostInfo . Yii::app()->request->requestUri; ?>&amp;title=<?php echo CHtml::encode('[Article] TITLE | odesys'); ?>">Google+</a></li>
            <li><a id="share_linkedin" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo Yii::app()->request->hostInfo . Yii::app()->request->requestUri; ?>&amp;title=<?php echo CHtml::encode('[Article] TITLE | odesys'); ?>&amp;summary=<?php echo CHtml::encode('DESCRIPTION'); ?>&amp;source=odesys">LinkedIn</a></li>
            <li>
                <a id="share_digg" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=800');return false;" href="http://digg.com/submit?url=<?php echo Yii::app()->request->hostInfo . Yii::app()->request->requestUri; ?>&amp;title=<?php echo CHtml::encode('[Article] TITLE | odesys'); ?>">Digg</a>
                <span style="display:none"><?php echo CHtml::encode('DESCRIPTION'); ?></span>
            </li>
            <li><a id="share_reddit" target="_blank" onclick="javascript:window.open(this.href, '', 'menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=600,width=600');return false;" href="http://www.reddit.com/submit?url=<?php echo Yii::app()->request->hostInfo . Yii::app()->request->requestUri; ?>&amp;title=<?php echo CHtml::encode('[Article] TITLE | odesys'); ?>&amp;text=<?php echo CHtml::encode('DESCRIPTION'); ?>">Reddit</a></li>
        </ul>
    </div>
</section>