<?php

	define('INFINITE_ITEM_ID', 16869357);
	define('INFINITE_PURCHASE_VERFIY_URL', 'https://goodlayers.com/licenses/wp-json/verify/purchase_code'); 
	define('INFINITE_PLUGIN_VERSION_URL', 'https://goodlayers.com/licenses/wp-json/version/plugin');
	define('INFINITE_PLUGIN_UPDATE_URL', 'https://goodlayers.com/licenses/wp-content/plugins/goodlayers-verification/download/');
	
	// define('INFINITE_PURCHASE_VERFIY_URL', 'http://localhost/infinite/wp-json/verify/purchase_code'); 
	// define('INFINITE_PLUGIN_VERSION_URL', 'http://localhost/infinite/wp-json/version/plugin'); 
	// define('INFINITE_PLUGIN_UPDATE_URL', 'http://localhost/Gdl%20Theme/plugins/goodlayers-verification/download/');

	if( !function_exists('infinite_is_purchase_verified') ){
		function infinite_is_purchase_verified(){
			$purchase_code = infinite_get_purchase_code();
			return empty($purchase_code)? false: true;
		}
	}
	if( !function_exists('infinite_get_purchase_code') ){
		function infinite_get_purchase_code(){
			return get_option('envato_purchase_code_' . INFINITE_ITEM_ID, '');
		}
	}
	if( !function_exists('infinite_get_download_url') ){
		function infinite_get_download_url($file){
			$download_key = get_option('infinite_download_key', '');
			$purchase_code = infinite_get_purchase_code();
			if( empty($download_key) ) return false;

			return add_query_arg(array(
				'purchase_code' => $purchase_code,
				'download_key' => $download_key,
				'file' => $file
			), INFINITE_PLUGIN_UPDATE_URL);
		}
	}

	# delete_option('envato_purchase_code_' . INFINITE_ITEM_ID);
	# delete_option('infinite_download_key');
	if( !function_exists('infinite_verify_purchase') ){
		function infinite_verify_purchase($purchase_code, $register){
			$response = wp_remote_post(INFINITE_PURCHASE_VERFIY_URL, array(
				'body' => array(
					'register' => $register,
					'item_id' => INFINITE_ITEM_ID,
					'website' => get_site_url(),
					'purchase_code' => $purchase_code
				)
			));

			if( is_wp_error($response) || wp_remote_retrieve_response_code($response) != 200 ){
				$e_message = wp_remote_retrieve_response_message($response);
				if( !empty($e_message) ){
					throw new Exception($e_message);
				}else{
					ob_start();
					print_r($response);
					$e_message = ob_get_contents();
					ob_end_clean();
					throw new Exception($e_message);
				}
			}

			$data = json_decode(wp_remote_retrieve_body($response), true);
			if( $data['status'] == 'success' ){
				update_option('envato_purchase_code_' . INFINITE_ITEM_ID, $purchase_code);
				update_option('infinite_download_key', $data['download_key']);
				return true;
			}else{
				update_option('envato_purchase_code_' . INFINITE_ITEM_ID, '');
				update_option('infinite_download_key', '');

				if( !empty($data['message']) ){
					throw new Exception($data['message']);
				}else{
					throw new Exception(esc_html__('Unknown Error', 'infinite'));
				}
				
			}

		} // infinite_verify_purchase
	}

	// delete_option('infinite_daily_schedule');
	// delete_option('infinite-plugins-version');
	add_action('init', 'infinite_admin_schedule');
	if( !function_exists('infinite_admin_schedule') ){
		function infinite_admin_schedule(){
			if( !is_admin() ) return;

			$current_date = date('Y-m-d');
			$daily_schedule = get_option('infinite_daily_schedule', '');
			if( $daily_schedule != $current_date ){
				update_option('infinite_daily_schedule', $current_date);
				do_action('infinite_daily_schedule');
			}
		}
	}

	# update version from server
	add_action('infinite_daily_schedule', 'infinite_plugin_version_update');
	if( !function_exists('infinite_plugin_version_update') ){
		function infinite_plugin_version_update(){
			$response = wp_remote_get(INFINITE_PLUGIN_VERSION_URL);

			if( !is_wp_error($response) && !empty($response['body']) ){
				update_option('infinite-plugins-version', json_decode($response['body'], true));
			}
		}
	}