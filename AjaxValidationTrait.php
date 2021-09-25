<?php

namespace common\traits;

use Yii;
use yii\base\Model;
use yii\web\Response;
use yii\widgets\ActiveForm;

trait AjaxValidationTrait
{
    /**
     * performs ajax validation
     */
    public function ajaxValidation(Model $model = null)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (!is_null($model)) {
                /* $model variable has been passed as a function argument */
                Yii::$app->response->data = ActiveForm::validate($model);
            } elseif (method_exists($this, 'validate')) {
                /* @var $this Model */
                Yii::$app->response->data = $this->validate();
            } else {
                Yii::$app->response->data = 'false';
            }
            Yii::$app->end();
        }
    }
}
