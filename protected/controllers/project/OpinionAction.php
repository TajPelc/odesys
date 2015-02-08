<?php
/**
 * Decision public page
 *
 * @author Taj
 *
 */
class PublicAction extends Action
{
    public function run()
    {
        if(Ajax::isAjax())
        {
            switch(true)
            {
                // new comment
                case isset($_POST['comment_new']):
                {
                    // create new opinion
                    $Opinion = new Opinion();
                    $Opinion->rel_user_id = Yii::app()->user->id;
                    $Opinion->rel_decision_id = $this->getController()->Decision->getPrimaryKey();
                    $Opinion->opinion = $this->post('comment_new');

                    // save
                    if(!$Opinion->save())
                    {
                        // oops, errors
                        Ajax::respondError($Opinion->getErrors());
                    }

                    // all good
                    Ajax::respondOk(array(
                        'opinion' => $this->renderPartial('_opinion', array('models' => array($Opinion)), true),
                    ));
                    break;
                }
                // get more comments
                case isset($_POST['showMore']):
                {
                    $pageNr = $this->post('opinionPage') ? $this->post('opinionPage') : 0;
                    $rv = $this->getController()->Decision->getAllOpinions($pageNr);

                    Ajax::respondOk(array(
                        'more' => $this->renderPartial('_opinion', array('models' => $rv['models']), true),
                        'pageCount' => $rv['pagination']->getPageCount(),
                    ));
                    break;
                }
            }
        }
    }
}