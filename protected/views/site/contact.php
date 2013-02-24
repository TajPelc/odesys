<?php $this->pageTitle='Contact | odesys'; ?>
<section class="content">
    <h1>Follow us on</h1>
    <div class="social btcf">
        <a target="_blank" class="facebook" href="https://www.facebook.com/odesys">Facebook</a>
        <a target="_blank" class="twitter" href="https://twitter.com/DecisionTool">Twitter</a>
        <a target="_blank" class="google" href="https://plus.google.com/112275384094460979880/">Google+</a>
    </div>
    <p>You can also do it the old fashion way - via <?php if(Yii::app()->user->isGuest){ ?><b>info -[at]- odesys.info</b><?php } else { ?><a href="mailto:info@odesys.info">info@odesys.info</a><?php } ?></p>
    <h1>Follow the developers</h1>
    <div id="developers">
        <dl>
            <dt><img src="https://graph.facebook.com/tajpelc/picture" title="Taj Pelc" alt="Taj Pelc" />Taj Pelc</dt>
            <dd><?php if(Yii::app()->user->isGuest){ ?><b>taj.pelc -[at]- odesys.info</b><?php } else { ?><a href="mailto:taj.pelc@odesys.info">taj.pelc@odesys.info</a><?php } ?></dd>
            <dd><a href="https://www.facebook.com/tajpelc"  title="Taj Pelc on Facebook">Facebook</a> | <a href="https://twitter.com/#!/tajpelc"  title="Taj Pelc on Twitter">Twitter</a> | <a href="https://plus.google.com/115350672233878010427/"  title="Taj Pelc on Google+">Google+</a> | <a href="http://linkedin.com/in/tajpelc" title="Taj Pelc on LinkedIn">LinkedIn</a></dd>
        </dl>
        <dl>
            <dt><img src="https://graph.facebook.com/frenk.ten/picture" title="Frenk T. Sedmak Nahtigal" alt="Frenk T. Sedmak Nahtigal" />Frenk T. Sedmak Nahtigal</dt>
            <dd><?php if(Yii::app()->user->isGuest){ ?><b>frenk.ten -[at]- odesys.info</b><?php } else { ?><a href="mailto:frenk.ten@odesys.info">frenk.ten@odesys.info</a><?php } ?></dd>
            <dd><a href="https://www.facebook.com/frenk.ten"  title="Frenk Ten on Facebook">Facebook</a> | <a href="https://twitter.com/#!/frenkten"  title="Frenk Ten on Twitter">Twitter</a> | <a href="https://plus.google.com/113782485154610601594/"  title="Frenk Ten on Google+">Google+</a> | <a href="http://linkedin.com/in/frenkten" title="Frenk Ten on LinkedIn">LinkedIn</a></dd>
        </dl>
    </div>
</section>
