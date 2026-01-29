<?php
/**
 * Register deprecated PHP functions with Smarty for template compatibility
 * This file is loaded early by the Dockerfile to ensure Smarty is properly configured
 */

if (!function_exists('aesop_register_smarty_plugins')) {
    function aesop_register_smarty_plugins() {
        global $SMARTY;
        
        if (!isset($SMARTY) || !($SMARTY instanceof \Smarty)) {
            return;
        }

        $plugins = [
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
        ];

        foreach ($plugins as $plugin) {
            if (function_exists($plugin)) {
                try {
                    $SMARTY->registerPlugin('modifier', $plugin, $plugin);
                } catch (Exception $e) {
                    // Plugin already registered or Smarty not ready
                }
            }
        }
    }

    // Register on Friendica hooks if available
    if (function_exists('\\Friendica\\DI::hook')) {
        \\Friendica\\DI::hook()->register('template_vars', 'aesop_register_smarty_plugins');
    }
    
    // Also try direct registration if global Smarty is available
    if (isset($GLOBALS['SMARTY'])) {
        aesop_register_smarty_plugins();
    }
}
