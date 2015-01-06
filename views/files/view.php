<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\File */

$this->title = $model->title ? $model->title : $model->filename;
$this->params['breadcrumbs'][] = ['label' => 'Files', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="file-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'id_users',
            'filename',
            [
                'label' => 'Listen to it',
                'value' => '<audio id="player" src="'.$files_path.$model->hashed_name.'" type="audio/mp3" controls="controls"></audio>',
                'format' => 'raw',
                'visible' => $model->hashed_name ? true : false,
            ],
            'title',
            'ganre',
        ],
    ]) ?>

</div>
