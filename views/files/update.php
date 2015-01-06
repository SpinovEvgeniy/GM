<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = 'Update File: ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="file-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'files_path' => $files_path
    ]) ?>

</div>
