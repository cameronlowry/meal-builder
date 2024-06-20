<?php
	/* a template for displaying the top bar */

	if( infinite_get_option('general', 'enable-top-bar', 'enable') == 'enable' ){

		$top_bar_width = infinite_get_option('general', 'top-bar-width', 'boxed');
		$top_bar_container_class = '';

		if( $top_bar_width == 'boxed' ){
			$top_bar_container_class = 'infinite-container ';
		}else if( $top_bar_width == 'custom' ){
			$top_bar_container_class = 'infinite-top-bar-custom-container ';
		}else{
			$top_bar_container_class = 'infinite-top-bar-full ';
		}

		$top_bar_menu = infinite_get_option('general', 'top-bar-menu-position', 'none');
		$top_bar_social = infinite_get_option('general', 'enable-top-bar-social', 'enable');
		$top_bar_social_position = infinite_get_option('general', 'top-bar-social-position', 'right');
		$top_bar_bottom_border = infinite_get_option('general', 'top-bar-bottom-border-style', 'outer');
		$top_bar_split_border = infinite_get_option('general', 'top-bar-split-border', 'disable');

		$header_style = infinite_get_option('general', 'header-style', 'plain');
		$header_plain_style = infinite_get_option('general', 'header-plain-style', 'menu-right');
		$middle_logo = $header_style == 'plain' && $header_plain_style == 'top-bar-logo';

		$top_bar_class  = $top_bar_bottom_border == 'inner'? ' infinite-inner': '';
		$top_bar_class .= $top_bar_split_border == 'enable'? ' infinite-splited-border': '';
		$top_bar_class .= $middle_logo? ' infinite-middle-logo': '';
		echo '<div class="infinite-top-bar ' . esc_attr($top_bar_class) . '" >';
		echo '<div class="infinite-top-bar-background" ></div>';
		echo '<div class="infinite-top-bar-container ' . esc_attr($top_bar_container_class) . '" >';
		echo '<div class="infinite-top-bar-container-inner clearfix" >';

		$language_flag = infinite_get_wpml_flag();
		$left_text = infinite_get_option('general', 'top-bar-left-text', '');
		if( $middle_logo || !empty($left_text) || !empty($language_flag) || ($top_bar_menu == 'left' && has_nav_menu('top_bar_menu')) ||
			($top_bar_social == 'enable' && $top_bar_social_position == 'left') ){

			echo '<div class="infinite-top-bar-left infinite-item-pdlr">';
			echo '<div class="infinite-top-bar-left-text">';
			if( $top_bar_menu == 'left' ){
				infinite_get_top_bar_menu('left');
			}
			echo gdlr_core_escape_content($language_flag);
			echo gdlr_core_escape_content(gdlr_core_text_filter($left_text));
			echo '</div>';

			// social
			if( $top_bar_social == 'enable' && $top_bar_social_position == 'left' ){
				echo '<div class="infinite-top-bar-right-social" >';
				get_template_part('header/header', 'social');
				echo '</div>';	
			}
			echo '</div>';
		}

		if( $middle_logo ){
			echo infinite_get_logo();
		}

		$right_text = infinite_get_option('general', 'top-bar-right-text', '');
		$custom_top_bar_right = apply_filters('infinite_custom_top_bar_right', ''); 
		if( !empty($right_text) || $top_bar_social == 'enable' || !empty($custom_top_bar_right) ||
			($top_bar_menu == 'right' && has_nav_menu('top_bar_menu')) ){
			echo '<div class="infinite-top-bar-right infinite-item-pdlr">';
			if( $top_bar_menu == 'right' ){
				infinite_get_top_bar_menu('right');
			}

			if( !empty($right_text) ){
				echo '<div class="infinite-top-bar-right-text">';
				echo gdlr_core_escape_content(gdlr_core_text_filter($right_text));
				echo '</div>';
			}

			if( $top_bar_social == 'enable' && $top_bar_social_position == 'right' ){
				echo '<div class="infinite-top-bar-right-social" >';
				get_template_part('header/header', 'social');
				echo '</div>';	

				$top_bar_social = 'disable';
			}

			if( !empty($custom_top_bar_right) ){
				echo gdlr_core_text_filter($custom_top_bar_right);
			}
			echo '</div>';	
		}

		if( $top_bar_bottom_border == 'inner' ){
			echo '<div class="infinite-top-bar-bottom-border infinite-item-mglr" ></div>';
		}

		echo '</div>'; // infinite-top-bar-container-inner
		echo '</div>'; // infinite-top-bar-container
		echo '</div>'; // infinite-top-bar

	}  // top bar
?>