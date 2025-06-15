<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class AdminController extends Controller
{

        public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['index'], // restrict only this action
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'], // '@' = authenticated users only
                    ],
                ],
            ],
        ];
    }

    /**
     * Displays the admin home page.
     */
    public function actionIndex()
    {
        return $this->render('//site/admin/admin_home');
    }
}
