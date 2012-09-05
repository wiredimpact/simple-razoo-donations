<?php

class razoo_options_page {
  
  public function __construct() {
    add_action('admin_menu', array($this, 'add_settings_page'));
    add_action('admin_init', array($this, 'settings_init'));
    add_action('admin_head', array($this, 'custom_admin_css'));
    add_action('admin_head', array($this, 'add_styles_scripts'));
    
  }
  
  public function add_settings_page(){
    $settings = add_options_page(
      'Razoo Donation Widget',
      'Razoo Donation Widget',
      'manage_options',
      'razoo-donation-widget-settings',
      array($this, 'settings_page_content')
    );
    
    //Add our styles and scripts only on the settings page.
    add_action('load-' . $settings, array($this, 'add_styles_scripts'));
  }
  
  public function settings_page_content(){
    ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h2>Razoo Donation Widget Settings</h2>
      <form id="razoo-settings" action="options.php" method="post">
        
        <?php settings_fields('razoo_options'); ?>
        <div class="alignright razoo-widget"><?php echo do_shortcode('[razoo_widget]'); ?></div>
        <?php do_settings_sections('razoo-donation-widget-settings'); ?>
        
        <p class="submit">
          <input id="razoo-submit" name="Submit" type="submit" class="button-primary" value="Save Changes & Update Donation Widget" />
        </p>
        
      </form>
    </div>
    <?php
  }
  
  function settings_init(){
    register_setting(
      'razoo_options',
      'razoo_options',
      array($this, 'validate_options')
    );
    
    /**Option Settings**/
    add_settings_section(
      'razoo-options-main',
      'Settings',
      array($this, 'options_settings_text'),
      'razoo-donation-widget-settings'
    );
    
    add_settings_field(
      'charity_id',
      'ID',
      array($this, 'id_input'),
      'razoo-donation-widget-settings',
      'razoo-options-main'
    );
    
    add_settings_field(
      'title',
      'Title',
      array($this, 'title_input'),
      'razoo-donation-widget-settings',
      'razoo-options-main'
    );
    
    add_settings_field(
      'summary',
      'Summary',
      array($this, 'summary_input'),
      'razoo-donation-widget-settings',
      'razoo-options-main'
    );
    
    add_settings_field(
      'more-info',
      'More Info',
      array($this, 'more_info_textarea'),
      'razoo-donation-widget-settings',
      'razoo-options-main'
    );
    
    add_settings_field(
      'color',
      'Color',
      array($this, 'color_input'),
      'razoo-donation-widget-settings',
      'razoo-options-main'
    );
    
    add_settings_field(
      'image',
      'Show Image',
      array($this, 'show_image_input'),
      'razoo-donation-widget-settings',
      'razoo-options-main'
    );
    
    add_settings_field(
      'donation-options',
      'Donation Options',
      array($this, 'donation_option_input'),
      'razoo-donation-widget-settings',
      'razoo-options-main'
    );
    
    add_settings_section(
      'razoo-options-docs',
      'How Tos',
      array($this, 'options_docs_text'),
      'razoo-donation-widget-settings'
    );
  }
  
  //Settings Section and Fields
  function options_settings_text(){
    echo '<p>Adjust your Razoo Donation Widget settings.  Every time you save changes the widget on the right will update to show you exactly what it will look like on your website.  To add the Razoo Donation widget to your website simply type "[razoo_widget]" into the WordPress editor wherever you want to add the donation widget.';
  }
  
  //Charity ID
  function id_input(){
    $options = get_option('razoo_options');
    $id = $options['charity_id'];
    
    echo '<input id="id" name="razoo_options[charity_id]" type="text" value="' . $id .'" class="regular-text" />';
    echo '<p class="description">This is the ID for your organization according to Razoo.  When on your organization\'s landing page it\'s the text that comes right after "/story/".  For example, the United Way of America ID is "United-Way-Of-America".  You can view their ID at <a href="http://www.razoo.com/story/United-Way-Of-America" target="_blank">http://www.razoo.com/story/United-Way-Of-America</a>.</p>';
  }
  
  //Widget Title
  function title_input(){
    $options = get_option('razoo_options');
    $title = $options['title'];
    
    echo '<input id="title" name="razoo_options[title]" type="text" value="' . $title .'" class="regular-text" />';
    echo '<p class="description">The title will show up in big letters at the top of the donation widget.</p>';
  }
  
  //Summary
  function summary_input(){
    $options = get_option('razoo_options');
    $summary = $options['summary'];
    
    echo '<input id="summary" name="razoo_options[summary]" type="text" value="' . $summary .'" class="regular-text" />';
    echo '<p class="description">The summary is a short description of your organization or an ask for people to donate.</p>';
  }
  
  //More Info
  function more_info_textarea(){
    $options = get_option('razoo_options');
    $more_info = $options['more_info'];
    
    echo '<textarea id="more-info" rows="5" name="razoo_options[more_info]" class="large-text">' . $more_info .'</textarea>';
    echo '<p class="description">The more info section can be much longer, describing more about your organization and where the donors money will go.</p>';
  }
  
