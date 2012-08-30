(function() {
  tinymce.create('tinymce.plugins.Razoo', {
    init : function(ed, url) {
      ed.addButton('razoo', {
        title : 'Razoo Donation Widget Shortcode',
        image : url.replace('js', 'img/razoo-icon.png'),
        onclick : function() {
          ed.execCommand('mceInsertContent', false, '[razoo_widget]');
        }
      });
    },
    createControl : function(n, cm) {
      return null;
    },
    getInfo : function() {
      return {
        longname : "Razoo Donation Widget Shortcode",
        author : 'Wired Impact',
        authorurl : 'http://wiredimpact.com/',
        infourl : 'http://wiredimpact.com/',
        version : "1.0"
      };
    }
  });
  tinymce.PluginManager.add('razoo', tinymce.plugins.Razoo);    
})();