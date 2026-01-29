<?php
/**
 * Aesop Social instance defaults.
 *
 * This file is intentionally additive and must not override
 * core Friendica behavior.
 */

return [
    'system' => [
        'sitename' => 'Aesop Social',
        'default_theme' => 'aesop',
        'register_policy' => \Friendica\Module\Register::APPROVE,
        'invite_only' => true,
        'behind_proxy' => true,
        'proxy_user_headers' => true,
        'ssl_policy' => 1,
        'force_ssl' => true,
        'url' => 'https://aesop-social.uk',
        'base_path' => '/var/www/html',
    ],
    'addon' => [
    'aesop_voting' => 1,
    ],
];
