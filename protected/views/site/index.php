<?php $this->pageTitle = Yii::t('frontPage', 'odesys // helping you decide'); ?>

<?php Yii::app()->clientScript->registerMetaTag('Decision Making, Visual Engine, Decision Tool, Social Networking, Solving Decision Problems, Helping You Decide, Web-based Decision Support System, Decision-Making Made Easy', NULL, NULL, array('property'=>'description')); ?>

<?php Yii::app()->clientScript->registerMetaTag('odesys // helping you decide · Decision Tool · Decision Support System', NULL, NULL, array('property'=>'og:title')); ?>
<?php Yii::app()->clientScript->registerMetaTag('en_US', NULL, NULL, array('property'=>'og:locale')); ?>
<?php Yii::app()->clientScript->registerMetaTag('Decision Making, Visual Engine, Decision Tool, Social Networking, Solving Decision Problems, Helping You Decide, Web-based Decision Support System, Decision-Making Made Easy', NULL, NULL, array('property'=>'og:description')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL(), NULL, NULL, array('property'=>'og:url')); ?>
<?php Yii::app()->clientScript->registerMetaTag('homepage', NULL, NULL, array('property'=>'og:site_name')); ?>
<?php Yii::app()->clientScript->registerMetaTag('website', NULL, NULL, array('property'=>'og:type')); ?>
<?php Yii::app()->clientScript->registerMetaTag(Common::getBaseURL() . '/images/logo_big.png', NULL, NULL, array('property'=>'og:image')); ?>

<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, Common::getBaseURL(), NULL, array('rel'=>'canonical')); ?>
<?php Yii::app()->clientScript->registerLinkTag(NULL, NULL, 'https://plus.google.com/112275384094460979880/', NULL, array('rel'=>'publisher')); ?>

    <section class="content">
        <?php $Titles = array(
            Yii::t('frontPage','Decision making is hard. We know. Why not let our system guide you through the process step by step until you have reached a decision?'),
            Yii::t('frontPage','Our system empowers you, but not with magic. The results are completely based on your own input. You have the power to decide.'),
            Yii::t('frontPage','With our visual engine you can easily model a decision and compare alternatives amongst themselves. Share it with your peers.')); $k = array_rand($Titles); $v = $Titles[$k]; ?>
        <h1><?php echo $v; ?></h1>
        <div>
            <?php if(Yii::app()->user->isGuest) { ?>
                <?php echo Yii::t('frontPage','<a href="{url}" title="begin your journey" class="decisionNew" rel="nofollow">make a decision</a>', array('{url}' => '/project/create/')); ?>
            <?php } else { ?>
                <?php echo Yii::t('frontPage','<a href="{url}" title="begin your journey" class="decisionNew">make a decision</a>', array('{url}' => '/project/create/')); ?>
            <?php } ?>
        </div>
        <script>
            //onYouTubePlayerAPIReady
            function promoVideoStateChange(event){
                if (event.data == YT.PlayerState.PLAYING) {
                    $('#promoVideo').attr('height', 518);
                    promoVideo.setPlaybackQuality('hd720');
                    promoVideo.getOptions('cc');
                }
                else if (event.data == YT.PlayerState.ENDED) {
                    $('#promoVideo').attr('height', 200);
                    promoVideo.stopVideo();
                }
            }
            var promoVideo;
            function floaded(){
                promoVideo = new YT.Player('promoVideo', {
                    height: '200',
                    videoId: '31pLgeOdohg',
                    setPlaybackQuality: 'hd720',
                    events:
                    {
                        'onStateChange': promoVideoStateChange
                    }
                });
            }
        </script>
        <iframe id="promoVideo" width="920" onload="floaded()" src="https://www.youtube.com/embed/31pLgeOdohg?rel=0&hd=1&vq=hd720&wmode=transparent&showinfo=0&enablejsapi=1&cc_load_policy=1" frameborder="0" allowfullscreen></iframe>


        <ul class="btcf" id="threeMusketeers">
            <li>
                <article>
                    <header>
                    <h2><?php echo Yii::t('frontPage','<a href="{url}" title="Contact us | odesys">Who we are</a>', array('{url}' => '/site/contact/')); ?></h2>
                    </header>
                    <p><?php echo Yii::t('frontPage','We are decision theory researches and explorers of the human mind.'); ?></p>
                    <p><?php echo Yii::t('frontPage','By combining our knowledge of decision theory with our skills of web development, we would like to create a world where the quality of our decisions and the quality of life are at their best.'); ?></p>
                    <p><?php echo Yii::t('frontPage','We will keep on supporting and developing odesys, but we need your help. By <a href="{url}" title="make a donation">making a donation</a> you will ensure further support for this project.', array('{url}' => 'https://www.paypal.com/cgi-bin/webscr?cmd=_donations&business=support%40odesys%2esi&lc=SI&item_name=odesys%20%2f%2f%20helping%20you%20decide&currency_code=EUR&bn=PP%2dDonationsBF%3abtn_donate_LG%2egif%3aNonHosted')); ?></p>
                    <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                        <input type="hidden" name="cmd" value="_s-xclick">
                        <input type="hidden" name="encrypted" value="-----BEGIN PKCS7-----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-----END PKCS7-----
