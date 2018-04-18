<?php
/**
 * Search template.
 *
 * @package WPAMPTheme
 */
get_header();
?>
<div class="travel-overlay-fx-scale">
    <div class="travel-no-focus flex-auto overflow-auto" role="button" tabindex="-1">

        <!-- Results -->
        <section class="travel-results pb1 md-pt1">
            <div class="travel-inline-list travel-results-list">
                <div class="max-width-3 mx-auto px1 md-px2">
                    <?php if ( have_posts() ): while ( have_posts() ) : ?>
                        <?php the_post(); ?>
                        <?php get_template_part( 'templates/entry/slim' ); ?>
                    <?php
                    endwhile;
                    else: ?>
                    <div><?php esc_html_e( 'No results' ); ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
        <!--/ Results -->
    </div>
</div>

<?php get_footer(); ?>
