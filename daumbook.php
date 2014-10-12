<?php
/*
Plugin Name: Daumbook
Plugin URI: http://www.bsidesoft.com/?p=450
Description: Daumbook 플러그인은 isbn으로 "다음검색API"를 이용해 워드프레스에서 책검색 결과를 포스트나 페이지에 쉽게 추가할 수 있도록 도와줍니다. This plugin uses Daum API and helps users easy to use in WordPress.
Version: 1.0
Author: bsidesoft
Author URI: http://www.bsidesoft.com
*/
define( 'DAUMBOOK_VERSION', '1.10' );

function bsjs(){
	wp_register_style( 'daumbook', plugins_url( '/daumbook.css', __FILE__ ), false, DAUMBOOK_VERSION );
	wp_enqueue_style( 'daumbook' );
	wp_register_script( 'bsjs', 'http://projectbs.github.io/bsJS/bsjs.0.6.js', false );
	wp_enqueue_script( 'bsjs' );
	wp_register_script( 'daumbook', plugins_url( '/daumbook.js', __FILE__ ), false, DAUMBOOK_VERSION );
	wp_enqueue_script( 'daumbook' );
}
add_action( 'wp_enqueue_scripts', 'bsjs' );

function daumbook_submenu(){
	add_option( 'daumbook_apikey', '', '', 'yes' );
	
	if( isset( $_POST['daumbook_apikey'] ) ){
		update_option( 'daumbook_apikey', $_POST['daumbook_apikey'], '', 'yes' );
		echo '
		<div id="setting-error-settings_updated" class="updated settings-error">
			<p><strong>Settings saved</strong></p>
		</div>';
	}
	$daumbook_apikey = get_option( 'daumbook_apikey' );
	require_once dirname( __FILE__ ) . '/daumbook_admin.php';
}
function daum_admincallback(){}
function daumbook_admin(){
	if( !current_user_can('manage_options') ) return false;
	add_action( 
		'admin_head-'. add_submenu_page( 
			'options-general.php', 
			__( 'Daumbook', 'Daumbook' ), 
			__( 'Daumbook', 'Daumbook' ), 
			'manage_options', 
			basename( __FILE__ ), 'daumbook_submenu' 
		),
		'daum_admincallback'
	);
}
add_action( 'admin_menu', 'daumbook_admin' );

function daumbook_shortcode( $atts ){//[daumbook isbn="1111111" style=""]
	return '<a class="daumbook" target="_blank" '.( isset($atts['style']) ? 'style="'.$atts['style'].'" ' : '' ).'id="daumbook'.$atts['isbn'].'"></a><script>bs(daumbook("'.$atts['isbn'].'","'.get_option('daumbook_apikey').'"));</script>';
}
add_shortcode( 'daumbook', 'daumbook_shortcode' );

function daumbook_filter( $contents ){
	if( !is_single() ) return $contents;
	$isbn = get_post_meta( $GLOBALS['post']->ID, 'isbn', true );
	if( empty($isbn) ) return $contents;
	$isbn = explode( ',', $isbn );
	$style = get_post_meta( $GLOBALS['post']->ID, 'daumbook_style', false );
	$param = array();
	if( $style ) $param['style'] = $style;
	for( $i = 0, $j = count($isbn) ; $i < $j ; $i++ ){
		$param['isbn'] = $isbn[$i];
		$contents .= daumbook_shortcode($param);
	}
	return $contents;
}
add_filter( 'the_content', 'daumbook_filter' );
?>