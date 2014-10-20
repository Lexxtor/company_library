<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\typeahead\Bloodhound;
use dosamigos\typeahead\TypeAhead;
use yii\helpers\Url;


/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */

$engine = new Bloodhound([
    'name' => 'authorsEngine',
    'clientOptions' => [
        'datumTokenizer' => new \yii\web\JsExpression("Bloodhound.tokenizers.obj.whitespace('name')"),
        'queryTokenizer' => new \yii\web\JsExpression("Bloodhound.tokenizers.whitespace"),
        'remote' => [
            'url' => Url::to(['author/name-autocomplete', 'query'=>'QRY']),
            'wildcard' => 'QRY'
        ]
    ]
]);
?>

<div class="book-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 200]) ?>
    <div class="form-group">
        <label class="control-label" for="book-authors">Авторы</label>
        <?= TypeAhead::widget(
            [
                'id'=>'book-authors',
                'name'=>'book-authors',
                'options' => ['class' => 'form-control'],
                'engines' => [ $engine ],
                'clientOptions' => [
                    'highlight' => true,
                    'minLength' => 1,
                ],
                'dataSets' => [
                    [
                        'name' => 'authors',
                        'displayKey' => 'name',
                        'source' => $engine->getAdapterScript()
                    ]
                ]
            ]
        );?>
    </div>
    <div id="authors_buttons" class="form-group">
    <?foreach($model->getAuthors()->select('id,name')->all() AS $author){?>
        <span class="btn btn-default author" onclick="jQuery(this).remove()">
            <input type="hidden" name="Book[authors_ids][]" value="<?=$author->id?>">
            <?=$author->name?>
            <span class="glyphicon glyphicon-remove"></span>
        </span>
    <?}?>
    </div>
    <?$this->registerJs(<<<JS
        jQuery('#book-authors').on('typeahead:selected typeahead:autocompleted', function (evt, data){
            jQuery('#authors_buttons').append(' <span class="btn btn-default author" onclick="jQuery(this).remove()"><input type="hidden" name="Book[authors_ids][]" value="'+data.id+'">'+data.name+' <span class="glyphicon glyphicon-remove"></span></span>');
            jQuery('#book-authors').val('');
        });
JS
);?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
