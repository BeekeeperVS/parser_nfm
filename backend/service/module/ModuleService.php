<?php


namespace app\service\module;


use Yii;
use yii\filters\AccessControl;

class ModuleService extends \yii\base\Module
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'denyCallback' => function ($rule, $action) {
                    return $action->controller->redirect('/');
                },
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            return (!Yii::$app->user->isGuest);
                        }
                    ]
                ]
            ]
        ];
    }
}