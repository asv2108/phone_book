<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "phone_number".
 *
 * @property int $id
 * @property int $contact_id
 * @property int $number
 * @property int $active
 *
 * @property Contact $contact
 */
class PhoneNumber extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'phone_number';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number'],'filter','filter'=>'trim'],
            ['number', 'string', 'min'=>7, 'max'=>20],
            ['number', 'match', 'pattern' => '/^(\s*)?(\+)?([- _():=+]?\d[- _():=+]?){7,14}(\s*)?$/'],
            ['number', 'unique']
        ];
    }



    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            //'id' => Yii::t('app', 'ID'),
            //'contact_id' => Yii::t('app', 'For the current contact'),
            'number' => Yii::t('app', 'Number'),
            //'active' => Yii::t('app', 'Active'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getContact()
    {
        return $this->hasOne(Contact::className(), ['id' => 'contact_id']);
    }

    /**
     * @inheritdoc
     * @return PhoneNumberQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PhoneNumberQuery(get_called_class());
    }

}
