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
      <h2>Razoo Donation Widget</h2>
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
    
    /**Documentation Info**/
    add_settings_section(
      'razoo-options-docs',
      'How to Add the Donation Widget to Your Website',
      array($this, 'options_docs_text'),
      'razoo-donation-widget-settings'
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
      'Razoo ID',
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
    
  }
  
  //Documentation text
  function options_docs_text(){ ?>
    <p>To add the Razoo Donation widget to your website follow these steps:</p>
    <ol>
      <li>Complete the settings below with all your organization's information, then save your changes.</li>
      <li>Go to the edit screen for the page or post where you want to add the donation widget.</li>
      <li>Place your cursor within the editor's text where you want the donation widget to be added.</li>
      <li>Click the Razoo icon in the WordPress editor toolbar <img class="editor-icon" src="<?php echo RAZOO_DONATION_PLUGINFULLURL; ?>img/razoo-icon.png" />.  The Razoo shortcode reading "[razoo_widget]" will be added in the editor.</li>
      <li>Click the blue "Publish" or "Update" button to save your changes and add the widget to your live website.</li>
    </ol>
    
  <?php }
  
  //Settings Section and Fields
  function options_settings_text(){
    echo '<p>Adjust your Razoo Donation Widget settings.  Every time you save changes the widget on the right will update to show you exactly what it will look like on your website.';
  }
  
  //Charity ID
  function id_input(){
    $options = get_option('razoo_options');
    $id = str_replace(' ', '-', sanitize_text_field($options['charity_id']));
    
    echo '<input id="id" name="razoo_options[charity_id]" type="text" value="' . $id .'" class="regular-text" />';
    echo '<p class="description">This is the ID for your organization according to Razoo.  When on your organization\'s landing page it\'s the text that comes right after "/story/".  For example, the United Way of America\'s ID is "United-Way-Of-America".  You can view their ID at <a href="http://www.razoo.com/story/United-Way-Of-America" target="_blank">http://www.razoo.com/story/United-Way-Of-America</a>.</p>';
  }
  
  //Widget Title
  function title_input(){
    $options = get_option('razoo_options');
    $title = sanitize_text_field($options['title']);
    
    echo '<input id="title" name="razoo_options[title]" type="text" value="' . $title .'" class="regular-text" />';
    echo '<p class="description">The title will show up in big letters at the top of the donation widget.</p>';
  }
  
  //Summary
  function summary_input(){
    $options = get_option('razoo_options');
    $summary = sanitize_text_field($options['summary']);
    
    echo '<input id="summary" name="razoo_options[summary]" type="text" value="' . $summary .'" class="regular-text" />';
    echo '<p class="description">The summary is a short description of your organization or an ask for people to donate.  This text shows up just below the title.</p>';
  }
  
  //More Info
  function more_info_textarea(){
    $options = get_option('razoo_options');
    $more_info = wp_strip_all_tags($options['more_info']);
    
    echo '<textarea id="more-info" rows="5" name="razoo_options[more_info]" class="large-text">' . $more_info .'</textarea>';
    echo '<p class="description">The more info section can be much longer, describing more about your organization and where the donors money will go.  This text shows up when users click the "More info" link on the donation widget.</p>';
  }
  
  //Color
  function color_input(){
    $options = get_option('razoo_options');
    $color = ($options['color'] != "") ? sanitize_text_field($options['color']) : '#3D9B0C';
    
    echo '<input id="color" name="razoo_options[color]" type="text" value="' . $color .'" />';
    echo '<p class="description">Provide the color you want for the donation widget in <a href="http://www.w3schools.com/html/html_colors.asp" target="_blank">hexadecimal format</a> (#000000).  You should match this closely to your website\'s colors.  You can also use the color picker below to make your selection.</p>';
    echo '<div id="colorpicker"></div>';
  }
  
  //Show Image
  function show_image_input(){
    $options = get_option('razoo_options');
    $show_image = (isset($options['show_image'])) ? 'true' : null;
    
    echo '<label for="show-image"><input id="show-image" name="razoo_options[show_image]" type="checkbox" value="true" ' . checked($show_image, 'true', false) . '/>';
    echo ' Do you want the main image for your organization to show up on the donation widget?</label>';
  }
  
  //Donation Options
  function donation_option_input(){
    $options = get_option('razoo_options');
    $donation_options = (isset($options['donation_options'])) ? sanitize_text_field($options['donation_options']) : null;
    
    if($donation_options != ''){
      $donation_options = explode('|', $donation_options);
      for($i = 0; $i < count($donation_options); $i++){
        $donation_options[$i] = explode('=', $donation_options[$i]);
      }
    }
    
    echo '<p class="description">Add the donation options you want to offer potential donors with the amount in the small box and the description in the large box.  Please only use numbers and periods in the amount field.  The numbers will also be sorted automatically with the smallest donation amounts coming first.  The field for donors to input an amount of their choosing will always be added.  </p>';
    
    //Add three donation amounts by default or if they already have them add as many as they have    
    echo '<div id="donation-option-fields">';
    if(isset($donation_options)){
      for($i = 0; $i < 5; $i++){
        $donation_amount = ($donation_options != '' && isset($donation_options[$i][0])) ? $donation_options[$i][0] : null;
        $donation_description = ($donation_options != '' && isset($donation_options[$i][1])) ? $donation_options[$i][1] : null;
        $hide = ($donation_options != '' && isset($donation_options[$i][0]) && $donation_options[$i][0] != '') ? false : true;
        
        echo self::make_donation_row($i, $donation_amount, $donation_description, $hide);
      }
      
    }
    else { //If they are loading the settings page for the first time
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
  
  
  //Sanitize and Validate
  function validate_options( $input ){
    $valid = array();
    
    $valid['charity_id'] = str_replace(' ', '-', sanitize_text_field($input['charity_id']));
    $valid['title'] = sanitize_text_field($input['title']);
    $valid['summary'] = sanitize_text_field($input['summary']);
    $valid['more_info'] = wp_strip_all_tags($input['more_info']);
    $valid['color'] = sanitize_text_field($input['color']);
    $valid['show_image'] = (isset($input['show_image'])) ? 'true' : null;
    $valid['donation_options'] = sanitize_text_field($input['donation_options']);
    
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
  
  //Admin CSS and JS
  function custom_admin_css(){
    ?>
    <style>
      #razoo-settings .editor-icon { vertical-align: middle; }
      .razoo-widget { margin: 50px 100px; }
      #razoo-settings .form-table { width: auto; clear: none; }
      #donation-option-fields .row img { vertical-align: middle; cursor: pointer; }
      #donation-option-fields .hide { display: none; }
      #razoo-settings .default { color: gray; text-decoration: none; }
      #razoo-settings .default:hover { cursor: default; }
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