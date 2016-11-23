<?php
// Filter Yoast Meta Priority
add_filter( 'wpseo_metabox_prio', function() { return 'low';});

/* Patch for WP Admin rendering bug in Chrome 45+ */
function admin_menu_chrome_patch(){
	echo '<style>#adminmenu { transform: translateZ(0); }</style>';
}
add_action('admin_head', 'admin_menu_chrome_patch');
/* end */

/* hide adminbar if u not admin */
function my_function_admin_bar($content) {
	return ( current_user_can("administrator") ) ? $content : false;
}
add_filter( 'show_admin_bar' , 'my_function_admin_bar');
/* end */

/* Optional */
if( function_exists('acf_add_options_page') ) {
	acf_add_options_page(array(
		'page_title' 	=> 'Управление сайтом',
		'menu_title'	=> 'Управление',
		'menu_slug' 	=> 'theme-general-settings',
		'capability'	=> 'edit_posts'
	));
}
/* end */

/* add title */
add_theme_support( 'title-tag' );
/* end */

/* remove attachment rel */
function my_remove_rel_attr($content) {
    return preg_replace('/\s+rel="attachment wp-att-[0-9]+"/i', '', $content);
}
add_filter('the_content', 'my_remove_rel_attr');
/* end */

/* register menus */
register_nav_menus( array(
	'main-menu' => __( 'Главное меню' ),
	'side-menu' => __( 'Боковое меню' ),
) );
/* end */

/* init widgets */
function prosites_widgets_init() {
	register_sidebar(
		array(
			'name'          => 'Sidebar',
			'id'            => 'sidebar-1',
			'description'   => '',
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'prosites_widgets_init' );
/* end */

/* short story ... */
function new_excerpt_more( $more ) {return '...';}
add_filter('excerpt_more', 'new_excerpt_more');
/* end */

/* Webber custom admin panel */
function webber_login_logo(){?>
	<style type="text/css">
		.login h1 a{
			outline: none !important;
			box-shadow: none !important;
			background-image: url('<?php bloginfo('template_url'); ?>/img/webber-black.svg') !important;
			background-size: 150px 155px !important;
			width: 150px !important;
			height: 155px !important;
		}
		.wp-core-ui .button-primary{
			border: 0;
			border-radius: 0;
		}
	</style>
<?php };
add_action('login_head', 'webber_login_logo');
function webber_custom_logo_url(){return 'http://webber.by';}
add_filter( 'login_headerurl', 'webber_custom_logo_url', 10, 4 );
function webber_custom_logo_title(){return 'Разработка и продвижение сайтов';}
add_filter('login_headertitle','webber_custom_logo_title');
function webber_change_toolbar(){
	global $wp_admin_bar;
	$wp_admin_bar->remove_node('wp-logo');
}
add_action('admin_bar_menu','webber_change_toolbar',40);
function webber_change_footer_link(){
	echo '<span id="footer-thankyou">Спасибо за заказ сайта, команда <a href="http://webber.by/">Webber.by</a></span>';
}
add_filter('admin_footer_text','webber_change_footer_link');

add_action('admin_menu', function(){
	add_menu_page( 'Заказ дополнительных услуг', 'Webber.by', 'manage_options', 'webber-adv', 'webber_admin_adv', 'data:image/svg+xml;base64,PHN2ZyBpZD0i0KHQu9C+0LlfMSIgZGF0YS1uYW1lPSLQodC70L7QuSAxIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAzMiAzMiI+PGRlZnM+PHN0eWxlPi5jbHMtMXtmaWxsOiM5ZWEzYTg7ZmlsbC1ydWxlOmV2ZW5vZGQ7fTwvc3R5bGU+PC9kZWZzPjx0aXRsZT7QnNC+0L3RgtCw0LbQvdCw0Y8g0L7QsdC70LDRgdGC0YwgMTwvdGl0bGU+PHBhdGggY2xhc3M9ImNscy0xIiBkPSJNMTMuNzEsNy40aDIuODdhMS43MiwxLjcyLDAsMCwxLDEuNzEsMS43MWgwYTEuNzIsMS43MiwwLDAsMS0xLjcxLDEuNzFIMTMuNzFabTAsNi44OGgyLjg3QTEuNzIsMS43MiwwLDAsMSwxOC4yOSwxNmgwYTEuNzIsMS43MiwwLDAsMS0xLjcxLDEuNzFIMTMuNzFabTAsNi44OGgyLjg3YTEuNzEsMS43MSwwLDAsMSwwLDMuNDNIMTMuNzFaTTkuMTIsNGg4LjZhNS4xNSw1LjE1LDAsMCwxLDMuODQsOC42LDUuMTMsNS4xMywwLDAsMSwwLDYuODhBNS4xNSw1LjE1LDAsMCwxLDE3LjcyLDI4SDkuMTJaIi8+PC9zdmc+', 0 ); 
} );
function webber_admin_adv(){
	$file = file_get_contents("http://webber.by/admin-start-page/index.php");
	print_r($file);
}
function webber_login_redirect( $redirect_to, $request, $user ){
	if( is_array( $user->roles ) ) { // check if user has a role
		return "/wp-admin/admin.php?page=webber-adv";
	}
}
add_filter("login_redirect", "webber_login_redirect", 10, 3);
/* end */

/* pagination */
function proPagination($pages = '', $range = 2){
	$showitems = ($range * 2)+1;
	global $paged;
	if(empty($paged)) $paged = 1;
	if($pages == ''){
		global $wp_query;
		$pages = $wp_query->max_num_pages;
		if(!$pages){$pages = 1;}
	};
	if(1 != $pages){
		echo "<ul class='pagination'>";
		if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<li class='page-item'><a href='".get_pagenum_link(1)."' class='page-link'>&laquo;</a></li>";
		if($paged > 1 && $showitems < $pages) echo "<li class='page-item'><a href='".get_pagenum_link($paged - 1)."' class='page-link'>&lsaquo;</a></li>";

		for ($i=1; $i <= $pages; $i++){
			if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )){
				echo ($paged == $i)? "<li class='page-item active'><a class='page-link' href='#'>".$i."</a></li>":"<li class='page-item'><a class='page-link' href='".get_pagenum_link($i)."'>".$i."</a></li>";
			};
		};
		if ($paged < $pages && $showitems < $pages) echo "<li class='page-item'><a class='page-link' href='".get_pagenum_link($paged + 1)."'>&rsaquo;</a></li>";
		if ($paged < $pages-1 && $paged+$range-1 < $pages && $showitems < $pages) echo "<li class='page-item'><a class='page-link' href='".get_pagenum_link($pages)."'>&raquo;</a></li>";
		echo "</ul>";
	};
};
/* end */