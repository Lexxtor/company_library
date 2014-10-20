<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "reader2author".
 *
 * @property integer $reader_id
 * @property integer $author_id
 *
 * @property Reader $reader
 * @property Author $author
 */
class Reader2author extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reader2author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['reader_id', 'author_id'], 'required'],
            [['reader_id', 'author_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'reader_id' => 'Reader ID',
            'author_id' => 'Author ID',
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
    public function getAuthor()
    {
        return $this->hasOne(Author::className(), ['id' => 'author_id']);
    }
}
