<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\File */
/* @var $form yii\widgets\ActiveForm */
?>

<br><br>

<div class="file-form">

    <?php if ($model->hasErrors()) {
        foreach ($model->errors as $error) {
            ?> <div class="error-summary"><?= $error[0] ?></div>

    <?php    
        }
     } 
     ?>

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

        <?php if ($model->filename) { ?>
            <div class="form-group field-files-title">
                <label class="control-label" for="files-title">
                    Current file ( <?= $model->filename ?> )
                </label>
                <audio id="player" src="<?=$files_path.$model->hashed_name?>" type="audio/mp3" controls="controls"></audio>
            </div>        
            
        <?php } ?>

    <?= $form->field($model, 'file')->fileInput() ?> 

    <?= $form->field($model, 'title')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'ganre')->textInput(['maxlength' => 255]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
