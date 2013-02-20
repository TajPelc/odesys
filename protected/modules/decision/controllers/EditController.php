<?php
/**
 * Analysis Controller
 *
 * @author Taj
 *
 */
class EditController extends DecisionController
{
    // default action
    public $defaultAction = 'edit';

    /**
     * Displays a particular model.
     */
    public function actionEdit()
    {
        $decisionTitle = $this->DecisionModel->Decision->title;

        // ajax
        if(Ajax::isAjax())
        {
            // render partial
            if($this->post('partial'))
            {
                Ajax::respondOk(array('html'=>$this->renderPartial('edit', array('title' => $decisionTitle), true)));
            }
        }

        if($this->post('decision')) {
            $Decision = $this->DecisionModel->Decision;

            // save project
            $Decision->title = $this->post('title');

            // save or return errors
            if($Decision->validate(array('title')))
            {
                $Decision->save(false);
                Ajax::respondOk(array('url'=>CHtml::encode($Decision->label)));
            }
            else
            {
                Ajax::respondError($Decision->getErrors());
            }

            //Ajax::respondError(array('fail'));
        }

        //include style files
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/projectMenu.css');
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/toolbox/delete.css');

        $this->render('edit', array('title' => $decisionTitle));
    }
}