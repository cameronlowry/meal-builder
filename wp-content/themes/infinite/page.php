<?php
/**
 * The template for displaying pages
 */
	global $infinite_event_id;
	$infinite_event_id = get_the_ID(); 

	get_header();
	
	while( have_posts() ){ the_post();
	
		$post_option = infinite_get_post_option(get_the_ID());
		$show_content = (empty($post_option['show-content']) || $post_option['show-content'] == 'enable')? true: false;

		if( empty($post_option['sidebar']) ){
			if( is_singular( 'tribe_events' ) ){
				$sidebar_type = infinite_get_option('general', 'default-event-sidebar', 'none');
				$sidebar_left = infinite_get_option('general', 'default-event-sidebar-left', '');
				$sidebar_right = infinite_get_option('general', 'default-event-sidebar-right', '');
			}else{
				$sidebar_type = 'none';
				$sidebar_left = '';
				$sidebar_right = '';
			}
		}else{
			$sidebar_type = empty($post_option['sidebar'])? 'none': $post_option['sidebar'];
			$sidebar_left = empty($post_option['sidebar-left'])? '': $post_option['sidebar-left'];
			$sidebar_right = empty($post_option['sidebar-right'])? '': $post_option['sidebar-right'];
		}

		if( $sidebar_type == 'none' ){

			// content from wordpress editor area
			ob_start();
			the_content();
			wp_link_pages(array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'infinite' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'infinite' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			));
			$content = ob_get_contents();
			ob_end_clean();

			if( ($show_content && trim($content) != "") || post_password_required() ){
				echo '<div class="infinite-content-container infinite-container">';
				echo '<div class="infinite-content-area infinite-item-pdlr infinite-sidebar-style-none clearfix" >';
				echo gdlr_core_escape_content($content);
				echo '</div>'; // infinite-content-area
				echo '</div>'; // infinite-content-container
			}

			if( !post_password_required() ){
				do_action('gdlr_core_print_page_builder');
			}

			// comments template
			if( comments_open() || get_comments_number() ){
				echo '<div class="infinite-page-comment-container infinite-container" >';
				echo '<div class="infinite-page-comments infinite-item-pdlr" >';
				comments_template();
				echo '</div>';
				echo '</div>';
			}

		}else{

			echo '<div class="infinite-content-container infinite-container">';
			echo '<div class="' . esc_attr(infinite_get_sidebar_wrap_class($sidebar_type)) . '" >';

			// sidebar content
			echo '<div class="' . esc_attr(infinite_get_sidebar_class(array('sidebar-type'=>$sidebar_type, 'section'=>'center'))) . '" >';
			
			// content from wordpress editor area
			ob_start();
			the_content();
			wp_link_pages(array(
				'before'      => '<div class="page-links"><span class="page-links-title">' . esc_html__( 'Pages:', 'infinite' ) . '</span>',
				'after'       => '</div>',
				'link_before' => '<span>',
				'link_after'  => '</span>',
				'pagelink'    => '<span class="screen-reader-text">' . esc_html__( 'Page', 'infinite' ) . ' </span>%',
				'separator'   => '<span class="screen-reader-text">, </span>',
			));
			$content = ob_get_contents();
			ob_end_clean();

			if( ($show_content && trim($content) != "") || post_password_required() ){
				echo '<div class="infinite-content-area infinite-item-pdlr" >' . $content . '</div>'; // infinite-content-wrapper
			}

			if( !post_password_required() ){
				do_action('gdlr_core_print_page_builder');
			}

			// comments template
			if( comments_open() || get_comments_number() ){
				echo '<div class="infinite-page-comments infinite-item-pdlr" >';
				comments_template();
				echo '</div>';
			}

			echo '</div>'; // infinite-get-sidebar-class

			// sidebar left
			if( $sidebar_type == 'left' || $sidebar_type == 'both' ){
				echo infinite_get_sidebar($sidebar_type, 'left', $sidebar_left);
			}

			// sidebar right
			if( $sidebar_type == 'right' || $sidebar_type == 'both' ){
				echo infinite_get_sidebar($sidebar_type, 'right', $sidebar_right);
			}

			echo '</div>'; // infinite-get-sidebar-wrap-class
		 	echo '</div>'; // infinite-content-container

		}
		
	} // while
	
	get_footer(); 
?>