<?php
/**
 * Template for sticky CTA.
 *
 * @package WPAMPTheme
 */

?>
<div class="product-cta-sticky-wrap md-hide lg-hide">
	<div class="product-cta-sticky">
		<h4 class="product-cta-sticky-title">
			<strong [text]="'$' + adventure_current_price">$<?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></strong>
			<span [text]="' - For ' + ( adventure_current_price / adventure_price )"><?php esc_html_e( '- For 1', 'travel' ); ?></span>
		</h4>
		<a href="#" class="product-cta-btn ampstart-btn rounded center bold white block"><?php esc_html_e( 'Call to book', 'travel' ); ?></a>
	</div>
</div>
<!-- / product-cta-sticky-wrap -->

<div class="product-cta lg-col-2 lg-right-align mb3">
	<h4 class="product-cta-title mb2 line-height-1" [text]="'$' + adventure_current_price">$<?php echo esc_html( get_post_meta( get_the_ID(), 'amp_travel_price', true ) ); ?></h4>
	<select class="select-arr mb1 rounded" name="count" on="change:AMP.setState({ adventure_current_price: event.value * adventure_price })">
		<option value="1"><?php esc_html_e( 'For 1', 'travel' ); ?></option>
		<?php for ( $i = 2; $i <= 8; $i += 2 ) : ?>
			<?php /* translators: %d: The number of people */ ?>
			<option value="<?php echo esc_attr( $i ); ?>"><?php printf( esc_html__( 'For %d', 'travel' ), esc_html( $i ) ); ?></option>
		<?php endfor; ?>
	</select>

	<a href="#" class="product-cta-btn ampstart-btn rounded center bold white block col-12"><?php esc_html_e( 'Call to book', 'travel' ); ?></a>
</div>
<!-- / product-cta -->
