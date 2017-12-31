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
            //TODO create my own validator for length
            ['number', 'integer'],
            ['number', 'unique'],
            ['number', 'validateNumber','skipOnEmpty'=> false],

        ];
    }


    /**
     * check phone number format
     */
    public function validateNumber(){
        if(strlen($this->number)<7 || strlen($this->number)>15){
            $errorMsg= 'wrong number format';
            $this->addError('number',$errorMsg);
        }
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
