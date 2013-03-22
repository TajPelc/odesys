<?php
/**
 *
 * Blog controller
 * @author Taj
 *
 */
class BlogController extends Controller
{
    /**
     * Blog index
     */
    public function actionIndex() {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/blog/index.css');
        Yii::app()->createUrl('blog/different-approach-to-decision-making');
        $this->render('index');
    }

    /**
     * Article1 "A different approach to decision making" index
     */
    public function actionArticle1() {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/blog/article.css');

        Yii::app()->createAbsoluteUrl('blog/different-approach-to-decision-making');
        $this->render('article1');
    }
    /**
     * Article2 "Learning from mistakes" index
     */
    public function actionArticle2() {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/blog/article.css');

        Yii::app()->createAbsoluteUrl('blog/learning-from-our-mistakes');
        $this->render('article2');
    }
    /**
     * Article3 "title" index
     */
    public function actionArticle3() {
        // include styles
        Yii::app()->clientScript->registerCSSFile(Yii::app()->baseUrl.'/css/blog/article.css');

        //Yii::app()->createAbsoluteUrl('blog/learning-from-our-mistakes');
        $this->render('article3');
    }
}
