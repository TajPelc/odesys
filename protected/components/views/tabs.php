<div id="mainmenu">
    <?php $this->widget('zii.widgets.CMenu',array(
       'items'=>array(
            array('label' => 'Home',                                'url'=>array('/site/index')),
            array('label' => 'Project',                             'url'=>array('/project/details'),       'visible' => Project::isProjectActive(), 'active' => $checkUrl),
            array('label' => 'My projects',                         'url'=>array('/project/index'),         'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Logout ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'),           'visible' => !Yii::app()->user->isGuest),
            array('label' => 'Login',                               'url'=>array('/site/login'),            'visible' => Yii::app()->user->isGuest),
        ),
    )); ?>
</div>