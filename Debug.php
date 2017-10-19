<?php

namespace achertovsky\helpers;

/**
 * Various things to help with debugging
 */
class Debug
{
    /**
     * Returns trace to required point from start of script
     * @param boolean $asString
     * Determines format of return. In case of true string will be returned
     * @return mixed
     */
    public static function currentPointTrace($asString = false)
    {
        $debug = debug_backtrace();
        $fileLine = [];
        foreach ($debug as $trace) {
            if (empty($trace['file'])) {
                continue;
            }
            $fileLine[] = "{$trace['file']}({$trace['line']})";
        }
        
        if ($asString) {
            return var_export($fileLine, true);
        }
        return $fileLine;
    }
}
