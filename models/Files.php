<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\File;
use yii\web\UploadedFile;

/**
 * Files represents the model behind the search form about `app\models\File`.
 */
class Files extends File
{

    // Directory should be writeable by Apache user, trailing slash required
    public static $uploadPath = 'uploads/';

    /**
     * @inheritdoc
     */
    public function rules()
    {
            return [
            [['id'], 'integer'],
            [['title', 'ganre', 'filename', 'hashed_name', 'login'], 'safe'],

            // Validation by MIME Type and extension seems broken for some reason.
            // Some files are accepted ok, some a rejected with error message. So checks are done manually
            // [['file'], 'file', 'extensions' => 'mp3, wav'],
            // [['file'], 'file', 'mimeTypes' => 'audio/mp3'],

            [['file'], 'required', 'on' => ['create']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = File::find()->select("files.id, files.title, files.ganre, files.filename, files.hashed_name, users.login")->joinWith('users');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'files.id' => $this->id,
            'users.login' => $this->login,
            'id_users' => $this->id_users,
        ]);

        $query->andFilterWhere(['like', 'filename', $this->filename])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'ganre', $this->ganre]);

        return $dataProvider;
    }

    public function beforeSave($insert) 
    {

        if (!parent::beforeSave($insert)) {
            $this->addError('beforeSave', "Something went wrong on previous steps, please refer to the logs.");
            return false;
        }

        $this->file = UploadedFile::getInstance($this, 'file');        

        if (!$this->file && $this->scenario == 'create') {
            $this->addError('file', "Uploaded file is unaccessible. Permission issues?");
            return false;
        }

        // File validation
        if ($this->file && $this->file->type != 'audio/mp3') {
            $this->addError('file', "File MIME type is ".$this->file->type." while allowed are only MP3.");
            return false;
        }

        // Directory that will handle uploaded files
        $uploadHere = self::$uploadPath.Yii::$app->user->identity->id.'/';

        // We need to delete exising file first if this is an update
        if ($this->scenario != 'create' && $this->file) {
            unlink($uploadHere . $this->hashed_name);
        }

        // We process file only in case when we create a new record or updating old one with file uploaded
        // In other case just update DB
        if ($this->scenario == 'create' || $this->file) {

            $this->filename = $this->file->baseName . '.' . $this->file->extension;
            $this->id_users = Yii::$app->user->identity->id;

            // We extract title from file name in case when title is not specified
            $this->title = $this->title ? $this->title : $this->file->baseName;

            // We hash filename with MD5 to allow multiple file uploads with same name
            $this->hashed_name = md5($this->file->baseName.microtime()) . '.' . $this->file->extension;

            $this->createUploadDirectory();

            if ($this->file->saveAs($uploadHere . $this->hashed_name)) {
                return parent::beforeSave($insert);
            } else {
                $this->addError('saveAs', "Something went wrong during saving file. Permission issues?");
                return false;
            }
        }

        if ($this->scenario != 'create') {
            return parent::beforeSave($insert);
        }

        $this->addError('Unexpected routine', "Something went wrong during DB record update. Execution should not get here.");
        return false;

    }

    public function beforeDelete() 
    {

        if (!parent::beforeDelete()) {
            $this->addError('beforeDelete', "Something went wrong on previous steps, please refer to the logs.");
            return false;
        }

        $uploadHere = self::$uploadPath.$this->id_users.'/';
        unlink($uploadHere . $this->hashed_name);

        return true;
    }

    private static function createUploadDirectory() 
    {

        // Form path with general upload directory + user id
        $uploadHere = self::$uploadPath.Yii::$app->user->identity->id;

        // Create directory for users that never uploaded files before
        if (!is_dir($uploadHere)) {

            // Directory with write only by owner permissions is created
            mkdir($uploadHere, 0700);
        }
    }

    /**
     * Used when user is deleted and it's directories are to be purged
     *
     */

    public static function deleteUploadDirectory($id_users) 
    {

        $uploadHere = self::$uploadPath.$id_users;
        if (is_dir($uploadHere)) {
            rmdir($uploadHere);
        }

    }    
}
