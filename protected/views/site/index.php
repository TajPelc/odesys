<?php $this->pageTitle='odesys // helping you decide'; ?>

<?php Yii::app()->clientScript->registerMetaTag('Decision Making, Visual Engine, Decision Tool, Social Networking, Solving Decision Problems, Helping You Decide, Web-based Decision Support System, Decision-Making Made Easy', NULL, NULL, array('property'=>'description')); ?>

<?php Yii::app()->clientScript->registerMetaTag('odesys // helping you decide | Decision Tool | Decision Support System', NULL, NULL, array('property'=>'og:title')); ?>
<?php Yii::app()->clientScript->registerMetaTag('en_US', NULL, NULL, array('property'=>'og:locale')); ?>
<?php Yii::app()->clientScript->registerMetaTag('Decision Making, Visual Engine, Decision Tool, Social Networking, Solving Decision Problems, Helping You Decide, Web-based Decision Support System, Decision-Making Made Easy', NULL, NULL, array('property'=>'og:description')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL(), NULL, NULL, array('property'=>'og:url')); ?>
<?php Yii::app()->clientScript->registerMetaTag('homepage', NULL, NULL, array('property'=>'og:site_name')); ?>
<?php Yii::app()->clientScript->registerMetaTag('website', NULL, NULL, array('property'=>'og:type')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL() . '/images/logo_big.png', NULL, NULL, array('property'=>'og:image')); ?>

<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, Common::getBaseURL(), NULL, array('rel'=>'canonical')); ?>
<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, 'https://plus.google.com/112275384094460979880/', NULL, array('rel'=>'publisher')); ?>

    <section class="content">
        <h1>Decision making is hard. We know. Why not let our system guide you through the process step by step until you have reached a decision?</h1>
        <div>
            <?php if(Yii::app()->user->isGuest) { ?>
                <?php echo CHtml::link('begin your journey', array('/project/create/'), array('class'=>'decisionNew', 'title'=>'begin your journey', 'rel' => 'nofollow')); ?>
            <?php } else { ?>
                <?php echo CHtml::link('begin your journey', array('/project/create/'), array('class'=>'decisionNew', 'title'=>'begin your journey')); ?>
            <?php } ?>
        </div>
        <iframe width="920" height="517" src="http://www.youtube-nocookie.com/embed/Zfb3AwJynpw?rel=0&hd=1&vq=hd720&wmode=transparent" frameborder="0" allowfullscreen></iframe>
        <ul class="btcf">
            <li>
                <article>
                    <header>
                        <h2><?php echo CHtml::link('What we do', array('site/about'), array('title'=>'About us | odesys')); ?></h2>
                    </header>
                    <p>We utilize the power of social networking to increase ones insight into the decision problem being analyzed by inviting other people to look at it from an independent or unbiased point of view. </p>
                    <p>Our application will guide you through the decision-making process step-by-step. We provide the tools, you need to analyse your alternatives and weigh your options. The decision is then up to you.</p>
                    <p style="display: none;">Odesys is a web-based decision support system that augments the user's decision-making process.</p>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h2><?php echo CHtml::link('Blog & Tips', array('/blog/'), array('title'=>'Blog | odesys')); ?></h2>
                        <p>Recent posts:</p>
                        <ul>
                            <li>
                                <span><b>6</b>MAR</span>
                                <?php echo CHtml::link('Learning from our mistakes', array('/blog/learning-from-our-mistakes/'), array('title'=>'Article | Learning from our mistakes')); ?> by Frenk T. Sedmak Nahtigal
                            </li>
                            <li>
                                <span><b>18</b>FEB</span>
                                <?php echo CHtml::link('A different approach to decision making', array('/blog/different-approach-to-decision-making/'), array('title'=>'Article | A different approach to decision making')); ?> by Taj Pelc
                            </li>
                        </ul>
                    </header>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h2><?php echo CHtml::link('Mission Statement', array('site/about'), array('title'=>'About us | odesys')); ?></h2>
                    </header>
                    <p>By utilizing the power of our visual engine and by enlisting help from the people you trust the quality of your decisions is sure to improve.</p>
                    <p>Helping you decide.</p>
                </article>
            </li>
        </ul>
    </section>

    <?php if($latestDecisions) { ?>
    <section id="public_decisions">
        <header>
            <h1>Latest public decisions by our users</h1>
        </header>
        <ul class="btcf">
            <?php foreach($latestDecisions as $d) { ?>
            <li>
                <article>
                    <header>
                        <h3><a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo CHtml::encode($d->title) . ' by ' . $d->User->getName(); ?>"><?php echo CHtml::encode($d->title); ?></a></h3>
                    </header>
                    <aside>
                        <a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo CHtml::encode($d->title) . ' by ' . $d->User->getName(); ?>"><img src="<?php echo $d->User->getProfileImage(); ?>" title="" /></a>
                    </aside>
                </article>
            </li>
            <? } ?>
        </ul>
    </section>
    <?php } ?>