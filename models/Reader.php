<?php

namespace app\models;

use Yii;
use yii\db\Query;

/**
 * This is the model class for table "reader".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_inserted
 * @property string $date_updated
 *
 * @property Reader2author[] $reader2authors
 * @property Reader2book[] $reader2books
 */
class Reader extends \yii\db\ActiveRecord
{
    public $books_ids;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reader';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['books_ids'], 'safe'],
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
        ];
    }

    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            ['books_ids']
        );
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBooks()
    {
        return $this->hasMany(Book::className(), ['reader_id' => 'id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        if (!$insert) $this->deleteAllBooks();
        $this->addBooks($this->books_ids);
    }

    public function deleteAllBooks()
    {
        Book::updateAll(['reader_id'=>null], 'reader_id = :reader_id', [':reader_id'=>$this->id]);
    }

    public function addBooks($books_ids)
    {
        if (empty($books_ids)) return;

        // так как в Yii2 нет возможности биндить массивы, фильтруем значения сами:
        $values = [];
        foreach ($books_ids AS $id)
            $values[] = intval($id);

        Book::updateAll(['reader_id'=>$this->id], 'id IN ('.implode(',',$values).')');
    }
}
