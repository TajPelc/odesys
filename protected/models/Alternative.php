<?php

class Alternative extends CActiveRecord
{
    /**
     *  Old values
     */
    private $_oldValues = array();

    /**
     * Color pool for plotting graphs
     *
     * @var array
     */
    private static $colorPool = array(
        "#c6dc0c",
        "#2da7b9",
        "#5c0369",
        "#6ac616",
        "#eb8e94",
        "#b000b7",
        "#18b3f7",
        "#bd3439",
        "#00953f"
    );

    /**
     * The followings are the available columns in table 'alternative':
     *
     * @var integer $alternative_id
     * @var integer $rel_project_id
     * @var string $title
     * @var double $score
     * @var double $weightedScore
     * @var string $color
     */

    /**
     * Returns the static model
     *
     * @return Alternative
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'alternative';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('title', 'filter', 'filter' => 'trim'),
            array('title', 'required'),
            array('title', 'length', 'max' => 60),
            array('title', 'isProjectUnique'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'Project' => array(self::BELONGS_TO, 'Project', 'rel_project_id'),
            'evaluations' => array(self::HAS_MANY, 'Evaluation', 'rel_alternative_id'),
        );
    }

    /**
     * Check if title is unique for this project
     *
     * @param $attribute
     * @param $params
     */
    public function isProjectUnique($attribute, $params)
    {
        // check for new records or if the title has been changed
        if($this->getIsNewRecord() || $this->_oldValues['title'] !== $this->title)
        {
            // editing
            if(!$this->getIsNewRecord() && mb_strtolower($this->title, mb_detect_encoding($this->title)) == mb_strtolower($this->_oldValues['title'], mb_detect_encoding($this->_oldValues['title'])) )
            {
                return true;
            }

            // record exists!
            if(null !== $this->findByAttributes(array('rel_project_id' => $this->rel_project_id, $attribute => $this->{$attribute})))
            {
                $this->addError($attribute, ucfirst($attribute).' must be unique.');
            }
        }
    }

    /**
     * After find
     *
     * Save old values
     */
    public function afterFind()
    {
        parent::afterFind();

        $this->_oldValues = $this->getAttributes();
    }

    /**
     * Before delete
     *
     * Update project last edit date and delete all evaluation
     */
    public function beforeDelete()
    {
        if( parent::beforeDelete() )
        {
            // update project's last edit
            $this->Project->updateLastEdit();

            // delete criteria
            foreach($this->evaluations as $e)
            {
                $e->delete();
            }
            return true;
        }

        return false;
    }


    /**
     * Reorder criteria
     */
    public function afterDelete()
    {
        parent::afterDelete();

        // decrease the number of criteria
        Project::model()->findByPk($this->_oldValues['rel_project_id'])->decrease('no_alternatives');
    }


    /**
     * Handle all the logic before save
     */
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            // update project's last edit
            $this->Project->updateLastEdit();

            // new record?
            if($this->isNewRecord)
            {
                // allocate a color
                $this->allocateColor();

                // increase the number of criteria
                $this->Project->increase('no_alternatives');
            }
            return true;
        }
        return false;
    }

    /**
     * Gives the current alternative a color for graphical display
     *
     * @return string $this->color
     */
    public function allocateColor()
    {
        $Project = $this->Project;

        // choose a color from the pool
        if(count(self::$colorPool) > $noAlt = $Project->no_alternatives)
        {
            // find out what colors are beeing used
            $usedColors = array();
            foreach($Project->alternatives as $A)
            {
                $usedColors[] = $A->color;
            }

            // find a free color
            foreach(self::$colorPool as $color)
            {
                if(!in_array($color, $usedColors))
                {
                    $this->color = $color;
                }
            }

            return $this->color;
        }

        // generate random color using colorjizz library
        Yii::import('application.vendors.color-jizz.*');
        require_once('ColorJizz-0.2.php');

        // get a random color by random hue
        $color = new HSV(rand(0,360), 80, 75);
        $this->color = '#' . str_pad($color->toHex()->toString(), 6, '0', STR_PAD_LEFT);

        return $this->color;
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'alternative_id' => 'Alternative',
            'rel_project_id' => 'Rel Project',
            'title' => 'Title',
            'description' => 'Description',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria=new CDbCriteria;

        $criteria->compare('title',$this->title,true);

        $criteria->compare('description',$this->description,true);

        return new CActiveDataProvider('Alternative', array(
            'criteria'=>$criteria,
        ));
    }
}