<?php
/**
 * Theme search template.
 * This is a placeholder for "real" template to display the found results.
 * @todo Create actual search template.
 *
 * @package WPAMPTheme
 */

// Ignore the issues of this file since that's just a placeholder.
// @codingStandardsIgnoreFile
if ( have_posts() ) :

	while ( have_posts() ) :
		the_post();
		global $post;
		var_dump( $post );
	endwhile;

endif;
