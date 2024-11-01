<?php 
/*
*  @package Web4xTableMaker
*/

function Web4xPCT_adminScripts()
{
	//Main CSS
	wp_enqueue_style( 'Web4x-Bstyle', plugins_url( '/CSS/styleCPB.css', __FILE__ ) );
	//Main JS
	wp_enqueue_script( 'Web4x-Bscript', plugins_url('/JS/Web4x-scripts.js', __FILE__ ) , array(), '20151215', true);
	//Media
    if ( ! did_action( 'wp_enqueue_media' ) ) {
	    wp_enqueue_media();
	}
  
}
add_action( 'admin_enqueue_scripts', 'Web4xPCT_adminScripts' );

function Web4xPCT_nScripts()
{
	//Main CSS
	wp_enqueue_style( 'Web4x-front-style', plugins_url('/CSS/stylefront.css', __FILE__ ) );
	//Main JS
}
add_action( 'wp_enqueue_scripts', 'Web4xPCT_nScripts' );

