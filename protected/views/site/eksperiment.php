<div id="content">
    <?php $this->pageTitle=Yii::app()->name . 'Eksperiment'; ?>

    <h1>ODESYS Eksperiment</h1>
    <p>V eksperimentu boste s pomočjo spletnega sistema za podporo odločanju reševali odločitveni problem.</p>

    <p><b>Povezava do vprašalnika:</b> <a href="#"></a></p>

    <p>Začetek: 10.00</p>
    <p>Konec: 10.45</p>

    <dl>
        <dt>Odločitveni problem</dt>
        <dd>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla neque tellus, placerat sed dapibus in, rhoncus id risus. Suspendisse sapien enim, ullamcorper quis facilisis sit amet, viverra eu nisi. Praesent vulputate interdum tempus. Cras cursus nisl vitae dui adipiscing consectetur. Curabitur nec tincidunt diam. Morbi fermentum quam in velit commodo condimentum. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Duis faucibus aliquam tellus, quis venenatis justo faucibus a. Aliquam erat volutpat. In sed ipsum nulla. Etiam tempor, lorem sed volutpat dictum, justo ipsum tristique massa, vel convallis justo augue ac dolor. Curabitur malesuada scelerisque egestas. Pellentesque elementum magna vitae massa semper facilisis. Sed viverra erat sed lectus suscipit ultricies. Fusce ut tortor nibh. Aenean eu ante sapien, sed feugiat orci. Mauris lacinia eros sed nulla posuere id tempor diam auctor. Nullam ultricies ipsum id ipsum pharetra in vehicula sem egestas.</dd>
    </dl>

    <?php if($error){?>
        <p>Vnesite veljavno mesto.</p>
    <?php } else { ?>
        <?php if(Yii::app()->user->isGuest) { ?>
            V polje vnesite številko mize in pritisnite "Pošlji" za prikaz prijavne povezave na Facebook.
            <?php if(!$user){ ?>
            <form action="" method="post">
                <input type="text" name="id" maxlength="2" />
                <input type="submit" name="submit" value="Pošlji" />
            </form>
            <?php } else { ?>
                <a href="<?php echo $user['login_url']; ?>" title="Povežin na facebook" rel="external" target="_blank">Prijavi se na Facebook</a>
            <?php } ?>
        <?php } ?>
    <?php } ?>
</div>