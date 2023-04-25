/*global $, dotclear, jsToolBar */
'use strict';

$(() => {
  if (typeof jsToolBar === 'function') {
    $('#howtoPostEditor').each(function () {
      const howtoPostEditor = new jsToolBar(this);
      howtoPostEditor.draw('xhtml');
    });
  }
});