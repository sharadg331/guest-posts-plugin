<?php 
// Register Custom Post Type

 function custom_guest_cpt() {

	$labels = array(
		'name'                  => _x( 'Guest Posts', 'Post Type General Name', 'MDTEST' ),
		'singular_name'         => _x( 'Guest Posts', 'Post Type Singular Name', 'MDTEST' ),
		'menu_name'             => __( 'Guest Posts', 'MDTEST' ),
		'name_admin_bar'        => __( 'Guest Posts', 'MDTEST' ),
		'archives'              => __( 'Guest Posts Archives', 'MDTEST' ),
		'attributes'            => __( 'Guest Posts Attributes', 'MDTEST' ),
		'parent_item_colon'     => __( 'Parent Item:', 'MDTEST' ),
		'all_items'             => __( 'All Guest Posts', 'MDTEST' ),
		'add_new_item'          => __( 'Add New Guest Post', 'MDTEST' ),
		'add_new'               => __( 'Add Guest Post', 'MDTEST' ),
		'new_item'              => __( 'New Guest Post', 'MDTEST' ),
		'edit_item'             => __( 'Edit Guest Post', 'MDTEST' ),
		'update_item'           => __( 'Update Guest Post', 'MDTEST' ),
		'view_item'             => __( 'View Guest Post', 'MDTEST' ),
		'view_items'            => __( 'View Guest Post', 'MDTEST' ),
		'search_items'          => __( 'Search Guest Post', 'MDTEST' ),
		'not_found'             => __( 'Not found', 'MDTEST' ),
		'not_found_in_trash'    => __( 'Not found in Trash', 'MDTEST' ),
		'featured_image'        => __( 'Featured Image', 'MDTEST' ),
		'set_featured_image'    => __( 'Set Guest Post Picture', 'MDTEST' ),
		'remove_featured_image' => __( 'Remove Guest Post Picture', 'MDTEST' ),
		'use_featured_image'    => __( 'Use as Guest Post Picture', 'MDTEST' ),
		'insert_into_item'      => __( 'Insert into item', 'MDTEST' ),
		'uploaded_to_this_item' => __( 'Uploaded to this item', 'MDTEST' ),
		'items_list'            => __( 'Items list', 'MDTEST' ),
		'items_list_navigation' => __( 'Items list navigation', 'MDTEST' ),
		'filter_items_list'     => __( 'Filter items list', 'MDTEST' ),
	);
	$args = array(
		'label'                 => __( 'Guest Posts', 'MDTEST' ),
		'description'           => __( ' Guest Posts', 'MDTEST' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor','excerpt','custom-fields', 'page-attributes', 'post-formats','thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 20,
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => true,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => false,
		'publicly_queryable'    => true,
		'capability_type'       => 'page',
	);
	register_post_type( 'guest', $args );

}
add_action( 'init', 'custom_guest_cpt', 0 );



