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
        <iframe id="promoVideo" width="920" height="518" onload="floaded()" src="https://www.youtube.com/embed/31pLgeOdohg?rel=0&hd=1&vq=hd720&wmode=transparent&showinfo=0" frameborder="0" allowfullscreen></iframe>

        <script>
            //onYouTubePlayerAPIReady
            $('#promoVideo').attr('height', 200);
            var promoVideo;
            function floaded(){
                promoVideo = new YT.Player('promoVideo', {
                    videoId: '31pLgeOdohg',
                    events:
                    {
                        'onStateChange': function (event)
                        {
                            if (event.data == YT.PlayerState.PLAYING)      { $('#promoVideo').attr('height', 518); }
                            else if (event.data == YT.PlayerState.ENDED)   { $('#promoVideo').attr('height', 200); promoVideo.stopVideo(); }
                        }
                    }
                });
            }
        </script>

        <ul class="btcf" id="threeMusketeers">
            <li>
                <article>
                    <header>
                        <h2><?php echo CHtml::link('Who we are', array('site/contact'), array('title'=>'Contact | odesys')); ?></h2>
                    </header>
                    <p>We are decision theory researches and explorers of the human mind.</p>
                    <p>By combining our knowledge of decision theory with our skills of web development, we would like to create a world where the quality of our decisions and the quality of life are at their best.</p>
                    <p>We are always looking for new connections.</p>
                    <p>If you would like to work with us or have a question, we encourage you to <a href="/site/contact/" title="contact">get in touch</a>.</p>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h2><?php echo CHtml::link('What we do', array('site/about'), array('title'=>'About us | odesys')); ?></h2>
                    </header>
                    <p>We provide the tool that help you quickly and easily build a model of your decision problem by guiding you through the decision-making process step-by-step.</p>
                    <p>By inviting other people to look at your decision from an independent or unbiased point of view through the power of social networking, you can increase your insight into the decision problem.</p>
                    <p>If you would like, you can remain anonymous, keep your decision private and just use our tool to model the decision problem for yourself.</p>
                    <p style="display: none;">Odesys is a web-based decision support system that augments the user's decision-making process.</p>
                </article>
            </li>

            <li>
                <article>
                    <header>
                        <h2><?php echo CHtml::link('Our blog', array('/blog/'), array('title'=>'Blog | odesys')); ?></h2>
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

        </ul>
    </section>

    <?php if($latestDecisions) { ?>
    <section id="public_decisions">
        <header>
            <h1>Latest public decisions by our users</h1>
        </header>
        <ul class="btcf">
            <li class="featured">
                <span>&nbsp;</span>
                <article>
                    <header>
                        <h3><a title="DEMO: Buying a car by Frenk Ten" href="/decision/86-demo-buying-a-car.html">DEMO: Buying a car</a></h3>
                    </header>
                    <aside>
                        <a title="DEMO: Buying a car by Frenk Ten" href="/decision/86-demo-buying-a-car.html"><img title="Frenk Ten" alt="Frenk Ten" src="https://graph.facebook.com/1362051067/picture"></a>
                    </aside>
                </article>
            </li>
            <?php foreach($latestDecisions as $d) { ?>
            <li>
                <article>
                    <header>
                        <h3><a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo CHtml::encode($d->title) . ' by ' . $d->User->getName(); ?>"><?php echo CHtml::encode($d->title); ?></a></h3>
                    </header>
                    <aside>
                        <a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo CHtml::encode($d->title) . ' by ' . $d->User->getName(); ?>"><img src="<?php echo $d->User->getProfileImage(); ?>" title="<?php echo $d->User->getName();?>" alt="<?php echo $d->User->getName();?>" /></a>
                    </aside>
                </article>
            </li>
            <? } ?>
        </ul>
    </section>
    <?php } ?>