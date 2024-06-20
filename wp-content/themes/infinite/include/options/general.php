<?php
	/*	
	*	Goodlayers Option
	*	---------------------------------------------------------------------
	*	This file store an array of theme options
	*	---------------------------------------------------------------------
	*/	

	// add custom css for theme option
	add_filter('gdlr_core_theme_option_top_file_write', 'infinite_gdlr_core_theme_option_top_file_write', 10, 2);
	if( !function_exists('infinite_gdlr_core_theme_option_top_file_write') ){
		function infinite_gdlr_core_theme_option_top_file_write( $css, $option_slug ){
			if( $option_slug != 'goodlayers_main_menu' ) return;

			ob_start();
?>
.infinite-body h1, .infinite-body h2, .infinite-body h3, .infinite-body h4, .infinite-body h5, .infinite-body h6{ margin-top: 0px; margin-bottom: 20px; line-height: 1.2; font-weight: 700; }
#poststuff .gdlr-core-page-builder-body h2{ padding: 0px; margin-bottom: 20px; line-height: 1.2; font-weight: 700; }
#poststuff .gdlr-core-page-builder-body h1{ padding: 0px; font-weight: 700; }

.gdlr-core-flexslider.gdlr-core-bullet-style-cylinder .flex-control-nav li a{ width: 27px; height: 7px; }
.gdlr-core-newsletter-item.gdlr-core-style-rectangle .gdlr-core-newsletter-email input[type="email"]{ line-height: 17px; padding: 30px 20px; height: 65px; }
.gdlr-core-newsletter-item.gdlr-core-style-rectangle .gdlr-core-newsletter-submit input[type="submit"]{ height: 65px; font-size: 13px; }
<?php
			$css .= ob_get_contents();
			ob_end_clean(); 

			return $css;
		}
	}
	add_filter('gdlr_core_theme_option_bottom_file_write', 'infinite_gdlr_core_theme_option_bottom_file_write', 10, 2);
	if( !function_exists('infinite_gdlr_core_theme_option_bottom_file_write') ){
		function infinite_gdlr_core_theme_option_bottom_file_write( $css, $option_slug ){
			if( $option_slug != 'goodlayers_main_menu' ) return;

			$general = get_option(INFINITE_SHORT_NAME . '_general');

			if( !empty($general['enable-fixed-navigation-slide-bar']) && $general['enable-fixed-navigation-slide-bar'] == 'disable' ){
				$css .= '.infinite-fixed-navigation .infinite-navigation .infinite-navigation-slide-bar{ display: none !important; }';
			}

			if( !empty($general['item-padding']) ){
				$margin = 2 * intval(str_replace('px', '', $general['item-padding']));
				if( !empty($margin) && is_numeric($margin) ){
					$css .= '.infinite-item-mgb, .gdlr-core-item-mgb{ margin-bottom: ' . $margin . 'px; }';

					$margin -= 1;
					$css .= '.infinite-body .gdlr-core-testimonial-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .gdlr-core-feature-content-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .gdlr-core-personnel-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .gdlr-core-hover-box-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport,'; 
					$css .= '.infinite-body .gdlr-core-portfolio-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .gdlr-core-product-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .gdlr-core-product-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .gdlr-core-blog-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .gdlr-core-page-list-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport, '; 
					$css .= '.infinite-body .infinite-lp-course-list-item .gdlr-core-flexslider.gdlr-core-with-outer-frame-element .flex-viewport{ '; 
					$css .= 'padding-top: ' . $margin . 'px; margin-top: -' . $margin . 'px; padding-right: ' . $margin . 'px; margin-right: -' . $margin . 'px; ';
					$css .= 'padding-left: ' . $margin . 'px; margin-left: -' . $margin . 'px; padding-bottom: ' . $margin . 'px; margin-bottom: -' . $margin . 'px; ';
					$css .= '}';
				}
			}

			if( !empty($general['mobile-logo-position']) && $general['mobile-logo-position'] == 'logo-right' ){
				$css .= '.infinite-mobile-header .infinite-logo-inner{ margin-right: 0px; margin-left: 80px; float: right; }';	
				$css .= '.infinite-mobile-header .infinite-mobile-menu-right{ left: 30px; right: auto; }';	
				$css .= '.infinite-mobile-header .infinite-main-menu-search{ float: right; margin-left: 0px; margin-right: 25px; }';	
				$css .= '.infinite-mobile-header .infinite-mobile-menu{ float: right; margin-left: 0px; margin-right: 30px; }';	
				$css .= '.infinite-mobile-header .infinite-main-menu-cart{ float: right; margin-left: 0px; margin-right: 20px; padding-left: 0px; padding-right: 5px; }';	
				$css .= '.infinite-mobile-header .infinite-top-cart-content-wrap{ left: 0px; }';
			}

			return $css;
		}
	}

	$infinite_admin_option->add_element(array(
	
		// general head section
		'title' => esc_html__('General', 'infinite'),
		'slug' => INFINITE_SHORT_NAME . '_general',
		'icon' => get_template_directory_uri() . '/include/options/images/general.png',
		'options' => array(
		
			'layout' => array(
				'title' => esc_html__('Layout', 'infinite'),
				'options' => array(
					'custom-header' => array(
						'title' => esc_html__('Select Custom Header As Default Header', 'infinite'),
						'type' => 'combobox',
						'single' => 'gdlr_core_custom_header_id',
						'options' => array('' => esc_html__('None', 'infinite')) + gdlr_core_get_post_list('gdlr_core_header'),
						'description' => esc_html__('Any settings you set at the theme option will be ignored', 'infinite')
					),
					'layout' => array(
						'title' => esc_html__('Layout', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'full' => esc_html__('Full', 'infinite'),
							'boxed' => esc_html__('Boxed', 'infinite'),
						)
					),
					'boxed-layout-top-margin' => array(
						'title' => esc_html__('Box Layout Top/Bottom Margin', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '150',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => 'body.infinite-boxed .infinite-body-wrapper{ margin-top: #gdlr#; margin-bottom: #gdlr#; }',
						'condition' => array( 'layout' => 'boxed' ) 
					),
					'body-margin' => array(
						'title' => esc_html__('Body Margin ( Frame Spaces )', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.infinite-body-wrapper.infinite-with-frame, body.infinite-full .infinite-fixed-footer{ margin: #gdlr#; }',
						'condition' => array( 'layout' => 'full' ),
						'description' => esc_html__('This value will be automatically omitted for side header style.', 'infinite'),
					),
					'background-type' => array(
						'title' => esc_html__('Background Type', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'color' => esc_html__('Color', 'infinite'),
							'image' => esc_html__('Image', 'infinite'),
							'pattern' => esc_html__('Pattern', 'infinite'),
						),
						'condition' => array( 'layout' => 'boxed' )
					),
					'background-image' => array(
						'title' => esc_html__('Background Image', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file', 
						'selector' => '.infinite-body-background{ background-image: url(#gdlr#); }',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'image' )
					),
					'background-image-opacity' => array(
						'title' => esc_html__('Background Image Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '100',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'image' ),
						'selector' => '.infinite-body-background{ opacity: #gdlr#; }'
					),
					'background-pattern' => array(
						'title' => esc_html__('Background Type', 'infinite'),
						'type' => 'radioimage',
						'data-type' => 'text',
						'options' => 'pattern', 
						'selector' => '.infinite-background-pattern .infinite-body-outer-wrapper{ background-image: url(' . GDLR_CORE_URL . '/include/images/pattern/#gdlr#.png); }',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'pattern' ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'enable-boxed-border' => array(
						'title' => esc_html__('Enable Boxed Border', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable',
						'condition' => array( 'layout' => 'boxed', 'background-type' => 'pattern' ),
					),
					'item-padding' => array(
						'title' => esc_html__('Item Left/Right Spaces', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '40',
						'data-type' => 'pixel',
						'default' => '15px',
						'description' => 'Space between each page items',
						'selector' => '.infinite-item-pdlr, .gdlr-core-item-pdlr{ padding-left: #gdlr#; padding-right: #gdlr#; }' . 
							'.infinite-mobile-header .infinite-logo.infinite-item-pdlr{ padding-left: #gdlr#; }' .
							'.infinite-item-rvpdlr, .gdlr-core-item-rvpdlr{ margin-left: -#gdlr#; margin-right: -#gdlr#; }' .
							'.gdlr-core-metro-rvpdlr{ margin-top: -#gdlr#; margin-right: -#gdlr#; margin-bottom: -#gdlr#; margin-left: -#gdlr#; }' .
							'.infinite-item-mglr, .gdlr-core-item-mglr, .infinite-navigation .sf-menu > .infinite-mega-menu .sf-mega,' . 
							'.sf-menu.infinite-top-bar-menu > .infinite-mega-menu .sf-mega{ margin-left: #gdlr#; margin-right: #gdlr#; }' .
							'.gdlr-core-pbf-wrapper-container-inner{ width: calc(100% - #gdlr# - #gdlr#); }'
					
					),
					'container-width' => array(
						'title' => esc_html__('Container Width', 'infinite'),
						'type' => 'text',
						'data-type' => 'pixel',
						'data-input-type' => 'pixel',
						'default' => '1180px',
						'selector' => '.infinite-container, .gdlr-core-container, body.infinite-boxed .infinite-body-wrapper, ' . 
							'body.infinite-boxed .infinite-fixed-footer .infinite-footer-wrapper, body.infinite-boxed .infinite-fixed-footer .infinite-copyright-wrapper{ max-width: #gdlr#; }' 
					),
					'container-padding' => array(
						'title' => esc_html__('Container Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '15px',
						'selector' => '.infinite-body-front .gdlr-core-container, .infinite-body-front .infinite-container{ padding-left: #gdlr#; padding-right: #gdlr#; }'  . 
							'.infinite-body-front .infinite-container .infinite-container, .infinite-body-front .infinite-container .gdlr-core-container, '.
							'.infinite-body-front .gdlr-core-container .gdlr-core-container{ padding-left: 0px; padding-right: 0px; }' .
							'.infinite-navigation-header-style-bar.infinite-style-2 .infinite-navigation-background{ left: #gdlr#; right: #gdlr#; }'
					),
					'sidebar-block-style' => array(
						'title' => esc_html__('Sidebar Block Style', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable',
						'description' => esc_html__('Enable block style on all sidebar widget except "goodlayers plain text" widget.', 'infinite')
					),
					'sidebar-title-divider' => array(
						'title' => esc_html__('Sidebar Title Divider', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'sidebar-heading-tag' => array(
						'title' => esc_html__('Sidebar Heading Tag', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'h1' => esc_html__('H1', 'infinite'),
							'h2' => esc_html__('H2', 'infinite'),
							'h3' => esc_html__('H3', 'infinite'),
							'h4' => esc_html__('H4', 'infinite'),
							'h5' => esc_html__('H5', 'infinite'),
							'h6' => esc_html__('H6', 'infinite'),
						),
						'default' => 'h3'
					),
					'sidebar-width' => array(
						'title' => esc_html__('Sidebar Width', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'30' => '50%', '20' => '33.33%', '15' => '25%', '12' => '20%', '10' => '16.67%'
						),
						'default' => 20,
					),
					'both-sidebar-width' => array(
						'title' => esc_html__('Both Sidebar Width', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'30' => '50%', '20' => '33.33%', '15' => '25%', '12' => '20%', '10' => '16.67%'
						),
						'default' => 15,
					),
					
				) // header-options
			), // header-nav	
			
			'top-bar' => infinite_top_bar_options(),

			'top-bar-social' => infinite_top_bar_social_options(),			

			'header' => infinite_header_options(),
			
			'logo' => infinite_logo_options(),

			'navigation' => infinite_navigation_options(), 
			
			'fixed-navigation' => infinite_fixed_navigation_options(),

			'float-social' => array(
				'title' => esc_html__('Float Social', 'infinite'),
				'options' => array(
					'enable-float-social' => array(
						'title' => esc_html__('Enable Float Social', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'display-float-social-after-page-title' => array(
						'title' => esc_html__('Display Float Social After Page Title', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'float-social-delicious' => array(
						'title' => esc_html__('Float Social Delicious Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-email' => array(
						'title' => esc_html__('Float Social Email Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-deviantart' => array(
						'title' => esc_html__('Float Social Deviantart Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-digg' => array(
						'title' => esc_html__('Float Social Digg Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-facebook' => array(
						'title' => esc_html__('Float Social Facebook Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-flickr' => array(
						'title' => esc_html__('Float Social Flickr Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-lastfm' => array(
						'title' => esc_html__('Float Social Lastfm Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-linkedin' => array(
						'title' => esc_html__('Float Social Linkedin Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-pinterest' => array(
						'title' => esc_html__('Float Social Pinterest Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-rss' => array(
						'title' => esc_html__('Float Social RSS Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-skype' => array(
						'title' => esc_html__('Float Social Skype Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-stumbleupon' => array(
						'title' => esc_html__('Float Social Stumbleupon Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-tumblr' => array(
						'title' => esc_html__('Float Social Tumblr Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-twitter' => array(
						'title' => esc_html__('Float Social Twitter Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-vimeo' => array(
						'title' => esc_html__('Float Social Vimeo Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-youtube' => array(
						'title' => esc_html__('Float Social Youtube Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-instagram' => array(
						'title' => esc_html__('Float Social Instagram Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-snapchat' => array(
						'title' => esc_html__('Float Social Snapchat Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
					'float-social-whatsapp' => array(
						'title' => esc_html__('Float Social Whatsapp Link', 'infinite'),
						'type' => 'text',
						'condition' => array( 'enable-float-social' => 'enable' )
					),
				)
			),

			'title-style' => array(
				'title' => esc_html__('Page Title Style', 'infinite'),
				'options' => array(

					'default-title-side-margin' => array(
						'title' => esc_html__('Default Title Left/Right Margin', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-page-title-wrap{ margin-left: #gdlr#; margin-right: #gdlr#; }'
					),
					'default-title-background-radius' => array(
						'title' => esc_html__('Default Title Background Top Radius', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.infinite-page-title-wrap{ border-radius: #gdlr#; -webkit-border-radius: #gdlr#; -moz-border-radius: #gdlr#; }'
					),
					'default-title-background-bottom-radius' => array(
						'title' => esc_html__('Default Title Background Bottom Radius', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector-extra' => true,
						'selector' => '.infinite-page-title-wrap{ border-radius: <default-title-background-radius> <default-title-background-radius> #gdlr# #gdlr#; -webkit-border-radius: <default-title-background-radius> <default-title-background-radius> #gdlr# #gdlr#; -moz-border-radius: <default-title-background-radius> <default-title-background-radius> #gdlr# #gdlr#; }'
					),
					'default-title-style' => array(
						'title' => esc_html__('Default Page Title Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'infinite'),
							'medium' => esc_html__('Medium', 'infinite'),
							'large' => esc_html__('Large', 'infinite'),
							'custom' => esc_html__('Custom', 'infinite'),
						),
						'default' => 'small'
					),
					'default-title-align' => array(
						'title' => esc_html__('Default Page Title Alignment', 'infinite'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left'
					),
					'default-title-top-padding' => array(
						'title' => esc_html__('Default Page Title Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '350',
						'default' => '93px',
						'selector' => '.infinite-page-title-wrap.infinite-style-custom .infinite-page-title-content{ padding-top: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-bottom-padding' => array(
						'title' => esc_html__('Default Page Title Bottom Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '350',
						'default' => '87px',
						'selector' => '.infinite-page-title-wrap.infinite-style-custom .infinite-page-title-content{ padding-bottom: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-page-caption-top-margin' => array(
						'title' => esc_html__('Default Page Caption Top Margin', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '200',
						'default' => '13px',						
						'selector' => '.infinite-page-title-wrap.infinite-style-custom .infinite-page-caption{ margin-top: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-font-transform' => array(
						'title' => esc_html__('Default Page Title Font Transform', 'infinite'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'infinite'),
							'none' => esc_html__('None', 'infinite'),
							'uppercase' => esc_html__('Uppercase', 'infinite'),
							'lowercase' => esc_html__('Lowercase', 'infinite'),
							'capitalize' => esc_html__('Capitalize', 'infinite'),
						),
						'default' => 'default',
						'selector' => '.infinite-page-title-wrap .infinite-page-title{ text-transform: #gdlr#; }'
					),
					'default-title-font-size' => array(
						'title' => esc_html__('Default Page Title Font Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '37px',
						'selector' => '.infinite-page-title-wrap.infinite-style-custom .infinite-page-title{ font-size: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-title-font-weight' => array(
						'title' => esc_html__('Default Page Title Font Weight', 'infinite'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.infinite-page-title-wrap .infinite-page-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (700).', 'infinite')					
					),
					'default-title-letter-spacing' => array(
						'title' => esc_html__('Default Page Title Letter Spacing', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '20',
						'default' => '0px',
						'selector' => '.infinite-page-title-wrap.infinite-style-custom .infinite-page-title{ letter-spacing: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-caption-font-transform' => array(
						'title' => esc_html__('Default Page Caption Font Transform', 'infinite'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'infinite'),
							'none' => esc_html__('None', 'infinite'),
							'uppercase' => esc_html__('Uppercase', 'infinite'),
							'lowercase' => esc_html__('Lowercase', 'infinite'),
							'capitalize' => esc_html__('Capitalize', 'infinite'),
						),
						'default' => 'default',
						'selector' => '.infinite-page-title-wrap .infinite-page-caption{ text-transform: #gdlr#; }'
					),
					'default-caption-font-size' => array(
						'title' => esc_html__('Default Page Caption Font Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '16px',
						'selector' => '.infinite-page-title-wrap.infinite-style-custom .infinite-page-caption{ font-size: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'default-caption-font-weight' => array(
						'title' => esc_html__('Default Page Caption Font Weight', 'infinite'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.infinite-page-title-wrap .infinite-page-caption{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (400).', 'infinite')					
					),
					'default-caption-letter-spacing' => array(
						'title' => esc_html__('Default Page Caption Letter Spacing', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '20',
						'default' => '0px',
						'selector' => '.infinite-page-title-wrap.infinite-style-custom .infinite-page-caption{ letter-spacing: #gdlr#; }',
						'condition' => array( 'default-title-style' => 'custom' )
					),
					'page-title-top-bottom-gradient' => array(
						'title' => esc_html__('Default Page Title Top/Bottom Gradient', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'both' => esc_html__('Both', 'infinite'),
							'top' => esc_html__('Top', 'infinite'),
							'bottom' => esc_html__('Bottom', 'infinite'),
							'none' => esc_html__('None', 'infinite'),
						),
						'default' => 'none',
					),
					'page-title-top-gradient-size' => array(
						'title' => esc_html__('Default Page Title Top Gradient Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.infinite-page-title-wrap .infinite-page-title-top-gradient{ height: #gdlr#; }',
					),
					'page-title-bottom-gradient-size' => array(
						'title' => esc_html__('Default Page Title Bottom Gradient Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.infinite-page-title-wrap .infinite-page-title-bottom-gradient{ height: #gdlr#; }',
					),
					'default-title-background-overlay-opacity' => array(
						'title' => esc_html__('Default Page Title Background Overlay Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '80',
						'selector' => '.infinite-page-title-wrap .infinite-page-title-overlay{ opacity: #gdlr#; }'
					),
				) 
			), // title style

			'title-background' => array(
				'title' => esc_html__('Page Title Background', 'infinite'),
				'options' => array(

					'default-title-background' => array(
						'title' => esc_html__('Default Page Title Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.infinite-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-portfolio-title-background' => array(
						'title' => esc_html__('Default Portfolio Title Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-portfolio .infinite-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-personnel-title-background' => array(
						'title' => esc_html__('Default Personnel Title Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-personnel .infinite-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-search-title-background' => array(
						'title' => esc_html__('Default Search Title Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.search .infinite-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-archive-title-background' => array(
						'title' => esc_html__('Default Archive Title Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.archive .infinite-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-404-background' => array(
						'title' => esc_html__('Default 404 Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.infinite-not-found-wrap .infinite-not-found-background{ background-image: url(#gdlr#); }'
					),
					'default-404-background-opacity' => array(
						'title' => esc_html__('Default 404 Background Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '27',
						'selector' => '.infinite-not-found-wrap .infinite-not-found-background{ opacity: #gdlr#; }'
					),

				) 
			), // title background

			'blog-title-style' => array(
				'title' => esc_html__('Blog Title Style', 'infinite'),
				'options' => array(

					'default-blog-title-side-margin' => array(
						'title' => esc_html__('Default Blog Title Left/Right Margin', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-blog-title-wrap{ margin-left: #gdlr#; margin-right: #gdlr#; }'
					),
					'blog-title-background-radius' => array(
						'title' => esc_html__('Default Blog Title Background Radius', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector' => '.infinite-blog-title-wrap{ border-radius: #gdlr#; -webkit-border-radius: #gdlr#; -moz-border-radius: #gdlr#; }'
					),
					'blog-title-background-bottom-radius' => array(
						'title' => esc_html__('Default Blog Title Background Bottom Radius', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '100',
						'data-type' => 'pixel',
						'default' => '0px',
						'selector-extra' => true,
						'selector' => '.infinite-blog-title-wrap{ border-radius: <blog-title-background-radius> <blog-title-background-radius> #gdlr# #gdlr#; -webkit-border-radius: <blog-title-background-radius> <blog-title-background-radius> #gdlr# #gdlr#; -moz-border-radius: <blog-title-background-radius> <blog-title-background-radius> #gdlr# #gdlr#; }'
					),
					'default-blog-title-style' => array(
						'title' => esc_html__('Default Blog Title Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'infinite'),
							'large' => esc_html__('Large', 'infinite'),
							'custom' => esc_html__('Custom', 'infinite'),
							'inside-content' => esc_html__('Inside Content', 'infinite'),
							'none' => esc_html__('None', 'infinite'),
						),
						'default' => 'small'
					),
					'default-blog-title-top-padding' => array(
						'title' => esc_html__('Default Blog Title Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '400',
						'default' => '93px',
						'selector' => '.infinite-blog-title-wrap.infinite-style-custom .infinite-blog-title-content{ padding-top: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => 'custom' )
					),
					'default-blog-title-bottom-padding' => array(
						'title' => esc_html__('Default Blog Title Bottom Padding', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '400',
						'default' => '87px',
						'selector' => '.infinite-blog-title-wrap.infinite-style-custom .infinite-blog-title-content{ padding-bottom: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => 'custom' )
					),
					'default-blog-feature-image' => array(
						'title' => esc_html__('Default Blog Feature Image Location', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'content' => esc_html__('Inside Content', 'infinite'),
							'title-background' => esc_html__('Title Background', 'infinite'),
							'none' => esc_html__('None', 'infinite'),
						),
						'default' => 'content',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),
					'default-blog-title-background-image' => array(
						'title' => esc_html__('Default Blog Title Background Image', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.infinite-blog-title-wrap{ background-image: url(#gdlr#); }',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),
					'default-blog-title-font-size' => array(
						'title' => esc_html__('Default Blog Title Font Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-blog-title-wrap .infinite-single-article-title, .infinite-single-article .infinite-single-article-title{ font-size: #gdlr#; }'
					),
					'default-blog-title-font-weight' => array(
						'title' => esc_html__('Default Blog Title Font Weight', 'infinite'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.infinite-blog-title-wrap .infinite-single-article-title, .infinite-single-article .infinite-single-article-title{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (700).', 'infinite')					
					),
					'default-blog-title-letter-spacing' => array(
						'title' => esc_html__('Default Blog Title Letter Spacing', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-blog-title-wrap .infinite-single-article-title, .infinite-single-article .infinite-single-article-title{ letter-spacing: #gdlr#; }',
					),
					'default-blog-title-text-transform' => array(
						'title' => esc_html__('Default Blog Title Text Transform', 'infinite'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'infinite'),
							'none' => esc_html__('None', 'infinite'),
							'uppercase' => esc_html__('Uppercase', 'infinite'),
							'lowercase' => esc_html__('Lowercase', 'infinite'),
							'capitalize' => esc_html__('Capitalize', 'infinite'),
						),
						'selector' => '.infinite-blog-title-wrap .infinite-single-article-title, .infinite-single-article .infinite-single-article-title{ text-transform: #gdlr#; }'
					),
					'default-blog-caption-font-size' => array(
						'title' => esc_html__('Default Blog Caption Font Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-blog-title-wrap .infinite-blog-info-wrapper .infinite-blog-info, .infinite-single-article .infinite-blog-info-wrapper .infinite-blog-info{ font-size: #gdlr#; }'
					),
					'default-blog-caption-font-weight' => array(
						'title' => esc_html__('Default Blog Caption Font Weight', 'infinite'),
						'type' => 'text',
						'data-type' => 'text',
						'selector' => '.infinite-blog-title-wrap .infinite-blog-info-wrapper .infinite-blog-info, .infinite-single-article .infinite-blog-info-wrapper .infinite-blog-info{ font-weight: #gdlr#; }',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800. Leave this field blank for default value (700).', 'infinite')					
					),
					'default-blog-caption-letter-spacing' => array(
						'title' => esc_html__('Default Blog Caption Letter Spacing', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
						'data-type' => 'pixel',
						'selector' => '.infinite-blog-title-wrap .infinite-blog-info-wrapper .infinite-blog-info, .infinite-single-article .infinite-blog-info-wrapper .infinite-blog-info{ letter-spacing: #gdlr#; }',
					),
					'default-blog-caption-text-transform' => array(
						'title' => esc_html__('Default Blog Caption Text Transform', 'infinite'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'' => esc_html__('Default', 'infinite'),
							'none' => esc_html__('None', 'infinite'),
							'uppercase' => esc_html__('Uppercase', 'infinite'),
							'lowercase' => esc_html__('Lowercase', 'infinite'),
							'capitalize' => esc_html__('Capitalize', 'infinite'),
						),
						'selector' => '.infinite-blog-title-wrap .infinite-blog-info-wrapper .infinite-blog-info, .infinite-single-article .infinite-blog-info-wrapper .infinite-blog-info{ text-transform: #gdlr#; }'
					),
					'default-blog-top-bottom-gradient' => array(
						'title' => esc_html__('Default Blog ( Feature Image ) Title Top/Bottom Gradient', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'enable' => esc_html__('Both', 'infinite'),
							'top' => esc_html__('Top', 'infinite'),
							'bottom' => esc_html__('Bottom', 'infinite'),
							'disable' => esc_html__('None', 'infinite'),
						),
						'default' => 'enable',
					),
					'single-blog-title-top-gradient-size' => array(
						'title' => esc_html__('Single Blog Title Top Gradient Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.infinite-blog-title-wrap.infinite-feature-image .infinite-blog-title-top-overlay{ height: #gdlr#; }',
					),
					'single-blog-title-bottom-gradient-size' => array(
						'title' => esc_html__('Single Blog Title Bottom Gradient Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'data-min' => '0',
						'data-max' => '1000',
 						'default' => '413px',
						'selector' => '.infinite-blog-title-wrap.infinite-feature-image .infinite-blog-title-bottom-overlay{ height: #gdlr#; }',
					),
					'default-blog-title-background-overlay-opacity' => array(
						'title' => esc_html__('Default Blog Title Background Overlay Opacity', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'opacity',
						'default' => '80',
						'selector' => '.infinite-blog-title-wrap .infinite-blog-title-overlay{ opacity: #gdlr#; }',
						'condition' => array( 'default-blog-title-style' => array('small', 'large', 'custom') )
					),

				) 
			), // post title style			

			'blog-style' => array(
				'title' => esc_html__('Blog Style', 'infinite'),
				'options' => array(
					'blog-style' => array(
						'title' => esc_html__('Single Blog Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
							'style-3' => esc_html__('Style 3', 'infinite'),
							'style-4' => esc_html__('Style 4', 'infinite'),
							'style-5' => esc_html__('Style 5', 'infinite'),
							'magazine' => esc_html__('Magazine', 'infinite')
						),
						'default' => 'style-1'
					),
					'blog-title-style' => array(
						'title' => esc_html__('Single Blog Title Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'' => esc_html__('Default', 'infinite'),
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
							'style-4' => esc_html__('Style 4', 'infinite')
						)
					),
					'blog-date-feature' => array(
						'title' => esc_html__('Enable Blog Date Feature', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'blog-title-style' => 'style-1' )
					),
					'blog-date-feature-year' => array(
						'title' => esc_html__('Enable Year on Blog Date Feature', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable',
						'condition' => array( 'blog-title-style' => 'style-1', 'blog-date-feature' => 'enable' )
					),
					'blockquote-style' => array(
						'title' => esc_html__('Blockquote Style ( <blockquote> tag )', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
							'style-3' => esc_html__('Style 3', 'infinite')
						),
						'default' => 'style-1'
					),
					'blockquote-background' => array(
						'title' => esc_html__('Blockquote Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.infinite-blockquote-background-style blockquote{ background-image: url(#gdlr#); }',
						'condition' => array( 'blockquote-style' => 'background-style' )
					),
					'blog-sidebar' => array(
						'title' => esc_html__('Single Blog Sidebar ( Default )', 'infinite'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'blog-sidebar-left' => array(
						'title' => esc_html__('Single Blog Sidebar Left ( Default )', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'blog-sidebar'=>array('left', 'both') )
					),
					'blog-sidebar-right' => array(
						'title' => esc_html__('Single Blog Sidebar Right ( Default )', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'blog-sidebar'=>array('right', 'both') )
					),
					'blog-max-content-width' => array(
						'title' => esc_html__('Single Blog Max Content Width ( No sidebar layout )', 'infinite'),
						'type' => 'text',
						'data-type' => 'text',
						'data-input-type' => 'pixel',
						'default' => '900px',
						'selector' => 'body.single-post .infinite-sidebar-style-none, body.blog .infinite-sidebar-style-none, ' . 
							'.infinite-blog-style-2 .infinite-comment-content{ max-width: #gdlr#; }'
					),
					'blog-thumbnail-size' => array(
						'title' => esc_html__('Single Blog Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
					'meta-option' => array(
						'title' => esc_html__('Meta Option', 'infinite'),
						'type' => 'multi-combobox',
						'options' => array( 
							'date' => esc_html__('Date', 'infinite'),
							'author' => esc_html__('Author', 'infinite'),
							'category' => esc_html__('Category', 'infinite'),
							'tag' => esc_html__('Tag', 'infinite'),
							'comment' => esc_html__('Comment', 'infinite'),
							'comment-number' => esc_html__('Comment Number', 'infinite'),
						),
						'default' => array('author', 'category', 'tag', 'comment-number')
					),
					'blog-author' => array(
						'title' => esc_html__('Enable Single Blog Author', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-navigation' => array(
						'title' => esc_html__('Enable Single Blog Navigation', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'pagination-style' => array(
						'title' => esc_html__('Pagination Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'plain' => esc_html__('Plain', 'infinite'),
							'rectangle' => esc_html__('Rectangle', 'infinite'),
							'rectangle-border' => esc_html__('Rectangle Border', 'infinite'),
							'round' => esc_html__('Round', 'infinite'),
							'round-border' => esc_html__('Round Border', 'infinite'),
							'circle' => esc_html__('Circle', 'infinite'),
							'circle-border' => esc_html__('Circle Border', 'infinite'),
						),
						'default' => 'round'
					),
					'pagination-align' => array(
						'title' => esc_html__('Pagination Alignment', 'infinite'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'right'
					),
					'enable-related-post' => array(
						'title' => esc_html__('Enable Related Post', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
					),
					'related-post-blog-style' => array(
						'title' => esc_html__('Related Post Blog Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'blog-column' => esc_html__('Blog Column', 'infinite'), 
							'blog-column-with-frame' => esc_html__('Blog Column With Frame', 'infinite'), 
						),
						'default' => 'blog-column-with-frame',
					),
					'related-post-blog-column-style' => array(
						'title' => esc_html__('Related Post Blog Column Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'), 
							'style-2' => esc_html__('Style 2', 'infinite'), 
							'style-3' => esc_html__('Style 3', 'infinite'), 
						),
						'default' => 'blog-column-with-frame',
					),
					'related-post-column-size' => array(
						'title' => esc_html__('Related Post Column Size', 'infinite'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
						'default' => '20',
					),
					'related-post-meta-option' => array(
						'title' => esc_html__('Related Post Meta Option', 'infinite'),
						'type' => 'multi-combobox',
						'options' => array(
							'date' => esc_html__('Date', 'infinite'),
							'author' => esc_html__('Author', 'infinite'),
							'category' => esc_html__('Category', 'infinite'),
							'tag' => esc_html__('Tag', 'infinite'),
							'comment' => esc_html__('Comment', 'infinite'),
							'comment-number' => esc_html__('Comment Number', 'infinite'),
						),
						'default' => array('date', 'author', 'category', 'comment-number'),
					),
					'related-post-thumbnail-size' => array(
						'title' => esc_html__('Related Post Blog Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full',
					),
					'related-post-num-fetch' => array(
						'title' => esc_html__('Related Post Num Fetch', 'infinite'),
						'type' => 'text',
						'default' => '3',
					),
					'related-post-excerpt-number' => array(
						'title' => esc_html__('Related Post Excerpt Number', 'infinite'),
						'type' => 'text',
						'default' => '0',
					),
				) // blog-style-options
			), // blog-style-nav

			'blog-social-share' => array(
				'title' => esc_html__('Blog Social Share', 'infinite'),
				'options' => array(
					'blog-social-share' => array(
						'title' => esc_html__('Enable Single Blog Share', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-social-share-count' => array(
						'title' => esc_html__('Enable Single Blog Share Count', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-social-facebook' => array(
						'title' => esc_html__('Facebook', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'blog-facebook-access-token' => array(
						'title' => esc_html__('Facebook Access Token', 'infinite'),
						'type' => 'text',
					),	
					'blog-social-linkedin' => array(
						'title' => esc_html__('Linkedin', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),			
					'blog-social-pinterest' => array(
						'title' => esc_html__('Pinterest', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-stumbleupon' => array(
						'title' => esc_html__('Stumbleupon', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),			
					'blog-social-twitter' => array(
						'title' => esc_html__('Twitter', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),			
					'blog-social-email' => array(
						'title' => esc_html__('Email', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
				) // blog-style-options
			), // blog-style-nav
			
			'event' => array(
				'title' => esc_html__('Event', 'infinite'),
				'options' => array(
					'default-event-title-background' => array(
						'title' => esc_html__('Default Event Title Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => 'body.single-event .infinite-page-title-wrap{ background-image: url(#gdlr#); }'
					),
					'default-event-sidebar' => array(
						'title' => esc_html__('Default Event Sidebar', 'infinite'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'default-event-sidebar-left' => array(
						'title' => esc_html__('Default Event Sidebar Left', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'default-event-sidebar'=>array('left', 'both') )
					),
					'default-event-sidebar-right' => array(
						'title' => esc_html__('Default Event Sidebar Right', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'default-event-sidebar'=>array('right', 'both') )
					),
				)
			),
			
			'search-archive' => array(
				'title' => esc_html__('Search/Archive', 'infinite'),
				'options' => array(
					'archive-blog-sidebar' => array(
						'title' => esc_html__('Archive Blog Sidebar', 'infinite'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'right',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-blog-sidebar-left' => array(
						'title' => esc_html__('Archive Blog Sidebar Left', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-blog-sidebar'=>array('left', 'both') )
					),
					'archive-blog-sidebar-right' => array(
						'title' => esc_html__('Archive Blog Sidebar Right', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-blog-sidebar'=>array('right', 'both') )
					),
					'archive-blog-style' => array(
						'title' => esc_html__('Archive Blog Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'blog-full' => GDLR_CORE_URL . '/include/images/blog-style/blog-full.png',
							'blog-full-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-full-with-frame.png',
							'blog-column' => GDLR_CORE_URL . '/include/images/blog-style/blog-column.png',
							'blog-column-with-frame' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-with-frame.png',
							'blog-column-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-column-no-space.png',
							'blog-image' => GDLR_CORE_URL . '/include/images/blog-style/blog-image.png',
							'blog-image-no-space' => GDLR_CORE_URL . '/include/images/blog-style/blog-image-no-space.png',
							'blog-left-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-left-thumbnail.png',
							'blog-right-thumbnail' => GDLR_CORE_URL . '/include/images/blog-style/blog-right-thumbnail.png',
						),
						'default' => 'blog-full',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-blog-full-style' => array(
						'title' => esc_html__('Blog Full Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-full', 'blog-full-with-frame') )
					),
					'archive-blog-side-thumbnail-style' => array(
						'title' => esc_html__('Blog Side Thumbnail Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-1-large' => esc_html__('Style 1 Large Thumbnail', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
							'style-2-large' => esc_html__('Style 2 Large Thumbnail', 'infinite'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-blog-column-style' => array(
						'title' => esc_html__('Blog Column Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-column', 'blog-column-with-frame', 'blog-column-no-space') )
					),
					'archive-blog-image-style' => array(
						'title' => esc_html__('Blog Image Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
						),
						'condition' => array( 'archive-blog-style'=>array('blog-image', 'blog-image-no-space') )
					),
					'archive-blog-full-alignment' => array(
						'title' => esc_html__('Archive Blog Full Alignment', 'infinite'),
						'type' => 'combobox',
						'default' => 'enable',
						'options' => array(
							'left' => esc_html__('Left', 'infinite'),
							'center' => esc_html__('Center', 'infinite'),
						),
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame') )
					),
					'archive-thumbnail-size' => array(
						'title' => esc_html__('Archive Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => 'thumbnail-size'
					),
					'archive-show-thumbnail' => array(
						'title' => esc_html__('Archive Show Thumbnail', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-column-size' => array(
						'title' => esc_html__('Archive Column Size', 'infinite'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5 ),
						'default' => 20,
						'condition' => array( 'archive-blog-style' => array('blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-image', 'blog-image-no-space') )
					),
					'archive-excerpt' => array(
						'title' => esc_html__('Archive Excerpt Type', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'specify-number' => esc_html__('Specify Number', 'infinite'),
							'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'infinite'),
						),
						'default' => 'specify-number',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail'))
					),
					'archive-excerpt-number' => array(
						'title' => esc_html__('Archive Excerpt Number', 'infinite'),
						'type' => 'text',
						'default' => 55,
						'data-input-type' => 'number',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-column', 'blog-column-with-frame', 'blog-column-no-space', 'blog-left-thumbnail', 'blog-right-thumbnail'), 'archive-excerpt' => 'specify-number')
					),
					'archive-date-feature' => array(
						'title' => esc_html__('Enable Blog Date Feature', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail') )
					),
					'archive-meta-option' => array(
						'title' => esc_html__('Archive Meta Option', 'infinite'),
						'type' => 'multi-combobox',
						'options' => array( 
							'date' => esc_html__('Date', 'infinite'),
							'author' => esc_html__('Author', 'infinite'),
							'category' => esc_html__('Category', 'infinite'),
							'tag' => esc_html__('Tag', 'infinite'),
							'comment' => esc_html__('Comment', 'infinite'),
							'comment-number' => esc_html__('Comment Number', 'infinite'),
						),
						'default' => array('date', 'author', 'category')
					),
					'archive-show-read-more' => array(
						'title' => esc_html__('Archive Show Read More Button', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array('archive-blog-style' => array('blog-full', 'blog-full-with-frame', 'blog-left-thumbnail', 'blog-right-thumbnail'),)
					),
					'archive-blog-title-font-size' => array(
						'title' => esc_html__('Blog Title Font Size', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'archive-blog-title-font-weight' => array(
						'title' => esc_html__('Blog Title Font Weight', 'infinite'),
						'type' => 'text',
						'description' => esc_html__('Eg. lighter, bold, normal, 300, 400, 600, 700, 800', 'infinite')
					),
					'archive-blog-title-letter-spacing' => array(
						'title' => esc_html__('Blog Title Letter Spacing', 'infinite'),
						'type' => 'text',
						'data-input-type' => 'pixel',
					),
					'archive-blog-title-text-transform' => array(
						'title' => esc_html__('Blog Title Text Transform', 'infinite'),
						'type' => 'combobox',
						'data-type' => 'text',
						'options' => array(
							'none' => esc_html__('None', 'infinite'),
							'uppercase' => esc_html__('Uppercase', 'infinite'),
							'lowercase' => esc_html__('Lowercase', 'infinite'),
							'capitalize' => esc_html__('Capitalize', 'infinite'),
						),
						'default' => 'none'
					),
				)
			),

			'woocommerce-style' => array(
				'title' => esc_html__('Woocommerce Style', 'infinite'),
				'options' => array(

					'woocommerce-single-product-style' => array(
						'title' => esc_html__('Woocommerce Single Product Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'style-1' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite')
						)
					),
					'woocommerce-archive-sidebar' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar', 'infinite'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'right',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'woocommerce-archive-sidebar-left' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar Left', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'woocommerce-archive-sidebar'=>array('left', 'both') )
					),
					'woocommerce-archive-sidebar-right' => array(
						'title' => esc_html__('Woocommerce Archive Sidebar Right', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'woocommerce-archive-sidebar'=>array('right', 'both') )
					),
					'woocommerce-archive-product-style' => array(
						'title' => esc_html__('Woocommerce Archive Product Style', 'infinite'),
						'type' => 'combobox',
						'options' => array( 
							'grid' => esc_html__('Grid', 'infinite'),
							'grid-2' => esc_html__('Grid 2', 'infinite'),
							'grid-3' => esc_html__('Grid 3', 'infinite'),
							'grid-3-with-border' => esc_html__('Grid 3 With Border', 'goodlayers-core'),
							'grid-3-without-frame' => esc_html__('Grid 3 Without Frame', 'goodlayers-core'),
							'grid-4' => esc_html__('Grid 4', 'infinite'),
							'grid-5' => esc_html__('Grid 5', 'infinite'),
							'grid-6' => esc_html__('Grid 6', 'infinite'),
							'box' => esc_html__('Box', 'goodlayers-core')
						),
						'default' => 'grid'
					),
					'woocommerce-archive-product-amount' => array(
						'title' => esc_html__('Woocommerce Archive Product Amount', 'infinite'),
						'type' => 'text',
					),
					'woocommerce-archive-column-size' => array(
						'title' => esc_html__('Woocommerce Archive Column Size', 'infinite'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15
					),
					'woocommerce-archive-thumbnail' => array(
						'title' => esc_html__('Woocommerce Archive Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
					'woocommerce-related-product-style' => array(
						'title' => esc_html__('Woocommerce Related Product Style', 'infinite'),
						'type' => 'combobox',
						'options' => array( 
							'grid' => esc_html__('Grid', 'infinite'),
							'grid-2' => esc_html__('Grid 2', 'infinite'),
							'grid-3' => esc_html__('Grid 3', 'infinite'),
							'grid-3-with-border' => esc_html__('Grid 3 With Border', 'goodlayers-core'),
							'grid-3-without-frame' => esc_html__('Grid 3 Without Frame', 'goodlayers-core'),
							'grid-4' => esc_html__('Grid 4', 'infinite'),
							'grid-5' => esc_html__('Grid 5', 'infinite'),
							'grid-6' => esc_html__('Grid 6', 'infinite'),
							'box' => esc_html__('Box', 'goodlayers-core')
						),
						'default' => 'grid'
					),
					'woocommerce-related-product-column-size' => array(
						'title' => esc_html__('Woocommerce Related Product Column Size', 'infinite'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15
					),
					'woocommerce-related-product-num-fetch' => array(
						'title' => esc_html__('Woocommerce Related Product Num Fetch', 'infinite'),
						'type' => 'text',
						'default' => 4,
						'data-input-type' => 'number'
					),
					'woocommerce-related-product-thumbnail' => array(
						'title' => esc_html__('Woocommerce Related Product Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'default' => 'full'
					),
				)
			),

			'portfolio-style' => array(
				'title' => esc_html__('Portfolio Style', 'infinite'),
				'options' => array(
					'portfolio-slug' => array(
						'title' => esc_html__('Portfolio Slug (Permalink)', 'infinite'),
						'type' => 'text',
						'default' => 'portfolio',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'infinite')
					),
					'portfolio-category-slug' => array(
						'title' => esc_html__('Portfolio Category Slug (Permalink)', 'infinite'),
						'type' => 'text',
						'default' => 'portfolio_category',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'infinite')
					),
					'portfolio-tag-slug' => array(
						'title' => esc_html__('Portfolio Tag Slug (Permalink)', 'infinite'),
						'type' => 'text',
						'default' => 'portfolio_tag',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'infinite')
					),
					'enable-single-portfolio-navigation' => array(
						'title' => esc_html__('Enable Single Portfolio Navigation', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'disable' => esc_html__('Disable', 'infinite'),
							'enable' => esc_html__('Style 1', 'infinite'),
							'style-2' => esc_html__('Style 2', 'infinite'),
						),
						'default' => 'enable'
					),
					'enable-single-portfolio-navigation-in-same-tag' => array(
						'title' => esc_html__('Enable Single Portfolio Navigation Within Same Tag', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'enable-single-portfolio-navigation' => array('enable', 'style-2') )
					),
					'single-portfolio-navigation-middle-link' => array(
						'title' => esc_html__('Single Portfolio Navigation Middle Link', 'infinite'),
						'type' => 'text',
						'default' => '#',
						'condition' => array( 'enable-single-portfolio-navigation' => 'style-2' )
					),
					'portfolio-icon-hover-link' => array(
						'title' => esc_html__('Portfolio Hover Icon (Link)', 'infinite'),
						'type' => 'radioimage',
						'options' => 'hover-icon-link',
						'default' => 'icon_link_alt'
					),
					'portfolio-icon-hover-video' => array(
						'title' => esc_html__('Portfolio Hover Icon (Video)', 'infinite'),
						'type' => 'radioimage',
						'options' => 'hover-icon-video',
						'default' => 'icon_film'
					),
					'portfolio-icon-hover-image' => array(
						'title' => esc_html__('Portfolio Hover Icon (Image)', 'infinite'),
						'type' => 'radioimage',
						'options' => 'hover-icon-image',
						'default' => 'icon_zoom-in_alt'
					),
					'portfolio-icon-hover-size' => array(
						'title' => esc_html__('Portfolio Hover Icon Size', 'infinite'),
						'type' => 'fontslider',
						'data-type' => 'pixel',
						'default' => '22px',
						'selector' => '.gdlr-core-portfolio-thumbnail .gdlr-core-portfolio-icon{ font-size: #gdlr#; }' 
					),
					'enable-related-portfolio' => array(
						'title' => esc_html__('Enable Related Portfolio', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'related-portfolio-style' => array(
						'title' => esc_html__('Related Portfolio Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'grid' => esc_html__('Grid', 'infinite'),
							'modern' => esc_html__('Modern', 'infinite'),
						),
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-column-size' => array(
						'title' => esc_html__('Related Portfolio Column Size', 'infinite'),
						'type' => 'combobox',
						'options' => array( 60 => 1, 30 => 2, 20 => 3, 15 => 4, 12 => 5, 10 => 6, ),
						'default' => 15,
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-num-fetch' => array(
						'title' => esc_html__('Related Portfolio Num Fetch', 'infinite'),
						'type' => 'text',
						'default' => 4,
						'data-input-type' => 'number',
						'condition' => array('enable-related-portfolio'=>'enable')
					),
					'related-portfolio-thumbnail-size' => array(
						'title' => esc_html__('Related Portfolio Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => 'thumbnail-size',
						'condition' => array('enable-related-portfolio'=>'enable'),
						'default' => 'medium'
					),
					'related-portfolio-num-excerpt' => array(
						'title' => esc_html__('Related Portfolio Num Excerpt', 'infinite'),
						'type' => 'text',
						'default' => 20,
						'data-input-type' => 'number',
						'condition' => array('enable-related-portfolio'=>'enable', 'related-portfolio-style'=>'grid')
					),
				)
			),

			'portfolio-archive' => array(
				'title' => esc_html__('Portfolio Archive', 'infinite'),
				'options' => array(
					'archive-portfolio-sidebar' => array(
						'title' => esc_html__('Archive Portfolio Sidebar', 'infinite'),
						'type' => 'radioimage',
						'options' => 'sidebar',
						'default' => 'none',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-sidebar-left' => array(
						'title' => esc_html__('Archive Portfolio Sidebar Left', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-portfolio-sidebar'=>array('left', 'both') )
					),
					'archive-portfolio-sidebar-right' => array(
						'title' => esc_html__('Archive Portfolio Sidebar Right', 'infinite'),
						'type' => 'combobox',
						'options' => 'sidebar',
						'default' => 'none',
						'condition' => array( 'archive-portfolio-sidebar'=>array('right', 'both') )
					),
					'archive-portfolio-style' => array(
						'title' => esc_html__('Archive Portfolio Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'modern' => get_template_directory_uri() . '/include/options/images/portfolio/modern.png',
							'modern-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/modern-no-space.png',
							'grid' => get_template_directory_uri() . '/include/options/images/portfolio/grid.png',
							'grid-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/grid-no-space.png',
							'modern-desc' => get_template_directory_uri() . '/include/options/images/portfolio/modern-desc.png',
							'modern-desc-no-space' => get_template_directory_uri() . '/include/options/images/portfolio/modern-desc-no-space.png',
							'medium' => get_template_directory_uri() . '/include/options/images/portfolio/medium.png',
						),
						'default' => 'medium',
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-thumbnail-size' => array(
						'title' => esc_html__('Archive Portfolio Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => 'thumbnail-size'
					),
					'archive-portfolio-grid-text-align' => array(
						'title' => esc_html__('Archive Portfolio Grid Text Align', 'infinite'),
						'type' => 'radioimage',
						'options' => 'text-align',
						'default' => 'left',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space' ) )
					),
					'archive-portfolio-grid-style' => array(
						'title' => esc_html__('Archive Portfolio Grid Content Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'normal' => esc_html__('Normal', 'infinite'),
							'with-frame' => esc_html__('With Frame', 'infinite'),
							'with-bottom-border' => esc_html__('With Bottom Border', 'infinite'),
						),
						'default' => 'normal',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space' ) )
					),
					'archive-enable-portfolio-tag' => array(
						'title' => esc_html__('Archive Enable Portfolio Tag', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
					),
					'archive-portfolio-medium-size' => array(
						'title' => esc_html__('Archive Portfolio Medium Thumbnail Size', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'small' => esc_html__('Small', 'infinite'),
							'large' => esc_html__('Large', 'infinite'),
						),
						'condition' => array( 'archive-portfolio-style' => 'medium' )
					),
					'archive-portfolio-medium-style' => array(
						'title' => esc_html__('Archive Portfolio Medium Thumbnail Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'left' => esc_html__('Left', 'infinite'),
							'right' => esc_html__('Right', 'infinite'),
							'switch' => esc_html__('Switch ( Between Left and Right )', 'infinite'),
						),
						'default' => 'switch',
						'condition' => array( 'archive-portfolio-style' => 'medium' )
					),
					'archive-portfolio-hover' => array(
						'title' => esc_html__('Archive Portfolio Hover Style', 'infinite'),
						'type' => 'radioimage',
						'options' => array(
							'title' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title.png',
							'title-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title-icon.png',
							'title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/title-tag.png',
							'icon-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/icon-title-tag.png',
							'icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/icon.png',
							'margin-title' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title.png',
							'margin-title-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title-icon.png',
							'margin-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-title-tag.png',
							'margin-icon-title-tag' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-icon-title-tag.png',
							'margin-icon' => get_template_directory_uri() . '/include/options/images/portfolio/hover/margin-icon.png',
							'none' => get_template_directory_uri() . '/include/options/images/portfolio/hover/none.png',
						),
						'default' => 'icon',
						'max-width' => '100px',
						'condition' => array( 'archive-portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'medium') ),
						'wrapper-class' => 'gdlr-core-fullsize'
					),
					'archive-portfolio-column-size' => array(
						'title' => esc_html__('Archive Portfolio Column Size', 'infinite'),
						'type' => 'combobox',
						'options' => array( 60=>1, 30=>2, 20=>3, 15=>4, 12=>5 ),
						'default' => 20,
						'condition' => array( 'archive-portfolio-style' => array('modern', 'modern-no-space', 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space') )
					),
					'archive-portfolio-excerpt' => array(
						'title' => esc_html__('Archive Portfolio Excerpt Type', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'specify-number' => esc_html__('Specify Number', 'infinite'),
							'show-all' => esc_html__('Show All ( use <!--more--> tag to cut the content )', 'infinite'),
							'none' => esc_html__('Disable Exceprt', 'infinite'),
						),
						'default' => 'specify-number',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ) )
					),
					'archive-portfolio-excerpt-number' => array(
						'title' => esc_html__('Archive Portfolio Excerpt Number', 'infinite'),
						'type' => 'text',
						'default' => 55,
						'data-input-type' => 'number',
						'condition' => array( 'archive-portfolio-style' => array( 'grid', 'grid-no-space', 'modern-desc', 'modern-desc-no-space', 'medium' ), 'archive-portfolio-excerpt' => 'specify-number' )
					),

				)
			),

			'personnel-style' => array(
				'title' => esc_html__('Personnel Style', 'infinite'),
				'options' => array(
					'personnel-slug' => array(
						'title' => esc_html__('Personnel Slug (Permalink)', 'infinite'),
						'type' => 'text',
						'default' => 'personnel',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'infinite')
					),
					'personnel-category-slug' => array(
						'title' => esc_html__('Personnel Category Slug (Permalink)', 'infinite'),
						'type' => 'text',
						'default' => 'personnel_category',
						'description' => esc_html__('Please save the "Settings > Permalink" area once after made a changes to this field.', 'infinite')
					),
				)
			),

			'footer' => array(
				'title' => esc_html__('Footer/Copyright', 'infinite'),
				'options' => array(

					'fixed-footer' => array(
						'title' => esc_html__('Fixed Footer', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
					'enable-footer' => array(
						'title' => esc_html__('Enable Footer', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'footer-background' => array(
						'title' => esc_html__('Footer Background', 'infinite'),
						'type' => 'upload',
						'data-type' => 'file',
						'selector' => '.infinite-footer-wrapper{ background-image: url(#gdlr#); background-size: cover; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'enable-footer-column-divider' => array(
						'title' => esc_html__('Enable Footer Column Divider', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-top-padding' => array(
						'title' => esc_html__('Footer Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '70px',
						'selector' => '.infinite-footer-wrapper{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-bottom-padding' => array(
						'title' => esc_html__('Footer Bottom Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '50px',
						'selector' => '.infinite-footer-wrapper{ padding-bottom: #gdlr#; }',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'footer-style' => array(
						'title' => esc_html__('Footer Style', 'infinite'),
						'type' => 'radioimage',
						'wrapper-class' => 'gdlr-core-fullsize',
						'options' => array(
							'footer-1' => get_template_directory_uri() . '/include/options/images/footer-style1.png',
							'footer-2' => get_template_directory_uri() . '/include/options/images/footer-style2.png',
							'footer-3' => get_template_directory_uri() . '/include/options/images/footer-style3.png',
							'footer-4' => get_template_directory_uri() . '/include/options/images/footer-style4.png',
							'footer-5' => get_template_directory_uri() . '/include/options/images/footer-style5.png',
							'footer-6' => get_template_directory_uri() . '/include/options/images/footer-style6.png',
							'footer-7' => get_template_directory_uri() . '/include/options/images/footer-style7.png',
							'footer-8' => get_template_directory_uri() . '/include/options/images/footer-style8.png',
						),
						'default' => 'footer-2',
						'condition' => array( 'enable-footer' => 'enable' )
					),
					'enable-copyright' => array(
						'title' => esc_html__('Enable Copyright', 'infinite'),
						'type' => 'checkbox',
						'default' => 'enable'
					),
					'copyright-style' => array(
						'title' => esc_html__('Copyright Style', 'infinite'),
						'type' => 'combobox',
						'options' => array(
							'center' => esc_html__('Center', 'infinite'),
							'left-right' => esc_html__('Left & Right', 'infinite'),
						),
						'condition' => array( 'enable-copyright' => 'enable' )
					),
					'copyright-top-padding' => array(
						'title' => esc_html__('Copyright Top Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '38px',
						'selector' => '.infinite-copyright-container{ padding-top: #gdlr#; }',
						'condition' => array( 'enable-copyright' => 'enable' )
					),
					'copyright-bottom-padding' => array(
						'title' => esc_html__('Copyright Bottom Padding', 'infinite'),
						'type' => 'fontslider',
						'data-min' => '0',
						'data-max' => '300',
						'data-type' => 'pixel',
						'default' => '38px',
						'selector' => '.infinite-copyright-container{ padding-bottom: #gdlr#; }',
						'condition' => array( 'enable-copyright' => 'enable' )
					),	
					'copyright-text' => array(
						'title' => esc_html__('Copyright Text', 'infinite'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'condition' => array( 'enable-copyright' => 'enable', 'copyright-style' => 'center' )
					),
					'copyright-left' => array(
						'title' => esc_html__('Copyright Left', 'infinite'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'condition' => array( 'enable-copyright' => 'enable', 'copyright-style' => 'left-right' )
					),
					'copyright-right' => array(
						'title' => esc_html__('Copyright Right', 'infinite'),
						'type' => 'textarea',
						'wrapper-class' => 'gdlr-core-fullsize',
						'condition' => array( 'enable-copyright' => 'enable', 'copyright-style' => 'left-right' )
					),
					'enable-back-to-top' => array(
						'title' => esc_html__('Enable Back To Top Button', 'infinite'),
						'type' => 'checkbox',
						'default' => 'disable'
					),
				) // footer-options
			), // footer-nav	
		
		) // general-options
		
	), 2);