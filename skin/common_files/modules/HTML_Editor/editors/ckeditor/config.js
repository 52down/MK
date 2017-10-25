/* vim: set ts=2 sw=2 sts=2 et: */
/**
 * @license Copyright (c) 2003-2016, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';
};

CKEDITOR.on('dialogDefinition', function (ev) {
    var dialogName = ev.data.name;
    var dialogDefinition = ev.data.definition;

    if (dialogName == 'image') {

        var upload_tab = dialogDefinition.getContents('Upload');

        upload_tab.add({
            type: 'button',
            label: 'Upload inline',
            id: 'uploadInline',
            title: 'Use this option for small images (up to 100x100 px)',
            onClick: function () {
                // wow, this is magic
                var fileinp = dialogDefinition.dialog.getContentElement('Upload', 'upload')
                        .getElement().$.getElementsByTagName('iframe')[0]
                        .contentDocument.querySelectorAll('input[type=file]')[0];

                if (fileinp.files && fileinp.files[0]) {
                    var reader = new FileReader();
                    reader.onloadend = function () {
                        dialogDefinition.dialog.setValueOf('info', 'txtUrl', reader.result);
                        dialogDefinition.dialog.selectPage('info');
                    };
                    reader.readAsDataURL(fileinp.files[0]);
                }
            }
        });

        upload_tab.add({
            type: 'html',
            html: '<h2>You can also drag and drop an image directly to the edit area</h2>'
        });
    }
});
