<?php
function university_post_types() {
	//Campus post type
	register_post_type('campus', array(
		'capability_type' => 'campus',
		'map_meta_cap' => true,
		'supports'=> array('title', 'editor', 'excerpt'),
		'rewrite' => array('slug' => 'campuses'),
		'has_archive' => true,
		'public' => true,
		'menu_icon' => 'dashicons-location-alt',
		'labels' => array (
			'name' => 'Campuses',
			'add_new_item' => 'Add New Campus',
			'edit_item' => 'Edit Campus',
			'all_items' => 'All Campuses',
			'singlar_name' => 'Campus'
		)
	));
	//Event post type
	register_post_type('event', array(
		'capability_type' => 'event',
		'map_meta_cap' => true,
		'supports'=> array('title', 'editor', 'excerpt'),
		'rewrite' => array('slug' => 'events'),
		'has_archive' => true,
		'public' => true,
		'menu_icon' => 'dashicons-calendar',
		'labels' => array (
			'name' => 'Events',
			'add_new_item' => 'Add New Event',
			'edit_item' => 'Edit Event',
			'all_items' => 'All Events',
			'singlar_name' => 'Event'
		)
	));
	//Program post type
	register_post_type('program', array(
		'supports'=> array('title'),
		'rewrite' => array('slug' => 'programs'),
		'has_archive' => true,
		'public' => true,
		'menu_icon' => 'dashicons-awards',
		'labels' => array (
			'name' => 'Programs',
			'add_new_item' => 'Add New Program',
			'edit_item' => 'Edit Program',
			'all_items' => 'All Programs',
			'singlar_name' => 'Program'
		)
	));
	//Professor post type
	register_post_type('professor', array(
		'show_in_rest' => true,
		'supports'=> array('title', 'editor', 'thumbnail'),
		'public' => true,
		'menu_icon' => 'dashicons-welcome-learn-more',
		'labels' => array (
			'name' => 'Professor',
			'add_new_item' => 'Add New Professor',
			'edit_item' => 'Edit Professor',
			'all_items' => 'All Professors',
			'singlar_name' => 'Professor'
		)
	));

	//note post type
	register_post_type('note', array(
		'capability_type' => 'note',
		'map_meta_cap' => true,
		'show_in_rest' => true,
		'supports'=> array('title', 'editor'),
		'public' => false,
		'show_ui' => true,
		'labels' => array (
			'name' => 'Notes',
			'add_new_item' => 'Add New Note',
			'edit_item' => 'Edit Note',
			'all_items' => 'All Notes',
			'singlar_name' => 'Note'
		),
		'menu_icon' => 'dashicons-welcome-write-blog',
	));
	//like post type
	register_post_type('like', array(
		'supports'=> array('title'),
		'public' => false,
		'show_ui' => true,
		'labels' => array (
			'name' => 'Likes',
			'add_new_item' => 'Add New Like',
			'edit_item' => 'Edit Like',
			'all_items' => 'All Likes',
			'singlar_name' => 'Like'
		),
		'menu_icon' => 'dashicons-heart',
	));
	//home-slide post type
	register_post_type('home-slide', array(
		'supports'=> array('title', 'editor'),
		'public' => true,
		'show_ui' => true,
		'labels' => array (
			'name' => 'Home Slide',
			'add_new_item' => 'Add New Home Slide',
			'edit_item' => 'Edit Home Slide',
			'all_items' => 'All Home Slides',
			'singlar_name' => 'Home Slide'
		),
		'menu_icon' => 'dashicons-images-alt',
	));
}
add_action('init', 'university_post_types');