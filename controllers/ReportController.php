<?php

namespace app\controllers;

use app\models\Author;
use app\models\Book;
use app\models\Book2author;
use app\models\Reader2book;
use yii\data\ActiveDataProvider;

class ReportController extends \yii\web\Controller
{
    public function actionIndex()
    {
        // report 1
        $reportOneDataProvider = new ActiveDataProvider([
            'query' => Book::findBySql('
                SELECT id, title FROM '.Book::tableName().'
                WHERE reader_id IS NOT NULL AND count_authors >= 3
            ')
        ]);

        // report 2
        $reportTwoDataProvider = new ActiveDataProvider([
            'query' => Author::findBySql('
                SELECT a.id, a.name , count(book.reader_id) as readers FROM '.Author::tableName().' a
                JOIN '.Book2author::tableName().' b2a ON (a.id = b2a.author_id)
                JOIN '.Book::tableName().' book ON (book.id = b2a.book_id)
                GROUP BY a.id
                HAVING count(book.reader_id) > 3
                ')
        ]);

        // report 3
        $limit = \Yii::$app->params['randomBooksLimit'];

        $booksCount = (new \yii\db\Query())
            ->select('COUNT(*)')
            ->from(Book::tableName())
            ->scalar();

        $reportThreeDataProvider = new ActiveDataProvider([
            'sort' => false,
            'pagination' => false,
            'query' => Book::findBySql('SELECT * FROM '.Book::tableName().'
                WHERE RAND()<(('.$limit.'/'.$booksCount.')*10) ORDER BY RAND()
                LIMIT '.$limit),
        ]);

        return $this->render('index',[
            'reportOneDataProvider' => $reportOneDataProvider,
            'reportTwoDataProvider' => $reportTwoDataProvider,
            'reportThreeDataProvider' => $reportThreeDataProvider,
        ]);
    }

}
