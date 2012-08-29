<?php
/**
 * @package ABT
 */
/*
Plugin Name: Razoo Donation Widget
Plugin URI: http://www.atlanticbt.com/blog/wordpress-plugin-razoo-donation-widget/
Description: Embed a customizable Razoo Donation widget. See also: <a href="http://www.razoo.com/p/donationWidget">Razoo Widget Creator</a>.
Version: 0.9
Author: atlanticbt, zaus
Author URI: http://atlanticbt.com/
License: GPLv2
*/

/*
GPLv2 - read it - http://www.gnu.org/licenses/license-list.html#GPLCompatibleLicenses
*/

/**
 * Plugin wrapper - razoo donation widget
 *
 * Embed a razoo donation widget on your site
 *
 * @author AtlanticBT, Jeremy Schwartz (zaus) - http://atlanticbt.com
 * 
 */
class razoo_donation_widget {

	/**
	 * Internal, global storage for defaults
	 */
	public static $default_atts;
	/**
	 * Internal, global storage for defaults
	 */
	public static $default_long_description;

	/**
	 * Initiate the plugin, options, etc
	 */
	public function __construct(){
		add_shortcode('razoo_widget', array(&$this, 'shortcode_widget_customize'));
		
		// set some defaults
		self::$default_atts = array(
			'id' => '????'
			, 'title' => 'Please Donate'
			, 'short_description' => 'Please donate any amount or fill in the blank after "OR" with sponsorship level. Thank you for supporting us!'
			#, 'long_description' => $content
			, 'color' => '#3D9B0C'
			, 'donation_options' => '5=Friend|25=Benefactor|100=Benefactor|500=Sponsor'
			, 'image' => 'true'
		);
		self::$default_long_description = 'Please <a href="/contact">contact us</a> if you have any questions.  Read more about our organization from the <a href="/about">About Us</a> page.';

	}//--	fn	__construct

	/**
	 * Add razoo widget - shortcode handler
	 * @param $atts shortcode attributes {id, title, short_description, color, donation_options, image}
	 * @param $content shortcode content {i.e. long_description}
	 */
	function shortcode_widget_customize($atts, $content = null){
		$shortcode_params = shortcode_atts(self::$default_atts, $atts);
		
		// turn donation options list into param list
		parse_str( str_replace('|', '&', $shortcode_params['donation_options']), $shortcode_params['donation_options']);
		
		return $this->embed($shortcode_params, $content);
	}//--	fn	shortcode_widget_customize


	/**
	 * Add razoo widget - embed with options
	 * @param $shortcode_params shortcode attributes {id, title, short_description, color, donation_options, image}
	 * @param $content shortcode content {i.e. long_description}
	 */
	function embed($shortcode_params, $content = NULL) {
			extract($shortcode_params);
		# print_r( array( 'params' => $shortcode_params, 'att' => $atts ) );
		
		// fallback & default
		if( !isset($long_description) ) $long_description = $content;
		if( NULL === $long_description ){
			$long_description = self::$default_long_description;
		}
		
		// cheat!
		/* catch the echo output, so we can control where it appears in the text  */
		ob_start();
		
		?>
		<!-- from http://www.razoo.com/story/<?php echo $id ?>/share -->

	<div id='razoo_donation_widget'>
		<span><a href="http://www.razoo.com/">Donate online</a> to <a href="http://www.razoo.com/story/<?php echo $id ?>"><?php echo $title ?></a> at Razoo</span>
	</div>
	<script type='text/javascript'>
	var r_params = {
		"title":"<?php echo addslashes($title) ?>"
		,"short_description":"<?php /* note that you need the charset to correctly interpret quotes? */ echo addslashes( html_entity_decode($short_description, ENT_QUOTES, 'UTF-8') ) ?>"
		,"long_description":"<?php /* note that you need the charset to correctly interpret quotes? */ echo addslashes( html_entity_decode($long_description, ENT_QUOTES, 'UTF-8') ) ?>"
		,"color":"<?php echo $color ?>"
		,"donation_options": <?php
			// turn listing into json list
			echo self::fallback_json_encode( $donation_options );
			?>
		,"image":"<?php echo $image ?>"
		};
		var r_protocol=(("https:"==document.location.protocol)?"https://":"http://");var r_path='www.razoo.com/javascripts/widget_loader.js';
		var r_identifier='<?php echo $id?>';
		document.write(unescape("%3Cscript id='razoo_widget_loader_script' src='"+r_protocol+r_path+"' type='text/javascript'%3E%3C/script%3E"));
	</script>
		<?php
		
		///TODO: add a hook for more stuff?
		
		return ob_get_clean();	//return the output (and stop the buffer)

	}//--	fn	embed
	
