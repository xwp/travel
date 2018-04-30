<?php
/**
 * Display Adventure CPT hero gallery.
 *
 * @package WPAMPTheme
 */

$thumbnail         = get_the_post_thumbnail_url( get_the_ID(), 'large' );
$additional_images = get_post_meta( get_the_ID(), 'amp_travel_images', true );

?>
<!-- CAROUSEL -->
<div class="hero-carousel">
	<amp-carousel layout="responsive" type="slides" height="50vw" width="100vw" autoplay loop>
		<?php if ( ! empty( $thumbnail ) ) : ?>
			<amp-img
					src="<?php echo esc_attr( $thumbnail ); ?>"
					srcset="<?php echo esc_attr( $thumbnail ); ?> 1x, <?php echo esc_attr( $thumbnail ); ?> 2x"
					width="1000"
					height="560"
			></amp-img>
		<?php endif; ?>

		<?php if ( ! empty( $additional_images ) ) : ?>
			<?php foreach ( $additional_images as $additional_image ) : ?>
				<?php $thumbnail = wp_get_attachment_image_url( $additional_image, 'large' ); ?>
				<?php if ( false !== $thumbnail ) : ?>
					<amp-img
							src="<?php echo esc_attr( $thumbnail ); ?>"
							srcset="<?php echo esc_attr( $thumbnail ); ?> 1x, <?php echo esc_attr( $thumbnail ); ?> 2x"
							width="1000"
							height="560"
					></amp-img>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	</amp-carousel>
</div>
