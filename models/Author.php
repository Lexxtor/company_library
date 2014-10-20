<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "author".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_inserted
 * @property string $date_updated
 *
 * @property integer $readers
 * @property Book2author[] $book2authors
 * @property Reader2author[] $reader2authors
 */
class Author extends \yii\db\ActiveRecord
{
    public $readers;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'author';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'date_inserted' => 'Создано',
            'date_updated' => 'Обновлено',
            'readers' => 'Число читателей',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook2authors()
    {
        return $this->hasMany(Book2author::className(), ['author_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReader2authors()
    {
        return $this->hasMany(Reader2author::className(), ['author_id' => 'id']);
    }
}
