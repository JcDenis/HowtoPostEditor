/*global $, dotclear, jsToolBar */
'use strict';

$(() => {
  if (typeof jsToolBar === 'function') {
    $('#textarea_HowtoPostEditor').each(function () {
      const HowtoPostEditorJsToolBar = new jsToolBar(this);
      HowtoPostEditorJsToolBar.draw('xhtml');
    });
  }
});