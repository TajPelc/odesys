<?php $this->pageTitle='ODESYS Eksperiment'; ?>

<div id="heading">
    <h2>ODESYS Experiment</h2>
</div>

<div id="content">
    <?php if(Yii::app()->user->isGuest) { ?>
        <?php if(!$user){ ?>
            <form action="" method="post">
                <p><em>Za prikaz Facebook prijavne povezave v polje vnesite številko mize in pritisnite "Pošlji".</em></p>
                <input type="text" name="id" maxlength="2" />
                <input type="submit" name="submit" value="Pošlji" />
                <?php if($fbError){?>
                    <p>Napaka pri povezavi s Facebookom, prosimo, poskusite ponovno. (<?php echo $fbError; ?>)</p>
                <?php } else if($error) { ?>
                    <p>Vnesite veljavno mesto od 00 do 33.</p>
                <?php } ?>
            </form>
        <?php } else { ?>
            <a id="fbLink" href="<?php echo $user['login_url']; ?>" title="Poveži na facebook" rel="external" target="_blank"><b>Povezava do testnega uporabnika na Facebooku (odpre novo okno).</b></a>
        <?php } ?>
    <?php } ?>

    <dl>
        <dt>Trajanje eksperimenta</dt>
        <dd>Od 12.00 do 13.00</dd>
    </dl>
    <dl>
        <dt>Odločitveni problem</dt>
        <dd><?php echo nl2br('Po zaključenem magistrskem študiju, ste se odločili za nadaljevanje akademske kariere. Neko poletno popoldne na udobnem ležalniku v senci in z iPadom v roki premišljujete o tem, katerega mentorja izbrati za doktorat.

Zavedate se, da bo od vaše odločitve odvisna vaša nadaljna življenska pot. Vsekakor si želite čim hitreje do kvalitetne doktorske disertacije. Želite si mentorja, ki vam je dosegljiv, ko ga potrebujete in vas bo podpiral in vodil pri vašem raziskovalnem delu. Pomembno vam je tudi, da je mentor priznan v akademskem svetu. Ima svoj laboratorij? Želite si mentorja, ki vam bo ponudil sodelovanje na priznanih projektih. Razmisliti je vredno tudi o tem, kakšno karierno pot imajo njegovi bivši doktoranti. Zna mentor prepoznati dosežke svojih doktorantov ali je znan po tem, da rad pobere zasluge. Še nekaj časa razmišljate o drugih faktorjih, ki so vam pomembni.

Ko vam na iPadu zmanjka glasbe in namesto  Andreja Šifrerja zaigrajo Black Sabbath, vas vrže z ležalnika, kjer na sveže pokošeni travi doživite razsvetljenje. Ker je odločitev daleč od trivialne, se odločite, da boste uporabili orodje za podporo odločanju, da zmodelirate svoj odločitveni problem, ocenite izbrane mentorje in jih med sabo primerjate.'); ?></dd>
    </dl>

    <dl>
        <dt>Anketni vprašalnik</dt>
        <dd><a href="http://edu.surveygizmo.com/s3/556000/ODESYS" rel="external" target="_blank"><b>Povezava do vprašalnika o eksperimentu (v novem oknu)</b></a></dd>
    </dl>
</div>