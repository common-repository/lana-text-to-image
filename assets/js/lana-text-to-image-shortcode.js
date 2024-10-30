tinymce.PluginManager.add('lana_text_to_image', function (editor) {

    editor.addButton('lana_text_to_image', {
        tooltip: 'Text to Image Shortcode',
        icon: 'lana-text-to-image',
        cmd: 'lanaTextToImageShortcodeCmd'
    });

    editor.addCommand('lanaTextToImageShortcodeCmd', function () {
        editor.windowManager.open({
            title: 'Text to Image',
            body: [
                {
                    type: 'textbox',
                    name: 'text',
                    label: 'Text',
                    minWidth: 350
                }
            ],
            onsubmit: function (e) {
                editor.focus();
                editor.execCommand('mceInsertContent', false, '[lana_text_to_image text="' + e.data.text + '"]');
            }
        });
    });
});