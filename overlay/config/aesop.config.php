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
    ]
];
