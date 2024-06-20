<?php

	add_filter('gdlr_core_enable_header_post_type', 'infinite_gdlr_core_enable_header_post_type');
	if( !function_exists('infinite_gdlr_core_enable_header_post_type') ){
		function infinite_gdlr_core_enable_header_post_type( $args ){
			return true;
		}
	}
	
	add_filter('gdlr_core_header_options', 'infinite_gdlr_core_header_options', 10, 2);
	if( !function_exists('infinite_gdlr_core_header_options') ){
		function infinite_gdlr_core_header_options( $options, $with_default = true ){

			// get option
			$options = array(
				'top-bar' => infinite_top_bar_options(),
				'top-bar-social' => infinite_top_bar_social_options(),			
				'header' => infinite_header_options(),
				'logo' => infinite_logo_options(),
				'navigation' => infinite_navigation_options(), 
				'fixed-navigation' => infinite_fixed_navigation_options(),
			);

			// set default
			if( $with_default ){
				foreach( $options as $slug => $option ){
					foreach( $option['options'] as $key => $value ){
						$options[$slug]['options'][$key]['default'] = infinite_get_option('general', $key);
					}
				}
			} 
			
			return $options;
		}
	}
	
	add_filter('gdlr_core_header_color_options', 'infinite_gdlr_core_header_color_options', 10, 2);
	if( !function_exists('infinite_gdlr_core_header_color_options') ){
		function infinite_gdlr_core_header_color_options( $options, $with_default = true ){

			$options = array(
				'header-color' => infinite_header_color_options(), 
				'navigation-menu-color' => infinite_navigation_color_options(), 		
				'navigation-right-color' => infinite_navigation_right_color_options(),
			);

			// set default
			if( $with_default ){
				foreach( $options as $slug => $option ){
					foreach( $option['options'] as $key => $value ){
						$options[$slug]['options'][$key]['default'] = infinite_get_option('color', $key);
					}
				}
			}

			return $options;
		}
	}

	add_action('wp_head', 'infinite_set_custom_header');
	if( !function_exists('infinite_set_custom_header') ){
		function infinite_set_custom_header(){
			infinite_get_option('general', 'layout', '');
			
			$header_id = get_post_meta(get_the_ID(), 'gdlr_core_custom_header_id', true);
			if( empty($header_id) ){
				$header_id = infinite_get_option('general', 'custom-header', '');
			}

			if( !empty($header_id) ){
				$option = INFINITE_SHORT_NAME . '_general';

				if( empty($GLOBALS[$option]) ) return;
				
				$header_options = get_post_meta($header_id, 'gdlr-core-header-settings', true);

				if( !empty($header_options) ){
					foreach( $header_options as $key => $value ){
						$GLOBALS[$option][$key] = $value;
					}
				}

				$header_css = get_post_meta($header_id, 'gdlr-core-custom-header-css', true);
				if( !empty($header_css) ){
					if( get_post_type() == 'page' ){
						$header_css = str_replace('.gdlr-core-page-id', '.page-id-' . get_the_ID(), $header_css);
					}else{
						$header_css = str_replace('.gdlr-core-page-id', '.postid-' . get_the_ID(), $header_css);
					}
					echo '<style type="text/css" >' . $header_css . '</style>';
				}
				

			}
		} // infinite_set_custom_header
	}

	// override menu on page option
	add_filter('wp_nav_menu_args', 'infinite_wp_nav_menu_args');
	if( !function_exists('infinite_wp_nav_menu_args') ){
		function infinite_wp_nav_menu_args($args){

			$infinite_locations = array('main_menu', 'right_menu', 'top_bar_menu', 'mobile_menu');
			if( !empty($args['theme_location']) && in_array($args['theme_location'], $infinite_locations) ){
				$menu_id = get_post_meta(get_the_ID(), 'gdlr-core-location-' . $args['theme_location'], true);
				
				if( !empty($menu_id) ){
					$args['menu'] = $menu_id;
					$args['theme_location'] = '';
				}
			}

			return $args;
		}
	}

	if( !function_exists('infinite_top_bar_options') ){
		function infinite_top_bar_options(){
			return array(
				'title' => esc_html__('Top Bar', 'infinite'),
				'options' => array(

					'enable-top-bar' => array(
						'title' => esc_html__('Enable Top Bar', 'infinite'),
						'type' => 'checkbox',
					),
					'enable-top-bar-on-mobile' => array(
						'title' => esc_html__('Enable Top Bar On Mobile', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'top-bar-width' => array(
						'title' => esc_html__('Top Bar Width', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'infinite'),
							'full' => esc_html__('Full', 'infinite'),
							'custom' => esc_html__('Custom', 'infinite'),
						),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-side-margin' => array(
						'title' => esc_html__('Top Bar ( Left/Right ) Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.infinite-top-bar, .infinite-header-wrap{ margin-right: #gdlr#; margin-left: #gdlr#; } .infinite-header-wrap.infinite-fixed-navigation{ margin-left: 0px; margin-right: 0px; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-width-pixel' => array(
						'title' => esc_html__('Top Bar Width Pixel', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'custom' ),
						'selector' => '.infinite-top-bar-container.infinite-top-bar-custom-container{ max-width: #gdlr#; }'
					),
					'top-bar-full-side-padding' => array(
						'title' => esc_html__('Top Bar Full ( Left/Right ) Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.infinite-top-bar-container.infinite-top-bar-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable', 'top-bar-width' => 'full' )
					),
					'top-bar-menu-position' => array(
						'title' => esc_html__('Top Bar Menu Position', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'none' => esc_html__('None', 'infinite'),
							'left' => esc_html__('Left', 'infinite'),
							'right' => esc_html__('Right', 'infinite'),
						),
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-left-text' => array(
						'title' => esc_html__('Top Bar Left Text', 'infinite'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-right-text' => array(
						'title' => esc_html__('Top Bar Right Text', 'infinite'),
						'type' => 'textarea',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-top-padding' => array(
						'title' => esc_html__('Top Bar Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
 						'default' => '10px',
						'selector' => '.infinite-top-bar{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-padding' => array(
						'title' => esc_html__('Top Bar Bottom Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '10px',
						'selector' => '.infinite-top-bar{ padding-bottom: #gdlr#; }' .
							'.infinite-top-bar .infinite-top-bar-menu > li > a{ padding-bottom: #gdlr#; }' .  
							'.sf-menu.infinite-top-bar-menu > .infinite-mega-menu .sf-mega, .sf-menu.infinite-top-bar-menu > .infinite-normal-menu ul{ margin-top: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-text-size' => array(
						'title' => esc_html__('Top Bar Text Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.infinite-top-bar{ font-size: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-border' => array(
						'title' => esc_html__('Top Bar Bottom Border', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.infinite-top-bar, .infinite-top-bar-bottom-border{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-bottom-border-style' => array(
						'title' => esc_html__('Top Bar Bottom Border Position', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'outer' => esc_html__('Outer', 'infinite'),
							'inner' => esc_html__('Inner', 'infinite')
						)
					),
					'top-bar-split-border' => array(
						'title' => esc_html__('Top Bar Split Border', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable' 
					),
					'top-bar-shadow-size' => array(
						'title' => esc_html__('Top Bar Shadow Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'condition' => array( 'enable-top-bar' => 'enable' )
					),
					'top-bar-shadow-color' => array(
						'title' => esc_html__('Top Bar Shadow Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.infinite-top-bar{ ' . 
							'box-shadow: 0px 0px <top-bar-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-webkit-box-shadow: 0px 0px <top-bar-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-moz-box-shadow: 0px 0px <top-bar-shadow-size>t rgba(#gdlra#, 0.1); }',
						'condition' => array( 'enable-top-bar' => 'enable' )
					)

				)
			);
		}
	}

	if( !function_exists('infinite_top_bar_social_options') ){
		function infinite_top_bar_social_options(){
			return array(
				'title' => esc_html__('Top Bar Social', 'infinite'),
				'options' => array(
					'enable-top-bar-social' => array(
						'title' => esc_html__('Enable Top Bar Social', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'top-bar-social-icon-size' => array(
						'title' => esc_html__('Icon Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-top-bar-right-social{ font-size: #gdlr#; }'
					),
					'top-bar-social-icon-type' => array(
						'title' => esc_html__('Icon Type', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'font-awesome' => esc_html__('Font Awesome', 'infinite'),
							'font-awesome5' => esc_html__('Font Awesome 5', 'infinite'),
							'font-awesome6' => esc_html__('Font Awesome 6', 'infinite'),
						)
					),
					'top-bar-social-position' => array(
						'title' => esc_html__('Top Bar Social Position', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left', 'infinite'),
							'right' => esc_html__('Right', 'infinite'),
						),
						'default' => 'right',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-tiktok' => array(
						'title' => esc_html__('Top Bar Social Tiktok Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable', 'top-bar-social-icon-type' => 'font-awesome5' )
					),
					'top-bar-social-twitch' => array(
						'title' => esc_html__('Top Bar Social Twitch Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-discord' => array(
						'title' => esc_html__('Top Bar Social Discord Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable', 'top-bar-social-icon-type' => 'font-awesome5' )
					),
					'top-bar-social-delicious' => array(
						'title' => esc_html__('Top Bar Social Delicious Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-email' => array(
						'title' => esc_html__('Top Bar Social Email Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-deviantart' => array(
						'title' => esc_html__('Top Bar Social Deviantart Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-digg' => array(
						'title' => esc_html__('Top Bar Social Digg Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-facebook' => array(
						'title' => esc_html__('Top Bar Social Facebook Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-flickr' => array(
						'title' => esc_html__('Top Bar Social Flickr Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-lastfm' => array(
						'title' => esc_html__('Top Bar Social Lastfm Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-linkedin' => array(
						'title' => esc_html__('Top Bar Social Linkedin Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-pinterest' => array(
						'title' => esc_html__('Top Bar Social Pinterest Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-rss' => array(
						'title' => esc_html__('Top Bar Social RSS Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-skype' => array(
						'title' => esc_html__('Top Bar Social Skype Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-stumbleupon' => array(
						'title' => esc_html__('Top Bar Social Stumbleupon Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-tumblr' => array(
						'title' => esc_html__('Top Bar Social Tumblr Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-twitter' => array(
						'title' => esc_html__('Top Bar Social Twitter Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' ),
						'description' => esc_html__('Change \'Icon Type\' on the top to \'Font Awesome 6\' for new (X) icon', 'infinite')
					),
					'top-bar-social-vimeo' => array(
						'title' => esc_html__('Top Bar Social Vimeo Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-youtube' => array(
						'title' => esc_html__('Top Bar Social Youtube Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-instagram' => array(
						'title' => esc_html__('Top Bar Social Instagram Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),
					'top-bar-social-snapchat' => array(
						'title' => esc_html__('Top Bar Social Snapchat Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-top-bar-social' => 'enable' )
					),

				)
			);
		}
	}

	if( !function_exists('infinite_header_options') ){
		function infinite_header_options(){
			return array(
				'title' => esc_html__('Header', 'infinite'),
				'options' => array(

					'header-style' => array(
						'title' => esc_html__('Header Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'plain' => esc_html__('Plain', 'infinite'),
							'bar' => esc_html__('Bar', 'infinite'),
							'bar2' => esc_html__('Navigation Boxed', 'infinite'),
							'boxed' => esc_html__('Boxed', 'infinite'),
							'side' => esc_html__('Side Menu', 'infinite'),
							'side-toggle' => esc_html__('Side Menu Toggle', 'infinite'),
						),
						'default' => 'plain',
					),
					'header-plain-style' => array(
						'title' => esc_html__('Header Plain Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'menu-left' => get_template_directory_uri() . '/images/header/plain-menu-left.jpg',
							'menu-right' => get_template_directory_uri() . '/images/header/plain-menu-right.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/plain-center-logo.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/plain-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/plain-splitted-menu.jpg',
							'top-bar-logo' => get_template_directory_uri() . '/images/header/top-bar-logo.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'plain' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-plain-bottom-border' => array(
						'title' => esc_html__('Plain Header Bottom Border', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '10',
						'default' => '0',
						'selector' => '.infinite-header-style-plain{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain') )
					),
					'header-bar-navigation-align' => array(
						'title' => esc_html__('Header Bar Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/bar-left.jpg',
							'center' => get_template_directory_uri() . '/images/header/bar-center.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/bar-center-logo.jpg',
						),
						'default' => 'center',
						'condition' => array( 'header-style' => 'bar' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-bar2-navigation-align' => array(
						'title' => esc_html__('Header Bar 2 Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/bar2-left.jpg',
							'center' => get_template_directory_uri() . '/images/header/bar2-center.jpg',
							'center-logo' => get_template_directory_uri() . '/images/header/bar2-center-logo.jpg',
						),
						'default' => 'center',
						'condition' => array( 'header-style' => 'bar2' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-background-style' => array(
						'title' => esc_html__('Header/Navigation Background Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'solid' => esc_html__('Solid', 'infinite'),
							'transparent' => esc_html__('Transparent', 'infinite'),
						),
						'default' => 'solid',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2') )
					),
					'top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => 'plain', 'header-background-style' => 'transparent' ),
						'selector' => '.infinite-header-background-transparent .infinite-top-bar-background{ opacity: #gdlr#; }'
					),
					'header-background-opacity' => array(
						'title' => esc_html__('Header Background Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => array('plain', 'bar2'), 'header-background-style' => 'transparent' ),
						'selector' => '.infinite-header-background-transparent .infinite-header-background{ opacity: #gdlr#; }'
					),
					'navigation-background-opacity' => array(
						'title' => esc_html__('Navigation Background Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '50',
						'condition' => array( 'header-style' => array('bar', 'bar2'), 'header-background-style' => 'transparent' ),
						'selector' => '.infinite-navigation-bar-wrap.infinite-style-transparent .infinite-navigation-background{ opacity: #gdlr#; }'
					),
					'header-boxed-style' => array(
						'title' => esc_html__('Header Boxed Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'menu-right' => get_template_directory_uri() . '/images/header/boxed-menu-right.jpg',
							'center-menu' => get_template_directory_uri() . '/images/header/boxed-center-menu.jpg',
							'splitted-menu' => get_template_directory_uri() . '/images/header/boxed-splitted-menu.jpg',
						),
						'default' => 'menu-right',
						'condition' => array( 'header-style' => 'boxed' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'boxed-top-bar-background-opacity' => array(
						'title' => esc_html__('Top Bar Background Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '0',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.infinite-header-boxed-wrap .infinite-top-bar-background{ opacity: #gdlr#; }'
					),
					'boxed-top-bar-background-extend' => array(
						'title' => esc_html__('Top Bar Background Extend ( Bottom )', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.infinite-header-boxed-wrap .infinite-top-bar-background{ margin-bottom: -#gdlr#; }'
					),
					'boxed-header-top-margin' => array(
						'title' => esc_html__('Header Top Margin', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0px',
						'data-max' => '200px',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.infinite-header-style-boxed{ margin-top: #gdlr#; }'
					),
					'header-side-style' => array(
						'title' => esc_html__('Header Side Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'top-left' => get_template_directory_uri() . '/images/header/side-top-left.jpg',
							'middle-left' => get_template_directory_uri() . '/images/header/side-middle-left.jpg',
							'middle-left-2' => get_template_directory_uri() . '/images/header/side-middle-left-2.jpg',
							'top-right' => get_template_directory_uri() . '/images/header/side-top-right.jpg',
							'middle-right' => get_template_directory_uri() . '/images/header/side-middle-right.jpg',
							'middle-right-2' => get_template_directory_uri() . '/images/header/side-middle-right-2.jpg',
						),
						'default' => 'top-left',
						'condition' => array( 'header-style' => 'side' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-align' => array(
						'title' => esc_html__('Header Side Text Align', 'infinite'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left',
						'condition' => array( 'header-style' => 'side' )
					),
					'header-side-toggle-style' => array(
						'title' => esc_html__('Header Side Toggle Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'left' => get_template_directory_uri() . '/images/header/side-toggle-left.jpg',
							'right' => get_template_directory_uri() . '/images/header/side-toggle-right.jpg',
						),
						'default' => 'left',
						'condition' => array( 'header-style' => 'side-toggle' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'header-side-toggle-menu-type' => array(
						'title' => esc_html__('Header Side Toggle Menu Type', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'infinite'),
							'right' => esc_html__('Right Slide Menu', 'infinite'),
							'overlay' => esc_html__('Overlay Menu', 'infinite'),
						),
						'default' => 'overlay',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-side-toggle-display-logo' => array(
						'title' => esc_html__('Display Logo', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'header-style' => 'side-toggle' )
					),
					'header-width' => array(
						'title' => esc_html__('Header Width', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'boxed' => esc_html__('Boxed ( Within Container )', 'infinite'),
							'full' => esc_html__('Full', 'infinite'),
							'custom' => esc_html__('Custom', 'infinite'),
						),
						'condition' => array('header-style'=> array('plain', 'bar', 'bar2', 'boxed'))
					),
					'header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'default' => '1140px',
						'condition' => array('header-style'=> array('plain', 'bar', 'bar2', 'boxed'), 'header-width' => 'custom'),
						'selector' => '.infinite-header-container.infinite-header-custom-container{ max-width: #gdlr#; }'
					),
					'header-full-side-padding' => array(
						'title' => esc_html__('Header Full ( Left/Right ) Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.infinite-header-container.infinite-header-full{ padding-right: #gdlr#; padding-left: #gdlr#; }',
						'condition' => array('header-style'=> array('plain', 'bar', 'bar2', 'boxed'), 'header-width'=>'full')
					),
					'boxed-header-frame-radius' => array(
						'title' => esc_html__('Header Frame Radius', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '3px',
						'condition' => array( 'header-style' => 'boxed' ),
						'selector' => '.infinite-header-boxed-wrap .infinite-header-background{ border-radius: #gdlr#; -moz-border-radius: #gdlr#; -webkit-border-radius: #gdlr#; }'
					),
					'boxed-header-content-padding' => array(
						'title' => esc_html__('Header Content ( Left/Right ) Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '30px',
						'selector' => '.infinite-header-style-boxed .infinite-header-container-item{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.infinite-navigation-right{ right: #gdlr#; } .infinite-navigation-left{ left: #gdlr#; }',
						'condition' => array( 'header-style' => 'boxed' )
					),
					'navigation-text-top-margin' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'plain', 'header-plain-style' => 'splitted-menu' ),
						'selector' => '.infinite-header-style-plain.infinite-style-splitted-menu .infinite-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.infinite-header-style-plain.infinite-style-splitted-menu .infinite-main-menu-left-wrap,' .
							'.infinite-header-style-plain.infinite-style-splitted-menu .infinite-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-top-margin-boxed' => array(
						'title' => esc_html__('Navigation Text Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '0px',
						'condition' => array( 'header-style' => 'boxed', 'header-boxed-style' => 'splitted-menu' ),
						'selector' => '.infinite-header-style-boxed.infinite-style-splitted-menu .infinite-navigation .sf-menu > li > a{ padding-top: #gdlr#; } ' .
							'.infinite-header-style-boxed.infinite-style-splitted-menu .infinite-main-menu-left-wrap,' .
							'.infinite-header-style-boxed.infinite-style-splitted-menu .infinite-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'navigation-text-side-spacing' => array(
						'title' => esc_html__('Navigation Text Side ( Left / Right ) Spaces', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '30',
						'data-type' => 'pixel',
						'default' => '13px',
						'selector' => '.infinite-navigation .sf-menu > li{ padding-left: #gdlr#; padding-right: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed') )
					),
					'navigation-left-offset' => array(
						'title' => esc_html__('Navigation Left Offset Spaces', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '0',
						'selector' => '.infinite-navigation .infinite-main-menu{ margin-left: #gdlr#; }'
					),
					'navigation-slide-bar' => array(
						'title' => esc_html__('Navigation Slide Bar', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'disable' => esc_html__('Disable', 'infinite'),
							'enable' => esc_html__('Bar With Triangle Style', 'infinite'),
							'style-2' => esc_html__('Bar Style', 'infinite'),
							'style-2-left' => esc_html__('Bar Style Left', 'infinite'),
							'style-dot' => esc_html__('Dot Style', 'infinite')
						),
						'default' => 'enable',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed') )
					),
					'navigation-slide-bar-width' => array(
						'title' => esc_html__('Navigation Slide Bar Width', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed'), 'navigation-slide-bar' => array('style-2', 'style-2-left') )
					),
					'navigation-slide-bar-height' => array(
						'title' => esc_html__('Navigation Slide Bar Height', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.infinite-navigation .infinite-navigation-slide-bar-style-2{ border-bottom-width: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed'), 'navigation-slide-bar' => array('style-2', 'style-2-left') )
					),
					'navigation-slide-bar-top-margin' => array(
						'title' => esc_html__('Navigation Slide Bar Top Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.infinite-navigation .infinite-navigation-slide-bar{ margin-top: #gdlr#; }',
						'condition' => array( 'header-style' => array('plain', 'bar', 'bar2', 'boxed'), 'navigation-slide-bar' => array('enable', 'style-2', 'style-2-left', 'style-dot') )
					),
					'side-header-width-pixel' => array(
						'title' => esc_html__('Header Width Pixel', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '600',
						'default' => '340px',
						'condition' => array('header-style' => array('side', 'side-toggle')),
						'selector' => '.infinite-header-side-nav{ width: #gdlr#; }' . 
							'.infinite-header-side-content.infinite-style-left{ margin-left: #gdlr#; }' .
							'.infinite-header-side-content.infinite-style-right{ margin-right: #gdlr#; }'
					),
					'side-header-side-padding' => array(
						'title' => esc_html__('Header Side Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '70px',
						'condition' => array('header-style' => 'side'),
						'selector' => '.infinite-header-side-nav.infinite-style-side{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.infinite-header-side-nav.infinite-style-left .sf-vertical > li > ul.sub-menu{ padding-left: #gdlr#; }' .
							'.infinite-header-side-nav.infinite-style-right .sf-vertical > li > ul.sub-menu{ padding-right: #gdlr#; }'
					),
					'navigation-text-top-spacing' => array(
						'title' => esc_html__('Navigation Text Top / Bottom Spaces', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '40',
						'data-type' => 'pixel',
						'default' => '16px',
						'selector' => ' .infinite-navigation .sf-vertical > li{ padding-top: #gdlr#; padding-bottom: #gdlr#; }',
						'condition' => array( 'header-style' => array('side') )
					),
					'logo-right-text' => array(
						'title' => esc_html__('Header Right Text', 'infinite'),
						'type' => 'textarea',
						'condition' => array('header-style' => array('bar', 'bar2')),
					),
					'logo-right-text-top-padding' => array(
						'title' => esc_html__('Header Right Text Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '30px',
						'condition' => array('header-style' => array('bar', 'bar2')),
						'selector' => '.infinite-header-style-bar .infinite-logo-right-text{ padding-top: #gdlr#; }'
					),
					'header-shadow-size' => array(
						'title' => esc_html__('Header Shadow Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'condition' => array( 'header-style' => 'plain' )
					),
					'header-shadow-color' => array(
						'title' => esc_html__('Header Shadow Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.infinite-header-style-plain{ ' . 
							'box-shadow: 0px 0px <header-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-webkit-box-shadow: 0px 0px <header-shadow-size>t rgba(#gdlra#, 0.1); ' . 
							'-moz-box-shadow: 0px 0px <header-shadow-size>t rgba(#gdlra#, 0.1); }',
						'condition' => array( 'header-style' => 'plain' )
					)
				)
			);
		}
	}

	if( !function_exists('infinite_logo_options') ){
		function infinite_logo_options(){
			return array(
				'title' => esc_html__('Logo', 'infinite'),
				'options' => array(
					'enable-logo' => array(
						'title' => esc_html__('Enable Logo', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'logo' => array(
						'title' => esc_html__('Logo', 'infinite'),
						'type' => 'upload',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo2x' => array(
						'title' => esc_html__('Logo 2x (Retina)', 'infinite'),
						'type' => 'upload',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo-top-padding' => array(
						'title' => esc_html__('Logo Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.infinite-logo{ padding-top: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'infinite'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo-bottom-padding' => array(
						'title' => esc_html__('Logo Bottom Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.infinite-logo{ padding-bottom: #gdlr#; }',
						'description' => esc_html__('This option will be omitted on splitted menu option.', 'infinite'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'logo-left-padding' => array(
						'title' => esc_html__('Logo Left Padding', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.infinite-logo.infinite-item-pdlr{ padding-left: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'infinite'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'max-logo-width' => array(
						'title' => esc_html__('Max Logo Width', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '200px',
						'selector' => '.infinite-logo-inner{ max-width: #gdlr#; }',
						'condition' => array( 'enable-logo' => 'enable' )
					),

					'mobile-logo' => array(
						'title' => esc_html__('Mobile/Tablet Logo', 'infinite'),
						'type' => 'upload',
						'description' => esc_html__('Leave this option blank to use the same logo.', 'infinite'),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'max-tablet-logo-width' => array(
						'title' => esc_html__('Max Tablet Logo Width', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 999px){ .infinite-mobile-header .infinite-logo-inner{ max-width: #gdlr#; } }',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'max-mobile-logo-width' => array(
						'title' => esc_html__('Max Mobile Logo Width', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '@media only screen and (max-width: 767px){ .infinite-mobile-header .infinite-logo-inner{ max-width: #gdlr#; } }',
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'mobile-logo-position' => array(
						'title' => esc_html__('Mobile Logo Position', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'logo-left' => esc_html__('Logo Left', 'infinite'),
							'logo-center' => esc_html__('Logo Center', 'infinite'),
							'logo-right' => esc_html__('Logo Right', 'infinite'),
						),
						'condition' => array( 'enable-logo' => 'enable' )
					),
					'mobile-header-bottom-shadow' => array(
						'title' => esc_html__('Mobile Header Bottom Shadow', 'infinite'),
						'type' => 'checkbox',
						'options' => 'enable'
					)
				
				)
			);
		}
	}

	if( !function_exists('infinite_navigation_options') ){
		function infinite_navigation_options(){
			return array(
				'title' => esc_html__('Navigation', 'infinite'),
				'options' => array(
					'main-navigation-top-padding' => array(
						'title' => esc_html__('Main Navigation Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '25px',
						'selector' => '.infinite-navigation{ padding-top: #gdlr#; }' . 
							'.infinite-navigation-top{ top: #gdlr#; }'
					),
					'main-navigation-bottom-padding' => array(
						'title' => esc_html__('Main Navigation Bottom Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '20px',
						'selector' => '.infinite-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }'
					),
					'main-navigation-item-right-padding' => array(
						'title' => esc_html__('Main Navigation Item Right Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '200',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.infinite-navigation .infinite-main-menu{ padding-right: #gdlr#; }'
					),
					'main-navigation-right-padding' => array(
						'title' => esc_html__('Main Navigation Wrap Right Padding', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.infinite-navigation.infinite-item-pdlr{ padding-right: #gdlr#; }',
						'description' => esc_html__('Leave this field blank for default value.', 'infinite'),
					),
					'enable-main-navigation-submenu-indicator' => array(
						'title' => esc_html__('Enable Main Navigation Submenu Indicator', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable',
					),
					'navigation-right-top-margin' => array(
						'title' => esc_html__('Navigation Right ( search/cart/button ) Top Margin', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-main-menu-right-wrap{ margin-top: #gdlr#; }'
					),
					'navigation-right-left-margin' => array(
						'title' => esc_html__('Navigation Right ( search/cart/button ) Left Margin ', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-main-menu-right-wrap{ margin-left: #gdlr# !important; }'
					),
					'enable-main-navigation-search' => array(
						'title' => esc_html__('Enable Main Navigation Search', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'main-navigation-search-icon' => array(
						'title' => esc_html__('Main Navigation Search Icon', 'infinite'),
						'type' => 'text',
						'default' => 'fa fa-search',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'main-navigation-search-icon-top-margin' => array(
						'title' => esc_html__('Main Navigation Search Icon Top Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'selector' => '.infinite-main-menu-search{ margin-top: #gdlr#; }',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'enable-main-navigation-cart' => array(
						'title' => esc_html__('Enable Main Navigation Cart ( Woocommerce )', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'description' => esc_html__('The icon only shows if the woocommerce plugin is activated', 'infinite')
					),
					'main-navigation-cart-icon' => array(
						'title' => esc_html__('Main Navigation Cart Icon', 'infinite'),
						'type' => 'text',
						'default' => 'fa fa-shopping-cart',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'main-navigation-cart-icon-top-margin' => array(
						'title' => esc_html__('Main Navigation Cart Icon Top Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel', 
						'selector' => '.infinite-main-menu-cart{ margin-top: #gdlr#; }',
						'condition' => array('enable-main-navigation-search' => 'enable')
					),
					'enable-main-navigation-right-button' => array(
						'title' => esc_html__('Enable Main Navigation Right Button', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('This option will be ignored on header side style', 'infinite')
					),
					'main-navigation-right-button-style' => array(
						'title' => esc_html__('Main Navigation Right Button Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'default' => esc_html__('Default', 'infinite'),
							'round' => esc_html__('Round', 'infinite'),
							'round-with-shadow' => esc_html__('Round With Shadow', 'infinite'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-text' => array(
						'title' => esc_html__('Main Navigation Right Button Text', 'infinite'),
						'type' => 'text',
						'default' => esc_html__('Buy Now', 'infinite'),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link' => array(
						'title' => esc_html__('Main Navigation Right Button Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-target' => array(
						'title' => esc_html__('Main Navigation Right Button Link Target', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'infinite'),
							'_blank' => esc_html__('New Window', 'infinite'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-style-2' => array(
						'title' => esc_html__('Main Navigation Right Button Style 2', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'default' => esc_html__('Default', 'infinite'),
							'round' => esc_html__('Round', 'infinite'),
							'round-with-shadow' => esc_html__('Round With Shadow', 'infinite'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-text-2' => array(
						'title' => esc_html__('Main Navigation Right Button Text 2', 'infinite'),
						'type' => 'text',
						'default' => esc_html__('Buy Now', 'infinite'),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-2' => array(
						'title' => esc_html__('Main Navigation Right Button Link 2', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'main-navigation-right-button-link-target-2' => array(
						'title' => esc_html__('Main Navigation Right Button Link Target 2', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'_self' => esc_html__('Current Screen', 'infinite'),
							'_blank' => esc_html__('New Window', 'infinite'),
						),
						'condition' => array( 'enable-main-navigation-right-button' => 'enable' ) 
					),
					'enable-secondary-menu' => array(
						'title' => esc_html__('Enable Secondary Menu', 'infinite'),
						'type' => 'checkbox', 
						'default' => 'enable'
					),
					'right-menu-type' => array(
						'title' => esc_html__('Secondary/Mobile Menu Type', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left Slide Menu', 'infinite'),
							'right' => esc_html__('Right Slide Menu', 'infinite'),
							'overlay' => esc_html__('Overlay Menu', 'infinite'),
						),
						'default' => 'right'
					),
					'right-menu-style' => array(
						'title' => esc_html__('Secondary/Mobile Menu Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'hamburger-with-border' => esc_html__('Hamburger With Border ( Font Awesome )', 'infinite'),
							'hamburger' => esc_html__('Hamburger', 'infinite'),
							'hamburger-small' => esc_html__('Hamburger Small', 'infinite'),
						),
						'default' => 'hamburger-with-border'
					),
					'right-menu-left-margin' => array(
						'title' => esc_html__('Secondary Menu Left Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.infinite-right-menu-button{ margin-left: #gdlr#; }'
					),
					'side-content-menu' => array(
						'title' => esc_html__('Side Content Menu', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'side-content-menu-left-margin' => array(
						'title' => esc_html__('Secondary Menu Left Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.infinite-side-content-menu-button{ margin-left: #gdlr#; }'
					),
					'side-content-widget' => array(
						'title' => esc_html__('Choose Side Content Widget', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-background-color' => array(
						'title' => esc_html__('Side Content Background Color', 'infinite'),
						'type' => 'colorpicker',
						'selector' => '.infinite-header-side-content, #infinite-side-content-menu{ background-color: #gdlr#; }',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-text-color' => array(
						'title' => esc_html__('Side Content Text Color', 'infinite'),
						'type' => 'colorpicker',
						'selector' => '#infinite-side-content-menu .widget{ color: #gdlr#; }',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-shadow-size' => array(
						'title' => esc_html__('Side Content Shadow Size', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'condition' => array( 'side-content-menu' => 'enable' )
					),
					'side-content-shadow-opacity' => array(
						'title' => esc_html__('Side Content Shadow Opacity', 'infinite'),
						'type' => 'text',
						'data-type' => 'text',
						'default' => '0.1',
						'condition' => array( 'side-content-menu' => 'enable' ),
						'selector-extra' => true,
						'selector' => '#infinite-side-content-menu{ box-shadow: 0px 0px <side-content-shadow-size>t rgba(0, 0, 0, #gdlr#); -webkit-box-shadow: 0px 0px <side-content-shadow-size>t rgba(0, 0, 0, #gdlr#); }'
					),
					
				) // logo-options
			);
		}
	}

	if( !function_exists('infinite_fixed_navigation_options') ){
		function infinite_fixed_navigation_options(){
			return array(
				'title' => esc_html__('Fixed Navigation', 'infinite'),
				'options' => array(

					'enable-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Fixed Navigation Bar', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'fixed-navigation-bar-background' => array(
						'title' => esc_html__('Fixed Navigation Bar Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.infinite-fixed-navigation .infinite-header-background{ background-image: url(#gdlr#); background-position: center; background-size: cover; }',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' )
					),
					'enable-logo-on-main-navigation-sticky' => array(
						'title' => esc_html__('Enable Logo on Fixed Navigation Bar', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'description' => esc_html__('This option will be omitted when the logo is disabeld', 'infinite'),
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-bar-logo' => array(
						'title' => esc_html__('Fixed Navigation Bar Logo', 'infinite'),
						'type' => 'upload',
						'description' => esc_html__('Leave blank to show default logo', 'infinite'),
						'condition' => array( 'enable-main-navigation-sticky' => 'enable', 'enable-logo-on-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-bar-logo2x' => array(
						'title' => esc_html__('Fixed Navigation Bar Logo 2x (Retina)', 'infinite'),
						'type' => 'upload',
						'description' => esc_html__('Leave blank to show default logo', 'infinite'),
						'condition' => array( 'enable-main-navigation-sticky' => 'enable', 'enable-logo-on-main-navigation-sticky' => 'enable' )
					),
					'fixed-navigation-max-logo-width' => array(
						'title' => esc_html__('Fixed Navigation Max Logo Width', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.infinite-fixed-navigation.infinite-style-slide .infinite-logo-inner img{ max-height: none !important; }' .
							'.infinite-animate-fixed-navigation.infinite-header-style-plain .infinite-logo-inner, ' . 
							'.infinite-animate-fixed-navigation.infinite-header-style-boxed .infinite-logo-inner{ max-width: #gdlr#; }' . 
							'.infinite-mobile-header.infinite-fixed-navigation .infinite-logo-inner{ max-width: #gdlr#; }'
					),
					'fixed-navigation-logo-top-padding' => array(
						'title' => esc_html__('Fixed Navigation Logo Top Padding', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '20px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.infinite-animate-fixed-navigation.infinite-header-style-plain .infinite-logo, ' . 
							'.infinite-animate-fixed-navigation.infinite-header-style-boxed .infinite-logo{ padding-top: #gdlr#; }'
					),
					'fixed-navigation-logo-bottom-padding' => array(
						'title' => esc_html__('Fixed Navigation Logo Bottom Padding', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '20px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.infinite-animate-fixed-navigation.infinite-header-style-plain .infinite-logo, ' . 
							'.infinite-animate-fixed-navigation.infinite-header-style-boxed .infinite-logo{ padding-bottom: #gdlr#; }'
					),
					'fixed-navigation-top-padding' => array(
						'title' => esc_html__('Fixed Navigation Top Padding', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '30px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.infinite-animate-fixed-navigation.infinite-header-style-plain .infinite-navigation, ' . 
							'.infinite-animate-fixed-navigation.infinite-header-style-boxed .infinite-navigation{ padding-top: #gdlr#; }' . 
							'.infinite-animate-fixed-navigation.infinite-header-style-plain .infinite-navigation-top, ' . 
							'.infinite-animate-fixed-navigation.infinite-header-style-boxed .infinite-navigation-top{ top: #gdlr#; }' .
							'.infinite-animate-fixed-navigation.infinite-navigation-bar-wrap .infinite-navigation{ padding-top: #gdlr#; }' .
							'.infinite-animate-fixed-navigation.infinite-header-style-plain.infinite-style-splitted-menu .infinite-main-menu-left-wrap,' .
							'.infinite-animate-fixed-navigation.infinite-header-style-plain.infinite-style-splitted-menu .infinite-main-menu-right-wrap{ padding-top: #gdlr#; }'
					),
					'fixed-navigation-bottom-padding' => array(
						'title' => esc_html__('Fixed Navigation Bottom Padding', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '25px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.infinite-animate-fixed-navigation.infinite-header-style-plain .infinite-navigation .sf-menu > li > a, ' . 
							'.infinite-animate-fixed-navigation.infinite-header-style-boxed .infinite-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }' .
							'.infinite-animate-fixed-navigation.infinite-navigation-bar-wrap .infinite-navigation .sf-menu > li > a{ padding-bottom: #gdlr#; }' .
							'.infinite-animate-fixed-navigation .infinite-main-menu-right{ margin-bottom: #gdlr#; }'
					),
					'fixed-navigation-right-top-space' => array(
						'title' => esc_html__('Fixed Navigation Right Top Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.infinite-animate-fixed-navigation .infinite-main-menu-right-wrap{ margin-top: #gdlr#; }'
					),
					'enable-fixed-navigation-slide-bar' => array(
						'title' => esc_html__('Enable Fixed Navigation Slide Bar', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'fixed-navigation-slide-bar-top-margin' => array(
						'title' => esc_html__('Fixed Navigation Slide Bar Top Margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'selector' => '.infinite-fixed-navigation .infinite-navigation .infinite-navigation-slide-bar{ margin-top: #gdlr#; }',
						'condition' => array('enable-fixed-navigation-slide-bar' => 'enable')
					),
					'fixed-navigation-right-top-margin' => array(
						'title' => esc_html__('Fixed Navigation Right (search/cart/button) Top margin', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
						'selector' => '.infinite-animate-fixed-navigation .infinite-main-menu-right-wrap{ margin-top: #gdlr# !important; }'
					),
					'fixed-navigation-anchor-offset' => array(
						'title' => esc_html__('Fixed Navigation Anchor Offset ( Fixed Navigation Height )', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '75px',
						'condition' => array( 'enable-main-navigation-sticky' => 'enable' ),
					),
					'enable-mobile-navigation-sticky' => array(
						'title' => esc_html__('Enable Mobile Fixed Navigation Bar', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
					),

				)
			);
		}
	}

	if( !function_exists('infinite_header_color_options') ){
		function infinite_header_color_options(){

			return array(
				'title' => esc_html__('Header', 'infinite'),
				'options' => array(
					'top-bar-background-color' => array(
						'title' => esc_html__('Top Bar Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#222222',
						'selector' => '.infinite-top-bar-background{ background-color: #gdlr#; }'
					),
					'top-bar-bottom-border-opacity' => array(
						'title' => esc_html__('Top Bar Bottom Border Opacity', 'infinite'),
						'type' => 'text',
						'default' => '0.85',
					),
					'top-bar-bottom-border-color' => array(
						'title' => esc_html__('Top Bar Bottom Border Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'selector-extra' => true,
						'default' => '#ffffff',
						'selector' => '.infinite-body .infinite-top-bar, .infinite-top-bar.infinite-splited-border .infinite-top-bar-right-social a:after,' .
							'.infinite-top-bar-left-text .infinite-with-divider:before, .infinite-body .infinite-top-bar-bottom-border{ border-color: #gdlr#; border-color: rgba(#gdlra#, <top-bar-bottom-border-opacity>t); }'
					),
					'top-bar-text-color' => array(
						'title' => esc_html__('Top Bar Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.infinite-top-bar{ color: #gdlr#; }'
					),
					'top-bar-link-color' => array(
						'title' => esc_html__('Top Bar Link Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.infinite-body .infinite-top-bar a{ color: #gdlr#; }'
					),
					'top-bar-link-hover-color' => array(
						'title' => esc_html__('Top Bar Link Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.infinite-body .infinite-top-bar a:hover{ color: #gdlr#; }'
					),
					'top-bar-social-color' => array(
						'title' => esc_html__('Top Bar Social Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.infinite-top-bar .infinite-top-bar-right-social a, .infinite-header-style-side .infinite-header-social a{ color: #gdlr#; }'
					),
					'top-bar-social-hover-color' => array(
						'title' => esc_html__('Top Bar Social Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#e44444',
						'selector' => '.infinite-top-bar .infinite-top-bar-right-social a:hover, .infinite-header-style-side .infinite-header-social a:hover{ color: #gdlr#; }'
					),
					'header-background-color' => array(
						'title' => esc_html__('Header Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.infinite-header-background, .infinite-sticky-menu-placeholder, .infinite-header-style-boxed.infinite-fixed-navigation, body.single-product .infinite-header-background-transparent, body.archive.woocommerce .infinite-header-background-transparent{ background-color: #gdlr#; }'
					),
					'header-plain-bottom-border-color' => array(
						'title' => esc_html__('Header Bottom Border Color ( Header Plain Style )', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#e8e8e8',
						'selector' => '.infinite-header-wrap.infinite-header-style-plain{ border-color: #gdlr#; }'
					),
					'logo-background-color' => array(
						'title' => esc_html__('Logo Background Color ( Header Side Menu Toggle Style )', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector' => '.infinite-header-side-nav.infinite-style-side-toggle .infinite-logo{ background-color: #gdlr#; }'
					),
					'secondary-menu-icon-color' => array(
						'title' => esc_html__('Secondary Menu Icon Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector'=> '.infinite-top-menu-button i, .infinite-mobile-menu-button i{ color: #gdlr#; }' . 
							'.infinite-mobile-button-hamburger:before, ' . 
							'.infinite-mobile-button-hamburger:after, ' . 
							'.infinite-mobile-button-hamburger span, ' . 
							'.infinite-mobile-button-hamburger-small:before, ' . 
							'.infinite-mobile-button-hamburger-small:after, ' . 
							'.infinite-mobile-button-hamburger-small span{ background: #gdlr#; }' .
							'.infinite-side-content-menu-button span,' .
							'.infinite-side-content-menu-button:before, ' .
							'.infinite-side-content-menu-button:after{ background: #gdlr#; }'
					),
					'secondary-menu-border-color' => array(
						'title' => esc_html__('Secondary Menu Border Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#dddddd',
						'selector'=> '.infinite-main-menu-right .infinite-top-menu-button, .infinite-mobile-menu .infinite-mobile-menu-button{ border-color: #gdlr#; }'
					),
					'search-overlay-background-color' => array(
						'title' => esc_html__('Search Overlay Background Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector'=> '.infinite-top-search-wrap{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.88); }'
					),
					'top-cart-background-color' => array(
						'title' => esc_html__('Top Cart Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.infinite-top-cart-content-wrap .infinite-top-cart-content{ background-color: #gdlr#; }'
					),
					'top-cart-title-color' => array(
						'title' => esc_html__('Top Cart Title Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector'=> '.infinite-top-cart-content-wrap .infinite-top-cart-title, .infinite-top-cart-item .infinite-top-cart-item-title, ' . 
							'.infinite-top-cart-item .infinite-top-cart-item-remove{ color: #gdlr#; }'
					),
					'top-cart-info-color' => array(
						'title' => esc_html__('Top Cart Info Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#6c6c6c',
						'selector'=> '.infinite-top-cart-content-wrap .woocommerce-Price-amount.amount{ color: #gdlr#; }'
					),
					'top-cart-view-cart-color' => array(
						'title' => esc_html__('Top Cart : View Cart Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#323232',
						'selector'=> '.infinite-body .infinite-top-cart-button-wrap .infinite-top-cart-button, .infinite-body .infinite-top-cart-button-wrap .infinite-top-cart-button:hover{ color: #gdlr#; }'
					),
					'top-cart-view-cart-background-color' => array(
						'title' => esc_html__('Top Cart : View Cart Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#f4f4f4',
						'selector'=> '.infinite-body .infinite-top-cart-button-wrap .infinite-top-cart-button{ background-color: #gdlr#; }'
					),
					'top-cart-checkout-color' => array(
						'title' => esc_html__('Top Cart : Checkout Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.infinite-body .infinite-top-cart-button-wrap .infinite-top-cart-button-2{ color: #gdlr#; }'
					),
					'top-cart-checkout-background-color' => array(
						'title' => esc_html__('Top Cart : Checkout Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#000000',
						'selector'=> '.infinite-body .infinite-top-cart-button-wrap .infinite-top-cart-button-2{ background-color: #gdlr#; }'
					),
					'breadcrumbs-text-color' => array(
						'title' => esc_html__('Breadcrumbs ( Plugin ) Text Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#c0c0c0',
						'selector'=> '.infinite-body .infinite-breadcrumbs, .infinite-body .infinite-breadcrumbs a span, ' . 
							'.gdlr-core-breadcrumbs-item, .gdlr-core-breadcrumbs-item a span{ color: #gdlr#; }'
					),
					'breadcrumbs-text-active-color' => array(
						'title' => esc_html__('Breadcrumbs ( Plugin ) Text Active Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#777777',
						'selector'=> '.infinite-body .infinite-breadcrumbs span, .infinite-body .infinite-breadcrumbs a:hover span, ' . 
							'.gdlr-core-breadcrumbs-item span, .gdlr-core-breadcrumbs-item a:hover span{ color: #gdlr#; }'
					),
				) // header-options
			);

		}
	}

	if( !function_exists('infinite_navigation_color_options') ){
		function infinite_navigation_color_options(){

			return array(
				'title' => esc_html__('Menu', 'infinite'),
				'options' => array(

					'navigation-bar-background-color' => array(
						'title' => esc_html__('Navigation Bar Background Color ( Header Bar Style )', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#f4f4f4',
						'selector' => '.infinite-navigation-background{ background-color: #gdlr#; }'
					),
					'navigation-bar-top-border-color' => array(
						'title' => esc_html__('Navigation Bar Top Border Color ( Header Bar Style )', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#e8e8e8',
						'selector' => '.infinite-navigation-bar-wrap{ border-color: #gdlr#; }'
					),
					'navigation-slide-bar-color' => array(
						'title' => esc_html__('Navigation Slide Bar Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#2d9bea',
						'selector' => '.infinite-navigation .infinite-navigation-slide-bar, ' . 
							'.infinite-navigation .infinite-navigation-slide-bar-style-dot:before{ border-color: #gdlr#; }' . 
							'.infinite-navigation .infinite-navigation-slide-bar:before{ border-bottom-color: #gdlr#; }'
					),
					'main-menu-text-color' => array(
						'title' => esc_html__('Main Menu Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#999999',
						'selector' => '.sf-menu > li > a, .sf-vertical > li > a{ color: #gdlr#; }'
					),
					'main-menu-text-hover-color' => array(
						'title' => esc_html__('Main Menu Text Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector' => '.sf-menu > li > a:hover, ' . 
							'.sf-menu > li.current-menu-item > a, ' .
							'.sf-menu > li.current-menu-ancestor > a, ' .
							'.sf-vertical > li > a:hover, ' . 
							'.sf-vertical > li.current-menu-item > a, ' .
							'.sf-vertical > li.current-menu-ancestor > a{ color: #gdlr#; }'
					),
					'sub-menu-background-color' => array(
						'title' => esc_html__('Sub Menu Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#2e2e2e',
						'selector'=> '.sf-menu > .infinite-normal-menu li, .sf-menu > .infinite-mega-menu > .sf-mega, ' . 
							'.sf-vertical ul.sub-menu li, ul.sf-menu > .menu-item-language li{ background-color: #gdlr#; }'
					),
					'sub-menu-text-color' => array(
						'title' => esc_html__('Sub Menu Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#bebebe',
						'selector'=> '.sf-menu > li > .sub-menu a, .sf-menu > .infinite-mega-menu > .sf-mega a, ' . 
							'.sf-vertical ul.sub-menu li a{ color: #gdlr#; }'
					),
					'sub-menu-text-hover-color' => array(
						'title' => esc_html__('Sub Menu Text Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.sf-menu > li > .sub-menu a:hover, ' . 
							'.sf-menu > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-menu > li > .sub-menu .current-menu-ancestor > a, '.
							'.sf-menu > .infinite-mega-menu > .sf-mega a:hover, '.
							'.sf-menu > .infinite-mega-menu > .sf-mega .current-menu-item > a, '.
							'.sf-vertical > li > .sub-menu a:hover, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-ancestor > a{ color: #gdlr#; }'
					),
					'sub-menu-text-hover-background-color' => array(
						'title' => esc_html__('Sub Menu Text Hover Background', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#393939',
						'selector'=> '.sf-menu > li > .sub-menu a:hover, ' . 
							'.sf-menu > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-menu > li > .sub-menu .current-menu-ancestor > a, '.
							'.sf-menu > .infinite-mega-menu > .sf-mega a:hover, '.
							'.sf-menu > .infinite-mega-menu > .sf-mega .current-menu-item > a, '.
							'.sf-vertical > li > .sub-menu a:hover, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-item > a, ' . 
							'.sf-vertical > li > .sub-menu .current-menu-ancestor > a{ background-color: #gdlr#; }'
					),
					'sub-mega-menu-title-color' => array(
						'title' => esc_html__('Sub Mega Menu Title Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.infinite-navigation .sf-menu > .infinite-mega-menu .sf-mega-section-inner > a{ color: #gdlr#; }'
					),
					'sub-mega-menu-divider-color' => array(
						'title' => esc_html__('Sub Mega Menu Divider Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#424242',
						'selector'=> '.infinite-navigation .sf-menu > .infinite-mega-menu .sf-mega-section{ border-color: #gdlr#; }'
					),
					'sub-menu-shadow-size' => array(
						'title' => esc_html__('Sub Menu Shadow Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'sub-menu-shadow-opacity' => array(
						'title' => esc_html__('Sub Menu Shadow Opacity', 'infinite'),
						'type' => 'text',
						'default' => '0.15',
					),
					'sub-menu-shadow-color' => array(
						'title' => esc_html__('Sub Menu Shadow Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.infinite-navigation .sf-menu > .infinite-normal-menu .sub-menu, .infinite-navigation .sf-menu > .infinite-mega-menu .sf-mega{ ' . 
							'box-shadow: 0px 0px <sub-menu-shadow-size>t rgba(#gdlra#, <sub-menu-shadow-opacity>t); ' .
							'-webkit-box-shadow: 0px 0px <sub-menu-shadow-size>t rgba(#gdlra#, <sub-menu-shadow-opacity>t); ' .
							'-moz-box-shadow: 0px 0px <sub-menu-shadow-size>t rgba(#gdlra#, <sub-menu-shadow-opacity>t); }',
					),
					'fixed-menu-shadow-size' => array(
						'title' => esc_html__('Fixed Menu Shadow Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'fixed-menu-shadow-opacity' => array(
						'title' => esc_html__('Fixed Menu Shadow Opacity', 'infinite'),
						'type' => 'text',
						'default' => '0.15',
					),
					'fixed-menu-shadow-color' => array(
						'title' => esc_html__('Fixed Menu Shadow Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector-extra' => true,
						'selector' => '.infinite-fixed-navigation.infinite-style-fixed, .infinite-fixed-navigation.infinite-style-slide{ ' . 
							'box-shadow: 0px 0px <fixed-menu-shadow-size>t rgba(#gdlra#, <fixed-menu-shadow-opacity>t); ' .
							'-webkit-box-shadow: 0px 0px <fixed-menu-shadow-size>t rgba(#gdlra#, <fixed-menu-shadow-opacity>t); ' .
							'-moz-box-shadow: 0px 0px <fixed-menu-shadow-size>t rgba(#gdlra#, <fixed-menu-shadow-opacity>t); }',
					),
					'side-menu-text-color' => array(
						'title' => esc_html__('Side Menu Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#979797',
						'selector'=> '.infinite-mm-menu-wrap.mm-menu a, .infinite-mm-menu-wrap.mm-menu a:active, ' . 
							'.infinite-mm-menu-wrap.mm-menu a:link, .infinite-mm-menu-wrap.mm-menu a:visited{ color: #gdlr#; }' . 
							'.mm-menu .mm-btn:after, .mm-menu .mm-btn:before{ border-color: #gdlr#; }'
					),
					'side-menu-text-hover-color' => array(
						'title' => esc_html__('Side Menu Text Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.infinite-mm-menu-wrap.mm-menu a:hover{ color: #gdlr#; }' . 
							'.mm-menu .mm-btn:hover:after, .mm-menu .mm-btn:hover:before{ border-color: #gdlr#; }'
					),
					'side-menu-background-color' => array(
						'title' => esc_html__('Side Menu Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#1f1f1f',
						'selector'=> '.infinite-mm-menu-wrap.mm-menu{ --mm-color-background: #gdlr#; }'
					),
					'side-menu-border-color' => array(
						'title' => esc_html__('Side Menu Border Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#626262',
						'selector'=> '.infinite-mm-menu-wrap .mm-listitem:after{ border-color: #gdlr#; }'
					),
					'overlay-menu-background-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Background Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000000',
						'selector'=> '.infinite-overlay-menu-content{ background-color: #gdlr#; background-color: rgba(#gdlra#, 0.88); }'  . 
							'.infinite-modern-menu-display{ background: #gdlr#; }'
					),
					'overlay-menu-border-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Border Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#424242',
						'selector'=> '.infinite-overlay-menu-content ul.menu > li, .infinite-overlay-menu-content ul.sub-menu ul.sub-menu{ border-color: #gdlr#; }' . 
							'.zyth-modern-menu-nav ul li a:after{ background: #gdlr#; }'
					),
					'overlay-menu-text-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.infinite-overlay-menu-content ul li a, .infinite-overlay-menu-content .infinite-overlay-menu-close{ color: #gdlr#; }' . 
							'.zyth-modern-menu-content .zyth-modern-menu-close, .zyth-modern-menu-nav-back, ' . 
							'.zyth-modern-menu-nav ul li a, .zyth-modern-menu-nav ul li a:hover, .zyth-modern-menu-nav ul li i{ color: #gdlr#; }'
					),
					'overlay-menu-text-hover-color' => array(
						'title' => esc_html__('Overlay/Modern Menu Text Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#a8a8a8',
						'selector'=> '.infinite-overlay-menu-content ul li a:hover{ color: #gdlr#; }'
					),
					'anchor-bullet-background-color' => array(
						'title' => esc_html__('Anchor Bullet Background', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#777777',
						'selector'=> '.infinite-bullet-anchor a:before{ background-color: #gdlr#; }'
					),
					'anchor-bullet-background-active-color' => array(
						'title' => esc_html__('Anchor Bullet Background Active', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.infinite-bullet-anchor a:hover, .infinite-bullet-anchor a.current-menu-item{ border-color: #gdlr#; }' .
							'.infinite-bullet-anchor a:hover:before, .infinite-bullet-anchor a.current-menu-item:before{ background: #gdlr#; }'
					),		
				) // navigation-menu-options
			);	

		}
	}

	if( !function_exists('infinite_navigation_right_color_options') ){
		function infinite_navigation_right_color_options(){

			return array(
				'title' => esc_html__('Navigation Right', 'infinite'),
				'options' => array(

					'navigation-bar-right-icon-color' => array(
						'title' => esc_html__('Navigation Bar Right Icon Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#383838',
						'selector'=> '.infinite-main-menu-search i, .infinite-main-menu-cart i{ color: #gdlr#; }'
					),
					'woocommerce-cart-icon-number-background' => array(
						'title' => esc_html__('Woocommmerce Cart\'s Icon Number Background', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#bd584e',
						'selector'=> '.infinite-main-menu-cart > .infinite-top-cart-count{ background-color: #gdlr#; }'
					),
					'woocommerce-cart-icon-number-color' => array(
						'title' => esc_html__('Woocommmerce Cart\'s Icon Number Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#ffffff',
						'selector'=> '.infinite-main-menu-cart > .infinite-top-cart-count{ color: #gdlr#; }'
					),
					'navigation-right-button-text-color' => array(
						'title' => esc_html__('Navigation Right Button Text Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector'=> '.infinite-body .infinite-main-menu-right-button{ color: #gdlr#; }'
					),
					'navigation-right-button-text-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Text Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#555555',
						'selector'=> '.infinite-body .infinite-main-menu-right-button:hover{ color: #gdlr#; }'
					),
					'navigation-right-button-background-color' => array(
						'title' => esc_html__('Navigation Right Button Background Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '',
						'selector'=> '.infinite-body .infinite-main-menu-right-button{ background-color: #gdlr#; }'
					),
					'navigation-right-button-background-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Background Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '',
						'selector'=> '.infinite-body .infinite-main-menu-right-button:hover{ background-color: #gdlr#; }'
					),
					'navigation-right-button-border-color' => array(
						'title' => esc_html__('Navigation Right Button Border Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#333333',
						'selector'=> '.infinite-body .infinite-main-menu-right-button{ border-color: #gdlr#; }'
					),
					'navigation-right-button-border-hover-color' => array(
						'title' => esc_html__('Navigation Right Button Border Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'default' => '#555555',
						'selector'=> '.infinite-body .infinite-main-menu-right-button:hover{ border-color: #gdlr#; }'
					),
					'navigation-right-button2-text-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Text Color', 'infinite'),
						'type' => 'colorpicker',
						'selector'=> '.infinite-body .infinite-main-menu-right-button.infinite-button-2{ color: #gdlr#; }'
					),
					'navigation-right-button2-text-hover-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Text Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'selector'=> '.infinite-body .infinite-main-menu-right-button.infinite-button-2:hover{ color: #gdlr#; }'
					),
					'navigation-right-button2-background-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Background Color', 'infinite'),
						'type' => 'colorpicker',
						'selector'=> '.infinite-body .infinite-main-menu-right-button.infinite-button-2{ background-color: #gdlr#; }'
					),
					'navigation-right-button2-background-hover-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Background Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'selector'=> '.infinite-body .infinite-main-menu-right-button.infinite-button-2:hover{ background-color: #gdlr#; }'
					),
					'navigation-right-button2-border-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Border Color', 'infinite'),
						'type' => 'colorpicker',
						'selector'=> '.infinite-body .infinite-main-menu-right-button.infinite-button-2{ border-color: #gdlr#; }'
					),
					'navigation-right-button2-border-hover-color' => array(
						'title' => esc_html__('Navigation Right Button 2 Border Hover Color', 'infinite'),
						'type' => 'colorpicker',
						'selector'=> '.infinite-body .infinite-main-menu-right-button.infinite-button-2:hover{ border-color: #gdlr#; }'
					),
					'navigation-right-button-shadow-color' => array(
						'title' => esc_html__('Main Navigation Right Button Shadow Color', 'infinite'),
						'type' => 'colorpicker',
						'data-type' => 'rgba',
						'default' => '#000',
						'selector' => '.infinite-main-menu-right-button.infinite-style-round-with-shadow{ box-shadow: 0px 4px 18px rgba(#gdlra#, 0.11); -webkit-box-shadow: 0px 4px 18px rgba(#gdlra#, 0.11); } '
					),

				)
			);

		}
	}