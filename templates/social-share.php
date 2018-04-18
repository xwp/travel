<?php
/**
 * Display Travel social share bar.
 *
 * @package WPAMPTheme
 */

?>
<div class="h4 line-height-2">
    <p class="travel-results-result-subtext"><?php esc_html_e( 'Share', 'travel' ); ?></p>
    <div class="ampstart-social-box mb1">
        <amp-social-share type="facebook"
            aria-label="<?php esc_attr_e( 'Share this on Facebook', 'travel' ); ?>"
            data-param-text="<?php esc_attr_e( 'Hello world', 'travel' ); ?>"
            data-param-href="<?php echo esc_url( 'https://example.com/?ref=URL', 'travel' ); ?>"
            data-param-app_id="145634995501895"></amp-social-share>
        <amp-social-share type="gplus" aria-label="<?php esc_attr_e( 'Share this on Google Plus', 'travel' ); ?>"></amp-social-share>
        <amp-social-share type="twitter" aria-label="<?php esc_attr_e( 'Share this on Twitter', 'travel' ); ?>"></amp-social-share>
    </div>
</div>
