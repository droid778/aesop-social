<?php
/**
 * Aesop Social: Register Smarty plugins for deprecated PHP functions
 * Hook to register is_null and other common PHP functions as Smarty modifiers
 */

namespace Aesop\Hooks;

use Friendica\App;
use Smarty;

/**
 * Register PHP functions with Smarty template engine
 */
class SmartySmartyPlugins
{
    /**
     * Register common PHP functions as Smarty modifiers
     *
     * @param App $a The Friendica App instance
     * @param Smarty $smarty The Smarty engine instance
     * @return void
     */
    public static function register(App $a, Smarty $smarty): void
    {
        $functions = [
            'is_null',
            'is_array',
            'is_string',
            'is_numeric',
            'is_int',
            'is_float',
            'is_bool',
            'strlen',
            'count',
            'empty',
            'isset',
        ];

        foreach ($functions as $func) {
            if (function_exists($func)) {
                $smarty->registerPlugin('modifier', $func, $func);
            }
        }
    }
}
