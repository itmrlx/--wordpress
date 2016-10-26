<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
		<meta charset="<?php bloginfo( 'charset' ); ?>">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="/favicon.png" rel="icon" type="image/png">
		<link href="<?php bloginfo('template_url'); ?>/css/style.css" rel="stylesheet">

		<?php wp_head(); ?>
	</head>
<body <?php body_class(); ?>>

<?php 
	$args = array(
	  'theme_location'  => 'main-menu',
	  'container'       => '', 
	  'menu_class'      => '', 
	);
	wp_nav_menu( $args );
?>

<h1>ProSites Studio project</h1>

<script src="<?php bloginfo('template_url'); ?>/js/script.js"></script>
</body>
<?php wp_footer(); ?>
</html>
