<?php
	/* a template for displaying the page title */

	$page_title = '';
	$page_caption = '';

	$title_style = infinite_get_option('general', 'default-title-style', 'small');
	$title_align = infinite_get_option('general', 'default-title-align', 'left');
	$title_side_margin = '';

	// header gradient
	$header_gradient = infinite_get_option('general', 'page-title-top-bottom-gradient', 'none');

	// for index page
	if( is_home() ){
		$main_head = true;
		$page_title = esc_html__('Blog', 'infinite');

	// tribe event
	}else if( is_singular( 'tribe_events' ) ){
		$main_head = true;

		global $infinite_event_id;
		$page_title = get_the_title($infinite_event_id);

		$events_label_plural = tribe_get_event_label_plural();
		$event_link  = '<div class="infinite-page-title-event-link" >';
		$event_link .= '<a href="' . esc_url(tribe_get_events_link()) . '">';
		$event_link .= sprintf('&laquo; ' . esc_html_x('All %s', '%s Events plural label', 'infinite'), $events_label_plural);
		$event_link .= '</a>';
		$event_link .= '</div>';

		$event_time = tribe_events_event_schedule_details($infinite_event_id, '', '');
		if( tribe_get_cost($infinite_event_id) ){
			$event_time .= '<span class="tribe-events-cost">' . tribe_get_cost($infinite_event_id, true) . '</span>';
		}
		if( !empty($event_time) ){
			$event_time = '<div class="infinite-page-title-event-time" >' . $event_time . '</div>';
		}

	// for single post
	}else if( is_single() && get_post_type() == 'post' ){


	// for single product
	}else if( is_single() && get_post_type() == 'product' ){

		echo '<div class="infinite-header-transparent-substitute" ></div>';

	// for pages
	}else if( is_page() || is_single() ){
		$post_option = infinite_get_post_option(get_the_ID());

		$main_head = true;
		$page_title = get_the_title();
		$page_caption = empty($post_option['page-caption'])? '': $post_option['page-caption'];

		if( !empty($post_option['title-background']) ){
			$title_background = $post_option['title-background'];
		}
		if( !empty($post_option['title-background-radius']) ){
			$title_background_radius = $post_option['title-background-radius'];
		}
		if( !empty($post_option['title-background-bottom-radius']) ){
			if( !empty($post_option['title-background-radius']) ){
				$title_background_radius = array(
					'top' => $post_option['title-background-bottom-radius'], 
					'right' => $post_option['title-background-bottom-radius'],
					'bottom' => $post_option['title-background-radius'],
					'left' => $post_option['title-background-radius']
				);
			}else{
				$title_background_radius = array(
					'top' => 0, 
					'right' => 0, 
					'bottom' => $post_option['title-background-bottom-radius'],
					'left' => $post_option['title-background-bottom-radius']
				);
			}
		}

		$title_color = empty($post_option['title-color'])? '': $post_option['title-color'];
		$caption_color = empty($post_option['caption-color'])? '': $post_option['caption-color'];
		$background_overlay_color = empty($post_option['title-background-overlay-color'])? '': $post_option['title-background-overlay-color'];
		if( !empty($post_option['title-align']) && $post_option['title-align'] != 'default' ){
			$title_align = $post_option['title-align'];
		}

		if( !empty($post_option['title-style']) && $post_option['title-style'] != 'default' ){
			$title_style = $post_option['title-style'];

			if( $post_option['title-style'] == 'custom' ){
				$title_size = empty($post_option['title-font-size'])? '': $post_option['title-font-size'];
				$title_weight = empty($post_option['title-font-weight'])? '': $post_option['title-font-weight'];
				$title_transform = empty($post_option['title-font-transform'])? '': $post_option['title-font-transform'];
				$title_spacing = empty($post_option['title-spacing'])? array(): $post_option['title-spacing'];
				$title_overlay_opacity = empty($post_option['title-background-overlay-opacity'])? '': $post_option['title-background-overlay-opacity'];
			}
		}

		// gradient
		if( !empty($post_option['top-bottom-gradient']) && $post_option['top-bottom-gradient'] != 'default' ){
			$header_gradient = $post_option['top-bottom-gradient'];
		}

		// breadcrumbs
		if( empty($post_option['enable-breadcrumbs']) || $post_option['enable-breadcrumbs'] == 'default' ){
			$breadcrumbs = infinite_get_option('general', 'enable-breadcrumbs', 'disable');
		}else{
			$breadcrumbs = $post_option['enable-breadcrumbs'];
		}
		
		// side margin
		$title_side_margin = empty($post_option['title-side-margin'])? '': $post_option['title-side-margin'];


	// 404 page
	}else if( is_404() ){

	// search page
	}else if( is_search() ){

		if( have_posts() ){
			$page_title = esc_html__('Search Results', 'infinite');
			$page_caption = get_search_query();
		}else{
			get_template_part('content/archive', 'not-found');
		}

	// archive page
	}else if( is_archive() ){

		if( !class_exists('gdlr_core_pb_element_product') && 
			((function_exists('is_shop') && is_shop()) || is_tax('product_cat') || is_tax('product_tag')) ){
			$page_title = '';
			$page_caption = '';
			echo '<div class="infinite-header-transparent-substitute" ></div>';

		}else if( is_category() || is_tax('portfolio_category') || is_tax('product_cat') ){
			$page_title = esc_html__('Category', 'infinite');

			if( is_tax('product_cat') && function_exists('woocommerce_breadcrumb') ){
				ob_start();
				woocommerce_breadcrumb();
				$page_caption = ob_get_contents();
				ob_end_clean();
			}else{
				$page_caption = single_cat_title('', false);
			}
		}else if( is_tag() || is_tax('portfolio_tag') || is_tax('product_tag') ){
			$page_title = esc_html__('Tag', 'infinite');
			
			if( is_tax('product_cat') && function_exists('woocommerce_breadcrumb') ){
				ob_start();
				woocommerce_breadcrumb();
				$page_caption = ob_get_contents();
				ob_end_clean();
			}else{
				$page_caption = single_cat_title('', false);
			}
		}else if( is_day() ){
			$page_title = esc_html__('Day','infinite');
			$page_caption = get_the_date('F j, Y');
		}else if( is_month() ){
			$page_title = esc_html__('Month','infinite');
			$page_caption = get_the_date('F Y');
		}else if( is_year() ){
			$page_title = esc_html__('Year','infinite');
			$page_caption = get_the_date('Y');
		}else if( is_author() ){
			$page_title = esc_html__('By','infinite');
			
			$author_id = get_query_var('author');
			$author = get_user_by('id', $author_id);
			$page_caption = $author->display_name;					
		}else if( is_post_type_archive('product') ){
			$page_title = esc_html__('Shop', 'infinite');
			$page_caption = '';
		}else if( is_post_type_archive('event') || is_post_type_archive('tribe-event') ){
			$page_title = esc_html__('Events', 'infinite');
			$page_caption = '';
		}else{
			$page_title = get_the_title();
			$page_caption = '';
		}

	}

	if( (empty($post_option['enable-page-title']) || $post_option['enable-page-title'] == 'enable') && (!empty($page_title) || !empty($page_caption)) ){	

		$page_title = apply_filters('infinite_page_title', $page_title);
		$page_caption = apply_filters('infinite_page_caption', $page_caption);

		$extra_class  = ' infinite-style-' . $title_style;
		$extra_class .= ' infinite-' . $title_align . '-align';

		echo '<div class="infinite-page-title-wrap ' . esc_attr($extra_class) . '" ' . gdlr_core_esc_style(array(
			'background-image' => empty($title_background)? '': $title_background,
			'border-radius' => empty($title_background_radius)? '': $title_background_radius,
			'margin-left' => $title_side_margin,
			'margin-right' => $title_side_margin
		)) . '>';
		echo '<div class="infinite-header-transparent-substitute" ></div>';
		echo '<div class="infinite-page-title-overlay" ' . gdlr_core_esc_style(array(
			'opacity' => empty($title_overlay_opacity)? '': $title_overlay_opacity,
			'background-color' => empty($background_overlay_color)? '': $background_overlay_color
		)) . ' ></div>';
		if( $header_gradient == 'top' || $header_gradient == 'both' ){
			echo '<div class="infinite-page-title-top-gradient" ></div>';
		}
		if( $header_gradient == 'bottom' || $header_gradient == 'both' ){
			echo '<div class="infinite-page-title-bottom-gradient" ></div>';
		}
		echo '<div class="infinite-page-title-container infinite-container" >';
		echo '<div class="infinite-page-title-content infinite-item-pdlr" ' . gdlr_core_esc_style(array(
			'padding-top' => empty($title_spacing['padding-top'])? '': $title_spacing['padding-top'],
			'padding-bottom' => empty($title_spacing['padding-bottom'])? '': $title_spacing['padding-bottom']
		)) . ' >';
		
		if( !empty($page_title) ){
			if( !empty($main_head) ){
				echo '<h1 class="infinite-page-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['title-size'])? '': $title_size['title-size'],
					'font-weight' => empty($title_weight['title-weight'])? '': $title_weight['title-weight'],
					'text-transform' => (empty($title_transform) || $title_transform == 'default')? '': $title_transform,
					'letter-spacing' => empty($title_size['title-letter-spacing'])? '': $title_size['title-letter-spacing'],
					'color' => empty($title_color)? '': $title_color
				)) . ' >' . $page_title . '</h1>';
			}else{
				echo '<h3 class="infinite-page-title" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['title-size'])? '': $title_size['title-size'],
					'font-weight' => empty($title_weight['title-weight'])? '': $title_weight['title-weight'],
					'text-transform' => (empty($title_transform) || $title_transform == 'default')? '': $title_transform,
					'letter-spacing' => empty($title_size['title-letter-spacing'])? '': $title_size['title-letter-spacing'],
					'color' => empty($title_color)? '': $title_color
				)) . ' >' . $page_title . '</h3>';
			}
		}

		if( !empty($page_caption) ){
			echo '<div class="infinite-page-caption" ' . gdlr_core_esc_style(array(
					'font-size' => empty($title_size['caption-size'])? '': $title_size['caption-size'],
					'font-weight' => empty($title_weight['caption-weight'])? '': $title_weight['caption-weight'],
					'letter-spacing' => empty($title_size['caption-letter-spacing'])? '': $title_size['caption-letter-spacing'],
					'margin-top' => empty($title_spacing['caption-top-margin'])? '': $title_spacing['caption-top-margin'],
					'color' => empty($caption_color)? '': $caption_color
				)) . ' >' . $page_caption . '</div>';
		}

		if( !empty($event_time) ){
			echo gdlr_core_text_filter($event_time);
		}
		if( !empty($event_link) ){
			echo gdlr_core_text_filter($event_link);
		}
		
		echo '</div>'; // infinite-page-title-content
		echo '</div>'; // infinite-page-title-container
		echo '</div>'; // infinite-page-title-wrap

		// breadcrumbs
		if( function_exists('bcn_display') && $breadcrumbs == 'enable' ){
			$breadcrumbs_padding = empty($post_option['breadcrumbs-padding'])? array(): $post_option['breadcrumbs-padding'];

			echo '<div class="infinite-breadcrumbs" ' . gdlr_core_esc_style(array(
				'padding-top' => empty($breadcrumbs_padding['padding-top'])? '': $breadcrumbs_padding['padding-top'],
				'padding-bottom' => empty($breadcrumbs_padding['padding-bottom'])? '': $breadcrumbs_padding['padding-bottom'],
			)) . ' >';
			echo '<div class="infinite-breadcrumbs-container infinite-container" >';
			echo '<div class="infinite-breadcrumbs-item infinite-item-pdlr" >';
       		bcn_display();
       		echo '</div>';
       		echo '</div>';
       		echo '</div>';
    	}
	}
?>