  //Color
  function color_input(){
    $options = get_option('razoo_options');
    $color = $options['color'];
    
    echo '<input id="color" name="razoo_options[color]" type="text" value="' . $color .'" />';
    echo '<p class="description">Provide the color you want for the donation widget in <a href="http://www.w3schools.com/html/html_colors.asp" target="_blank">hexadecimal format</a> (#000000).  You should match this closely to your website\'s colors.  You can also use the color picker below to make your selection.</p>';
    echo '<div id="colorpicker"></div>';
  }
  
  //Show Image
  function show_image_input(){
    $options = get_option('razoo_options');
    $show_image = $options['show_image'];
    
    echo '<label for="show-image"><input id="show-image" name="razoo_options[show_image]" type="checkbox" value="true" ' . checked($show_image, 'true', false) . '/>';
    echo ' Do you want the main image for your organization to show up on the donation widget?</label>';
  }
  
  //Donation Options
  function donation_option_input(){
    $options = get_option('razoo_options');
    $donation_options = (isset($options['donation_options'])) ? $options['donation_options'] : '';
    
    if($donation_options != ''){
      $donation_options = explode('|', $donation_options);
      for($i = 0; $i < count($donation_options); $i++){
        $donation_options[$i] = explode('=', $donation_options[$i]);
      }
    }
    
    echo '<p class="description">Add the donation options you want to offer potential donors.  The field to input any amount will always be added.</p>';
    
    //Add three donation amounts by default or if they already have them add as many as they have    
    echo '<div id="donation-option-fields">';
    if(isset($donation_options) && $donation_options != ''){
      for($i = 0; $i < 5; $i++){
        $hide = (isset($donation_options[$i][0]) && $donation_options[$i][0] != '') ? false : true;
        echo self::make_donation_row($i, $donation_options[$i][0], $donation_options[$i][1], $hide);
      }
      
    }
    else {
      for($i = 0; $i < 5; $i++){
        if($i < 3){ //Show the first three by default before they've ever saved settings
          echo self::make_donation_row($i, null, null, false); 
        }
        else { //Hide the last two by default before they've ever saved settings
          echo self::make_donation_row($i, null, null, true);
        }
      }
    }
    echo '</div>';
    
    echo '<p class="description"><a href="#" id="add-donation-amount">Add Donation Amount (Up to 5)</a></p>';
    
    //Add hidden input that is updated on save with the data from all the fields using jQuery
    echo '<input id="donation-options" name="razoo_options[donation_options]" type="hidden" value="' . $donation_options .'" />';
    
  }
  
  
  //Validation
  function validate_options( $input ){
    $valid = array();
    $valid['charity_id'] = $input['charity_id'];
    $valid['title'] = $input['title'];
    $valid['summary'] = $input['summary'];
    $valid['more_info'] = $input['more_info'];
    $valid['color'] = $input['color'];
    $valid['show_image'] = $input['show_image'];
    $valid['donation_options'] = $input['donation_options'];
    //TODO Do real validation
    
    return $valid;
  }
  
  //Make the rows to handle the donation amounts and descriptions
  function make_donation_row($num, $donation_amount = null, $donation_description = null, $hide = false){
    $row = '';
    
    $row .= '<div class="row';
    if($hide == true) $row .= ' hide';
    $row .= '">';
    $row .= '<label for="donation_amount[' . $num . ']">$</label> <input id="donation_amount[' . $num . ']" name="donation_amount[' . $num . ']" type="text" class="small-text" value="';
    if(isset($donation_amount)) $row .= $donation_amount;
    $row .= '" />';
    $row .= '<input id="donation_title[' . $num . ']" name="donation_title[' . $num . ']" type="text" class="regular-text" value="';
    if(isset($donation_description)) $row .=  $donation_description;
    $row .= '" />';
    $row .= '<img id="donation-trash[' . $num . ']" src="' . RAZOO_DONATION_PLUGINFULLURL . 'img/trash-can.png" />';
    $row .= '</div>';
    
    return $row;
  }
  
  
  function options_docs_text(){
    echo '<p>Get all the information you need here on how to customize this plugin to what you need. THIS NEEDS TO BE ADDED. THIS COULD ALSO BE DONE USING THE HELP CONTEXT MENU.</p>';
  }
  
  //Admin CSS and JS
  function custom_admin_css(){
    ?>
    <style>
      .razoo-widget { margin: 50px 100px; }
      .settings_page_razoo-donation-widget-settings .form-table { width: auto; clear: none; }
      #donation-option-fields .row img { vertical-align: middle; cursor: pointer; }
      #donation-option-fields .hide { display: none; }
      .settings_page_razoo-donation-widget-settings .default { color: gray; text-decoration: none; }
      .settings_page_razoo-donation-widget-settings .default:hover { cursor: default; }
    </style>
    <?php
  }
  
  function add_styles_scripts(){
    wp_enqueue_style( 'farbtastic' );
    wp_enqueue_script( 'farbtastic' );
    wp_enqueue_script('razoo-settings', RAZOO_DONATION_PLUGINFULLURL . 'js/settings.js');
  }
  
}

//Create Our Settings Page!
new razoo_options_page();