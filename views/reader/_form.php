<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\typeahead\Bloodhound;
use dosamigos\typeahead\TypeAhead;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Reader */
/* @var $form yii\widgets\ActiveForm */

$engine = new Bloodhound([
    'name' => 'booksEngine',
    'clientOptions' => [
        'datumTokenizer' => new \yii\web\JsExpression("Bloodhound.tokenizers.obj.whitespace('title')"),
        'queryTokenizer' => new \yii\web\JsExpression("Bloodhound.tokenizers.whitespace"),
        'remote' => [
            'url' => Url::to(['book/title-autocomplete', 'query'=>'QRY']),
            'wildcard' => 'QRY'
        ]
    ]
]);
?>

<div class="reader-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => 200]) ?>
    <div class="form-group">
        <label class="control-label" for="book-authors">Книги на курах</label>
        <?= TypeAhead::widget(
            [
                'id'=>'reader-books',
                'name'=>'reader-books',
                'options' => ['class' => 'form-control'],
                'engines' => [ $engine ],
                'clientOptions' => [
                    'highlight' => true,
                    'minLength' => 1,
                ],
                'dataSets' => [
                    [
                        'name' => 'books',
                        'displayKey' => 'title',
                        'source' => $engine->getAdapterScript()
                    ]
                ]
            ]
        );?>
    </div>
    <div id="books_buttons" class="form-group">
        <?foreach($model->getBooks()->select('id,title')->all() AS $book){?>
        <span class="btn btn-default book" onclick="jQuery(this).remove()">
        <input type="hidden" name="Reader[books_ids][]" value="<?=$book->id?>">
            <?=$book->title?>
            <span class="glyphicon glyphicon-remove"></span>
        </span>
        <?}?>
    </div>
    <?$this->registerJs(<<<JS
        jQuery('#reader-books').on('typeahead:selected typeahead:autocompleted', function (evt, data){
            jQuery('#books_buttons').append(' <span class="btn btn-default book" onclick="jQuery(this).remove()"><input type="hidden" name="Reader[books_ids][]" value="'+data.id+'">'+data.title+' <span class="glyphicon glyphicon-remove"></span></span>');
            jQuery('#reader-books').val('');
        });
JS
    );?>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
