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
                SELECT book.id, title FROM '.Book::tableName().' book
                JOIN '.Reader2book::tableName().' ON (book.id = book_id)
                WHERE count_authors >= 3
                GROUP BY book.id')
        ]);

        // report 2
        $reportTwoDataProvider = new ActiveDataProvider([
            'query' => Author::findBySql('
                SELECT a.id, a.name , count(r2b.reader_id) as readers FROM '.Author::tableName().' a
                JOIN '.Book2author::tableName().' b2a ON (a.id = b2a.author_id)
                JOIN '.Reader2book::tableName().' r2b ON (r2b.book_id = b2a.book_id)
                GROUP BY a.id
                HAVING count(r2b.reader_id) > 3
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
