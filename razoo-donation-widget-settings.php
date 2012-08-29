<?php

class razoo_options_page {
  
  public function __construct() {
    add_action('admin_menu', array(&$this, 'add_settings_page'));
    add_action('admin_init', array(&$this, 'settings_init'));
    add_action('admin_head', array(&$this, 'custom_admin_css'));
  }
  
  public function add_settings_page(){
    add_options_page(
      'Razoo Donation Widget',
      'Razoo Donation Widget',
      'manage_options',
      'razoo-donation-widget-settings',
      array($this, 'settings_page_content')
    );
  }
  
  public function settings_page_content(){
    ?>
    <div class="wrap">
      <?php screen_icon(); ?>
      <h2>Razoo Donation Widget Settings</h2>
      <form action="options.php" method="post">
        
        <?php settings_fields('razoo_options'); ?>
        <div class="alignright razoo-widget"><?php echo do_shortcode('[razoo_widget]'); ?></div>
        <?php do_settings_sections('razoo-donation-widget-settings'); ?>
        
        <p class="submit">
          <input name="Submit" type="submit" class="button-primary" value="Save Changes & Update Donation Widget" />
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
    
    //TODO Add donation choices.
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
    //TODO Add a color picker here instead of a plain text area (http://acko.net/blog/farbtastic-jquery-color-picker-plug-in/).
    $options = get_option('razoo_options');
    $color = $options['color'];
    
    echo '<input id="color" name="razoo_options[color]" type="text" value="' . $color .'" />';
    echo '<p class="description">The color determines the color used for the donation widget.  You should match this closely to your website\'s colors.</p>';
  }
  
  //Show Image
  function show_image_input(){
    $options = get_option('razoo_options');
    $show_image = $options['show_image'];
    
    echo '<label for="show-image"><input id="show-image" name="razoo_options[show_image]" type="checkbox" value="true" ' . checked($show_image, 'true', false) . '/>';
    echo ' Do you want the main image for your organization to show up on the donation widget?.</label>';
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
    //TODO Do real validation
    
    return $valid;
  }
  
  //Admin CSS
  function custom_admin_css(){
    ?>
    <style>
      .razoo-widget { margin: 50px 100px; }
      .settings_page_razoo-donation-widget-settings .form-table { width: auto; clear: none; }
    </style>
    <?php
  }
  
}

//Create Our Settings Page!
new razoo_options_page();