<?php

/**
 * This is the model class for table "alternative".
 *
 * Extends DecisionElement
 *
 * The followings are the available columns in table 'alternative':
 * @property string $alternative_id
 * @property string $rel_model_id
 * @property string $title
 * @property double $score
 * @property double $weightedScore
 * @property string $color
 *
 * The followings are the available model relations:
 * @property Model $relModel
 * @property Criteria[] $criterias
 */
class Alternative extends DecisionElement
{
    /**
     * Color pool for plotting graphs
     *
     * @var array
     */
    private static $colorPool = array(
        "#6ac616",
        "#b000b7",
        "#2da7b9",
        "#18b3f7",
        "#bd3439",
        "#c6dc0c",
        "#5c0369",
        "#eb8e94",
        "#00953f"
    );

	/**
	 * Returns the static model of the specified AR class.
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
            array('title', 'isDecisionModelUnique'),
			array('title', 'safe', 'on'=>'search'),
        );
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		return array(
			'DecisionModel' => array(self::BELONGS_TO, 'DecisionModel', 'rel_model_id'),
            'evaluations' => array(self::HAS_MANY, 'Evaluation', 'rel_alternative_id'),
			// 'criterias' => array(self::MANY_MANY, 'Criteria', 'evaluation(rel_alternative_id, rel_criteria_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'alternative_id' => 'Alternative',
			'rel_model_id' => 'Rel Model',
			'title' => 'Title',
			'score' => 'Score',
			'weightedScore' => 'Weighted Score',
			'color' => 'Color',
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
		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
    /**
     * Before delete
     *
     * Update decision model's last edit date and delete all evaluation
     */
    public function beforeDelete()
    {
        if( parent::beforeDelete() )
        {
            // update prefered alternative
            if($this->DecisionModel->preferred_alternative == $this->getPrimaryKey())
            {
                $this->DecisionModel->preferred_alternative = null;
                $this->DecisionModel->save();
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
        DecisionModel::model()->findByPk($this->_oldValues['rel_model_id'])->decrease('no_alternatives');
    }

    /**
     * Handle all the logic before save
     */
    public function beforeSave()
    {
        if( parent::beforeSave() )
        {
            if(!$this->clone)
            {
                // update decision model's last edit
                $this->DecisionModel->updateLastEdit();

                // new record?
                if($this->isNewRecord)
                {
                    // allocate a color
                    $this->allocateColor();

                    // increase the number of criteria
                    $this->DecisionModel->increase('no_alternatives');
                }
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
        $DecisionModel = $this->DecisionModel;

        // choose a color from the pool
        if(count(self::$colorPool) > $noAlt = $DecisionModel->no_alternatives)
        {
            // find out what colors are beeing used
            $usedColors = array();
            foreach($DecisionModel->alternatives as $A)
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
}