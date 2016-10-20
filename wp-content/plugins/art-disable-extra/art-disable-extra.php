<?php
/*
Plugin Name: Art Disable Extra
Description: Плагин отключает Емодзи, Rest API и лишние ссылки в шапке
Author: Артем Абрамович
Plugin URI: http://wpruse.ru/?p=570
Author URI: abrfolio.ru
Version: 1.2.1
*/

/* --------------------------------------------------------------------------
 * Отключаем Emojii
 * -------------------------------------------------------------------------- */
remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
remove_action( 'wp_print_styles', 'print_emoji_styles' );
remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
add_filter( 'tiny_mce_plugins', 'disable_wp_emojis_in_tinymce' );
function disable_wp_emojis_in_tinymce( $plugins ) {
    if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
    } else {
        return array();
    }
}

/* --------------------------------------------------------------------------
 * Отключаем REST API
 * -------------------------------------------------------------------------- */
// Отключаем сам REST API
add_filter('rest_enabled', '__return_false');

// Отключаем фильтры REST API
remove_action( 'xmlrpc_rsd_apis',            'rest_output_rsd' );
remove_action( 'wp_head',                    'rest_output_link_wp_head', 10, 0 );
remove_action( 'template_redirect',          'rest_output_link_header', 11, 0 );
remove_action( 'auth_cookie_malformed',      'rest_cookie_collect_status' );
remove_action( 'auth_cookie_expired',        'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_username',   'rest_cookie_collect_status' );
remove_action( 'auth_cookie_bad_hash',       'rest_cookie_collect_status' );
remove_action( 'auth_cookie_valid',          'rest_cookie_collect_status' );
remove_filter( 'rest_authentication_errors', 'rest_cookie_check_errors', 100 );

// Отключаем события REST API
remove_action( 'init','rest_api_init' );
remove_action( 'rest_api_init', 'rest_api_default_filters', 10, 1 );
remove_action( 'parse_request', 'rest_api_loaded' );

// Отключаем Embeds связанные с REST API
remove_action( 'rest_api_init','wp_oembed_register_route');
remove_filter( 'rest_pre_serve_request', '_oembed_rest_pre_serve_request', 10, 4 );

remove_action( 'wp_head', 'wp_oembed_add_discovery_links' );
remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
remove_action( 'wp_head', 'rest_output_link_wp_head' );
// если собираетесь выводить вставки из других сайтов на своем, то закомментируйте след. строку.
remove_action( 'wp_head','wp_oembed_add_host_js');

/* --------------------------------------------------------------------------
 * Удаляем лишнее из шапки
 * -------------------------------------------------------------------------- */
 // Удаляет ссылки RSS-лент записи и комментариев
remove_action( 'wp_head', 'feed_links', 2 ); 
// Удаляет ссылки RSS-лент категорий и архивов
remove_action( 'wp_head', 'feed_links_extra', 3 ); 
// Удаляет RSD ссылку для удаленной публикации
remove_action( 'wp_head', 'rsd_link' ); 
// Удаляет ссылку Windows для Live Writer
remove_action( 'wp_head', 'wlwmanifest_link' ); 
// Удаляет короткую ссылку
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10, 0); 
// Удаляет информацию о версии WordPress
remove_action( 'wp_head', 'wp_generator' ); 
// Удаляет ссылки на предыдущую и следующую статьи
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 ); 