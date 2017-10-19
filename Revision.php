<?php

namespace achertovsky\helpers;

use Yii;

class Revision
{
    public static function addRevision($fileName)
    {
        $revision = isset(Yii::$app->params['revision']) ? "?".Yii::$app->params['revision'] : "";
        if (strpos($fileName, $revision) === false) {
            $fileName .= $revision;
        }
        return $fileName;
    }
}
