<?php

namespace achertovsky\helpers;

use Yii;
use yii\helpers\ArrayHelper;

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
     * @param array $dontTouchClasses
     * classes listed in this array and their descendants wont be ignored
     */
    public static function ignoreCategory($category, $dontTouchClasses = [])
    {
        if (!is_array($category)) {
            $category = [$category];
        }
        $logger = self::getInitialLogger();
        $targets = $logger->dispatcher->targets;
        foreach ($targets as $key => $target) {
            foreach ($dontTouchClasses as $class) {
                if ($target instanceof $class) {
                    continue 2;
                }
            }
            if ($category == ['*']) {
                unset($targets[$key]);
                continue;
            }
            $target->except = ArrayHelper::merge(
                $target->except,
                $category
            );
            $targets[$key] = $target;
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
