    <?php $this->pageTitle=Yii::app()->name . ' | Welcome'; ?>

    <section class="content">
        <h1>Decision making is hard. We know. Why not let our system guide you through the process step by step until you have reached a decision?</h1>
        <div>
            <?php echo CHtml::link('begin your journey', array('/site/login/'), array('class'=>'decisionNew', 'title'=>'begin your journey')); ?>
        </div>
        <ul class="btcf">
            <li>
                <article>
                    <header>
                        <h2>Who we are</h2>
                    </header>
                    <p>ODESYS is a web-based decision support system that augments the user's decision-making process.</p>
                    <p>We utilize the power of social networking to increase ones insight into the decision problem being analyzed by inviting other people to look at it from an independent or unbiased point of view. </p>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h2>What we do</h2>
                    </header>
                    <p>Our application will guide you through the decision-making process. We provide the tool you need to analyse your alternatives and weigh your options. The decision is then up to you.</p>
                </article>
            </li>
            <li>
                <article>
                    <header>
                        <h2>Mission Statement</h2>
                    </header>
                    <p>By utilizing the power of our visual engine and by enlisting help from the people you trust the quality of your decisions is sure to improve.</p>
                </article>
            </li>
        </ul>
    </section>

    <section id="public_decisions">
        <header>
            <h1>Latest public decisions by our users</h1>
        </header>
        <ul class="btcf">
            <?php foreach($latestDecisions as $d) { ?>
            <li>
                <article>
                    <header>
                        <h3><a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo $d->getPublicLink(); ?>"><?php echo CHtml::encode($d->title); ?></a></h3>
                    </header>
                    <aside>
                        <a href="<?php echo $d->getPublicLink(); ?>" title="<?php echo $d->getPublicLink(); ?>"><img src="/images/gravatar_default.png" title="" /></a>
                    </aside>
                </article>
            </li>
            <? } ?>
        </ul>
    </section>