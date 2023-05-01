<?php
/**
 * @brief HowtoPostEditor, a plugin for Dotclear 2
 *
 * @package Dotclear
 * @subpackage Plugin
 *
 * @author Jean-Christian Denis
 *
 * @copyright Jean-Christian Denis
 * @copyright GPL-2.0 https://www.gnu.org/licenses/gpl-2.0.html
 */
if (!defined('DC_RC_PATH')) {
    return null;
}

$this->registerModule(
    'Howto PostEditor',
    'How to add post editor',
    'Jean-Christian Denis',
    '1.1',
    [
        'requires'   => [['core', '2.26']],
        'type'       => 'plugin',
        'support'    => 'https://github.com/JcDenis/' . basename(__DIR__),
        'details'    => 'https://github.com/JcDenis/' . basename(__DIR__),
        'repository' => 'https://raw.githubusercontent.com/JcDenis/' . basename(__DIR__) . '/master/dcstore.xml',
        'settings'   => [
            'blog' => '#params.' . basename(__DIR__),
        ],
    ]
);
