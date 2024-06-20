<?php
	/* a template for displaying the header area */

	// header container
	$body_layout = infinite_get_option('general', 'layout', 'full');
	$body_margin = infinite_get_option('general', 'body-margin', '0px');
	$header_width = infinite_get_option('general', 'header-width', 'boxed');
	$header_style = infinite_get_option('general', 'header-bar2-navigation-align', 'center');
	$header_background_style = infinite_get_option('general', 'header-background-style', 'solid');

	$header_wrap_class = '';
	if( $header_style == 'center-logo' ){
		$header_wrap_class .= ' infinite-style-center';
	}else{
		$header_wrap_class .= ' infinite-style-left';
	}

	$header_container_class = '';
	if( $header_width == 'boxed' ){
		$header_container_class .= ' infinite-container';
	}else if( $header_width == 'custom' ){
		$header_container_class .= ' infinite-header-custom-container';
	}else{
		$header_container_class .= ' infinite-header-full';
	}

	$navigation_wrap_class  = ' infinite-sticky-navigation infinite-sticky-navigation-height';
	if( $header_style == 'center' || $header_style == 'center-logo' ){
		$navigation_wrap_class .= ' infinite-style-center';
	}else{
		$navigation_wrap_class .= ' infinite-style-left';
	}
	if( $body_layout == 'boxed' || $body_margin != '0px' ){
		$navigation_wrap_class .= ' infinite-style-slide';
	}else{
		$navigation_wrap_class .= '  infinite-style-fixed';
	}

?>	
<header class="infinite-header-wrap infinite-header-style-bar infinite-style-2 <?php echo esc_attr($header_wrap_class); ?>" >
	<div class="infinite-header-background"></div>
	<div class="infinite-header-container clearfix <?php echo esc_attr($header_container_class); ?>">
		<div class="infinite-header-container-inner">
		<?php
			
			echo infinite_get_logo();

			$logo_right_text = '';
			$logo_right_text_content = infinite_get_option('general', 'logo-right-text');
			if( !empty($logo_right_text_content) ){
				$logo_right_text .= '<div class="infinite-logo-right-text-content" >';
				$logo_right_text .= gdlr_core_content_filter($logo_right_text_content);
				$logo_right_text .= '</div>';
			}

			if( !empty($logo_right_text) ){
				echo '<div class="infinite-logo-right-text infinite-item-pdlr clearfix" >' . gdlr_core_text_filter($logo_right_text) . '</div>';
			}
		?>
		</div>
	</div>
	<div class="infinite-navigation-bar-wrap infinite-navigation-header-style-bar infinite-style-2 <?php echo esc_attr($navigation_wrap_class); ?>" >
		
		<div class="infinite-navigation-container clearfix <?php echo esc_attr($header_container_class); ?>">
			<div class="infinite-navigation-background infinite-item-mglr" ></div>
			<?php
				$navigation_class = '';
				if( infinite_get_option('general', 'enable-main-navigation-submenu-indicator', 'disable') == 'enable' ){
					$navigation_class .= 'infinite-navigation-submenu-indicator ';
				}
			?>
			<div class="infinite-navigation infinite-item-pdlr clearfix <?php echo esc_attr($navigation_class); ?>" >
			<?php
				// print main menu
				if( has_nav_menu('main_menu') ){
					echo '<div class="infinite-main-menu" id="infinite-main-menu" >';
					wp_nav_menu(array(
						'theme_location'=>'main_menu', 
						'container'=> '', 
						'menu_class'=> 'sf-menu',
						'walker' => new infinite_menu_walker()
					));
					
					infinite_get_navigation_slide_bar();
					
					echo '</div>';
				}

				// menu right side
				$menu_right_class = '';
				if( $header_style == 'center' || $header_style == 'center-logo' ){
					$menu_right_class = ' infinite-item-mglr infinite-navigation-top';
				}

				// menu right side
				$enable_search = (infinite_get_option('general', 'enable-main-navigation-search', 'enable') == 'enable')? true: false;
				$enable_cart = (infinite_get_option('general', 'enable-main-navigation-cart', 'enable') == 'enable' && class_exists('WooCommerce'))? true: false;
				$enable_right_button = (infinite_get_option('general', 'enable-main-navigation-right-button', 'disable') == 'enable')? true: false;
				$custom_main_menu_right = apply_filters('infinite_custom_main_menu_right', '');
				$side_content_menu = (infinite_get_option('general', 'side-content-menu', 'disable') == 'enable')? true: false;
				if( has_nav_menu('right_menu') || $enable_search || $enable_cart || $enable_right_button || !empty($custom_main_menu_right) || $side_content_menu ){
					echo '<div class="infinite-main-menu-right-wrap clearfix ' . esc_attr($menu_right_class) . '" >';

					// search icon
					if( $enable_search ){
						echo '<div class="infinite-main-menu-search" id="infinite-top-search" >';
						echo '<i class="fa fa-search" ></i>';
						echo '</div>';
						infinite_get_top_search();
					}

					// cart icon
					if( $enable_cart ){
						echo '<div class="infinite-main-menu-cart" id="infinite-main-menu-cart" >';
						echo '<i class="fa fa-shopping-cart" data-infinite-lb="top-bar" ></i>';
						infinite_get_woocommerce_bar();
						echo '</div>';
					}

					// custom menu right
					if( !empty($custom_main_menu_right) ){
						echo gdlr_core_text_filter($custom_main_menu_right);
					}

					// menu right button
					if( $enable_right_button ){
						$button_class = 'infinite-style-' . infinite_get_option('general', 'main-navigation-right-button-style', 'default');
						$button_link = infinite_get_option('general', 'main-navigation-right-button-link', '');
						$button_link_target = infinite_get_option('general', 'main-navigation-right-button-link-target', '_self');
						echo '<a class="infinite-main-menu-right-button ' . esc_attr($button_class) . '" href="' . esc_url($button_link) . '" target="' . esc_attr($button_link_target) . '" >';
						echo infinite_get_option('general', 'main-navigation-right-button-text', '');
						echo '</a>';
					}

					// print right menu
					$secondary_menu = infinite_get_option('general', 'enable-secondary-menu', 'enable');
					if( has_nav_menu('right_menu') && $secondary_menu == 'enable' ){
						infinite_get_custom_menu(array(
							'container-class' => 'infinite-main-menu-right',
							'button-class' => 'infinite-right-menu-button infinite-top-menu-button',
							'icon-class' => 'fa fa-bars',
							'id' => 'infinite-right-menu',
							'theme-location' => 'right_menu',
							'type' => infinite_get_option('general', 'right-menu-type', 'right')
						));
					}

					if( $side_content_menu ){
						$side_content_widget = infinite_get_option('general', 'side-content-widget', '');
						if( is_active_sidebar($side_content_widget) ){ 
							echo '<div class="infinite-side-content-menu-button" ><span></span></div>';
						}
					}

					echo '</div>'; // infinite-main-menu-right-wrap
				}
			?>
			</div><!-- infinite-navigation -->

		</div><!-- infinite-header-container -->
	</div><!-- infinite-navigation-bar-wrap -->
</header><!-- header -->