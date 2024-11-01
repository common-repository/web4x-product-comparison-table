<?php 
/*
*  @package Web4xTableMaker
*/

add_action( 'init', 'Web4xPCT_init' );
/**
 * Register a Table post type.
 *
 */
function Web4xPCT_init() {
	$labels = array(
		'name'               => _x( 'Web4x Tables', 'post type general name', 'web4x-product-comparison-table' ),
		'singular_name'      => _x( 'Web4x Table', 'post type singular name', 'web4x-product-comparison-table' ),
		'menu_name'          => _x( 'Web4x Table', 'admin menu', 'web4x-product-comparison-table' ),
		'name_admin_bar'     => _x( 'Table', 'add new on admin bar', 'web4x-product-comparison-table' ),
		'add_new'            => _x( 'Add New Table', 'web4xpct', 'web4x-product-comparison-table' ),
		'add_new_item'       => __( 'Add New Table', 'web4x-product-comparison-table' ),
		'new_item'           => __( 'New Table', 'web4x-product-comparison-table' ),
		'edit_item'          => __( 'Edit Table', 'web4x-product-comparison-table' ),
		'view_item'          => __( 'View Table', 'web4x-product-comparison-table' ),
		'all_items'          => __( 'All Table', 'web4x-product-comparison-table' ),
		'search_items'       => __( 'Search Table', 'web4x-product-comparison-table' ),
		'parent_item_colon'  => __( 'Parent Table:', 'web4x-product-comparison-table' ),
		'not_found'          => __( 'No Table found.', 'web4x-product-comparison-table' ),
		'not_found_in_trash' => __( 'No Table found in Trash.', 'web4x-product-comparison-table' )
	);
	$args = array(
		'labels'             => $labels,
		'description'        => __( 'Description.', 'web4x-product-comparison-table' ),
		'public'             => false,
		'publicly_queryable' => false,
		'menu_icon'   		 => 'dashicons-welcome-widgets-menus',
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => false,
		'rewrite'            => array( 'slug' => 'web4xpct'),
		'capability_type'    => 'post',
		'has_archive'        => false,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title' )
	);

	register_post_type( 'web4xpct', $args );
}

function Web4xPCT_name_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");?>
    <div class="meta-boxes">        
    <?php  
}

function Web4xPCT_custom_meta_box_markup($object)
{
    wp_nonce_field(basename(__FILE__), "meta-box-nonce");

	global $post;
    $nd_p_mytext =   get_post_meta($post->ID, 'nd_p_mytext', true);
    $nd_m_p_collect =   get_post_meta($post->ID, 'nd_m_p_collect', true);
    $table_title =   get_post_meta($post->ID, 'table_title', true);
    $nd_btn_text =   get_post_meta($post->ID, 'nd_btn_text', true);
    ?>
<section class="nd-table-sec">
	<div class="table-title">
		<label for="table_title">Table Title</label>
		<input type="text" name="table_title" id="table_title" value="<?php echo esc_attr($table_title) ?>">
	</div>
	<div class="nd_btn_text">
		<label for="nd_btn_text">Button Text</label>
		<input type="text" name="nd_btn_text" id="nd_btn_text" value="<?php echo esc_attr($nd_btn_text) ?>">
	</div>

	<div class="nd-sc">
		Table Shortcode<br>
		<span><?php echo esc_html('[Web4x_PCT id="'.get_the_ID().'"]'); ?></span>
	</div>
</section>

<div class="nd-table-admin">
	<div class="nd-table-admin-title">
		Enter Table Data
	</div>

	<div class="nd-add-f">
		<a class="add_field_button_p button-secondary">Add New Row</a>
	</div>
	<div class="input_fields_wrap_p nd_p_table">
		<label for="nd_p_image">Product Image Link</label>
		<label for="nd_p_name">Product Name</label>
		<label for="nd_p_description">Product Description</label>
		<label for="nd_p_shop">Affliate Link</label>
	   	<div class="nd-table-data">

		    <?php $count = 1;
		    if (!empty($nd_p_mytext))
		    	foreach ($nd_p_mytext as $key => $value) {
		    		if ($count%4 == 1)
				    {  
				        echo "<div class='row'>";
				    }
		    		?>
		    		<?php foreach ($value as $key => $newvalue) {
		    		?>
						<?php if($key == 'nd_p_name' || $key == 'nd_p_shop' || $key == 'nd_p_description' || $key == 'nd_p_image'){?>
							<input type="text" name="nd_p_mytext[][<?php echo esc_attr($key) ?>]" id="<?php echo $key ?>" value="<?php echo esc_attr($newvalue) ?>">
						<?php } ?>
		    	<?php } 

		    	if ($count%4 == 0)
			    {
			        echo "<span class='delete-field_p button-secondary_p'>x</span></div>";
			    }
		    $count++;?> 
		    <?php } if ($count%4 != 1) echo "</div><i></i>";?>
		</div>
	</div>
</div>

<?php
}

