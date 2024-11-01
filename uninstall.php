<?php 
/*
*  @package Web4xTableMaker
*/



if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	die;
}


function Web4xPCT_delete_plugin() {

	$posts = get_posts(
		array(
			'post_type' => 'web4xpct',
			'numberposts' => -1,
		)
	);

	foreach ( $posts as $post ) {
		wp_delete_post( $post->ID, true );
	}
}
Web4xPCT_delete_plugin();