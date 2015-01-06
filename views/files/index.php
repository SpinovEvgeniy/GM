<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\Files */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Files';
$this->params['breadcrumbs'][] = $this->title;
$this->params['files_path'] = $files_path;
?>
<div class="file-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create File', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'label' => "Owner",
                'value' => function ($data) {
                    return $data->login;
                },
                'attribute' => 'login'
            ],
            [
                'label'         => 'Filename',
                'value'         => function ($data) {
                    return $data->filename.'<audio id="player" src="'.$this->params['files_path'].$data->hashed_name.'" type="audio/mp3" controls="controls"></audio>';
                },
                
                'format'        => 'raw',
                'visible'       => function ($data) {
                    return $data->hashed_name ? true : false;
                },
                'attribute'     => 'filename'
            ],
            'title',
            'ganre',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
