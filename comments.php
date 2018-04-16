<?php
/**
 * Comments template.
 *
 *  @package WPAMPTheme
 */

// Ignore the issues of this file since that's just a copied HTML placeholder and requires creating dynamical version.
// @codingStandardsIgnoreFile

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}

?>

<div class="product-reviews">

	<h2 class="mb3"><?php esc_html_e( 'Reviews', 'travel' ); ?></h2>

	<div class="comments wrap__item">

		<amp-live-list id="amp-live-comments-list-<?php the_ID(); ?>" class="live-list" layout="container" data-poll-interval="<?php echo esc_attr( AMP_TRAVEL_LIVE_LIST_POLL_INTERVAL ); ?>" data-max-items-per-page="<?php echo esc_attr( get_option( 'page_comments' ) ? get_option( 'comments_per_page' ) : 10000 ); ?>">
			<ol items class="comments__list">
				<?php if ( empty( $comments ) ): ?>
					<?php esc_html_e( 'No comments found', 'travel' ); ?>
				<?php else: ?>
					<li data-sort-time="1519880447" data-update-time="1519880447" id="comment-32" class="comment byuser comment-author-ryan-kienstra even thread-even depth-1">
						<article id="div-comment-32" class="comment-body"><footer class="comment-meta"><div class="comment-author vcard">
									<amp-img alt="" src="https://secure.gravatar.com/avatar/ea4feefa34607a9eda9d5478dac38a1e?s=32&amp;d=mm&amp;r=g" srcset="https://secure.gravatar.com/avatar/ea4feefa34607a9eda9d5478dac38a1e?s=64&amp;d=mm&amp;r=g 2x" class="avatar avatar-32 photo amp-wp-enforced-sizes" height="32" width="32" layout="intrinsic"></amp-img><strong class="fn">Ryan Kienstra</strong>
									<div class="inline-block relative ml1 h3 line-height-2">
										<div class="travel-results-result-stars green">★★★★★</div>
									</div>
								</div>
								<!-- .comment-author -->

								<div class="comment-metadata">
									<time datetime="2018-03-01T05:00:47+00:00">March 1, 2018 at 5:00 am</time>
								</div>
								<!-- .comment-metadata -->

							</footer><!-- .comment-meta --><div class="comment-content">
								<p>This is a test comment.</p>
							</div>
							<!-- .comment-content -->

							<a rel="nofollow" class="comment-reply-link" href="#respond" on='tap:AMP.setState( {"commentform_post_106":{"replyToName":"Ryan Kienstra","values":{"comment_parent":"32"}}} )' aria-label="Reply to Ryan Kienstra">Reply</a>			</article><!-- .comment-body -->
					</li>
					<!-- #comment-## -->
				<?php endif; ?>
			</ol>
			<!-- .comment-list --><div update class="live-list__button">
				<button class="button" on="tap:amp-live-comments-list-106.update">New comment(s)</button>
			</div>
			<nav pagination></nav></amp-live-list><div id="respond" class="comment-respond">
			<h2 id="reply-title" class="comment-reply-title">
				<span [text]='commentform_post_106.replyToName ? "Leave a Reply to " + commentform_post_106.replyToName + "" : "Leave a Reply"'>Leave a Reply</span> <small><a id="cancel-comment-reply-link" href="/2018/02/06/elon-musks-new-tesla-pay-package-is-a-publicity-stunt-thats-also-real/#respond" hidden [hidden]='commentform_post_106.values.comment_parent == "0"' on='tap:AMP.setState( {"commentform_post_106":{"replyToName":"","values":{"comment_parent":"0"}}} )'>Cancel reply</a></small>
			</h2>			<form method="post" id="commentform" class="comment-form" novalidate action-xhr="https://dev-ampconfdemo.pantheonsite.io/wp-comments-post.php?_wp_amp_action_xhr_converted=1" target="_top" on='submit:AMP.setState( { "commentform_post_106": { submitting: true } } );submit-error:AMP.setState( { "commentform_post_106": { submitting: false } } );submit-success:AMP.setState( { commentform_post_106: {"values":{"submit":"Post Comment","comment_post_ID":"106","comment_parent":"0","comment":""},"submitting":false,"replyToName":""} } )'>
				<amp-state id="commentform_post_106"><script type="application/json">{"values":{"author":"","email":"","url":"","submit":"Post Comment","comment_post_ID":"106","comment_parent":"0","comment":""},"submitting":false,"replyToName":""}</script></amp-state>
				<p class="comment-form-comment"><label for="comment">Comment</label> <textarea class="rounded" id="comment" name="comment" cols="45" rows="8" maxlength="65525" required="required" [disabled]="commentform_post_106.submitting" [text]="commentform_post_106.values.comment" on='change:AMP.setState( { commentform_post_106: { values: { "comment": event.value } } } )'></textarea></p>
				<p class="comment-form-author"><label for="author">Name <span class="required">*</span></label> <input class="rounded" id="author" name="author" type="text" value="" size="30" maxlength="245" required="required" [disabled]="commentform_post_106.submitting" [value]="commentform_post_106.values.author" on='change:AMP.setState( { commentform_post_106: { values: { "author": event.value } } } )'></p>
				<p class="comment-form-email"><label for="email">Email <span class="required">*</span></label> <input class="rounded" id="email" name="email" type="email" value="" size="30" maxlength="100" aria-describedby="email-notes" required="required" [disabled]="commentform_post_106.submitting" [value]="commentform_post_106.values.email" on='change:AMP.setState( { commentform_post_106: { values: { "email": event.value } } } )'></p>
				<p class="comment-form-url"><label for="url">Website</label> <input class="rounded" id="url" name="url" type="url" value="" size="30" maxlength="200" [disabled]="commentform_post_106.submitting" [value]="commentform_post_106.values.url" on='change:AMP.setState( { commentform_post_106: { values: { "url": event.value } } } )'></p>
				<p class="comment-form-rating"><label for="rating">Your rating</label>
					<select class="select-arr rounded" name="rating" id="rating" [disabled]="commentform_post_106.submitting" on='change:AMP.setState( { commentform_post_106: { values: { "rating": event.value } } } )'>
						<option value="1">1 star</option>
						<option value="2">2 stars</option>
						<option value="3">3 stars</option>
						<option value="4">4 stars</option>
						<option value="5">5 stars</option>
					</select>
				</p>
				<p class="form-submit"><input name="submit" type="submit" id="submit" class="submit ampstart-btn rounded center bold white block col-12" value="Post review" [disabled]="commentform_post_106.submitting" [value]="commentform_post_106.values.submit" on='change:AMP.setState( { commentform_post_106: { values: { "submit": event.value } } } )'><input type="hidden" name="comment_post_ID" value="106" id="comment_post_ID" [disabled]="commentform_post_106.submitting" [value]="commentform_post_106.values.comment_post_ID" on='change:AMP.setState( { commentform_post_106: { values: { "comment_post_ID": event.value } } } )'><input type="hidden" name="comment_parent" id="comment_parent" value="0" [disabled]="commentform_post_106.submitting" [value]="commentform_post_106.values.comment_parent" on='change:AMP.setState( { commentform_post_106: { values: { "comment_parent": event.value } } } )'></p>
				<div submit-success>
					<template type="amp-mustache"><p>{{{message}}}</p>
					</template>
				</div>
				<div submit-error>
					<template type="amp-mustache"><p class="amp-comment-submit-error">{{{error}}}</p>
					</template>
				</div>
			</form>
		</div>
		<!-- #respond -->

	</div>

</div>
<!-- / product-reviews -->