<?php
/**
 * Plugin Name: Lana Text to Image
 * Plugin URI: https://lana.codes/product/lana-text-to-image/
 * Description: Easy to use text to image shortcode.
 * Version: 1.1.0
 * Author: Lana Codes
 * Author URI: https://lana.codes/
 * Text Domain: lana-text-to-image
 * Domain Path: /languages
 */

defined( 'ABSPATH' ) or die();
define( 'LANA_TEXT_TO_IMAGE_VERSION', '1.1.0' );
define( 'LANA_TEXT_TO_IMAGE_DIR_URL', plugin_dir_url( __FILE__ ) );
define( 'LANA_TEXT_TO_IMAGE_DIR_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Language
 * load
 */
load_plugin_textdomain( 'lana-text-to-image', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );

/**
 * Styles
 * load in admin
 */
function lana_text_to_image_admin_styles() {

	wp_register_style( 'lana-text-to-image-admin', LANA_TEXT_TO_IMAGE_DIR_URL . '/assets/css/lana-text-to-image-admin.css', array(), LANA_TEXT_TO_IMAGE_VERSION );
	wp_enqueue_style( 'lana-text-to-image-admin' );
}

add_action( 'admin_enqueue_scripts', 'lana_text_to_image_admin_styles' );

/**
 * Lana Text to Image
 * shortcode
 *
 * @param $atts
 *
 * @return string
 */
function lana_text_to_image_shortcode( $atts ) {

	$a = shortcode_atts( array(
		'text'      => '',
		'class'     => '',
		'alt'       => __( 'Protected Text Image', 'lana-text-to-image' ),
		'color'     => '#000000',
		'font_size' => 13,
	), $atts );

	$text = htmlspecialchars_decode( $a['text'] );

	$font = dirname( __FILE__ ) . '/assets/fonts/arial.ttf';

	error_reporting( 0 );

	$bbox = imagettfbbox( $a['font_size'], 0, $font, $text );

	$bbox['x']      = min( $bbox[0], $bbox[6] ) * - 1;
	$bbox['y']      = min( $bbox[5], $bbox[7] ) * - 1;
	$bbox['height'] = max( $bbox[1], $bbox[3] ) - min( $bbox[5], $bbox[7] );
	$bbox['width']  = max( $bbox[2], $bbox[4] ) - min( $bbox[0], $bbox[6] );

	$image = imagecreatetruecolor( $bbox['width'], $bbox['height'] );

	/** transparent image */
	imagesavealpha( $image, true );

	/** background color */
	$image_background_color = imagecolorallocatealpha( $image, 0, 0, 0, 127 );

	/** color */
	$color       = lana_text_to_image_hex_to_rgb( $a['color'] );
	$image_color = imagecolorallocate( $image, $color['r'], $color['g'], $color['b'] );

	imagefill( $image, 0, 0, $image_background_color );
	imagettftext( $image, $a['font_size'], 0, $bbox['x'], $bbox['y'], $image_color, $font, $text );

	/** class */
	$classes = array( 'lana-text-to-image' );

	/** atts class */
	if ( ! is_array( $a['class'] ) ) {
		$a['class'] = preg_split( '#\s+#', $a['class'] );
	}

	$classes = array_merge( $classes, $a['class'] );

	ob_start();
	imagepng( $image );
	$image_data = ob_get_clean();
	imagedestroy( $image );

	$image = sprintf( '<img src="data:image/png;base64,%s" class="%s" alt="%s">', esc_attr( base64_encode( $image_data ) ), esc_attr( implode( ' ', $classes ) ), esc_attr( $a['alt'] ) );

	return $image;
}

add_shortcode( 'lana_text_to_image', 'lana_text_to_image_shortcode' );
add_shortcode( 'lana_text_to_img', 'lana_text_to_image_shortcode' );

/**
 * Lana Text to Image
 * hex to rgb
 *
 * @param $hex_color
 *
 * @return array|false
 */
function lana_text_to_image_hex_to_rgb( $hex_color ) {
	$rgb_color = array();

	/** sanitize color */
	$hex_color = sanitize_hex_color_no_hash( $hex_color );

	/** check color length */
	switch ( strlen( $hex_color ) ) {

		/** 3 characters length: #f00 */
		case 3;
			list( $rgb_color['r'], $rgb_color['g'], $rgb_color['b'] ) = sscanf( $hex_color, '%1s%1s%1s' );

			return array_map( function ( $c ) {
				return hexdec( str_repeat( $c, 2 ) );
			}, $rgb_color );

		/** 3 characters length: #ff0000 */
		case 6;
			list( $rgb_color['r'], $rgb_color['g'], $rgb_color['b'] ) = sscanf( $hex_color, '%02x%02x%02x' );

			return $rgb_color;

		/** default false */
		default:
			return false;
	}
}

/**
 * TinyMCE
 * Register Plugins
 *
 * @param $plugins
 *
 * @return mixed
 */
function lana_text_to_image_add_mce_plugin( $plugins ) {

	$plugins['lana_text_to_image'] = LANA_TEXT_TO_IMAGE_DIR_URL . '/assets/js/lana-text-to-image-shortcode.js';

	return $plugins;
}

/**
 * TinyMCE
 * Register Buttons
 *
 * @param $buttons
 *
 * @return mixed
 */
function lana_text_to_image_add_mce_button( $buttons ) {

	array_push( $buttons, 'lana_text_to_image' );

	return $buttons;
}

/**
 * TinyMCE
 * Add Custom Buttons
 */
function lana_text_to_image_add_mce_shortcodes_buttons() {
	add_filter( 'mce_external_plugins', 'lana_text_to_image_add_mce_plugin' );
	add_filter( 'mce_buttons_3', 'lana_text_to_image_add_mce_button' );
}

add_action( 'admin_init', 'lana_text_to_image_add_mce_shortcodes_buttons' );