CKEDITOR.plugins.add('socialembed', {
    icons: 'socialembed',
    init: function(editor) {
  
      // Register dialog
      CKEDITOR.dialog.add('socialEmbedDialog', function(editor) {
        return {
          title: 'Insert Social Media Embed',
          minWidth: 400,
          minHeight: 100,
          contents: [
            {
              id: 'tab-basic',
              label: 'URL',
              elements: [
                {
                  type: 'text',
                  id: 'url',
                  label: 'Social Media URL',
                  validate: CKEDITOR.dialog.validate.notEmpty("Please enter a URL.")
                }
              ]
            }
          ],
          onOk: function() {
            var url = this.getValueOf('tab-basic', 'url');
  
            // AJAX call to your PHP embed script
            fetch('/admin/ckeditor/plugins/socialembed/embed.php?url=' + encodeURIComponent(url))
              .then(res => res.text())
              .then(embedHtml => {
                editor.insertHtml(embedHtml);
              })
              .catch(err => {
                alert('Error embedding content.');
                console.error(err);
              });
          }
        };
      });
  
      // Add button to toolbar
      editor.ui.addButton('SocialEmbed', {
        label: 'Insert Social Embed',
        command: 'openSocialEmbedDialog',
        toolbar: 'insert',
        icon: this.path + 'icons/socialembed.png'
      });
  
      editor.addCommand('openSocialEmbedDialog', new CKEDITOR.dialogCommand('socialEmbedDialog'));
    }
  });
  