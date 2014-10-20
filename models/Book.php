<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "book".
 *
 * @property integer $id
 * @property string $title
 * @property string $count_authors
 * @property string $date_inserted
 * @property string $date_updated
 *
 * @property Book2author[] $book2authors
 * @property Reader2book[] $reader2books
 */
class Book extends \yii\db\ActiveRecord
{
    public $authors_ids;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'book';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['authors_ids'], 'filter', 'filter' => 'array_unique'],
            [['title'], 'string', 'max' => 200]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'date_inserted' => 'Создано',
            'date_updated' => 'Обновлено',
            'authors' => 'Авторы',
        ];
    }

    public function attributes()
    {
        return array_merge(
            parent::attributes(),
            ['authors_ids']
        );
    }

    public function afterValidate()
    {
        $this->count_authors = sizeof($this->authors_ids);
        parent::afterValidate();
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (!$insert) $this->deleteAllAuthors();
        $this->addAuthors($this->authors_ids);
    }

    public function deleteAllAuthors()
    {
        Book2author::deleteAll('book_id = :book_id', [':book_id'=>$this->id]);
    }

    public function addAuthors($authors_ids)
    {
        if (empty($authors_ids)) return;

        $values = [];
        foreach ($authors_ids AS $id)
            $values[] = [$this->id, $id];

        Yii::$app->db->createCommand()
            ->batchInsert(Book2author::tableName(), ['book_id','author_id'], $values)
            ->execute();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBook2authors()
    {
        return $this->hasMany(Book2author::className(), ['book_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthors()
    {
        return $this->hasMany(Author::className(), ['id' => 'author_id'])
            ->via('book2authors');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReaders()
    {
        return $this->hasMany(Reader::className(), ['id' => 'reader_id'])
            ->via('reader2books');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getReader2books()
    {
        return $this->hasMany(Reader2book::className(), ['book_id' => 'id']);
    }
}