	/**
	 * Substitute encoder when lacking native function
	 * @param $data the stuff to encode
	 * @param $flags flags used by json_encode
	 * @see http://www.php.net/manual/en/function.json-encode.php#100835
	 */
	static function fallback_json_encode($data, $flags = null){
		//fallback to provided method
		if(function_exists('json_encode')){
			if($flags) return json_encode($data, $flags);
			
			return json_encode($data);
			#return json_encode($data, ($flags ? $flags : JSON_HEX_TAG|JSON_HEX_APOS|JSON_HEX_QUOT|JSON_HEX_AMP));
		}
		
		if( is_array($data) || is_object($data) ) {
			 $islist = is_array($data) && ( empty($data) || array_keys($data) === range(0,count($data)-1) );
		   
			if( $islist ) {
				$json = '[' . implode(',', array_map(array(__CLASS__, 'fallback_json_encode'), $data) ) . ']';
			} else {
			
				$items = Array();
				foreach( $data as $key => $value ) {
					$items[] = self::fallback_json_encode("$key") . ':' . self::fallback_json_encode($value);
				}
				$json = '{' . implode(',', $items) . '}';
			}
		} elseif( is_string($data) ) {
			# Escape non-printable or Non-ASCII characters.
			# I also put the \\ character first, as suggested in comments on the 'addclashes' page.
			$string = '"' . addcslashes($data, "\\\"\n\r\t/" . chr(8) . chr(12)) . '"';
			$json    = '';
			$len    = strlen($string);
			# Convert UTF-8 to Hexadecimal Codepoints.
			for( $i = 0; $i < $len; $i++ ) {
			   
				$char = $string[$i];
				$c1 = ord($char);
			   
				# Single byte;
				if( $c1 <128 ) {
					$json .= ($c1 > 31) ? $char : sprintf("\\u%04x", $c1);
					continue;
				}
			   
				# Double byte
				$c2 = ord($string[++$i]);
				if ( ($c1 & 32) === 0 ) {
					$json .= sprintf("\\u%04x", ($c1 - 192) * 64 + $c2 - 128);
					continue;
				}
			   
				# Triple
				$c3 = ord($string[++$i]);
				if( ($c1 & 16) === 0 ) {
					$json .= sprintf("\\u%04x", (($c1 - 224) <<12) + (($c2 - 128) << 6) + ($c3 - 128));
					continue;
				}
				   
				# Quadruple
				$c4 = ord($string[++$i]);
				if( ($c1 & 8 ) === 0 ) {
					$u = (($c1 & 15) << 2) + (($c2>>4) & 3) - 1;
			   
					$w1 = (54<<10) + ($u<<6) + (($c2 & 15) << 2) + (($c3>>4) & 3);
					$w2 = (55<<10) + (($c3 & 15)<<6) + ($c4-128);
					$json .= sprintf("\\u%04x\\u%04x", $w1, $w2);
				}
			}
		} else {
			# int, floats, bools, null
			$json = strtolower(var_export( $data, true ));
		}
		return $json;
		
	}//--	fn	fallback_json_encode



}///---	class	razoo_donation_widget


// engage!
new razoo_donation_widget();




?>