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
declare(strict_types=1);

namespace Dotclear\Plugin\HowtoPostEditor;

use ArrayObject;
use dcAdmin;
use dcCore;
use dcPage;
use dcNsProcess;
use dcSettings;
use Dotclear\Helper\Html\Form\{
    Div,
    Label,
    Para,
    Text,
    Textarea
};

class Backend extends dcNsProcess
{
    public static function init(): bool
    {
        static::$init = defined('DC_CONTEXT_ADMIN');

        return static::$init;
    }

    public static function process(): bool
    {
        if (!static::$init) {
            return false;
        }

        // avoid null warnings
        if (is_null(dcCore::app()->auth) || is_null(dcCore::app()->adminurl)) {
            return false;
        }

        // add backend sidebar menu to go to manage page
        dcCore::app()->menu[dcAdmin::MENU_PLUGINS]->addItem(
            My::name(),
            dcCore::app()->adminurl->get('admin.plugin.' . My::id()),
            dcPage::getPF(My::id() . '/icon.svg'),
            preg_match('/' . preg_quote(dcCore::app()->adminurl->get('admin.plugin.' . My::id())) . '/', $_SERVER['REQUEST_URI']),
            dcCore::app()->auth->isSuperAdmin()
        );

        dcCore::app()->addBehaviors([
            // add HTML headers to backend blog preferences page
            'adminBlogPreferencesHeaders' => function (): string {
                if (is_null(dcCore::app()->auth)) {
                    return '';
                }

                return dcPage::jsModuleLoad(My::id() . '/js/backend.js');
            },

            // add our textarea form ID to post editor
            'adminPostEditorTags' => function (string $editor, string $context, ArrayObject $alt_tags, string $format): void {
                // there is an existsing postEditor on this page, so we add our textarea to it
                if ($context == 'blog_desc') {
                    $alt_tags->append('#textarea_HowtoPostEditor');
                }
            },

            // add our form to backend blog preferences page
            'adminBlogPreferencesFormV2' => function (dcSettings $blog_settings): void {
                echo
                (new Div())->class('fieldset')->items([
                    (new Text('h4', My::name()))->id(My::id()),
                    (new Div())->items([
                        (new Para())->items([
                            (new Label('Textarea:', Label::OUTSIDE_LABEL_BEFORE))->for('textarea_HowtoPostEditor'),
                            (new Textarea('textarea_HowtoPostEditor', ''))->cols(60)->rows(5)->lang($blog_settings->get('system')->get('lang'))->spellcheck(true),
                        ]),
                    ]),
                ])->render();
            },
        ]);

        return true;
    }
}
