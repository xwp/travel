<?php
/**
 * Display reviews count.
 *
 * @package WPAMPTheme
 */

$reviews = wp_count_comments( get_the_ID() );
?>
<?php /* translators: %d: Number of reviews. */ ?>
<p class="travel-results-result-subtext"><?php echo sprintf( esc_html__( '%d Reviews', 'travel' ), esc_html( $reviews->approved ) ); ?></p>
