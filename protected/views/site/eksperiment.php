<?php $this->pageTitle='ODESYS Eksperiment'; ?>

<div id="heading">
    <h2>ODESYS Experiment</h2>
</div>

<div id="content">

    <p><a href="http://edu.surveygizmo.com/s3/556000/ODESYS" rel="external" target="_blank"><b>Povezava do vprašalnika o eksperimentu (v novem oknu)</b> </a></p>

    <p><b>Začetek:</b> 10.45</p>
    <p><b>Konec:</b> 11.30</p>

    <dl>
        <dt>Odločitveni problem</dt>
        <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla neque tellus, placerat sed dapibus in, rhoncus id risus. Suspendisse sapien enim, ullamcorper quis facilisis sit amet, viverra eu nisi. Praesent vulputate interdum tempus. Cras cursus nisl vitae dui adipiscing consectetur. Curabitur nec tincidunt diam. Morbi fermentum quam in velit commodo condimentum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis faucibus aliquam tellus, quis venenatis justo faucibus a. Aliquam erat volutpat. In sed ipsum nulla. Etiam tempor, lorem sed volutpat dictum, justo ipsum tristique massa, vel convallis justo augue ac dolor. Curabitur malesuada scelerisque egestas. Pellentesque elementum magna vitae massa semper facilisis. Sed viverra erat sed lectus suscipit ultricies. Fusce ut tortor nibh. Aenean eu ante sapien, sed feugiat orci. Mauris lacinia eros sed nulla posuere id tempor diam auctor. Nullam ultricies ipsum id ipsum pharetra in vehicula sem egestas.</dd>
    </dl>

    <?php if(Yii::app()->user->isGuest) { ?>
        <?php if(!$user){ ?>
            <form action="" method="post">
                <p><b>V polje vnesite številko mize in pritisnite "Pošlji" za prikaz prijavne povezave na Facebook.</b></p>
                <input type="text" name="id" maxlength="2" />
                <input type="submit" name="submit" value="Pošlji" />
                <?php if($fbError){?>
                    <p>Napaka pri povezavi s Facebookom, prosimo, poskusite ponovno. (<?php echo $fbError; ?>)</p>
                <?php } else if($error) { ?>
                    <p>Vnesite veljavno mesto od 00 do 33.</p>
                <?php } ?>
            </form>
        <?php } else { ?>
            <a href="<?php echo $user['login_url']; ?>" title="Poveži na facebook" rel="external" target="_blank"><b>Povezava do testnega uporabnika na Facebooku (odpre novo okno).</b></a>
        <?php } ?>
    <?php } ?>
</div>