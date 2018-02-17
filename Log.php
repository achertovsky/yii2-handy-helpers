<?php

namespace achertovsky\helpers;

use Yii;
use yii\helpers\ArrayHelper;
use yii\log\EmailTarget;

class Log
{
    /**
     * @return yii\log\Logger
     */
    public static function getInitialLogger()
    {
        return Yii::getLogger();
    }
    
    /**
     * Overrides except of logger on the fly
     * @param string|array $category
     * @param boolean $dontTouchEmailLogs
     * in case of true this param wont allow helper to change EmailTarget components
     */
    public static function ignoreCategory($category, $dontTouchEmailLogs = false)
    {
        if (!is_array($category)) {
            $category = [$category];
        }
        $logger = self::getInitialLogger();
        $targets = $logger->dispatcher->targets;
        if ($category != '*') {
            foreach ($targets as $key => $target) {
                if ($dontTouchEmailLogs && $target instanceof EmailTarget) {
                    continue;
                }
                $target->except = ArrayHelper::merge(
                    $target->except,
                    $category
                );
                $targets[$key] = $target;
            }
        } else {
            $targets = [];
        }
        $logger->dispatcher->targets = $targets;
        self::setLogger($logger);
    }
    
    /**
     * @param yii\log\Logger $logger
     */
    public static function setLogger($logger)
    {
        Yii::setLogger($logger);
    }
}
