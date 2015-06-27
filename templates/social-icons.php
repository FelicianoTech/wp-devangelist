<?php
/**
 * Generates the social icons in the header.
 *
 * If the user has the profile field filled in for a particular social site or
 * network, creates a link to it using the appropriate Font Awesom unicode
 * character.
 *
 * @package wp-devangelist
 */

$showcased_user = get_userdata( get_theme_mod( "wp_devangelist_showcased_user"
));

$social_data = array(
	'twitter' => array(
		'icon' => 'fa-twitter',
		'url_pre' => 'https://twitter.com/'
	),
	'github' => array(
		'icon' => 'fa-github',
		'url_pre' => 'https://github.com/'
	),
	'gplus' => array(
		'icon' => 'fa-google-plus',
		'url_pre' => ''
	),
	'linkedin' => array(
		'icon' => 'fa-linkedin',
		'url_pre' => ''
	),
	'facebook' => array(
		'icon' => 'fa-facebok',
		'url_pre' => ''
	)
);

$rendered_html = "";

foreach( $social_data as $service => $data ){
	
	if( $showcased_user->$service != "" ){
	
		$rendered_html .=
		'<a href="'.$data['url_pre'].$showcased_user->$service.
		'" title="Visit my profile."><span class="fa '.$data['icon'].
		'"></span></a>';
	}
}

if( isset( $rendered_html )){

	$rendered_html = '<div class="profile-data">'.$rendered_html.'</div>';
}

echo $rendered_html;
?>
