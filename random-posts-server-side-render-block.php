<?php
/**
 * Random Posts ServerSideRender Block
 *
 * @package 2ndkauboy/random-posts-server-side-render-block
 * @author  Bernhard Kau
 * @license GPLv3
 *
 * @wordpress-plugin
 * Plugin Name: Random Posts ServerSideRender Block
 * Plugin URI: https://github.com/2ndkauboy/random-posts-server-side-render-block
 * Description: An example for a ServerSideRender block similar to shortcodes with minimal code using only ES5 code.
 * Version: 1.0.0
 * Author: Bernhard Kau
 * Author URI: https://kau-boys.de
 * Text Domain: server-side-render-block
 * License: GPLv3
 * License URI: http://www.gnu.org/licenses/gpl-3.0.txt
 */

/**
 * Register the block.
 */
function rpssrb_init() {
	register_block_type(
		'rpssrb/random-posts',
		[
			'render_callback' => 'rpssrb_render_callback',
		]
	);
}

add_action( 'init', 'rpssrb_init' );

/**
 * Render callback for the block.
 *
 * @return string
 */
function rpssrb_render_callback( $atts ) {
	$atts = shortcode_atts(
		[
			'post_type'      => 'post',
			'orderby'        => 'rand',
			'posts_per_page' => 5,
		],
		$atts
	);

	$query = new WP_Query( $atts );

	$output = '';
	if ( $query->have_posts() ) {
		$output .= '<ul>';
		while ( $query->have_posts() ) {
			$query->the_post();
			$output .= sprintf(
				'<li><a href=%s>%s</a></li>',
				get_permalink(),
				get_the_title()
			);
		}
		$output .= '</ul>';
	}

	return $output;
}

/**
 * Register scripts for the block editor.
 */
function rpssrb_register_scripts() {
	wp_enqueue_script(
		'random-posts-server-side-render-block',
		plugin_dir_url( __FILE__ ) . 'index.js',
		[ 'wp-blocks', 'wp-server-side-render' ],
		filemtime( plugin_dir_path( __FILE__ ) . 'index.js' ),
		true
	);
}

add_action( 'enqueue_block_editor_assets', 'rpssrb_register_scripts' );
