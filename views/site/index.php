<?php
/* @var $this yii\web\View */
$this->title = 'Music CMS';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Welcome, <?= Yii::$app->user->identity->login ?></h1>

        <p class="lead">To start managing your music click the button bellow</p>

        <p><a class="btn btn-lg btn-success" href="?r=files/index">Manage music</a></p>
    </div>
</div>
