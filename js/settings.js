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
  
  
  //Click of submit
  //Take all form values and place them in the correct format
  
  
  
}); //End Document Ready


//Run the color picker.
jQuery(document).ready(function(){
  jQuery('#colorpicker').farbtastic('#color');
}); //End Document Ready