">
                        <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donate_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                        <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                    </form>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h2><?php echo Yii::t('frontPage','<a href="{url}" title="About us | odesys">What we do</a>', array('{url}' => '/site/about/')); ?></h2>
                    </header>
                    <p><?php echo Yii::t('frontPage','We provide the tool that help you quickly and easily build a model of your decision problem by guiding you through the decision-making process step-by-step.'); ?></p>
                    <p><?php echo Yii::t('frontPage','By inviting other people to look at your decision from an independent or unbiased point of view through the power of social networking, you can increase your insight into the decision problem.'); ?></p>
                    <p><?php echo Yii::t('frontPage','If you would like, you can remain anonymous, keep your decision private and just use our tool to model the decision problem for yourself.'); ?></p>
                    <p style="display: none;"><?php echo Yii::t('frontPage','Odesys is a web-based decision support system that augments the user\'s decision-making process.'); ?></p>
                </article>
            </li>

            <li>
                <article>
                    <header>
                        <h2><?php echo Yii::t('frontPage','<a href="{url}" title="Blog | odesys">Our blog</a>', array('{url}' => '/blog/')); ?></h2>
                        <ul>
                            <!--li>
                                <span><b>22</b>MAR</span>
                                <?php echo Yii::t('frontPage','<a href="{url}" title="Article | TITLE">TITLE</a> by AUTHOR', array('{url}' => '/blog/article3')); ?>
                            </li-->
                            <li>
                                <span><b>6</b>MAR</span>
                                <?php echo Yii::t('frontPage','<a href="{url}" title="Article | Learning from our mistakes">Learning from our mistakes</a> by Frenk T. Sedmak Nahtigal', array('{url}' => '/blog/learning-from-our-mistakes/')); ?>
                            </li>
                            <li>
                                <span><b>18</b>FEB</span>
                                <?php echo Yii::t('frontPage','<a href="{url}" title="Article | A different approach to decision making">A different approach to decision making</a> by Taj Pelc', array('{url}' => '/blog/different-approach-to-decision-making/')); ?>
                            </li>
                        </ul>
                    </header>
                </article>
            </li>

        </ul>
    </section>

    <p>Hello world!</p>

    <?php if($latestDecisions) { ?>
    <section id="public_decisions">
        <header>
            <h1><?php echo Yii::t('frontPage','Latest public decisions by our users'); ?></h1>
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
                        <h3><a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo CHtml::encode($d->title) . Yii::t('frontPage', ' by ') . $d->User->getName(); ?>"><?php echo CHtml::encode($d->title); ?></a></h3>
                    </header>
                    <aside>
                        <a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo CHtml::encode($d->title) . Yii::t('frontPage', ' by ') . $d->User->getName(); ?>"><img src="<?php echo $d->User->getProfileImage(); ?>" /></a>
                    </aside>
                </article>
            </li>
            <?php } ?>
        </ul>
    </section>
    <?php } ?>