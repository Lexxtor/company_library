<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reader2book".
 *
 * @property integer $reader_id
 * @property integer $book_id
 *
 * @property Reader $reader
 * @property Book $book
 */
class Reader2book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reader2book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reader_id', 'book_id'], 'required'],
            [['reader_id', 'book_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reader_id' => 'Reader ID',
            'book_id' => 'Book ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReader()
    {
        return $this->hasOne(Reader::className(), ['id' => 'reader_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook()
    {
        return $this->hasOne(Book::className(), ['id' => 'book_id']);
    }
}
