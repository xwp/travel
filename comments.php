<?php
/**
 * Comments template.
 *
 *  @package WPAMPTheme
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

$reviews = wp_count_comments( get_the_ID() );
?>

<div class="product-reviews">

	<h2 class="mb3"><?php esc_html_e( 'Reviews', 'travel' ); ?></h2>

	<div class="comments wrap__item">

		<?php $sort_attr = ( 'asc' === get_option( 'comment_order' ) ) ? ' sort="ascending" ' : ''; ?>
		<amp-live-list id="amp-live-comments-list-<?php the_ID(); ?>" class="live-list" layout="container" <?php echo $sort_attr; // WPCS: XSS OK. ?> data-poll-interval="<?php echo esc_attr( AMP_TRAVEL_LIVE_LIST_POLL_INTERVAL ); ?>" data-max-items-per-page="<?php echo esc_attr( get_option( 'page_comments' ) ? get_option( 'comments_per_page' ) : 10000 ); ?>">
			<ol items class="comments__list">
				<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
				) );
				?>
			</ol><!-- .comment-list -->
			<div update class="live-list__button">
				<button class="button" on="tap:amp-live-comments-list-<?php the_ID(); ?>.update"><?php esc_html_e( 'New review(s)', 'travel' ); ?></button>
			</div>
			<nav pagination>
				<?php the_comments_navigation(); ?>
			</nav>
		</amp-live-list>

		<?php if ( ! comments_open() ) : ?>
			<p class="no-comments"><?php esc_html_e( 'Reviews are closed.', 'travel' ); ?></p>
		<?php endif; ?>

		<?php
		// Warning: If you supply title_reply_before/title_reply_after here then the comment_form_defaults filter won't be able to inject the necessary markup for AMP.
		comment_form();
		?>

	</div>

</div>
<!-- / product-reviews -->
