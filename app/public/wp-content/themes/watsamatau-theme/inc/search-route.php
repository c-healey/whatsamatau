<?php

add_action('rest_api_init', 'universityRegisterSearch');
function universityRegisterSearch (){
	register_rest_route ('university/v1', 'search', array(
		'methods' => WP_REST_SERVER::READABLE,
		'callback' => 'universitySearchResults'
	));

}
function universitySearchResults ($data){
	$mainQuery = new WP_QUERY(array(
		'post_type' => array('professor', 'post', 'page', 'program', 'campus', 'event'),
		's'=> sanitize_text_field($data['term'])
	));

	$results = array(
		'generalInfo' => array(),
		'professor' => array(),
		'program' => array(),
		'event' => array(),
		'campus' => array()

	);

	while ($mainQuery->have_posts()){
		$mainQuery->the_post();
		$postType = get_post_type();

		if($postType == 'post' OR $postType == 'page'){ 
			array_push($results['generalInfo'], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
				'postType'=> $postType,
				'authorName'=> get_the_author()
			));
		} else if ($postType == 'professor'){
			array_push($results[$postType], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
				'postType'=> $postType,
				'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
			));
		} else if ($postType == 'event'){
			$eventDate = new DateTime(get_field('event_date'));
			$description = NULL;

			if (has_excerpt()) {
				$description = get_the_excerpt();
			} else {
				$description = wp_trim_words(get_the_content(), 18);
			}
			array_push($results[$postType], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),
				'month' => $eventDate->format('M'),
				'day' => $eventDate->format('d'),
				'description' => $description
			));
		} else if ($postType == 'program'){ 
			$relatedCampuses = get_field('related_campuses');

			if ($relatedCampuses) {
				foreach ($relatedCampuses as $campus){
					array_push($results['campus'], array(
						'title' => get_the_title($campus),
						'permalink' => get_the_permalink ($campus)
					));
				}
			}


			array_push($results[$postType], array(
				'id' => get_the_id(),
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),	
			));
		} else { // campus
			array_push($results[$postType], array(
				'title' => get_the_title(),
				'permalink' => get_the_permalink(),	
			));
		}		
	}

	if ($results['program']) 
	{
		$programMetaQuery = array ('relation' => 'OR');

		foreach ($results['program'] as $item){
			array_push( $programMetaQuery, array(
				'key' => 'related_program',
				'compare' => 'LIKE',
				'value' => '"'. $item['id'] .'"'
			));
		}

		$programRelationshipQuery = new WP_Query (array(
			'post_type' => array('professor', 'event'),
			'meta_query' => $programMetaQuery
		));

		while ($programRelationshipQuery->have_posts()) {
			$programRelationshipQuery->the_post();
		
			if (get_post_type() == 'event'){
				$eventDate = new DateTime(get_field('event_date'));
				$description = NULL;

				if (has_excerpt()) {
					$description = get_the_excerpt();
				} else {
					$description = wp_trim_words(get_the_content(), 18);
				}
				array_push($results['event'], array(
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'month' => $eventDate->format('M'),
					'day' => $eventDate->format('d'),
					'description' => $description
				));
			} 

			if (get_post_type() == 'professor'){
				array_push($results['professor'], array(
					'title' => get_the_title(),
					'permalink' => get_the_permalink(),
					'postType'=> 'professor',
					'image' => get_the_post_thumbnail_url(0, 'professorLandscape')
				));
			}
		}
		$results['professor'] = array_values (array_unique($results['professor'], SORT_REGULAR));
		$results['event'] = array_values (array_unique($results['event'], SORT_REGULAR));
	}
	return $results;
}