add_action("save_post", "Web4xPCT_save_custom_meta_box", 10, 3 );

function Web4xPCT_save_custom_meta_box( $post_id, $post, $update )
{
    if (!isset($_POST["meta-box-nonce"]) || !wp_verify_nonce($_POST["meta-box-nonce"], basename(__FILE__))){
        return $post_id;
    }

    if(!current_user_can("edit_post", $post_id)){
        return $post_id;
    }

    if(defined("DOING_AUTOSAVE") && DOING_AUTOSAVE){

        return $post_id;
    }

    $slug = "web4xpct";
    if($slug != $post->post_type){

        return $post_id;
    }

	$nd_p_mytext = $_POST['nd_p_mytext'];

	function Web4xPCT__sanitize_array_field($nd_p_mytext) {
	    if( is_string($nd_p_mytext) ){
	        $nd_p_mytext = sanitize_text_field($nd_p_mytext);
	    }
	    elseif( is_array($nd_p_mytext) ){
	        foreach ( $nd_p_mytext as $key => &$value ) {
	            if ( is_array( $value ) ) {
	                $value = sanitize_text_or_array_field($value);
	            }
	            else {
	                $value = sanitize_text_field( $value );
	            }
	        }
	    }

	    return $nd_p_mytext;
	}

	$table_title = sanitize_text_field( $_POST['table_title'] );
	$nd_btn_text = sanitize_text_field( $_POST['nd_btn_text'] );
	$nd_m_p_collect = sanitize_text_field( $_POST['nd_m_p_collect'] );


    update_post_meta( $post_id, 'table_title', $table_title );
    update_post_meta( $post_id, 'nd_btn_text', $nd_btn_text );
    update_post_meta( $post_id, 'nd_m_p_collect', $nd_m_p_collect );
    update_post_meta( $post_id, 'nd_p_mytext', $nd_p_mytext );



}

function Web4xPCT_custom_meta_box()
{
    add_meta_box("meta-box", "Table Information", "Web4xPCT_custom_meta_box_markup", "web4xpct", "normal", "high", null);
}

add_action("add_meta_boxes", "Web4xPCT_custom_meta_box");


/**
 * Creating a Shortcode
 *
 */

