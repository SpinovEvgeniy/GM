<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\User;

/**
 * Users represents the model behind the search form about `app\models\User`.
 */
class Users extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['login', 'password'], 'safe'],
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
        $query = User::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!($this->load($params) && $this->validate())) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'login', $this->login])
            ->andFilterWhere(['like', 'password', $this->password]);

        return $dataProvider;
    }

    function beforeDelete() 
    {

        if (Files::find()->where(['id_users' => $this->id])->count()) {
            $this->addError('recordsPresent', "You cannot delete this user, cause he still have files uploaded. Delete files first.");
            return false;
        }

        if (!parent::beforeDelete()) {
            $this->addError('beforeDelete', "Something went wrong on previous steps, please refer to the logs.");
            return false;
        }

        Files::deleteUploadDirectory($this->id);

        return true;

    }
}
