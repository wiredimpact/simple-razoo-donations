jQuery(document).ready(function(){
  var add_donation_amount = jQuery('#add-donation-amount'),
      donation_option_fields = jQuery('#donation-option-fields'),
      trash_cans = donation_option_fields.find('.row img');
      
  //Get the total number of showing fields    
  function get_showing_total(){
    var total_showing_fields = donation_option_fields.find('.row:not(.hide)').length;
    
    return total_showing_fields;
  }
  
  //Click to add donation option
  add_donation_amount.click(function(){
    donation_option_fields.find('.row.hide').first().removeClass('hide');
    
    if(get_showing_total() == 5){
      jQuery(this).addClass('default');
    }
    else {
      jQuery(this).removeClass('default');
    }
          
    return false;
  });
  
  
  //Click to remove donation option
  trash_cans.click(function(){
    var $this = jQuery(this);
    
    $this.closest('.row').addClass('hide');
    $this.siblings('input').val('');
    
    if(get_showing_total() < 5){
      add_donation_amount.removeClass('default');
    }
  });
  
  //Pull the donation amount and description into a string that can be used in the widget
  jQuery('#razoo-settings').submit(function(){
    var donate_options = '';
    
    donation_option_fields.find('.row .small-text').each(function(){
      
      var $this = jQuery(this);
      
      if($this.val() != ''){
        var amount, description;
        amount = parseFloat($this.val());
        description = $this.siblings('input').val();

        donate_options += amount + '=' + description + '|';
      }
      
    });
    
    donate_options = donate_options.slice(0,-1);
    console.log(donate_options);
    
    jQuery('#donation-options').val(donate_options);
    console.log(jQuery('#donation-options').val());
  }); 
  
}); //End Document Ready


//Run the color picker.
jQuery(document).ready(function(){
  jQuery('#colorpicker').farbtastic('#color');
}); //End Document Ready

