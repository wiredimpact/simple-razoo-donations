(function() {
  tinymce.create('tinymce.plugins.Razoo', {
    init : function(ed, url) {
      ed.addButton('razoo', {
        title : 'Razoo Donation Widget Shortcode',
        image : url.replace('js', 'img/razoo-icon.png'),
        onclick : function() {
          //ed.execCommand('mceInsertContent', false, '[razoo_widget]');
          // triggers the thickbox
          show_razoo_popup();
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
    
  function show_razoo_popup(){
    var form = jQuery('<div id="razoo-form"></div>');
    form.appendTo('body').hide();
    
    var data = {
      action: 'razoo_popup'
    };
    
    jQuery.post(ajaxurl, data, function(response){
    
      jQuery('#razoo-form').html(response);
      
      var width = jQuery(window).width(), H = jQuery(window).height(), W = ( 720 < width ) ? 720 : width;
          W = W - 80;
          H = H - 84;
          tb_show( 'Razoo Shortcode Settings', '#TB_inline?width=' + W + '&height=' + H + '&inlineId=razoo-form' );
    
      var table = jQuery('#razoo-popup-table'),
          submitButton = table.siblings('p').find('#razoo-popup-submit');
		
      // handles the click event of the submit button
      submitButton.click(function(){
        // defines the options and their default values
        // again, this is not the most elegant way to do this
        // but well, this gets the job done nonetheless
        var options = { 
          'columns'    : '3',
          'id'         : '',
          'size'       : 'thumbnail',
          'orderby'    : 'menu_order ASC, ID ASC',
          'itemtag'    : 'dl',
          'icontag'    : 'dt',
          'captiontag' : 'dd',
          'link'       : '',
          'include'    : '',
          'exclude'    : '' 
        };
        var shortcode = '[gallery';
			
        for( var index in options) {
          var value = table.find('#mygallery-' + index).val();
				
          // attaches the attribute to the shortcode only if it's different from the default value
          if ( value !== options[index] )
            shortcode += ' ' + index + '="' + value + '"';
        }
			
        shortcode += ']';
			
        // inserts the shortcode into the active editor
        tinyMCE.activeEditor.execCommand('mceInsertContent', 0, shortcode);
			
        // closes Thickbox
        tb_remove();
      });
    });
  }   
    
})();