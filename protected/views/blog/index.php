<?php $this->pageTitle='Blog | odesys'; ?>

<?php Yii::app()->clientScript->registerMetaTag('Decision Making, Visual Engine, Decision Tool, Social Networking, Solving Decision Problems, Helping You Decide, Web-based Decision Support System, Decision-Making Made Easy', NULL, NULL, array('property'=>'description')); ?>

<?php Yii::app()->clientScript->registerMetaTag('odesys // helping you decide | Decision Tool | Decision Support System', NULL, NULL, array('property'=>'og:title')); ?>
<?php Yii::app()->clientScript->registerMetaTag('en_US', NULL, NULL, array('property'=>'og:locale')); ?>
<?php Yii::app()->clientScript->registerMetaTag('Decision Making, Visual Engine, Decision Tool, Social Networking, Solving Decision Problems, Helping You Decide, Web-based Decision Support System, Decision-Making Made Easy', NULL, NULL, array('property'=>'og:description')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL(), NULL, NULL, array('property'=>'og:url')); ?>
<?php Yii::app()->clientScript->registerMetaTag('blog', NULL, NULL, array('property'=>'og:site_name')); ?>
<?php Yii::app()->clientScript->registerMetaTag('website', NULL, NULL, array('property'=>'og:type')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL() . '/images/logo_big.png', NULL, NULL, array('property'=>'og:image')); ?>

<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, Common::getBaseURL(), NULL, array('rel'=>'canonical')); ?>
<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, 'https://plus.google.com/112275384094460979880/', NULL, array('rel'=>'publisher')); ?>

<nav>
    <div>
        <?php echo CHtml::link('Home', Yii::app()->homeUrl, array('title'=>'odesys // helping you decide')); ?> / Blog
    </div>
</nav>

<section class="content btcf">
    <div id="content">
        <article>
            <header>
                <h1><span><b>6</b>MAR</span><?php echo CHtml::link('Learning from our mistakes', array('/blog/learning-from-our-mistakes/'), array('title'=>'Article | Learning from our mistakes')); ?></h1>
                <p>Author: Frenk T. Sedmak Nahtigal, 2013</p>
            </header>
            <div class="btcf">
                <div class="img">
                    <img src="/images/article/2_150.png" title="" alt="" />
                    photo credit: <a href="http://cybersocialstructure.org/2012/04/23/double-loop-learning-as-an-outcome-of-double-loop-governance/">Bruce Caron</a> via <a href="http://cybersocialstructure.org/">cybersocialstructure.org</a></a>
                </div>
                <p>Often in life we follow patterns, repetitions of our actions as we are engaged in a single-learning loop. We see things as they appear and rush to get to the results of our actions focusing only on incremental changes. If our actions do not yield expected results, we might fine-tune our strategy or change it in hope of achieving them. But sometimes that is not enough to achieve the desired results.  We need to change the way we think, question our values, our beliefs.</p>
            </div>
        </article>

        <article>
            <header>
                <h1><span><b>18</b>FEB</span><?php echo CHtml::link('A different approach to decision making', array('/blog/different-approach-to-decision-making/'), array('title'=>'Article | A different approach to decision making')); ?></h1>
                <p>Author: Taj Pelc, 2013</p>
            </header>
            <div class="btcf">
                <div class="img">
                    <img src="/images/article/1_150.png" title="" alt="" />
                    photo credit: <a href="http://www.flickr.com/photos/jdhancock/3842546304/">JD Hancock</a> via <a href="http://photopin.com">photopin</a> <a href="http://creativecommons.org/licenses/by/2.0/">cc</a>
                </div>
                <p>Making good decisions is hard, yet most of us consider ourselves to be good decision makers. After all we make decisions every day, most of them without much effort.</p>
                <p>But there are times when looking at the past when you can’t help thinking how you should have done something different.</p>
                <p>How to do it better?</p>
            </div>
        </article>
    </div>

    <aside>
        <h2>Sidebar</h2>
        <p>Lorem ipsum dolor sit amet.</p>
    </aside>
</section>