<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;

class AdminController extends Controller
{
    /**
     * Displays the admin home page.
     */
    public function actionIndex()
    {
        return $this->render('//site/admin/admin_home');
    }
}
