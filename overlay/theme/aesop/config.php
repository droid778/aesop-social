<?php
/**
 * Aesop theme stylesheet loader
 */

function aesop_init(\Friendica\App $a) {
    // Load custom stylesheet after parent theme
    \Friendica\DI::page()->registerStylesheet(__DIR__ . '/style.css');
}
