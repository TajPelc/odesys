<?php

/**
 * Alternatives controller
 *
 * @author Taj
 *
 */
class AlternativesController extends DecisionController
{
    // default action
    public $defaultAction = 'create';

    /**
     * Add / Update / Delete alternatives
     */
    public function actionCreate()
    {
        // add style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/heading.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/content-nav.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/alternatives/index.css');

        // add style files
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/core/jquery.color.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/alternatives/index.js');

        // ajax
        if(Ajax::isAjax())
        {
            // find alternative
            $Alternative = Alternative::model()->findByPk($this->post('alternative_id'));

            // actions
            switch ($this->post('action'))
            {
                // create/edit alternative
                case 'save':
                    if(empty($Alternative))
                    {
                        $Alternative = new Alternative();
                    }
                    // set attributes
                    $Alternative->rel_model_id = $this->DecisionModel->model_id;
                    $Alternative->title = $this->post('value');

                    // save
                    if($Alternative->save())
                    {
                        Ajax::respondOk(array(
                            'alternative_id' => $Alternative->alternative_id,
                            'projectMenu' => $this->getProjectMenu(),
                        ));
                    }

                    // save failed
                    Ajax::respondError($Alternative->getErrors());

                // delete
                case 'delete':
                    if(!empty($Alternative))
                    {
                        // delete
                        if($Alternative->delete())
                        {
                            Ajax::respondOk(array(
                                'projectMenu' => $this->getProjectMenu(),
                            ));
                        }
                    }
                    // delete failed
                    Ajax::respondError();

                // default action
                default:
                    Ajax::respondError();
            }
        }

        // save criteria
        if(isset($_POST['newAlternative']))
        {
            // set attributes
            $Alternative = new Alternative();
            $Alternative->attributes = $_POST['newAlternative'];


            // redirect
            if( $Alternative->save())
            {
                $this->redirect(array('alternative/create'));
            }
        }

        // render the view
        $this->render('create');
    }
}