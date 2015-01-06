<?php

namespace app\models;

use Yii;
use app\models\Users;

/**
 * This is the model class for table "files".
 *
 * @property integer $id
 * @property integer $id_users
 * @property string $filename
 * @property string $title
 * @property string $ganre
 */
class File extends \yii\db\ActiveRecord
{

    // This variable will be used for form generation
    public $file;

    // Login assiciated with file
    public $login;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_users', 'filename', 'title', 'ganre', 'hashed_name'], 'required'],
            [['id_users'], 'integer'],
            [['filename', 'title', 'ganre'], 'string', 'max' => 255],
            [['hashed_name'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_users' => 'ID of the user',
            'filename' => 'Filename',
            'title' => 'Title',
            'ganre' => 'Ganre',
            'hashed_name' => 'Hashed file name'
        ];
    }

    public function getUsers() {
        return $this->hasOne(Users::className(), ['id' => 'id_users']);
    }
}
