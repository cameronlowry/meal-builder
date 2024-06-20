<?php
	/* a template for displaying the header social network */

	$social_list = array(
		'delicious' => 'fa fa-delicious', 
		'email' => 'fa fa-envelope', 
		'deviantart' => 'fa fa-deviantart', 
		'digg' => 'fa fa-digg', 
		'facebook' => 'fa fa-facebook', 
		'flickr' => 'fa fa-flickr', 
		'lastfm' => 'fa fa-lastfm',
		'linkedin' => 'fa fa-linkedin', 
		'pinterest' => 'fa fa-pinterest-p', 
		'rss' => 'fa fa-rss', 
		'skype' => 'fa fa-skype', 
		'stumbleupon' => 'fa fa-stumbleupon', 
		'tumblr' => 'fa fa-tumblr', 
		'twitter' => 'fa fa-twitter',
		'vimeo' => 'fa fa-vimeo', 
		'youtube' => 'fa fa-youtube',
		'instagram' => 'fa fa-instagram',
		'snapchat' => 'fa fa-snapchat-ghost',
		'whatsapp' => 'fa fa-whatsapp',
	);

	
	$post_option = infinite_get_post_option(get_the_ID());

	$extra_class = '';

	if( empty($post_option['display-float-social-after-page-title']) ){
		$after_title = infinite_get_option('general', 'display-float-social-after-page-title', 'disable');
	}else{
		$after_title = $post_option['display-float-social-after-page-title'];
	}
	if( $after_title == 'enable' ){
		$extra_class .= ' infinite-display-after-title';
	}
	
	echo '<div class="infinite-float-social ' . esc_attr($extra_class) . '" id="infinite-float-social" >';
	echo '<span class="infinite-head" >' . esc_html__('Follow Us On', 'infinite') . '</span>';
	echo '<span class="infinite-divider" ></span>';
	foreach( $social_list as $social_key => $social_icon ){
		$social_link = infinite_get_option('general', 'float-social-' . $social_key);

		if( $social_key == 'email' && !empty($social_link) ){
			$social_link = 'mailto:' . $social_link;
		}

		if( !empty($social_link) ){
			echo '<a href="' . esc_attr($social_link) . '" target="_blank" class="infinite-float-social-icon" title="' . esc_attr($social_key) . '" >';
			echo '<i class="' . esc_attr($social_icon) . '" ></i>';
			echo '</a>';
		}
	}
	echo '</div>';