<?php
/**
 * @brief howtoPostEditor, a plugin for Dotclear 2
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

namespace Dotclear\Plugin\howtoPostEditor;

use dcCore;
use dcNsProcess;
use dcPage;
use Dotclear\Helper\Html\Form\{
    Checkbox,
    Div,
    Form,
    Hidden,
    Input,
    Label,
    Note,
    Para,
    Submit,
    Text,
    Textarea
};

class Manage extends dcNsProcess
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

        return true;
    }

    public static function render(): void
    {
        if (!static::$init) {
            return;
        }

        // avoid null warnings
        if (is_null(dcCore::app()->auth) || is_null(dcCore::app()->adminurl)) {
            return;
        }

        // retrieve used editor
        $editor = dcCore::app()->auth->getOption('editor');

        // open our manage page
        dcPage::openModule(
            // page title
            'howtoPostEditor',
            // register our form into post editor
            dcCore::app()->callBehavior('adminPostEditor', $editor['xhtml'], 'demo_context', ['#howtoPostEditor'], 'xhtml') .
            // add HTML header to load our js file
            dcPage::jsModuleLoad('howtoPostEditor/js/backend.js')
        );

        // add page header
        echo
        dcPage::breadcrumb([
            __('Plugins')            => '',
            'How to add post editor' => '',
        ]) .
        // display dotclear notices
        dcPage::notices() .

        // build ou textarea form
        (new Form('howtoPostEditor_form'))->method('post')->action(dcCore::app()->adminurl->get('admin.plugin.howtoPostEditor'))->fields([
            (new Div())->class('fieldset')->items([
                (new Para())->class('area')->items([
                    (new Label('Textarea:', Label::OUTSIDE_LABEL_BEFORE))->for('howtoPostEditor'),
                    (new Textarea('howtoPostEditor', ''))->cols(40)->rows(10),
                ]),
            ]),
        ])->render();

        // close our module page
        dcPage::closeModule();
    }
}
