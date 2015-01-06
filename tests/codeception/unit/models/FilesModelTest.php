<?php

namespace tests\codeception\unit\models;

use Yii;
use yii\codeception\TestCase;
use app\models\LoginForm;
use app\models\Files;
use Codeception\Specify;

class FilesModelTest extends TestCase
{
    use Specify;

    protected function setUp() {
        parent::setUp();
        $login_model = new LoginForm([
            'login' => 'admin',
            'password' => 'admin'
            ]);

        $login_model->login();
    }

    protected function tearDown()
    {
        Yii::$app->user->logout();
        parent::tearDown();
    }


    public function testFileAddDelete()
    {
        $model = new Files([
            'filename'      => 'test_filename',
            'title'         => 'Test filename',
            'ganre'         => 'New ganre',
            'hashed_name'   => md5('Test filename'),
        ]);

        $this->specify('record should be successfully inserted', function () use ($model) {
            expect('record successfully inserted', $model->save())->true();
            $model = Files::findOne($model->id);
            expect('record exists', $model instanceof Files)->true();
        });

        $this->specify('record should be successfully deleted', function() use ($model) {
            expect('record successfully deleted', $model->delete())->equals(1);
        });
    }
}