function Web4xPCT_shortcode( $atts ) {

	$b = shortcode_atts( array(
		'id' => '',
	), $atts );

	$meta_ID = $b['id'];

    $nd_table_title =   get_post_meta($meta_ID, 'table_title', true);
    $nd_btn_text =   get_post_meta($meta_ID, 'nd_btn_text', true);
    $mytext =   get_post_meta($meta_ID, 'mytext', true);
    $nd_check_txt = ( $nd_btn_text != "" ) ? $nd_btn_text : 'Check Price';
    $nd_p_mytext =   get_post_meta($meta_ID, 'nd_p_mytext', true);

$table_act = "
<section id='nd-product-table' class='table_".$meta_ID."'>
	<div class='table-title'><h2>".  $nd_table_title ."</h2></div>
	<div class='nd-custom-content'>
		<div id='nd-sec1' class='top-picks'>
			<div class='nd-sec1-inner'>
				<div class='div-table-row'>";
	               $count = 1;
	              	if ( isset($nd_p_mytext ) )
				    	foreach ($nd_p_mytext as $key => $value) {
				    		foreach ($value as $key => $newvalue) {
								$nd_p_image='nd_p_image';
								$nd_p_name='nd_p_name';
								$nd_p_description='nd_p_description';
								$nd_p_shop='nd_p_shop';
								 if ($count%4 == 1){ 
							   		 $table_act .= "
							   		<div class='nd-product-container'>
				    					<div class='nd-p-inner-left'>";
							    }
				    			 if($key == 'nd_p_image') {
						    				$table_act .= "
						    				<div class='nd-p-img ".esc_attr($nd_p_image)."'>
							    				<img src='" . esc_url($value[$nd_p_image]) ."'>
							    			</div>
										</div> 
									<div class='nd-middle-data'>";
				    			}
				    			if ($key == 'nd_p_name' ) {
									$table_act .= "<div class='nd-p-title ".esc_attr($nd_p_name)."'>
				    					<div class='Web4xPCT-heading'>".__( $value[$nd_p_name], 'web4x-product-comparison-table' )."</div>
				    				</div>";
				    			}
				    			if ( $key == 'nd_p_description' ) {
									$table_act .= "<div class='Web4xPCT-desc ".esc_attr($nd_p_name)."'>
				    					<p>".__( $value[$nd_p_description], 'web4x-product-comparison-table' )."</p>
				    				</div>";
				    			}
				    			if ($key == 'nd_p_shop') {
									$table_act .= "
									</div> 
										<div class='nd-right-box'>
											<div class='nd-p-btn'>
												<a href='" . esc_url($value[$nd_p_shop]) ."'>".esc_attr($nd_check_txt)."</a>
											</div>";	
				    				} 
				    	if ($count%4 == 0){ 
									$table_act .= "
										</div>
								</div>";
				    	}
					}

				    $count++;
				    } if ($count%4 != 1){
				    	$table_act .= "</div>";
				    }
					$table_act .= "
				</div>
			</div>
		</div>
	</div>
</section>";

return $table_act;

}
add_shortcode( 'Web4x_PCT', 'Web4xPCT_shortcode' ); 

/**
 * Add the custom columns to the web4xpct post type:
 *
 */
    add_filter( 'manage_web4xpct_posts_columns', 'Web4xPCT_set_custom_edit_book_columns' );
function Web4xPCT_set_custom_edit_book_columns( $columns ) {
    unset( $columns['shortcode'] );
    $columns['shortcode'] = __( '<strong>ShortCode</strong>', 'your_text_domain' );

    return $columns;
}

// Add the data to the custom columns for the book post type:
add_action( 'manage_web4xpct_posts_custom_column' , 'Web4xPCT_custom_book_column', 10, 3);
function Web4xPCT_custom_book_column( $column, $post_id ) {
    switch ( $column ) {
        case 'shortcode' :
            echo esc_html('[Web4x_PCT id="'.$post_id.'"]');
            break;

    }
}
/**
 * Add the column in sidebar of add new table for image selection:
 *
 */
function Web4xPCT_custom_meta_boxes( $post_type, $post ) {
    add_meta_box(
        'aw-meta-box',
        __( 'Custom Image' ),
        'Web4xPCT_img_function',
        array('web4xpct'), //post types here
        'side',
        ''
    );


}
add_action( 'add_meta_boxes', 'Web4xPCT_custom_meta_boxes', 10, 2 );

function Web4xPCT_img_function($post) {
    $image = get_post_meta($post->ID, 'aw_custom_image', true);
    ?>
            <div class="nd-img-field">
            	<input type="text" name="aw_custom_image" id="aw_custom_image" value="<?php echo esc_url($image) ?>"  />
            	<span class="nd-copy-text">Copy URL</span>
            </div>
            <div class="nd-img-btn">
            	<a href="#" class="aw_upload_image_button button button-secondary"><?php _e('Choose Image', 'web4x-product-comparison-table'); ?></a>
            </div>
    <?php
}
?>