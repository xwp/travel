<?php
/**
 * Theme header template.
 *
 * @package WPAMPTheme
 */

?>
<!doctype html>
<html amp <?php language_attributes(); ?>>
<head>
	<?php wp_head(); ?>
	<link rel="profile" href="http://gmpg.org/xfn/11">
</head>
<body <?php body_class(); ?>>

<section class="travel-main-wrapper overflow-hidden" role="main">

	<?php if ( is_singular( 'adventure' ) || is_archive() || is_search() ) : ?>
		<?php get_template_part( 'templates/navbar-search' ); ?>
	<?php endif; ?>
